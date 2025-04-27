<?php
// Initialize the session
session_start();

// Include config file
require_once "../config/config.php";

// Define variables and initialize with empty values
$address = $description = $rental = $image_path = "";
$address_err = $description_err = $rental_err = $image_err = "";

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

    // Validate image file
    if (empty($_FILES["image"]["name"])) {
        $image_err = "Please select an image file.";
    } else {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $image_err = "File is not an image.";
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            $image_err = "Sorry, your file is too large.";
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $image_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (empty($image_err)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $image_err = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Check input errors before inserting into database
    if (empty($address_err) && empty($description_err) && empty($rental_err) && empty($image_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO properties (user_id, address, description, rental, image_path) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issss", $param_user_id, $param_address, $param_description, $param_rental, $param_image_path);

            // Set parameters
            $param_user_id = $_SESSION["id"];
            $param_address = $address;
            $param_description = $description;
            $param_rental = $rental;
            $param_image_path = $image_path;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to manage properties page
                header("location: index.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Property</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="max-w-lg mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Add Property</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-semibold mb-2">Image</label>
                        <input type="file" id="image" name="image" class="w-full border-2 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500">
                        <span class="text-red-500"><?php echo $image_err; ?></span>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Add Property</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
