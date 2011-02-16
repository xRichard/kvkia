<?php
include('../admin_functions.inc.php');
upload_image($_FILES, $_GET['postcode'], $_GET['huisnummer'], $_GET['house_id']);
?>
