<?php
    //Database connection
    $user          		=       	"root";		//Database username
    $password       		=       	"171284";	//Database password
    $server         		=       	"localhost"; 	//In case of custom port use: ip_adress:port
    $database	    		=	    	"vermet";	//Database

    //website configuration
    $overall_title		=		"kvkia.nl";	//The title of the website, the general part.
    $link			=		"127.0.0.1/vermet.nl/";	//Domain info => for example: www.vermet.nl used too build up certain links.
    //RSS config
    $rss_feed                   =               "http://rss.eigenhuis.nl/news.xml"; //XML link input
    //Cache dir is required for the RSS feed, without it, it will keep loading the news from the RSS feed making both this website
    //slow and the other one, and also generating a lot of unneeded traffic.
    $cache_dir                  =               "/var/www/development/vermet.nl/cache";
    $total_feeds                =               5;      //Number of feeds that will be showed on the main page.
    $length_rss_description     =               150;    //Number of characters the RSS feed will show till giving a few dots.
    
    //XML config
    $makelaar                   =               "Vermet Makelaar en Taxateur O.Z.";           //Name of company
    $makelaarsOrganisatie       =               "";                 //Which organisation in this case => NVM for example
    $naam_makelaar              =               "M.A. Vermet";                 //The name of the real estate agent
    $telefoon                   =               "0522-257200";                 //phone number
    $email                      =               "rinus@vermet.nl";  //e-mail adress of real estate agent
    
    //Contact information
    $streetname                 =               "Molenstraat 32a";  //street name
    $zipcode                    =               "7941 KB";          //Zipcode => prefer space between numbers and letters
    $city                       =               "Koekange";           //City -> do i seriously need too explain.....?
    $email_contact              =               "info@vermet.nl";   //contact e-mail

    //image setings
    $file_size                  =               15728640;           //Size is in bytes so => size x 1024 x 1024;
    
    $route_beschrijving         =               '<td>Komende van de A32 neemt u de afslag <b>Meppel Noord</b>, vervolgens links afslaan richting <b>Meppel</b>.<br>

                                                De rotonde waar u op aanrijdt recht oversteken en de volgende rotonde (bij de watertoren) rijdt u driekwart over. U volgt de borden <b>Centrum</b>.<br>
                                                <br>
                                                Na het oversteken van de beweegbare brug gaat u direct rechtsaf het Noordeinde op. Over de (vaste) brug meteen links langs het water de parkeerplaats oprijden.<br>
                                                <br>
                                                U kunt ook uw auto parkeren op onze eigen parkeerplaats, rechts om de hoek gemarkeerd met "Parkeren uitsluitend bezoekers Vermet". Deze is <u>gratis</u>. Lopend via de steegjes komt u in de Molenstraat waar wij onder huisnummer 32a zijn te vinden.<br>
                                                <br>
                                                Voorzover u met de auto uit andere richtingen komt adviseer ik u de watertoren aan de steenwijkerstraatweg als oriëntatiepunt te nemen.</td>
                                                ';
?>
