<?php
if(!empty($_GET['aanbod_id']) && is_numeric($_GET['aanbod_id']))
{
    include('includes/functions.inc.php');
    include('includes/config.inc.php');
    
    db_connect();
    $aanbod_id = MYSQL_REAL_ESCAPE_STRING($_GET['aanbod_id']);
    $brochure = mysql_fetch_array(mysql_query("SELECT aanbod_pdf, aanbod_postcode, aanbod_straatnaam, aanbod_huisnummer FROM aanbod WHERE aanbod_id = ".$aanbod_id.";"));
    if($_GET['status'] == 'process_download')
    {
    $file = "pdf/".$brochure['aanbod_pdf'];
    header('Content-type: application/force-download');
    header('Content-Disposition: attachment; filename=' . basename ($file));
    readfile($file);
    
    readfile($file);
    }
    echo $file;
    echo "<h1>Brochure downloaden of meer informatie aanvragen</h1>";
    echo "<hr />";
    echo "<a href='download_pdf.php?status=process_download&aanbod_id=".$aanbod_id."'>Download de brochure</a>";
    echo "<br /><br />";
 	echo "<span class='note'>Om de brochure te kunnen bekijken op uw computer, dient u te beschikken over de Adobe Reader software. Deze software kunt u gratis downloaden en installeren vanaf de Adobe <a href='http://www.adobe.com/reader' target='_blank' class='note_link'>website</a>.<br /></span>";
    echo "<hr />";
    if(empty($_POST) || empty($_POST['voornaam']) || empty($_POST['achternaam']) || empty($_POST['email']))
    {
        
        if(isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['email']))
        {
            if(empty($_POST['voornaam']))
            {
                echo "U heeft geen voornaam ingevoerd.<br />";
            }
            if(empty($_POST['achternaam']))
            {
                echo "U heeft geen achternaam ingevoerd.<br />";
            }
            if(empty($_POST['email']))
            {
                echo "U heeft geen e-mailadres ingevoerd.<br />";
            }
        }
    echo "<label>Wilt u meer informatie ontvangen? Vul dan het onderstaande formulier in. U ontvangt dan zo spoedig mogelijk meer informatie per e-mail.<br /></label>";
    echo "<br />";
    echo "<form id='send-email' action='download_pdf.php?aanbod_id=".$aanbod_id."' method=POST>";
    echo "<label>Voornaam</label><br />";
    echo "<input type='text' id='voornaam' name='voornaam' /><br />";
    echo "<br />";
    echo "<label>Achternaam</label><br />";
    echo "<input type='text' id='achternaam' name='achternaam'/><br />";
    echo "<br />";
    echo "<label>E-mailadres</label><br />";
    echo "<input type='text' id='email' name='email' /><br />";
    echo "<br />";
    echo "<input type='submit' value='Verzenden' />";
    echo "</form>";
    echo "<a href='javascript:window.close()'>Sluit dit venster</a>";
    }
    else
    {
        $sender = MYSQL_REAL_ESCAPE_STRING($_POST['email']);
        $subject = "Website informatieverzoek";
        $voornaam = MYSQL_REAL_ESCAPE_STRING($_POST['voornaam']);
        $achternaam = MYSQL_REAL_ESCAPE_STRING($_POST['achternaam']);
        $naam = $voornaam." ".$achternaam;
        $content = "Adres: ".$brochure['aanbod_postcode'];
        $content .= "\n".$brochure['aanbod_straatnaam']." ".$brochure['aanbod_huisnummer'];
        $content .= "\n Link naar het aanbod: <a href='http://".$link."/index.php?page=aanbod_show&aanbod_id=".$aanbod_id."'>Aanbod</a>";
        $content .= "\n Naam contactpersoon: ".$naam;
        $content .= "\n E-mail adres: ".$sender;
        if(validate_email($sender) == TRUE)
        {
            send_mail($sender,$subject,$content);
        }
    }
}
else
{
    echo "Helaas is er geen brochure gevonden";
}
?>
<style type="text/css">
/* Text */
h1 {
	font-family: Helvetica, Arial, sans-serif;
	font-size: 18px;
	color: #005d89;
	font-weight: bold;
}

label {
	font-family: Helvetica, Arial, sans-serif;
    font-size: 13px;
    color: #000000;
}

.note {
	font-family: Helvetica, Arial, sans-serif;
    font-size: 11px;
    color: #000000;
}
/* End Text */

/* Links */
a {
	font-family: Helvetica, Arial, sans-serif;
    font-size: 13px;
	color: #005d89;
	text-decoration: none;
}

a:hover {
	text-decoration: underline;
}

.note_link {
	font-family: Helvetica, Arial, sans-serif;
    font-size: 11px;
	color: #005d89;
	text-decoration: none;
}
/* End Links */

/* Misc */
hr {
	height: 1px; 
	border: 0px; 
	background-color: #dfe7eb; 
	color: #dfe7eb;
}
/* End Misc */
</style>