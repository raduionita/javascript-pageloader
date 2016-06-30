</div>
<div id="footer"></div>
<script type="text/javascript">
(function($) {
  console.log('Index');
  
  /** @todo Replace this 'Builder' with a Prototype pattern */
  var PageLoaderBuilder = new function() {
    this.CLICK    = 'click';
    this.DBLCLICK = 'dblclick';
    this.SCROLL   = 'scroll';
    
    var RANDOM  = 0; // see window on load
    var COUNTER = 0;
    var $loading =  $('<div style="margin: 0; padding: 0; background: red; height: 2px; width: 0%; position: fixed; top: 0px; left: 0px; transition: width 1s ease;"></div>').prependTo($('body'));
    
    var loading = function(percent) {
      $loading.width(percent +'%');
      if(percent == 100) {
        setTimeout(function() { $loading.css({ opacity: 0 }).width('0%'); }, 1000);
      } else {
        $loading.css({ opacity: 1 });
      }
    };
    
    var Content = function() {

    };
  
    var PageLoader = function(target, $content, event) {
      var self    = this;
      var onLoad  = function () { };
      var counter = 1;
      
      this.id      = 0;
      this.title   = $('#title').text();
      this.url     = 'index.php';
      
      this.event    = event || PageLoaderBuilder.CLICK;
      this.target   = target;
      this.$content = $content;
      
      var load = function(url) {
        loading(40);
        console.log('page: loading', url);
        if(window.localStorage.hasOwnProperty('link_'+ url)) {
          console.log('page: from cache');
          window.history.pushState({ title: self.title, id : self.id, url: self.url }, self.title, self.url);
          self.id    = window.localStorage.getItem('link_'+ url);
          self.$content.html(window.localStorage.getItem('content_'+ self.id));
          self.url   = url;
          self.title = $(self.target).attr('title');
          window.history.replaceState({ title: self.title, id : self.id, url: self.url }, self.title, self.url);
          loading(100);
          onLoad.call(self, []);
        } else {
          window.localStorage.setItem('content_'+ self.id, self.$content.html());
          window.history.pushState({ title: self.title, id : self.id, url: self.url }, self.title, self.url);
          $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            error: function(xhr, options, error) {
              console.log('ajax error', error); 
              console.log(xhr.responseText);
            },
            xhr: function() {
              var xhr = new window.XMLHttpRequest();
              xhr.addEventListener('progress', function(evt) {
                console.log(evt);
                if(evt.lengthComputable) {
                  var precent = evt.loaded / evt.total;
                  console.log(percent);
                }
              });
              return xhr;
            },
            success: function (response) {
              console.log('page: finished');
              self.title = $('#title').text();
              self.url   = url;
              self.id++;
              self.$content.html(response);
              window.history.replaceState({ title: self.title, id : self.id, url: self.url }, self.title, self.url);
              window.localStorage.setItem('content_'+ self.id, response);
              window.localStorage.setItem('link_'+ self.url, self.id);
              window.localStorage.setItem('title_'+ self.url, self.title);
              loading(100);
              onLoad.call(self, []);
            }
          });
        }
      };
      
      $(window).on('load', function(evt) {
        console.log('window onload');
        RANDOM = Math.floor(Math.random() * 1000);
        COUNTER++;
        window.localStorage.clear();
      }).on('popstate', function(evt) {
        console.log('window onpopstate');
        loading(99);
        loading(100);
        var state = evt.originalEvent.state;
        var html  = '';
        if(state !== null) {
          self.id    = state.id;
          self.title = state.title;
          self.url   = state.url;
          html       = window.localStorage.getItem('content_'+ state.id);
        } else {
          self.id    = 0;
          self.title = 'Index';
          self.url   = 'index.php';
          html       = window.localStorage.getItem('content_0');
        }
        self.$content.html(html);
        onLoad.call(self, []);
      });
          
      $(document).on(this.event, this.target, function(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        load($(this).attr('href'));
      });
      
      this.onLoad = function(callback) {
        onLoad = callback;
      };
    };
    
    var target  = null;
    var content = null;
    var event   = null;
    this.setTarget = function(t) {
      target = t;
    };
    this.setContent = function(c) {
      content = c;
    };
    this.setEvent = function(e) {
      event = e;
    }
    this.build = function() {
      if(target === null) {
        console.log('A target must be defined');
        return null;
      }
      if(content === null) {
        console.log('A content must be defined');
        return null;
      }
      return new PageLoader(target, $(content), event);
    };
  };
  
  PageLoaderBuilder.setTarget('#link');             // MUST
  PageLoaderBuilder.setContent('#content');         // MUST
  PageLoaderBuilder.setEvent(PageLoaderBuilder.CLICK);
  var pageLoader = PageLoaderBuilder.build();
  pageLoader.onLoad(function() {
    console.log('PageLoader onLoad');
  });

})(jQuery);
</script>
</body>
</html>