<?php

header("Content-type: text/css; charset: UTF-8");

session_start();
require_once '../../basic-config.php';

$site = BasicConfig::$_site;

?>

body {
    
    padding: 0;
    margin: 0;
    font-family: Arsenal;
    font-size: <?php echo $_SESSION[$site]['var']['font'].'px'; ?>;
    color: #333;
}