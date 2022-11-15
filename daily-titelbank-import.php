<?php


// define some variables
$conn = ftp_connect('ftp.titelbank.nl');
$ftp_user_name = get_field('titelbank_ftp_user', 'options');
$ftp_user_pass = get_field('titelbank_ftp_password', 'options');

ftp_login($conn, $ftp_user_name, $ftp_user_pass);


$files = ftp_nlist($conn, '');

$mostRecent = array(
    'time' => 0,
    'file' => null
);

foreach ($files as $file) {
    // get the last modified time for the file
    $time = ftp_mdtm($conn, $file);

    if ($time > $mostRecent['time']) {
        // this file is the most recent so far
        $mostRecent['time'] = $time;
        $mostRecent['file'] = $file;
    }
}

ftp_get($conn, "onixexport.zip", $mostRecent['file']);
ftp_close($conn);

ftp_close($conn);