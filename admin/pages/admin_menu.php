<?php
//admin menu
	//include functions.inc.php for database connection
	include_once('../includes/functions.inc.php');
	//menu file to load overall menu
	echo '</div><div id="mainmenu"><ul>';
	//this will be loaded from the mysql database soon, this too allow the dynamic building
	//of multiple pages.
	db_connect();
	//Menu only needs too show the menu items that have a menu_order ID.
	$query = mysql_query("SELECT *
				FROM menu_admin
				WHERE menu_order > 0
				ORDER BY menu_order ASC");
	//count too check how many menu items are in the database.
	$count = mysql_numrows($query);

	//for loop too walk through all the menu items in the database
	for($i = 0; $i < $count; $i++)
	{
		//fetching the data
		$menu_data = mysql_fetch_row($query);
		//putting the data on the screen
		echo '<li><a href="?page='.$menu_data['2'].'" title="'.$menu_data['3'].'">'.$menu_data['1'].'</a></li>';
		if($i != $count -1)
		{
		echo "<div class='menu_divider'></div>";
		}
		

	}
	//Logout button
	echo "<div class='menu_divider'></div>";
	echo "<li><a href='".$_SERVER['PHP_SELF']."?logout=true' title='Uitloggen'>Uitloggen</a></li>";
	echo "</ul></div>";
	echo '<div id="submenu">';
	if(isset($_GET['page']))
	{
		$page = MYSQL_REAL_ESCAPE_STRING($_GET['page']);

	$query_submenu = mysql_query("SELECT sub_admin_title, sub_admin_file FROM submenu_admin WHERE sub_admin_order > 0 AND sub_admin_mainfile = '".$page."' ORDER BY sub_admin_order ASC;");
	$count = mysql_numrows($query_submenu);

	if($count > 0)
	{
		echo "<ul>";
		for($i = 0; $i < $count; $i++)
		{

			$submenu = mysql_fetch_row($query_submenu);
			echo "<li><a href='?page=".$page."&status=".$submenu[1]."'>".$submenu[0]."</a></li>";
			if($i != $count -1)
		{
		echo "<div class='submenu_divider'></div>";
		}
		}
		echo "</ul>";
	}

	}
	echo '</div>
		<div id="wrapper">';


	//check if $_GET['page] is set, and if not empty then go to the next step
	if(isset($_GET['page']) && !empty($_GET['page']))
	   {
		//Converting the $_GET into a $page var and converting it too lower case chars. This  because of the including of
		//files, and seeing nobody wants too host a website on Windows we need lower case chars.
		$page = strtolower($_GET['page']);

		//combining $page and .php so that we can load the files easily.
		$page = $page.".php";

		//check too see if page file exists, this too allow the loading of a dynamic menu
		if(file_exists("pages/".$page))
		{
			//ugly br because of no style yet :)
			echo "<br />";
			//includes the $page var too load the files dynamicly.
			include($page);
		}
		//in case file doesn't exist: load home.php
		else
		{
			echo "<br />";
			//Loading home.php seeing the other file that was requested didn't exist.
			//Maybe i will consider making an error page for this
			include("home.php");
		}
	   }
	   else if($_GET['logout'] == true)
{
    logout();
    echo "U bent nu uitgelogd.";
    echo "<br />";
    echo "<br />";
    echo "<a href='../index.php' title='Homepage'>Keer terug naar Vermet.nl</a>";

}
	//either $_Get wasn't set, or it was empty
	else
	{
		echo "<br />";
		//includes the default home, to be sure we have a default page that loads
		include("home.php");

	}

?>
