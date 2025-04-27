<?php
// Initialize the session
session_start();

// Include config file
require_once "../config/config.php";

// Check if the user is logged in and is a landlord, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'landlord') {
    header("location: ../login.php");
    exit;
}

// Check if property id is set
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
    // Redirect to error page
    header("location: error.php");
    exit;
}

// Prepare a delete statement
$sql = "DELETE FROM properties WHERE property_id = ?";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_property_id);

    // Set parameters
    $param_property_id = trim($_GET["id"]);

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to manage properties page
        header("location: manage_properties.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($link);

?>
