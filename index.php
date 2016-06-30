<?php if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) require_once('header.php') ?>
<h3 id="title"><?= 'Index'; ?></h3>
<a href="page1.php" id="link" title="Page 1">Goto: Page 1</a>
<pre><?php print_r($_SERVER); ?></pre>
<?php if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) require_once('footer.php') ?>
