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

// Define variables and initialize with empty values
$address = $description = $rental = "";
$address_err = $description_err = $rental_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter the address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Validate rental
    if (empty(trim($_POST["rental"]))) {
        $rental_err = "Please enter the rental amount.";
    } else {
        $rental = trim($_POST["rental"]);
    }

    // Check input errors before updating the database
    if (empty($address_err) && empty($description_err) && empty($rental_err)) {
        // Prepare an update statement
        $sql = "UPDATE properties SET address = ?, description = ?, rental = ? WHERE property_id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssdi", $param_address, $param_description, $param_rental, $param_property_id);

            // Set parameters
            $param_address = $address;
            $param_description = $description;
            $param_rental = $rental;
            $param_property_id = $_GET["id"];

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
    }

    // Close connection
    mysqli_close($link);
} else {
    // Get property details from database
    $property_id = $_GET["id"];
    $sql = "SELECT address, description, rental FROM properties WHERE property_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_property_id);

        // Set parameters
        $param_property_id = $property_id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if property exists
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $address, $description, $rental);
                mysqli_stmt_fetch($stmt);
            } else {
                // Redirect to error page
                header("location: error.php");
                exit;
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Property</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="max-w-lg mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Edit Property</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $property_id; ?>" method="post">
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                        <input type="text" id="address" name="address" class="w-full border-2 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" value="<?php echo $address; ?>">
                        <span class="text-red-500"><?php echo $address_err; ?></span>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea id="description" name="description" class="w-full border-2 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"><?php echo $description; ?></textarea>
                        <span class="text-red-500"><?php echo $description_err; ?></span>
                    </div>
                    <div class="mb-4">
                        <label for="rental" class="block text-gray-700 font-semibold mb-2">Rental Amount</label>
                        <input type="text" id="rental" name="rental" class="w-full border-2 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" value="<?php echo $rental; ?>">
                        <span class="text-red-500"><?php echo $rental_err; ?></span>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Update Property</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
