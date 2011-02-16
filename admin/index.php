<?php
//basic part for the admin part.
//seeing admin gets a different part so that the admin

//starting the session again, seeing it's the idea that the moment the sesion for the admin is loaded.
//he gets redirected here if he opens the admin panel
session_start();

//include too access database and other functions
include('../includes/functions.inc.php');
include('includes/admin_functions.inc.php');
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
	$query = "SELECT menu_title_mouse FROM menu_admin WHERE menu_file = '".$page."';";
	$title = mysql_fetch_row(mysql_query($query));
        
        //A check to be sure there was data received from the database
	if(mysql_numrows(mysql_query($query)) > 0)
	{
	//Define doctype - does make HTML code look CRAP, but meh L2 use a editor too look @ it :)
	doctype($title['0'],'admin');
	}
        
	//If no data is found in the database it will load the default page which is home, so giving it a Home title.
	else
	{
		doctype("Admin Home","admin");
	}
        

//Check to be sure your not already logged in, bit useless too show a login page when your logged in :)
if($_SESSION['admin_logging'] != 'TRUE1')
{
    
//Check if there is any post data too process, in case a user wants too login
if(empty($_POST['username']) && empty($_POST['password']))
{
    
    //Login form
    echo '</div><div id="mainmenu"><ul>';
?>

        <li><a href="../index.php" title="Home">Home</a></li>
        </ul>
        </div>
	<div id="wrapper">
		<div id="loginbox"> 
        <h1>Inloggen</h1>             
        <form id="login" name="login" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <label>Gebruikersnaam:</label>
        <input type="text" id="username" name="username"></input>
        <br />
        <label>Wachtwoord:</label>
        <input type="password" id="password" name="password"></input>
        <br />
        <input type="submit" class="submit_btn" value="Inloggen" />
        </form>
        </div>
<?php
    }
    else if(empty($_POST['username']) || empty($_POST['password']))
    {
        echo "De ingevoerde gegevens zijn niet gevonden.";
    }

//Processing the post data, into usefull information too check if the username and the password combo
//match the information from the database.
else
{
    //making the connection too the database
    db_connect();
    
        //SQL injection prevention - this allows us too use the vars directly in a SQL query without
        //having the danger of getting injections.
        $username = MYSQL_REAL_ESCAPE_STRING($_POST['username']);
        //password gets converted in MD5 right away - no need too use plain passwords looks way too ugly
        $password = md5(MYSQL_REAL_ESCAPE_STRING($_POST['password']));
        
        //just fetching the login id for now, maybe we can get something more, but
        //doubt it's needed, seeing it will be mostly used by 1 person anyway
        $query = "SELECT login_id FROM login WHERE login_name = '".$username."' AND login_pass = '".$password."';";
        //Check too see if we get any values from the database
        $check = mysql_numrows(mysql_query($query));
        
        //If we get 1 value back, it means we have 1 user present YaY
        //even though the database is fixed so that the username = unique
        if($check == 1)
        {
            //setting the value that will be used too check if a user is logged in or not.
            $_SESSION['admin_logging'] = TRUE;
            //This value is going to be used too change certain things easier, like make a personal
            //change password menu, etc.
            //Maybe even make a nice welcome message
            $_SESSION['username'] = $username;
            include('pages/admin_menu.php');
            
        }
        //If this error happens - somebody has been screwing around with the database.
        //seeing the database is set up too only allow unigue usernames
        else if($check > 1)
        {
            echo "Something went wrong with the database - call your system admin and let him check <br />
            the existing usernames that are in the database.";
        }
        //either the user is trying too hack the system and guessing the password
        //or he just forgot his own password - but this error returns him too try again.
        //still requires a part that allows the user too see the login page again.
        else
        {
            echo "<div id='error'> De ingevoerde gebruikersnaam en/of het wachtwoord zijn niet gevonden. Probeert u het nogmaals.</div>";
        }
        
}
}

//There is a session
else
{
    include('pages/admin_menu.php');
    
}
footer();

?>
