<?php
//seeing there are some special functions that are only needed for the admin
//we will need a extra file for it, that will be this file.

//Temp debug function, purely used too quickly return the session - what can i say this is faster!
function show_session()
{
    echo "<pre>";
    var_dump($_SESSION);
    echo "</pre>";
}

//returns the users so that they can be adjusted in case this is required.
//Not like that will happen that much but if it's not there it's annoying as well.
function show_users()
{
    //Setting up the query
    $query = mysql_query("SELECT login_id, login_name FROM login order by login_id DESC;");
    //counting the number of rows in the database
    $count = mysql_numrows($query);
    //walking through the amount of rows
    for($i = 0; $i < $count; $i++)
    {
        //fetched data is: login_id, login_name
        //password isn't required for the showing of the users
        //fetching the rows, login_id = 0, login_name = 1
        $data = mysql_fetch_row($query);
        //returning the login_id
        echo $data[0];
        echo "<br />";
        //returning the login_name
        echo "<br />";
        echo $data[1];
        
    }
}

function upload_image($_FILES, $postcode, $huisnummer, $house_id)
//start function upload_image
{
        require_once '../../../includes/phpthumbs/ThumbLib.inc.php'; 
		$uploaddir = '../../../images/aanbod/'.$postcode.'/'.$huisnummer.'/';

$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
$size=$_FILES['uploadfile']['size'];
    /*if($size>$file_size )
    {
            echo "error file size is too big!";
            unlink($_FILES['uploadfile']['tmp_name']);
            exit;
    }*/
    if(!file_exists($file))
    {
        if(!file_exists('../../../images/aanbod/'.$postcode) && !file_exists('../../../images/aanbod/thumbnails/'.$postcode)){
            mkdir('../../../images/aanbod/'.$postcode, 0755);
            mkdir('../../../images/aanbod/thumbnails/'.$postcode, 0755);    
        }
        if(!file_exists('../../../images/aanbod/'.$postcode.'/'.$huisnummer) && !file_exists('../../../images/aanbod/thumbnails/'.$postcode.'/'.$huisnummer)){
        mkdir('../../../images/aanbod/'.$postcode.'/'.$huisnummer, 0755);
        mkdir('../../../images/aanbod/thumbnails/'.$postcode.'/'.$huisnummer, 0755);
        }
        
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
            //Create the image
            $thumb = PhpThumbFactory::create("../../../images/aanbod/".$postcode."/" .$huisnummer."/". $_FILES["uploadfile"]["name"]);
            //Resize the image to 1024 pixels width
            $thumb->resize(1024)->save("../../../images/aanbod/".$postcode."/" .$huisnummer."/". $_FILES["uploadfile"]["name"]);
            //Resize the image to 200 pixels width
            $thumb->resize(200)->save("../../../images/aanbod/thumbnails/".$postcode."/" .$huisnummer."/". $_FILES["uploadfile"]["name"]);
            
            
            include('../../../includes/functions.inc.php');
            db_connect();
            $postcode_safe = MYSQL_REAL_ESCAPE_STRING($postcode);
            $huisnummer_safe = MYSQL_REAL_ESCAPE_STRING($huisnummer);
            $huis_id = MYSQL_REAL_ESCAPE_STRING($house_id);
            $afbeelding_loc = $postcode_safe."/" .$huisnummer_safe."/". $_FILES["uploadfile"]["name"];
            $last_id = mysql_fetch_array(mysql_query('select afb_order from afbeeldingen where aanbod_id = '.$huis_id.' ORDER BY afb_order DESC LIMIT 1;'));
            $last_order_id = $last_id['afb_order'] + 1;
        
            $query_afb = "INSERT INTO afbeeldingen (afb_locatie, aanbod_id, afb_order)
            VALUES
            ('".$afbeelding_loc."', '".$huis_id."','".$last_order_id."');";
            mysql_query($query_afb);
            
        } else {
            echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
        }
    }
//end function upload_image
}

//This function allows the user too change his own password in case he wants too.
//This can be because he feels safer that way.
//There won't be given any vars with the function seeing we can pull this directly
//from the session.
function change_own_password()
{
    //Check to see if current password is set, new password is set, if new password and confirm match
    //will require a better function most likely but will do for now
    if(empty($_POST['old_password'])
       || $_POST['new_password'] != $_POST['confirm_password']
       || empty($_POST['new_password']))
    {
        echo "<form id='change_password' name='change_password' method='POST' action='".$_SERVER['PHP_SELF']."'>";
        echo "<label>Old password:</label>";
        echo "<input type='password' id='old_password' name='old_password'></input>";
        echo "<br />";
        echo "<label>New password:</label>";
        echo "<input type='password' id='new_password' name='new_password'></input>";
        echo "<br />";
        echo "<label>Confirm new password:";
        echo "<input type='password' id='confirm_password' name='confirm_password'></input>";
        echo "<br />";
        echo "<input type='submit' value='Change Password'></input>";
        echo "</form>";
    }
    else
    {
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
    }
}
//function too process the upload of the PDF file.
function upload_pdf($_FILES, $postcode, $huisnummer, $house_id)
{
    $file = $_FILES['file'];
    $extension_explode = explode(".",$file['name']);

    if(count($extension_explode) == 2)
    {
	if(strtolower($extension_explode[1]) == 'pdf')
	{
	    
$uploaddir = '../pdf/'.$postcode.'/'.$huisnummer.'/';

$file = $uploaddir . basename($_FILES['file']['name']);
$file = str_replace(" ","_",$file);
$size=$_FILES['uploadfile']['size'];

    if(!file_exists($file))
	{
	    if(!file_exists('../pdf/'.$postcode))
	    {
	        mkdir('../pdf/'.$postcode, 0755);
	    }
	    if(!file_exists('../pdf/'.$postcode.'/'.$huisnummer) )
	    {
		mkdir('../pdf/'.$postcode.'/'.$huisnummer, 0755);
	    }
	    if (move_uploaded_file($_FILES['file']['tmp_name'], $file))
	    {
		$postcode_safe = MYSQL_REAL_ESCAPE_STRING($postcode);
		$huisnummer_safe = MYSQL_REAL_ESCAPE_STRING($huisnummer);
		$huis_id = MYSQL_REAL_ESCAPE_STRING($house_id);
		$pdf_loc = str_replace(" ","_",$postcode_safe."/" .$huisnummer_safe."/". $_FILES["file"]["name"]);
		mysql_query('update aanbod set aanbod_pdf = "'.$pdf_loc.'" where aanbod_id = '.$house_id.';');
		if(mysql_affected_rows() == 0)
		{
		    echo "Database is niet geupdate";
		}
	    }
	}
	else
	{
	    echo "Bestand bestaat al.";
	}
	}
    }
    else
    {
	echo "Ongeldig bestand. Alleen PDF's toegestaan en de enige punt moet tussen de bestandsnaam en de extensie staan.";
    }
}

function remove_pdf($aanbod_id)
{
    $aanbod_id = MYSQL_REAL_ESCAPE_STRING($aanbod_id);
    //Blok that removes the PDF if it exists
        $pdf_locatie = mysql_fetch_array(mysql_query('select aanbod_pdf from aanbod where aanbod_id = '.$aanbod_id.';'));
        
        if(!empty($pdf_locatie['aanbod_pdf']))
        {
        if(file_exists("../pdf/".$pdf_locatie['aanbod_pdf']))
        {
            unlink("../pdf/".$pdf_locatie['aanbod_pdf']);
	    mysql_query('update aanbod set aanbod_pdf = "" where aanbod_id = '.$aanbod_id.';');
        }
        
        
        $pdf_dir = explode("/",$pdf_locatie['aanbod_pdf']);
        rmdir("../pdf/".$pdf_dir[0]."/".$pdf_dir[1]);
        $dir = scandir("../pdf/".$pdf_dir[0]);
        if(count($dir) <= 2)
        {
            rmdir("../pdf/".$pdf_dir[0]);    
        }
        }
        //End PDF remove blocks
}

//Basic logout function, seeing everything works based on sessions
//this function is purely designed too kill the sessions
function logout()
{
    //destroys the session
    session_destroy();
    //unsets all the values, just to be 100% sure the session is gone.
    session_unset();
}

?>
