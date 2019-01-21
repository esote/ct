<?php

/*

Escape HTML

*/

$hsc = 'hsc';
$$hsc = function($x) {
	return htmlspecialchars($x, ENT_QUOTES | ENT_HTML5);
};

