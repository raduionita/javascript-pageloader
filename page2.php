<?php if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) require_once('header.php') ?>
<?php sleep(6) ?>
<h3 id="title">Page 2</h3>
<div>page 2 body here</div>
<pre><?php print_r($_SERVER); ?></pre>
<script type="text/javascript">
(function($) {
  console.log('Page 2');
  
  window.page = function () {
    console.log('This is page two');
  }  
})(jQuery);
</script>
<?php if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) require_once('footer.php') ?>