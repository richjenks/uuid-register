<?php

// Generates a v4 UUID
// See https://gist.github.com/dahnielson/508447
function uuid() {
	return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

		// 32 bits for "time_low"
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

		// 16 bits for "time_mid"
		mt_rand( 0, 0xffff ),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand( 0, 0x0fff ) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand( 0, 0x3fff ) | 0x8000,

		// 48 bits for "node"
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}

// Default HTTP status
$status = 200;

// Storage directory
$dir = join(DIRECTORY_SEPARATOR, [__DIR__, '.id']);
if (!is_dir($dir)) mkdir($dir);

// ID provided, check whether it's in use
if (!empty($_SERVER['QUERY_STRING'])) {
	$file = join(DIRECTORY_SEPARATOR, [$dir, $_SERVER['QUERY_STRING']]);
	if (file_exists($file)) {
		echo 1;
		$status = 200;
	} else {
		echo 0;
		$status = 400;
	}
}

// If not, generate a new unused ID and store
else {
	do {
		$uuid = uuid();
		$file = join(DIRECTORY_SEPARATOR, [$dir, $uuid]);
	} while (file_exists($file));
	touch($file);
	echo $uuid;
	$status = 201;
}

// Respond!
http_response_code($status);
