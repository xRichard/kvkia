<?php
	//functions file
	//This loads the header of the page, includes doctype, CSS, everything till the body tag.
	//$css_user is because the admin part is in a different folder.

	function doctype($page, $css_user)
	{
		//include config for title
		include('config.inc.php');
		//Strict doctype
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
		echo '<head>';
		//metatype
		echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
		//Keywords for google etc
		echo '<meta name="Keywords" content="" />';
		//Description of the website
		echo '<meta name="Description" content="" />';
		//$overall_title is loaded from config.inc.php, $page = given with the function
		echo "<title>".$overall_title." - ".$page."</title>";
		//General stylesheet
		echo '<!-- Stylesheet -->';
		//This check is because of the include can be fixed a lot easier ofc
		//by just adding the hardcoded link based on the config.
		if($css_user == "user")
		{
			echo '<link rel="stylesheet" href="includes/vermet.css" type="text/css" />';
			echo '<link rel="stylesheet" href="includes/lightbox/css/lightbox.css" type="text/css" media="screen" />';
		?>
			<script type="text/javascript" src="includes/lightbox/js/prototype.js"></script>
			<script type="text/javascript" src="includes/lightbox/js/scriptaculous.js?load=effects,builder"></script>
			<script type="text/javascript" src="includes/lightbox/js/lightbox.js"></script>
			<script type="text/javascript" src="includes/custom_elements/custom-form-elements.js"></script>

		<?php
		}
		else if($css_user == "admin")
		{
			echo '<link rel="stylesheet" href="../includes/vermet.css" type="text/css" />';

			echo '<script type="text/javascript" src="../includes/mootools/mootools.js"></script>';
			?>
			<script type="text/javascript" src="../includes/ckeditor/ckeditor.js"></script>
			<style type="text/css" media="screen">

				input.error            {border: 1px dotted red;}

			</style>
<script type="text/javascript">

        window.addEvent ('domready', function () {

            $$('input.required').each (function (item) {

                item.addEvent ('blur', function () {

                    if (item.get ('value') == '') {

                        item.setAttribute ('class', 'error');

                    }

                    else {

                        item.setAttribute ('class', 'required');

                    }

                });

            });

        });
</script>
<script type="text/javascript" src="includes/imageupload/jquery-1.3.2.js"></script>
<script type="text/javascript" src="includes/imageupload/swfupload/swfupload.js"></script>
<script type="text/javascript" src="includes/imageupload/jquery.swfupload.js"></script>

<script type="text/javascript">

$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "includes/imageupload/process_upload.php?postcode=<?php echo $_GET['postcode']; ?>&huisnummer=<?php echo $_GET['huisnummer']; ?>&house_id=<?php echo $_GET['house_id']; ?>",
		file_post_name: 'uploadfile',
		file_size_limit : "10240",
		file_types : "*.jpg;*.png;*.gif; *.JPG",
		file_types_description : "Image files",
		file_upload_limit : 0,
		flash_url : "includes/imageupload/swfupload/swfupload.swf",
		button_image_url : 'includes/imageupload/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Size of the file '+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href="../images/aanbod/<?php echo $_GET['postcode']."/".$_GET['huisnummer']."/"; ?>'+file.name+'" target="_blank" >view &raquo;</a>';
			item.addClass('success').find('p.status').html('Succes | '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})

});

    </script><style type="text/css" >
#swfupload-control p{ margin:10px 5px; font-size:0.9em; }
#log{ margin:0; padding:0; width:500px;}
#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px;
	font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}
#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }
#log li .progress{ background:#999; width:0%; height:5px; }
#log li p{ margin:0; line-height:18px; }
#log li.success{ border:1px solid #339933; background:#ccf9b9; }
#log li span.cancel{ position:absolute; top:5px; right:5px; width:20px; height:20px;
	background:url('includes/imageupload/swfupload/cancel.png') no-repeat; cursor:pointer; }
</style><?php
		}

		echo '</head>';
		echo '<body>';
		echo '<!-- Wrapper div -->';
		echo '<div id="container">';
		echo '<!-- Header -->';
		echo '<div id="header">';
	}

	function footer()
	{
	//Footer for all the pages, so that there is one footer in all pages.
	include("config.inc.php");
	//Generating the lower footer part
	//footer bar build
	echo '</div>
		<!-- end wrapper -->
		<div id="footer">
			Copyright <a href="http://'.$link.'/admin" title="Beheergedeelte">&copy;</a> 2011 - Korfbalvereninging KIA 
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			Beheerd door: <a href="http://www.vangijsselcomputers.nl"> vangijsselcomputers </a>
			</div>

		<!-- end footer -->
	</div>
	<!-- end container -->
        </body>
        </html>';
	}

	//function too connect too the database
	function db_connect()
	{
	//include config file for database connection
	include('config.inc.php');
	//set connection var
	$con = mysql_connect($server, $user, $password);
	//Check if connection works if not return error
		if (!$con)
  			{
  				die('Could not connect: ' . mysql_error());
  			}
		//Connection works
		else
			{
		//Select database
				$db_selected = mysql_select_db($database, $con);
		//check if selected database exists, if not return error.
					if (!$db_selected)
						{
    						die ('Can\'t use '.$database.' : ' . mysql_error());
						}
			}
	}

	
function show_sqlpage($page_id)
{
    if(is_numeric($page_id))
    {
        $page_id = MYSQL_REAL_ESCAPE_STRING($page_id);
        $sql = mysql_query('SELECT page_title, page_content FROM pages WHERE page_id = '.$page_id.';');
        $content = mysql_fetch_array($sql);
    if (get_magic_quotes_gpc()) {
      function stripslashes_deep($value)
      {
          $value = is_array($value) ?
                      array_map('stripslashes_deep', $value) :
                      stripslashes($value);

          return $value;
      }
    }

            echo "<h1>".stripslashes_deep($content['page_title'])."</h1>";
            echo stripslashes_deep($content['page_content']);

    }
    else
    {
        echo "Er is ergens iets verkeerd gegaan met het ophalen van de database gegevens.";
    }
}

function validate_email($email)
{
	$isValid = true;
	$atIndex = strrpos($email,"@");
		if(is_bool($atIndex) && !$atIndex)
		{
				$isValid = false;
		}
		else
		{
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if($localLen < 1 || $localLen > 64)
			{
				//The local length part exceeded.
				$isValid = false;
			}
			else if($domainLen < 1 || $domainLen > 255)
			{
				//domain length exceeded
				$isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.')
			{
				//local part starts or ends with a .
				$isValid = false;
			}
			else if(preg_match('/\\.\\./',$local))
			{
				//local part has two consecutive dots.
				$isValid = false;
			}
			else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
                 {
                 	//character not valid in local part unless local part is quoted
                 	if (!preg_match('/^"(\\\\"|[^"])+"$/',
             		str_replace("\\\\","",$local)))
         				{
            				$isValid = false;
         				}

                 }
            if($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A")))
            {
            	//domain not found in DNS
            	$isValid = false;
		$error = '7';
            }
		}
		return $isValid;
}
function send_mail($sender,$subject,$content)
{
	include('config.inc.php');
	require_once('swiftmailer/swift_required.php');
	$transport = Swift_SmtpTransport::newInstance('localhost', 25);
	$mailer = Swift_Mailer::newInstance($transport);
	$message = Swift_Message::newInstance()
	
	//Give the message a subject
	->setSubject('Bericht via website vermet.nl')
	
	//Set the from address
	->setFrom(array('website@vermet.nl' => 'Website Vermet.nl'))
	
	//Set the to address
	->setTo(array( $email => $naam_makelaar))
	
	//Give it a body
	->setBody('Onderwerp: '.$subject.' <br />
		  Verzonden door: '.$sender.' <br />
		  <hr />
		  '.nl2br($content).'','text/html');
	
	if ($mailer->send($message))
	{
		echo "Uw bericht is succesvol verzonden. \n";
	}
	else
	{
		echo "Er is helaas iets fout gegaan tijdens het verzenden van uw bericht. \n";
	}

}


function include_remote($url) {
$output = "";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
return $output;
}



?>
