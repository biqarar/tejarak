<?php
/**
 @ In the name Of Allah
**/

// if Ermile exist, require it else show related error message
if ( file_exists( '../../ermile/autoload.php') )
{
	require_once( '../../ermile/autoload.php');
}
else
{   // A config file doesn't exist
	exit("<p>We can't find <b>Ermile</b>! Please contact administrator!</p>");
}
?>