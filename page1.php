<?php if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) require_once('header.php') ?>
<?php sleep(3) ?>
<h3 id="title">Page 1</h3>
<div>page 1 body here</div>
<a href="page2.php" id="link" title="Page 2">Goto: Page 2</a>
<pre><?php print_r($_SERVER); ?></pre>

<script type="text/javascript">
(function($) {
  console.log('Page 1');
  
  window.page = function () {
    console.log('This is page one');
  }
})(jQuery);
</script> 
<?php if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) require_once('footer.php') ?>