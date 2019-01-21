<?php

/*

Get core area credit requirements and hex color

*/

function session_credit_reqs() {
	require_once __DIR__ . "/sql.php";

	$_SESSION['credit_reqs'] = sql("SELECT area, total_req, hexcolor FROM credit_reqs", '', False, True, True);
}

