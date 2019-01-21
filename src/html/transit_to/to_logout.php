<?php

/*

Logout

*/

session_start();
session_regenerate_id(True);

$_SESSION = array();
session_unset();
session_destroy();

header("Location: https://example.com/");
die();

