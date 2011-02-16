<?php
require_once 'includes/phptumbs/ThumbLib.inc.php';
$thumb = PhpThumbFactory::create('test.jpg');
$thumb->resize(500);
$thumb->show();
?>
