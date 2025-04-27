<?php
// Initialize the session
session_start();

// Include config file
require_once "../config/config.php";

// Check if the user is logged in and is a student, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'student') {
    header("location: ../index.php");
    exit;
}

// Check if property id is set
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
    // Redirect to error page
    header("location: error.php");
    exit;
}

// Fetch the status of the property
$sql_status = "SELECT warden_status FROM properties WHERE property_id = ? AND warden_status = 'approved'";

if ($stmt_status = mysqli_prepare($link, $sql_status)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt_status, "i", $param_property_id);

    // Set parameters
    $param_property_id = trim($_GET["id"]);

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt_status)) {
        // Store result
        mysqli_stmt_store_result($stmt_status);

        // Check if the property exists and has been approved by the warden
        if (mysqli_stmt_num_rows($stmt_status) == 1) {
            // Property has been approved by warden, proceed with reservation
            // Prepare a reservation statement
            $sql_reservation = "INSERT INTO reservations (property_id, student_id) VALUES (?, ?)";

            if ($stmt_reservation = mysqli_prepare($link, $sql_reservation)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt_reservation, "ii", $param_property_id, $param_student_id);

                // Set parameters
                $param_property_id = trim($_GET["id"]);
                $param_student_id = $_SESSION["id"];

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt_reservation)) {
                    // Update property status to 'reserved'
                    $sql_update = "UPDATE properties SET status = 'reserved' WHERE property_id = ?";
                    if ($stmt_update = mysqli_prepare($link, $sql_update)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt_update, "i", $param_property_id);

                        // Set parameters
                        $param_property_id = trim($_GET["id"]);

                        // Attempt to execute the prepared statement
                        mysqli_stmt_execute($stmt_update);

                        // Close statement
                        mysqli_stmt_close($stmt_update);
                    }
                    // Redirect to student dashboard
                    header("location: index.php");
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }

            // Close statement
            mysqli_stmt_close($stmt_reservation);
        } else {
            // Property does not exist or has not been approved by warden
            header("location: error.php");
        }
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt_status);
}

// Close connection
mysqli_close($link);
?>
