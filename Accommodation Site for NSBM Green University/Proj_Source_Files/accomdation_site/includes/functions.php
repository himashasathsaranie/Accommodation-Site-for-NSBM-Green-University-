<?php
// Function to sanitize user input
function sanitize_input($input) {
    // Prevent SQL injection
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($input)));
}

// Function to redirect to a specified URL
function redirect($url) {
    header("Location: $url");
    exit();
}
?>
