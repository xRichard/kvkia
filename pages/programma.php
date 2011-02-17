<htmL>
<head>
<link href="www.kvkia.nl/includes/kia_antiloop.css" rel="stylesheet" type="text/css" /> 
</head>

<?php
	
	

	
if($_GET['status'] == 'uitslagen')
{

  echo '<iframe src="http://www.antilopen.nl/competitie/uitslagen.asp?cI=530&css=530" width="100%" height="800">
            <p>Your browser does not support iframes.</p>
        </iframe>';
	/*
		require_once('includes/functions.inc.php');
		echo "<div id='text_container'>";
		include_remote('http://www.antilopen.nl/competitie/uitslagen.asp?cI=530&css=530');
		echo "</div>";
	*/	
}

else if($_GET['status'] == 'standen')
{
	
  echo '<iframe src="http://www.antilopen.nl/competitie/standen.asp?cI=530&css=530" width="100%" height="800">
            <p>Your browser does not support iframes.</p>
        </iframe>';
		/*
		require_once('includes/functions.inc.php');
		echo "<div id='text_container'>";
		include_remote('http://www.antilopen.nl/competitie/standen.asp?cI=530&css=530');
		echo "</div>";
		*/
}
else
	{
		
		echo 	'<iframe src="http://www.antilopen.nl/competitie/programma.asp?cI=530&css=530" width="100%" height="800">
				<p>Your browser does not support iframes.</p>
				</iframe>';
		
		/*
		require_once('includes/functions.inc.php');
		echo "<div id='text_container'>";
		include_remote('http://www.antilopen.nl/competitie/programma.asp?cI=530&css=530');
		echo "</div>";
		*/
	}
		
?>