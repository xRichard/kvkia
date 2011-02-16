<?php
require_once('includes/phpthumbs/ThumbLib.inc.php');
$fileName = $_GET['file'];
$status = strtolower($_GET['status']);
if ($fileName === null || !file_exists($fileName))
{
     // handle missing images however you want... perhaps show a default image??  Up to you...
}

try
{
     $thumb = PhpThumbFactory::create($fileName);
}
catch (Exception $e)
{
     // handle error here however you'd like
}
switch($status)
{
     case 'verkocht':
          $mark_image = 'images/thumb_verkocht.png';
          break;
     case 'te_huur':
          $mark_image = 'images/thumb_tehuur.png';
          break;
     case 'te_koop':
          $mark_image = 'images/thumb_tekoop.png';
          break;
     case 'verhuurd':
          $mark_image = 'images/thumb_verhuurd.png';
          break;
     case 'verkocht_onder_voor_behoud':
          $mark_image = 'images/thumb_verkochtovb.png';
          break;
     case 'terug_getrokken':
          $mark_image = 'images/thumb_teruggetrokken.png';
          break;
     default:
          $mark_image = 'images/Smiley.png';
}

$thumb->createWatermark($mark_image);
$thumb->show();
?>

