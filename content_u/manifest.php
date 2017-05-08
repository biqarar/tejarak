<?php
$modules = array();


$modules['admin'] = array(
'desc' 			=> T_("admin"),
'icon'			=> 'file-text-o',
'permissions'	=> ['admin'],
);


return ["modules" => $modules];
?>