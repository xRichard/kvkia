<?php
/*
*	Build by: 	Richard Boer
*	Date:		July - augustus 2010
*	Version:	1.0
*/

	//session start in case of the use of sessions
	session_start();
	//if($_SESSION['admin_login'] == FALSE){
	include('includes/functions.inc.php');
	//Setting up a database connection
	db_connect();
	//Checking if a var is set
	if(isset($_GET['page']) && !empty($_GET['page']))
	{
		//making sure that SQL injection ain't possible.
		$page = mysql_real_escape_string($_GET['page']);

	}
	else
	{
		$page = "Home";
	}

	//fetching the data from the database.
	$query = "SELECT menu_title_mouse FROM menu WHERE menu_file = '".$page."';";
	$title = mysql_fetch_row(mysql_query($query));

	//A check to be sure there was data received from the database
	if(mysql_numrows(mysql_query($query)) > 0)
	{
	//Define doctype - does make HTML code look CRAP, but meh L2 use a editor too look @ it :)
	doctype($title['0'],'user');
	}
	//If no data is found in the database it will load the default page which is home, so giving it a Home title.
	else
	{
		doctype("Home","user");
	}

	//including the menu
	//the menu page takes care of the loading of the other files.
	//Gotta see if this works out nicely, or that we are going too change it, too this page instead.
	include('pages/menu.php');

	//define footer
	footer();
	//}
	//else
	//{
		//still need too code this part ofc :)
	//	echo "load admin part";
	//}
	if(isset($_GET['page']))
	{
		$_SESSION['previous_page'] = $_GET['page'];
	}
	else
	{
		unset($_SESSION['previous_page']);
	}
?>
