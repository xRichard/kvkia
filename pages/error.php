<?php
//This page will return a error - seeing this page is purely build too return
//a error when there is a page that cannot be loaded. Mostly because it doesn't
//exist.

//div too style the error page
echo "<div id='error'>";
//Standard info telling page could not be found
echo "De pagina die U heeft proberen te openen bestaat helaas niet.";
echo "<br />";

//check if $_SESSION['previous_page'] contains any data 
if(!empty($_SESSION['previous_page']))
{
    //Check if the file exists - in case people refresh the error page
    if(file_exists("pages/".$_SESSION['previous_page'].".php"))
       {
            //produce a link based on the previous page data
            echo '<a href="index.php?page='.$_SESSION['previous_page'].'">Ga terug naar de vorige pagina</a>';
       }
    //The previous page could not be found, and to keep people on the website we will return
    //them too the homepage.
    else
        {
            echo '<a href="index.php?page=home">Terug keren naar de homepage</a>';
        }
    
}
//No session data has been found -> this can have multiple reasons
else
{
    echo '<a href="index.php?page=home">Terug keren naar home</a>';
}
echo "</div>";

?>
