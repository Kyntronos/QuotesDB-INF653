<?php
    // Disable directory listing by sending a 403 Forbidden status code
if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
    http_response_code(403);
    exit("Access Forbidden");
}

// Show your message
echo "Mid-term Proj: REST API - KyleCassity";
