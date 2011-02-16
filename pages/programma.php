<?php
		
if($_GET['status'] == 'uitslagen')
{
  echo '<iframe src="http://www.antilopen.nl/competitie/uitslagen.asp?cI=530" width="100%" height="800">
            <p>Your browser does not support iframes.</p>
        </iframe>';
}

else if($_GET['status'] == 'standen')
{
  echo '<iframe src="http://www.antilopen.nl/competitie/standen.asp?cI=530" width="100%" height="800">
            <p>Your browser does not support iframes.</p>
        </iframe>';
}
else
	{
		echo 	'<iframe src="http://www.antilopen.nl/competitie/programma.asp?cI=530" width="100%" height="800">
				<p>Your browser does not support iframes.</p>
				</iframe>';
	}
		
?>