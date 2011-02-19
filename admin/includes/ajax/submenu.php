<?php
include('../../../includes/functions.inc.php');
db_connect();
if($_GET['menu'] == 'none')
    {
        echo "Selecteer een menu item";
    }
else if(!empty($_GET['menu']))
    {
        $file = MYSQL_REAL_ESCAPE_STRING($_GET['menu']);
        $sql = mysql_query('SELECT * FROM submenu where submenu_mainfile = "'.$file.'";');
	$count = mysql_numrows($sql);
        if($count > 0)
            {
                echo "<label>Submenu</label><br />";
                echo '<select name="submenu">';
                    echo '<option value="none">Geen</option>';
                    for($i = 0; $i < $count; $i++)
                        {
                            $menu = mysql_fetch_array($sql);
                            echo "<option value='".$menu['submenu_file']."'>".$menu['submenu_title']."</option>";
                        }
                echo '</select>';
            }
        else
        {
            echo "<label>Submenu</label><br />";
            echo "<input type='text' name='submenu' /><sub>Voer zelf een submenu in, indien gewenst</sub>";
        }
    }
else
    {
        //Don't do anything ^^
    }
?>
