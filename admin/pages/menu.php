<?php
//adjust the menu

//Main menu
if($_GET['status'] == 'add')
{
	if(!empty($_POST) && $_POST['menu'] == 'main_menu')
	{
		$sql = 'SELECT menu_order FROM menu ORDER BY menu_order DESC LIMIT 1;';
		$menu_order = mysql_fetch_array(mysql_query($sql));
		if(isset($menu_title))
		{
		$menu_title = MYSQL_REAL_ESCAPE_STRING($_POST['menu_title']);
		}
		else
		{
			$error = "Geen titel ingevoerd. <br />";
		}
		if(isset($_POST['menu_file']))
		{
			$menu_file = MYSQL_REAL_ESCAPE_STRING($_POST['menu_file']);
		}
		else
		{
			$error .= 'Geen bestand ingevoerd. <br />';
		}
		if(isset($_POST['menu_mouse']))
		{
		$menu_mouse = MYSQL_REAL_ESCAPE_STRING($_POST['menu_mouse']);
		}
		else
		{
			$error .= 'Geen mouseover titel ingevoerd.';
		}
		if(empty($error))
		{
		$insert = "INSERT INTO menu(menu_title, menu_file, menu_title_mouse, menu_order) VALUES ('".$menu_title."','".$menu_file."','".$menu_mouse."','".($menu_order['menu_order'] + 1) ."');";
		mysql_query($insert);
		echo "Menu item succesvol toegevoegd.";
		}
		else
		{
			echo $error;
		}
	}
	else if(!empty($_POST) && $_POST['menu'] == 'submenu')
	{
		if(isset($_POST['sub_title']) && !empty($_POST['sub_title']))
		{
			$sub_title = MYSQL_REAL_ESCAPE_STRING($_POST['sub_title']);
		}
		else
		{
			$error = 'Geen titel ingevoerd. <br />';
		}
		if(isset($_POST['main_menu']) && !empty($_POST['main_menu']))
		{
			$main_menu = MYSQL_REAL_ESCAPE_STRING($_POST['main_menu']);
		}
		else
		{
			$error .= 'Geen hoofdmenu item ingevoerd. <br />';
		}
		if(isset($_POST['sub_file']) && !empty($_POST['sub_file']))
		{
			$sub_file = strtolower(MYSQL_REAL_ESCAPE_STRING($_POST['sub_file']));
		}
		else
		{
			$error .= 'Geen submenu bestand ingevoerd. <br />';
		}
		if(!isset($error) || empty($error))
		{
			$order = mysql_fetch_array(mysql_query('select submenu_order from submenu where submenu_mainfile = "'.$main_menu.'"  ORDER BY submenu_order DESC limit 1;'));
			if($order['submenu_order'] > 0)
			{
				$sub_order = $order['submenu_order'];
			}
			else
			{
				$sub_order = 1;
			}
			$query = "INSERT INTO submenu (submenu_title, submenu_file, submenu_mainfile, submenu_order)
			VALUES
			(
			'".$sub_title."',
			'".$sub_file."',
			'".$main_menu."',
			'".$sub_order."'
			);";
			mysql_query($query);
			if(mysql_insert_id > 0)
			{
				echo "Submenu succesvol toegevoegd.";
			}
		}
	}
	else
	{
	echo "<h1>Menu item toevoegen</h1>";
	echo "<form id='add_main_menu' class='aanbod_forms' name='add_main_menu' method=POST action='index.php?page=menu&status=add'>";
	echo "<input type='hidden' value='main_menu' id='menu' name='menu'/>";
	echo "<label>Menutitel:</label>";
	echo "<input type='text' name='menu_title' class='required' id='menu_title' />";
	echo "<br />";
	echo "<label>Menubestand:</label>";
	echo "<input type='text' name='menu_file' class='required' id='menu_file' /> <sub>(Geen extensie toevoegen!)</sub>";
	echo "<br />";
	echo "<label>Mouseover info:</label>";
	echo "<input type='text' name='menu_mouse' class='required' id='menu_mouse' />";
	echo "<br />";
	echo "<input type='submit' class='submit_btn' value='Toevoegen' /></form>";
	echo "<hr />";
	echo "<h1>Submenu toevoegen</h1>";
	echo "<form id='add_submenu_' class='aanbod_forms' name='add_submenu' method=POST action='index.php?page=menu&status=add'>";
	echo "<input type='hidden' value='submenu' id='menu' name='menu' />";
	echo "<label>Titel:</label>";
	echo "<input type='text' name='sub_title' class='required' id='sub_title' />";
	echo "<br />";
	echo "<label>Menu:</label>";
	echo "<select id='main_menu' name='main_menu'>";
	$query = mysql_query('SELECT * FROM menu;');
	$menu_count = mysql_numrows($query);
	for($i = 0; $i < $menu_count; $i++)
	{
		$menu_data = mysql_fetch_array($query);
		echo "<option id='".$menu_data['menu_file']."' name='".$menu_data['menu_file']."' value='".$menu_data['menu_file']."'>".$menu_data['menu_title']."</option>";
	}
	echo "</select>";
	echo "<br />";
	echo "<label>Submenu bestand:</label>";
	echo "<input type='text' name='sub_file' id='sub_file' /> <sub>(Geen extensie toevoegen!)</sub>";
	echo "<br />";
	echo "<input type='submit' id='sub_add' name='sub_add' value='Toevoegen' class='submit_btn' /></form>";
	}
}
else if($_GET['status'] == 'adjust')
{
	if(!empty($_GET['menu_id']) && is_numeric($_GET['menu_id']))
	{
		if(isset($_POST) && !empty($_POST))
		{
			if(!empty($_POST['menu_title']))
			{
				$menu_title = MYSQL_REAL_ESCAPE_STRING($_POST['menu_title']);	
			}
			else
			{
				$error = "Er is geen menutitel ingevoerd. <br />";
			}
			if(!empty($_POST['menu_file']))
			{
				$menu_file = MYSQL_REAL_ESCAPE_STRING($_POST['menu_file']);
			}
			else
			{
				$error .= "Er is geen menubestand ingevoerd";
			}
			if(!empty($_POST['menu_mouse']))
			{
				$menu_mouse = MYSQL_REAL_ESCAPE_STRING($_POST['menu_mouse']);
			}
			else
			{
				$error .= "Er is geen mouse over informatie ingevoerd. <br />";
			}
			if(!empty($_POST['volgorde_main']) && is_numeric($_POST['volgorde_main']))
			{
				$volgorde_main = MYSQL_REAL_ESCAPE_STRING($_POST['volgorde_main']);
			}
			else
			{
				$error .= "Er is geen volgorde ingevoerd. <br />";
			}
			if(empty($error))
			{
			$update = 'UPDATE menu SET
			menu_title = "'.$menu_title.'",
			menu_file = "'.$menu_file.'",
			menu_title_mouse = "'.$menu_mouse.'",
			menu_order = "'.$volgorde_main.'" WHERE menu_id = '.$menu_id.';';
			mysql_query($update);
			if(mysql_affected_rows() > 0)
			{
				echo '<div id="error">Menu succesvol aangepast.</div>';
			}
			else
			{
				echo '<div id="error">Menu is niet aangepast.</div>';
			}
			}
			else
			{
				echo "<div id='error'>".$error."</div>";
			}
		}
		else
		{
			$menu_id = MYSQL_REAL_ESCAPE_STRING($_GET['menu_id']);
			$sql = 'SELECT * FROM menu WHERE menu_id = '.$menu_id.' LIMIT 1;';
			$menu = mysql_fetch_array(mysql_query($sql));
			echo "<h1>Menu item aanpassen</h1>";
			echo "<form id='menu_adjust' class='aanbod_forms' name='menu_adjust' method='POST' action=''>";
			echo "<label>Menutitel:</label>";
			echo "<input type='text' name='menu_title' class='required' id='menu_title' value='".$menu['menu_title']."'/>";
			echo "<br />";
			echo "<label>Menubestand:</label>";
			echo "<input type='text' name='menu_file' class='required' id='menu_file' value='".$menu['menu_file']."'/> <sub>(Geen extensie toevoegen!)</sub>";
			echo "<br />";
			echo "<label>Mouseover info:</label>";
			echo "<input type='text' name='menu_mouse' class='required' id='menu_mouse' value='".$menu['menu_title_mouse']."'/>";
			echo "<br />";
			echo "<label>Volgorde:</label>";
			echo "<select id='volgorde_main' name='volgorde_main'>";
			echo "<option id='0' name='0' value='0'>0</option>";
			$menu_order = mysql_query('select menu_order from menu');
			for($i = 0; $i < mysql_numrows($menu_order); $i++)
			{
				$data = mysql_fetch_array($menu_order);
				if($menu['menu_order'] == $data['menu_order'])
				{
					echo "<option id='".$data['menu_order']."' name='".$data['menu_order']."' value='".$data['menu_order']."' SELECTED>".$data['menu_order']."</option>";
				}
				else
				{
					echo "<option id='".$data['menu_order']."' name='".$data['menu_order']."' value='".$data['menu_order']."'>".$data['menu_order']."</option>";
				}
			}
			echo "</select>";
			echo "<br />";
			echo "<input type='submit' class='submit_btn' value='Aanpassen' />";
			echo "</form>";
			echo "<hr />";
			//Produce list
			$query = mysql_query('SELECT * FROM submenu WHERE submenu_mainfile = "'.$menu['menu_file'].'" ORDER by submenu_order ASC');
			$count = mysql_numrows($query);
			if($count > 0)
			{
			echo "<h1>Submenu items aanpassen</h1>";
			echo "<table class='admintable'>";
			echo "<th>Submenu ID</th>";
			echo "<th>Submenu titel</th>";
			echo "<th>Submenu bestand</th>";
			echo "<th>Menu volgorde</th>";
			echo "<th>Aanpassen</th>";
			for($i = 0; $i < $count; $i++)
				{
					$submenu = mysql_fetch_array($query);
					echo "<tr>";
					echo "<td>".$submenu['submenu_id']."</td>";
					echo "<td>".$submenu['submenu_title']."</td>";
					echo "<td>".$submenu['submenu_file']."</td>";
					echo "<td>".$submenu['submenu_order']."</td>";
					echo "<td><a href='index.php?page=menu&status=adjustsubmenu&menu_id=".$submenu['submenu_id']."'><img src='../images/edit_btn.png' alt='Aanpassen' /></a></td>";
					echo "</tr>";
				}
			echo "</table>";
		}
		}
	}
	else
	{
	//Produce list
        $query = mysql_query('SELECT * FROM menu ORDER by menu_order ASC');
        $count = mysql_numrows($query);
        echo "<h1>Menu items aanpassen</h1>";
        echo "<table class='admintable'>";
        echo "<th>Menu ID</th>";
        echo "<th>Menutitel</th>";
        echo "<th>Menubestand</th>";
        echo "<th>Menu mouseover info</th>";
        echo "<th>Menuvolgorde</th>";
        echo "<th>Aanpassen</th>";
        for($i = 0; $i < $count; $i++)
        {
            $menu = mysql_fetch_array($query);
            echo "<tr>";
            echo "<td>".$menu['menu_id']."</td>";
            echo "<td>".$menu['menu_title']."</td>";
            echo "<td>".$menu['menu_file']."</td>";
            echo "<td>".$menu['menu_title_mouse'].$aanbod_array['aanbod_huis']."</td>";
            echo "<td>".$menu['menu_order']."</td>";
            echo "<td><a href='index.php?page=menu&status=adjust&menu_id=".$menu['menu_id']."'><img src='../images/edit_btn.png' alt='Aanpassen' /></a></td>";
            echo "</tr>";

        }
        echo "</table>";
	}
}
else if($_GET['status'] == 'delete')
{
	if(!empty($_GET['menu_id']) && is_numeric($_GET['menu_id']))
	{
		if($_POST['delete_main'] == 'yes')
		{
			echo "<div id='error'>";
			$menu_id = MYSQL_REAL_ESCAPE_STRING($_GET['menu_id']);
			$menu_file = mysql_fetch_array(mysql_query('select menu_file from menu where menu_id = '.$menu_id.';'));
			$main_menu_file = $menu_file['menu_file'];
			$delete_sub = 'DELETE FROM submenu where submenu_mainfile = "'.$main_menu_file.'";';
			mysql_query($delete_sub);
			if(mysql_affected_rows() > 0)
			{
				echo "Alle submenu's zijn verwijdert. <br />";
			}
			else
			{
				echo "Er zijn geen submenu's verwijdert, dit kan komen doordat deze niet aanwezig waren <br />";
			}
			$sql = 'DELETE FROM menu WHERE menu_id = '.$menu_id.' LIMIT 1;';
			mysql_query($sql);
			if(mysql_affected_rows() > 0)
			{
				echo "Menuitem succesvol verwijderd.";
			}
			else
			{
				echo "Menuitem niet gevonden.";
			}
			echo "</div>";
		}
		else
		{
			echo "<h1>Hoofdmenu verwijderen</h1>";
			echo "<form id='delete_mainmenu' name='delete_mainmenu' method=POST action='?page=menu&status=delete&menu_id=".$_GET['menu_id']."'>";
			echo "<input type='hidden' id='delete_main' value='yes' name='delete_main' />";
			echo "<label>Daadwerkelijk het hoofdmenu verwijderen?</label><br />";
			echo "<input type='submit' id='del_btn' name='del_btn' value='Verwijder'/>";
			echo "</form>";
			echo "<br />";
			//Produce list
			$query = mysql_query('SELECT * FROM submenu ORDER by submenu_order ASC');
			$count = mysql_numrows($query);
			if($count > 0)
			{
			echo "<hr />";
			echo "<h1>Het submenu verwijderen</h1>";
			echo "<table class='admintable'>";
			echo "<th>Menu ID</th>";
			echo "<th>Menutitel</th>";
			echo "<th>Menubestand</th>";
			echo "<th>Menuvolgorde</th>";
			echo "<th>Verwijderen</th>";
			for($i = 0; $i < $count; $i++)
			{
				$submenu = mysql_fetch_array($query);
				echo "<tr>";
				echo "<td>".$submenu['submenu_id']."</td>";
				echo "<td>".$submenu['submenu_title']."</td>";
				echo "<td>".$submenu['submenu_file']."</td>";
				echo "<td>".$submenu['submenu_order']."</td>";
				echo "<td><a href='index.php?page=menu&status=deletesubmenu&menu_id=".$submenu['submenu_id']."'><img src='../images/delete_btn.png' alt='Delete' /></a></td>";
				echo "</tr>";
			}
			echo "</table>";
			}
		}

	}
	else
	{
	//Produce list
        $query = mysql_query('SELECT * FROM menu ORDER by menu_order ASC');
        $count = mysql_numrows($query);
        echo "<h1>Menu items verwijderen</h1>";
        echo "<table class='admintable'>";
        echo "<th>Menu ID</th>";
        echo "<th>Menutitel</th>";
        echo "<th>Menubestand</th>";
        echo "<th>Menu mouseover info</th>";
        echo "<th>Menuvolgorde</th>";
        echo "<th>Verwijderen</th>";
		for($i = 0; $i < $count; $i++)
			{
				$menu = mysql_fetch_array($query);
				echo "<tr>";
				echo "<td>".$menu['menu_id']."</td>";
				echo "<td>".$menu['menu_title']."</td>";
				echo "<td>".$menu['menu_file']."</td>";
				echo "<td>".$menu['menu_title_mouse'].$aanbod_array['aanbod_huis']."</td>";
				echo "<td>".$menu['menu_order']."</td>";
				echo "<td><a href='index.php?page=menu&status=delete&menu_id=".$menu['menu_id']."'><img src='../images/delete_btn.png' alt='Delete' /></a></td>";
				echo "</tr>";
			}
	}
        echo "</table>";
}
else if($_GET['status'] == 'adjustsubmenu' && is_numeric($_GET['menu_id']))
{
$menu_id = MYSQL_REAL_ESCAPE_STRING($_GET['menu_id']);
	if(empty($_POST))
	{
			
			$sql = 'SELECT * FROM submenu WHERE submenu_id = '.$menu_id.' LIMIT 1;';
			$submenu = mysql_fetch_array(mysql_query($sql));
			echo "<h1>Menu item aanpassen</h1>";
			echo "<form id='menu_adjust' class='aanbod_forms' name='menu_adjust' method='POST' action=''>";
			echo "<label>Menutitel:</label>";
			echo "<input type='text' name='menu_title' class='required' id='menu_title' value='".$submenu['submenu_title']."'/>";
			echo "<br />";
			echo "<label>Menubestand:</label>";
			echo "<input type='text' name='menu_file' class='required' id='menu_file' value='".$submenu['submenu_file']."'/> <sub>(Geen extensie toevoegen!)</sub>";
			echo "<br />";
			echo "<label>Volgorde:</label>";
			echo "<select id='volgorde_sub' name='volgorde_sub'>";
			echo "<option id='0' name='0' value='0'>0</option>";
			$submenu_order = mysql_query('select submenu_order from submenu');
			for($i = 0; $i < mysql_numrows($submenu_order); $i++)
			{
				$data = mysql_fetch_array($submenu_order);
				if($submenu['submenu_order'] == $data['submenu_order'])
				{
					echo "<option id='".$data['submenu_order']."' name='".$data['submenu_order']."' value='".$data['submenu_order']."' SELECTED>".$data['submenu_order']."</option>";
				}
				else
				{
					echo "<option id='".$data['submenu_order']."' name='".$data['submenu_order']."' value='".$data['submenu_order']."'>".$data['submenu_order']."</option>";
				}
			}
			echo "</select>";
			echo "<br />";
			echo "<input type='submit' class='submit_btn' value='Aanpassen' />";
			echo "</form>";
	}
	else
	{
		if(!empty($_POST['menu_title']))
		{
			$menu_title = MYSQL_REAL_ESCAPE_STRING($_POST['menu_title']);
		}
		else
		{
			$error = 'Geen titel ingevoerd. <br />';
		}
		if(!empty($_POST['menu_file']))
		{
			$menu_file = MYSQL_REAL_ESCAPE_STRING($_POST['menu_file']);
		}
		else
		{
			$error .= 'Geen bestand ingevoerd. <br />';
		}
		if(!empty($_POST['volgorde_sub']) && is_numeric($_POST['volgorde_sub']))
		{
			$order = MYSQL_REAL_ESCAPE_STRING($_POST['volgorde_sub']);
		}
		else
		{
			$error .= 'Geen volgorde ingevoerd. ';
		}
		if(!empty($error))
		{
			echo $error;
		}
		else
		{
		$update = 'UPDATE submenu SET
		submenu_title = "'.$menu_title.'",
		submenu_file = "'.$menu_file.'",
		submenu_order = "'.$order.'" WHERE submenu_id = '.$menu_id.';';
		mysql_query($update);
		if(mysql_affected_rows() > 0)
		{
			echo "<div id='error'>Submenu succesvol aangepast.</div>";
		}
		else
		{
			echo "<div id='error'>Submenu is niet aangepast.</div>";
		}
		}
	}
}
else if($_GET['status'] == 'deletesubmenu' && is_numeric($_GET['menu_id']))
{
	$menu_id = MYSQL_REAL_ESCAPE_STRING($_GET['menu_id']);
	echo "<div id='error'>";
		$delete_sub = 'DELETE FROM submenu where submenu_id = "'.$menu_id.'";';
		mysql_query($delete_sub);
		if(mysql_affected_rows() > 0)
			{
				echo "Het submenu is verwijderd. <br />";
			}
		else
			{
				echo "Fout!";
			}
	echo "</div>";
	
}
else
{
	echo "<h1>Menu</h1>";
    echo "In dit gedeelte kunnen de menu's en submenu's worden beheerd. In het submenu kunt u kiezen om een (sub)menu toe te voegen, aan te passen of te verwijderen.";
}
?>