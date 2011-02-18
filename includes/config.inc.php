<?php
    //Database connection
    $user          		=       	"root";		//Database username
    $password       		=       	"171284";	//Database password
    $server         		=       	"localhost"; 	//In case of custom port use: ip_adress:port
    $database	    		=	    	"vermet";	//Database

    //website configuration
    $overall_title		=		"kvkia.nl";	//The title of the website, the general part.
    $link			=		"127.0.0.1/vermet.nl/vermet";	//Domain info => for example: www.vermet.nl used too build up certain links.
    //RSS config
    $rss_feed                   =               "http://rss.eigenhuis.nl/news.xml"; //XML link input
    //Cache dir is required for the RSS feed, without it, it will keep loading the news from the RSS feed making both this website
    //slow and the other one, and also generating a lot of unneeded traffic.
    $cache_dir                  =               "/var/www/development/vermet.nl/cache";
    $total_feeds                =               5;      //Number of feeds that will be showed on the main page.
    $length_rss_description     =               150;    //Number of characters the RSS feed will show till giving a few dots.
    
    //XML config
    $makelaar                   =               "Korfbalvereniging Kia";           //Name of company
    $makelaarsOrganisatie       =               "";                 //Which organisation in this case => NVM for example
    $naam_makelaar              =               "Kia";                 //The name of the real estate agent
    $telefoon                   =               "0522-451067";                 //phone number
    $email                      =               "";  //e-mail adress of real estate agent
    
    //Contact information
    $streetname                 =               "Sportlaan 1c";  //street name
    $zipcode                    =               "7958 SL";          //Zipcode => prefer space between numbers and letters
    $city                       =               "Koekange";           //City -> do i seriously need too explain.....?
    $email_contact              =               "";   //contact e-mail

    //image setings
    $file_size                  =               15728640;           //Size is in bytes so => size x 1024 x 1024;
    
    $veld         =               				'<td>wij spelen in het veld seizoen op de bovenstaande locatie.<br>
													<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.nl/maps?f=d&amp;source=s_d&amp;saddr=52.697893,6.317025&amp;daddr=&amp;hl=nl&amp;geocode=FSUbJAMd4WNgAA&amp;mra=ls&amp;sll=52.698008,6.316903&amp;sspn=0.001442,0.004128&amp;ie=UTF8&amp;t=h&amp;ll=52.698008,6.316903&amp;spn=0.001442,0.004128&amp;output=embed"></iframe><br /><small><a href="http://maps.google.nl/maps?f=d&amp;source=embed&amp;saddr=52.697893,6.317025&amp;daddr=&amp;hl=nl&amp;geocode=FSUbJAMd4WNgAA&amp;mra=ls&amp;sll=52.698008,6.316903&amp;sspn=0.001442,0.004128&amp;ie=UTF8&amp;t=h&amp;ll=52.698008,6.316903&amp;spn=0.001442,0.004128" style="color:#0000FF;text-align:left">Grotere kaart weergeven</a></small>
                                                </td>
                                                ';


   



    //XML config
    $sporthal                   =               "Sporthal De Slenken";           //Name of company
    $makelaarsOrganisatie       =               "";                 //Which organisation in this case => NVM for example
    $naam_makelaar              =               "Kia";                 //The name of the real estate agent
    $telefoonsporthal                   =               "0522-441088";                 //phone number
    $email                      =               "";  //e-mail adress of real estate agent
    
    //Contact information
    $streetnamesporthal         =               "H Tillemaweg 63/B";  //street name
    $zipcodesporthal            =               "7957 CB";          //Zipcode => prefer space between numbers and letters
    $citysporthal               =               "De Wijk";           //City -> do i seriously need too explain.....?
    $email_contact              =               "";   //contact e-mail

    //image setings
    $file_size                  =               15728640;           //Size is in bytes so => size x 1024 x 1024;
    
    $zaal         =               				'<td>in de zaal spelen wij op de bovenstaande locatie.<br>
													<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.nl/maps?f=d&amp;source=s_d&amp;saddr=52.676412,6.298631&amp;daddr=H.+Tillemaweg+63,+7957+De+Wijk&amp;hl=nl&amp;geocode=%3BCRAx4BIF3aVzFZLGIwMdpARgACmJkjR0pQ3IRzHhWyZfgiRQMw&amp;mra=mift&amp;mrsp=0&amp;sz=18&amp;sll=52.676398,6.298535&amp;sspn=0.002885,0.008256&amp;ie=UTF8&amp;t=h&amp;ll=52.676398,6.298535&amp;spn=0.002885,0.008256&amp;output=embed"></iframe><br /><small><a href="http://maps.google.nl/maps?f=d&amp;source=embed&amp;saddr=52.676412,6.298631&amp;daddr=H.+Tillemaweg+63,+7957+De+Wijk&amp;hl=nl&amp;geocode=%3BCRAx4BIF3aVzFZLGIwMdpARgACmJkjR0pQ3IRzHhWyZfgiRQMw&amp;mra=mift&amp;mrsp=0&amp;sz=18&amp;sll=52.676398,6.298535&amp;sspn=0.002885,0.008256&amp;ie=UTF8&amp;t=h&amp;ll=52.676398,6.298535&amp;spn=0.002885,0.008256" style="color:#0000FF;text-align:left">Grotere kaart weergeven</a></small>
                                                </td>
                                                ';
?>