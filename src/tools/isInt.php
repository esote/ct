<?php

/*

Evaluate if input is an integer (or interpeted as such)

*/

function isInt($a) {
	return ctype_digit(strval($a));
}

