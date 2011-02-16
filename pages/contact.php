<?php

//This file contains the contact form.
//Allowing people too send e-mails directly too the person set in the config.inc.php file.
if($_GET['status'] == 'adres')
{
	echo "Adres info";
}
else
{
	include('includes/config.inc.php');
	
	echo "<div id='contact_left'>";
	echo "<h1>Contactgegevens</h1>";
	echo $makelaar."<br />";
	if(!empty($makelaarsOrganisatie ))
	{
		echo "<label>Organisatie: </label>";
		echo $makelaarsOrganisatie."<br />";
	}
	echo "<label>Telefoon: <label>";
	echo $telefoon."<br />";
	echo "<label>E-mail: </label>";
	echo $email_contact."<br /><br />";
	echo "<label><h1>Adres</h1> </label>";
	echo $streetname."<br />";
	echo $zipcode.' '.$city."<br /><br /><h1>Routebeschrijving</h1>".$route_beschrijving;
	echo "</div>";
	if(empty($_POST))
	{
		echo "<div id='contact_right'>";
		echo "<h1>Stuur een bericht</h1>";
		echo "<form id='contact' class='aanbod_forms' name='contact' method='POST' action='?page=contact&status=email'> ";
		echo "<label>Uw e-mailadres</label><br />";
		echo "<input type='text' name='email' id='email' /><br /><sub>Vul alstublieft een geldig e-mail adres in.</sub><br />";
		echo "<br />";
		echo "<label>Onderwerp</label><br />";
		echo "<input type='text' name='subject' id='subject' /><br />";
		echo "<br />";
		echo "<label>Bericht</label><br />";
		echo "<textarea id='content' name='content'></textarea>";
		echo "<br />";
		echo "<br />";
		echo "<input type='submit' class='submit_btn' value='Verzend'>";
		echo "</div>";
	}
	else
	{
		echo "<div id='contact_right'>";
		
		if(validate_email($_POST['email']) == true)
		{
			send_mail($_POST['email'], $_POST['subject'], $_POST['content']);
		}
		else
		{
			echo "Ongeldig e-mailadres.";
		}
		echo "</pre>";
		echo "</div>";
	}
	
}

?>
