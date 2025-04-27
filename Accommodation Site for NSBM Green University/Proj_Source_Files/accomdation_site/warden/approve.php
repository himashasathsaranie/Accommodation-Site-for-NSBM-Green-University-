<?php
// Check if property_id is set and not empty
if (isset($_POST['property_id']) && !empty($_POST['property_id'])) {
    // Include config file
    require_once "../config/config.php";

    // Prepare an SQL statement to update the warden_status of the property to 'approved' if its status is 'pending'
    $sql_approve = "UPDATE properties SET warden_status = 'approved' WHERE property_id = ? AND warden_status = 'pending'";

    if ($stmt_approve = mysqli_prepare($link, $sql_approve)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_approve, "i", $param_property_id);

        // Set parameters
        $param_property_id = $_POST['property_id'];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_approve)) {
            // If the property status was successfully updated to 'approved', redirect to the warden's dashboard
            header("location: index.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt_approve);
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close connection
    mysqli_close($link);
} else {
    // If property_id is not set, redirect to the warden's dashboard
    header("location: index.php");
    exit;
}
?>
