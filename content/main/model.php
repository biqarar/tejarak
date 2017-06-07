<?php
namespace content\main;

class model extends \mvc\model
{
	// API BRANCH
	use \content_api\v1\branch\tools\get;
	use \content_api\v1\branch\tools\add;

	// API TEAM
	use \content_api\v1\team\tools\add;
	use \content_api\v1\team\tools\get;
	use \content_api\v1\team\tools\delete;

	// API MEMBER
	use \content_api\v1\member\tools\add;
	use \content_api\v1\member\tools\get;

	// API GETWAY
	use \content_api\v1\getway\tools\get;
	use \content_api\v1\getway\tools\add;

	// API FILE
	use \content_api\v1\file\tools\get;
	use \content_api\v1\file\tools\link;

}
?>