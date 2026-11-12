<?php
function get_ip_address($url) {
    // Parse the URL to get the hostname
    $parsed_url = parse_url($url);
    if (isset($parsed_url['host'])) {
        $hostname = $parsed_url['host'];
    } else {
        // In case the URL does not have a scheme, assume it's a hostname
        $hostname = $url;
    }
    
    // Get the IP address associated with the hostname
    $ip_address = gethostbyname($hostname);
    return $ip_address;
}

// Example usage
$url = "https://msd.gptech.pk/";
$ip_address = get_ip_address($url);
echo "The IP address of $url is $ip_address";

?>
