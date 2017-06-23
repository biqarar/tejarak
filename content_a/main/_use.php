<?php
namespace content_a\main;

trait _use
{
	// API OPTIONS
	use \content_api\v1\home\tools\options;

	// API HOURS
	use \content_api\v1\hours\tools\add;

	// API TEAM
	use \content_api\v1\team\tools\add;
	use \content_api\v1\team\tools\get;
	use \content_api\v1\team\tools\close;

	// API MEMBER
	use \content_api\v1\member\tools\add;
	use \content_api\v1\member\tools\get;

	// API GETWAY
	use \content_api\v1\getway\tools\get;
	use \content_api\v1\getway\tools\add;

	// API FILE
	use \content_api\v1\file\tools\get;
	use \content_api\v1\file\tools\link;

	// API REPORT
	use \content_api\v1\report\tools\get;

}
?>