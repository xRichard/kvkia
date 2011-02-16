<?php

	//include functions.inc.php for database connection
	include_once('includes/functions.inc.php');
	//menu file to load overall menu

	echo '</div><div id="mainmenu"><ul>';

	//this will be loaded from the mysql database soon, this too allow the dynamic building
	//of multiple pages.
	db_connect();
	//Menu only needs too show the menu items that have a menu_order ID.
	$query = mysql_query("SELECT *
				FROM menu
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
		echo "<li><a href='?page=".$menu_data['2']."' title='".$menu_data['3']."'>".$menu_data['1']."</a></li>";
		if($i != $count -1)
		{
		echo "<div class='menu_divider'></div>";
		}
		echo "&nbsp;";

	}
	echo "</ul></div>";
	echo '<div id="submenu">';
	if(isset($_GET['page']))
	{
		$page = MYSQL_REAL_ESCAPE_STRING($_GET['page']);

	$query_submenu = mysql_query("SELECT submenu_title, submenu_file FROM submenu WHERE submenu_order > 0 AND submenu_mainfile = '".$page."' ORDER BY submenu_order ASC;");
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

		//in case file doesn't exist: load error page -> error.php

			$sql_page = MYSQL_REAL_ESCAPE_STRING($_GET['page']);
			$sql = mysql_query('SELECT page_id FROM pages where page_file = "'.$sql_page.'";');
			if(mysql_numrows($sql) > 0)
				{
					if(isset($_GET['status']))
					{
						$status = MYSQL_REAL_ESCAPE_STRING($_GET['status']);
						$sql_sub = mysql_query('SELECT page_id FROM pages where page_file = "'.$sql_page.'" AND page_subfile = "'.$status.'";');
						if(mysql_numrows($sql_sub) > 0)
						{
							$page_id = mysql_fetch_array($sql_sub);
							show_sqlpage($page_id['page_id']);
						}
					}
					else
					{
						$sql_main = mysql_query('SELECT page_id FROM pages where page_file = "'.$sql_page.'" AND page_subfile = "";');
						if(mysql_numrows($sql_main) > 0)
						{

							$page_id = mysql_fetch_array($sql_main);
							$content = show_sqlpage($page_id['page_id']);

						}
						else
						{
							if(file_exists("pages/".$page))
								{
									//includes the $page var too load the files dynamicly.
									include($page);
								}
							else
								{
									//Loading the error page seeing nothing was found in the database either.
									include("error.php");
								}
						}
					}
				}
			else
				{
					if(file_exists("pages/".$page))
						{
							//includes the $page var too load the files dynamicly.
							include($page);
						}
					else
						{
							//Loading the error page seeing nothing was found in the database either.
							include("error.php");
						}
				}
	   }
	//either $_Get wasn't set, or it was empty
	else
	{
		//includes the default home, to be sure we have a default page that loads
		include("home.php");
	}


?>
