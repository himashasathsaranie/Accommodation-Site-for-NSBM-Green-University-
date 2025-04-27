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

// Define an array to store all properties
$properties = array();

// Fetch properties of the logged-in landlord from the database
$sql = "SELECT * FROM properties WHERE user_id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_user_id);

    // Set parameters
    $param_user_id = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $properties[] = $row;
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="max-w-lg mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Manage Properties</h2>
                <?php if (!empty($properties)) : ?>
                    <ul>
                        <?php foreach ($properties as $property) : ?>
                            <li class="border-b border-gray-300 py-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold"><?php echo $property['address']; ?></h3>
                                        <p class="text-gray-500"><?php echo $property['description']; ?></p>
                                        <p class="text-gray-500">Rental Amount: $<?php echo $property['rental']; ?></p>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="edit_property.php?id=<?php echo $property['property_id']; ?>" class="text-blue-500 font-semibold hover:underline mr-4">Edit</a>
                                        <a href="delete_property.php?id=<?php echo $property['property_id']; ?>" class="text-red-500 font-semibold hover:underline">Delete</a>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-gray-500">No properties found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
