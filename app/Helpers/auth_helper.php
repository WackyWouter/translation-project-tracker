<?php
if (!function_exists('isEmailValid')) {
    function isEmailValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        //Get host name from email and check if it is valid
        $email_host = array_slice(explode("@", $email), -1)[0];

        // Check if valid IP (v4 or v6). If it is we can't do a DNS lookup
        if (!filter_var($email_host, FILTER_VALIDATE_IP, [
            'flags' => FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
        ])) {
            //Add a dot to the end of the host name to make a fully qualified domain name
            // and get last array element because an escaped @ is allowed in the local part (RFC 5322)
            // Then convert to ascii (http://us.php.net/manual/en/function.idn-to-ascii.php)
            $email_host = idn_to_ascii($email_host . '.');

            //Check for MX pointers in DNS (if there are no MX pointers the domain cannot receive emails)
            if (!checkdnsrr($email_host, "MX")) {
                return false;
            }
        }

        return true;
    }
}
if (!function_exists('isPasswordStrEnough')) {
    function isPasswordStrEnough($pwd)
    {

        if (strlen($pwd) < 8 || !preg_match("#[0-9]+#", $pwd) || !preg_match("#[a-zA-Z]+#", $pwd)) {
            return false;
        }

        return true;
    }
}
