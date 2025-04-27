<?php
// Check if property_id is set and not empty
if (isset($_POST['property_id']) && !empty($_POST['property_id'])) {
    // Include config file
    require_once "../config/config.php";

    // Prepare an SQL statement to update the warden_status of the property to 'rejected' and delete the property
    $sql = "DELETE FROM properties WHERE property_id = ? AND warden_status = 'pending'";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_property_id);

        // Set parameters
        $param_property_id = $_POST['property_id'];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the warden's dashboard
            header("location: index.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else {
    // If property_id is not set, redirect to the warden's dashboard
    header("location: index.php");
    exit;
}
?>
