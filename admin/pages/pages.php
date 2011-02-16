<?php
//This file will be used too add/adjust and remove pages
//All the pages added will be purely build in the MySQL database.
//So no physical files!
?>
	<script type="text/javascript">
	function showSubMenu(str)
	    {
		if (str=="")
		    {
		        document.getElementById("txtHint").innerHTML="";
		        return;
		    }
		if (window.XMLHttpRequest)
		    {	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		    }
		else
		    {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		    }
		    xmlhttp.onreadystatechange=function()
			{
			    if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				}
			}
		    xmlhttp.open("GET","includes/ajax/submenu.php?menu="+str,true);
		    xmlhttp.send();
	    }
	</script>
	<?php
//Function for stripping crap	
if (get_magic_quotes_gpc()) 
		{
       			function stripslashes_deep($value)
       				{
           				$value = is_array($value) ?
                       			array_map('stripslashes_deep', $value) :
                       			stripslashes($value);
 
	           			return $value;
       				}
		}

if($_GET['status'] == 'add')
{
	if(empty($_POST))
	{
	echo "<h1>Pagina toevoegen</h1>";
	echo "<form name='page_add' class='aanbod_forms' id='page_add' method='POST' action='?page=pages&status=add'>";
        echo "<label>Paginatitel:</label><br />";
        echo "<input type='text' class='required' name='title' id='title'/> <sub>Voer hier de paginatitel in. Bijvoorbeeld: Hypotheekinformatie</sub>";
        echo "<br />";
        echo "<label>Menu:</label> <br />";

	//Building the first selectbox
	$sql = mysql_query('SELECT * FROM menu;');
	$count = mysql_numrows($sql);
	echo '<select name="menu" onchange="showSubMenu(this.value)">';
	echo '<option value="none">Menu</option>';
	for($i = 0; $i < $count; $i++)
	{
	    $menu = mysql_fetch_array($sql);
	    echo "<option value='".$menu['menu_file']."'>".$menu['menu_title']."</option>";
	}
	echo '</select>';
	//Start of second selectbox, this one will be loaded using javascript/ajax
	echo '<div id="txtHint"></div>';
	//End of second selectbox
        echo "<br />";
        echo "<label>Content:</label><br />";
        echo '<textarea name="content" id="content" class="required"></textarea>';
    ?>
    <script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'content' );
	};
    </script>
<br />
<div id="storage"></div>

    <?php
    echo "<input type='submit' class='submit_btn' value='Toevoegen' />";
    echo "</form>";
	}
	else
	{
	    if(!empty($_POST['title']))
	    {
		$title = MYSQL_REAL_ESCAPE_STRING($_POST['title']);
	    }
	    else
	    {
		$error = 'Geen titel ingevoerd. <br />';
	    }
	    if(!empty($_POST['menu']) || $_POST['menu'] == 'none')
	    {
		$menu = MYSQL_REAL_ESCAPE_STRING($_POST['menu']);
	    }
	    else
	    {
		$error .= 'Geen menu geselecteerd. <br />';
	    }
	    if(isset($_POST['submenu']) && !empty($_POST['submenu']))
	    {
		$submenu = MYSQL_REAL_ESCAPE_STRING($_POST['submenu']);
	    }
	    else
	    {
		$submenu = "";
	    }
	    if(!empty($_POST['content']))
	    {
		$content = MYSQL_REAL_ESCAPE_STRING($_POST['content']);
	    }
	    else
	    {
		$error .= 'Geen content ingevoerd. <br />';
	    }
	    if(file_exists("../pages/".$menu.".php") && empty($_POST['submenu']))
	    {
		$error .= "Page already exists";
	    }
	    if(empty($error) || !isset($error))
	    {
		$sql = 'select page_id from pages where page_file = "'.$menu.'" and page_subfile = "'.$submenu.'";';
		if(mysql_numrows(mysql_query($sql)) > 0)
		{
		    echo "De pagina bestaat al.";
		}
		else
		{
		mysql_query('insert into pages (page_file, page_subfile, page_title, page_content) values ("'.$menu.'", "'.$submenu.'", "'.$title.'", "'.$content.'");');
		    if(strlen($submenu > 0))
		        {
			    $sql = 'select submenu_id from submenu where submenu_mainfile = "'.$menu.'" AND submenu_file = "'.$submenu.'";';
			    if(mysql_numrows(mysql_query($sql)) == 0)
			    {
				$sub_order = mysql_fetch_array(mysql_query('SELECT submenu_order from submenu WHERE submenu_file = "'.$menu.'";'));
				mysql_query('insert into submenu (submenu_title,submenu_file,submenu_mainfile,submenu_order) VALUES ("'.$submenu.'","'.$submenu.'","'.$menu.'","'.($sub_order['submenu_order'] + 1).'");');
			    }
			}
		}
	    }
	    else
	    {
		echo $error;
	    }

    	}
}
else if($_GET['status'] == 'adjust')
{
	if(is_numeric($_GET['page_id']))
	{
	if(!empty($_POST))
	{
	
		if(isset($_POST['menu']) && !empty($_POST['menu']))
		{
			$menu = MYSQL_REAL_ESCAPE_STRING($_POST['menu']);
		}
		else
		{
			$error = 'Geen menu item opgegeven. <br />';
		}
		if(isset($_POST['submenu']) && !empty($_POST['submenu']))
		{
			$submenu = MYSQL_REAL_ESCAPE_STRING($_POST['submenu']);
		}
		else
		{
			$submenu = "";
		}
		if(isset($_POST['content']) && !empty($_POST['content']))
		{
			$content = MYSQL_REAL_ESCAPE_STRING($_POST['content']);
		}
		else
		{
			$error .= 'Geen content ingevoerd.';
		}
		if(isset($_GET['page_id']))
		{
			$page_id = MYSQL_REAL_ESCAPE_STRING($_GET['page_id']);
		}
		if(empty($error))
		{
		    $update = 'UPDATE pages SET page_file = "'.$menu.'", page_subfile = "'.$submenu.'", page_content = "'.$content.'" WHERE page_id = "'.$page_id.'";';
		    mysql_query($update);
		    if(mysql_affected_rows() > 0)
		    {
			echo "De pagina succesvol aangepast.";
		    }
		    else
		    {
			echo "De pagina is niet aangepast.<br />";
		    }
		}
		else
		{
		    echo $error;
		}
	}
	else
	{	
	    $page_id = MYSQL_REAL_ESCAPE_STRING($_GET['page_id']);
	    $query = mysql_query('SELECT * FROM pages WHERE page_id = "'.$page_id.'";');
	    $content = mysql_fetch_array($query);
	    $menu_query = mysql_query('select * from menu order by menu_id ASC');
	    echo "<h1>Pagina aanpassen</h1>";
	    echo "<form id='adjust_pages' class='aanbod_forms' name='adjust_pages' action='?page=pages&status=adjust&page_id=".$page_id."' method=POST >";
	    echo "<label>Menutitel</label><br />";
	    echo "<input type='text' value='".$content['page_title']."' id='menu_title' name='menu_title' /><br />";
	    echo '<select name="menu" onchange="showSubMenu(this.value)">';
	    $count_menu = mysql_numrows($menu_query);
	    for($i = 0; $i < $count_menu; $i++)
	        {
	            $menu = mysql_fetch_array($menu_query);
		if($menu['menu_file'] == $content['page_file'])
			{
			    echo "<option value='".$menu['menu_file']."' SELECTED>".$menu['menu_title']."</option>";
			}
		    else
			{
			    echo "<option value'".$menu['menu_file']."' >".$menu['menu_title']."</option>"; 
			}
	        }
	    echo '</select>';
	    //fetching submenu if required
	    echo '<div id="txtHint">';
	    if(strlen($content['page_subfile'] > 0))
		{
		    $submenu_query = mysql_query("select * from submenu where submenu_mainfile = '".$content['page_file']."';");
		    $count_sub = mysql_numrows($submenu_query);
		    echo "<label>Submenu</label><br />";
		    echo '<select name="submenu">';
                    echo '<option value="none">Geen</option>';
                    for($i = 0; $i < $count_sub; $i++)
                        
                            $menu = mysql_fetch_array($submenu_query);
                            echo "<option value='".$menu['menu_file']."'>".$menu['menu_title']."</option>";
                        }
		    echo '</select>';
	
	    echo '</div>';
	    echo '<br />';
	    echo "<label>Content</label><br />";
         echo '<textarea name="content" id="content" class="required">'.stripslashes_deep($content['page_content']).'</textarea>';
     ?>
     <script type="text/javascript">
         window.onload = function()
         {
                 CKEDITOR.replace( 'content' );
         };
     </script>
	 <br />
 	<!-- <div id="storage"></div> -->
 
     	<?php
	    	echo "<input type='submit' class='submit_btn' value='Aanpassen' />";
	    echo "</form>";
	}
	}
	else
	{
	//Produce list
        $query = mysql_query('SELECT * FROM pages;');
        $count = mysql_numrows($query);
        echo "<h1>Pagina's aanpassen</h1>";
        echo "<table class='admintable'>";
        echo "<th>Pagina ID</th>";
        echo "<th>Paginatitel</th>";
        echo "<th>Hoofdmenu</th>";
		echo "<th>Submenu</th>";
        echo "<th>Aanpassen</th>";
        for($i = 0; $i < $count; $i++)
        {
            $page = mysql_fetch_array($query);
            echo "<tr>";
            echo "<td>".$page['page_id']."</td>";
            echo "<td>".$page['page_title']."</td>";
            echo "<td>".$page['page_file']."</td>";
	    echo "<td>".$page['page_subfile']."</td>";
            echo "<td><a href='index.php?page=pages&status=adjust&page_id=".$page['page_id']."'><img src='../images/edit_btn.png' alt='Aanpassen' /></a></td>";
            echo "</tr>";

        }
        echo "</table>";
	}
}
else if($_GET['status'] == 'delete')
{
	if(is_numeric($_GET['page_id']))
	{
	    $page_id = MYSQL_REAL_ESCAPE_STRING($_GET['page_id']);
	    mysql_query("DELETE FROM pages WHERE page_id = '".$page_id."';");
	    if(mysql_affected_rows() > 0 )
	    {
		echo "De pagina is verwijderd.";
	    }
	    else
	    {
		echo "De pagina kan niet worden gevonden.";
	    }
	}
	else
	{
	//Produce list
        $query = mysql_query('SELECT * FROM pages;');
        $count = mysql_numrows($query);
        echo "<h1>Pagina's verwijderen</h1>";
        echo "<table class='admintable'>";
        echo "<th>Pagina ID</th>";
        echo "<th>Paginatitel</th>";
        echo "<th>Hoofdmenu</th>";
        echo "<th>Submenu</th>";
        echo "<th>Verwijderen</th>";

        for($i = 0; $i < $count; $i++)
        {
            $page = mysql_fetch_array($query);
            echo "<tr>";
            echo "<td>".$page['page_id']."</td>";
            echo "<td>".$page['page_title']."</td>";
            echo "<td>".$page['page_file']."</td>";
            echo "<td>".$page['page_subfile']."</td>";
            echo "<td><a href='index.php?page=pages&status=delete&page_id=".$page['page_id']."'><img src='../images/delete_btn.png' alt='Aanpassen' /></a></td>";
            echo "</tr>";

        }
        echo "</table>";
	}
}
else
{
	echo "<h1>Pagina's</h1>";
    echo "In dit gedeelte kunnen de pagina's worden beheerd. In het submenu kunt u kiezen om een pagina toe te voegen, aan te passen of te verwijderen.";
}
?>
