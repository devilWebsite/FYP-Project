<?php
session_start(); // Start session to track notification state

// Reset notification state
$_SESSION['notification_viewed'] = true;

// Return success response
http_response_code(200);
?>
