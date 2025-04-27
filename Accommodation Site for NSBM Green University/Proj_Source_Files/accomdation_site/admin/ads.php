<?php
// Initialize the session
session_start();

// Include config file
require_once "../config/config.php";

// Check if the user is logged in and is an admin, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'admin') {
    header("location: ../login.php");
    exit;
}

// Define variables and initialize with empty values
$description = $image_path = "";
$description_err = $image_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter ad description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Validate image file
    if ($_FILES["image"]["error"] == 0) {
        // Check if file size is less than 2MB
        if ($_FILES["image"]["size"] > 2097152) {
            $image_err = "Sorry, your file is too large. Max file size is 2MB.";
        } else {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $image_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                } else {
                    // Move uploaded file to uploads directory
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image_path = $target_file;
                    } else {
                        $image_err = "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                $image_err = "File is not an image.";
            }
        }
    }

    // Check input errors before inserting into database
    if (empty($description_err) && empty($image_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO ads (description, image_path) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_description, $param_image_path);

            // Set parameters
            $param_description = $description;
            $param_image_path = $image_path;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to ads page
                header("location: ads.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Add Ad</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-4">Add Ad</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="4" placeholder="Enter ad description"></textarea>
                <span class="text-red-500"><?php echo $description_err; ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image">
                <span class="text-red-500"><?php echo $image_err; ?></span>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Add Ad</button>
            </div>
        </form>
    </div>
</body>

</html>
