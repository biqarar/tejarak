<?php
$modules = array();
/**
 * poll to complete profile
 */
$modules['admin'] = array(
'desc' 			=> T_("Allow to add the poll for profile completion"),
'icon'			=> 'file-text-o',
'permissions'	=> ['admin'],
);


return ["modules" => $modules];
?>