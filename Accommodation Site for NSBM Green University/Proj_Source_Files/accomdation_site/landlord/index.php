<?php
// Initialize the session
session_start();

// Check if the user is logged in and is a landlord, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'landlord') {
    header("location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white font-bold text-xl">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>. Welcome to our site.</h1>
            <a href="../logout.php" class="text-white font-semibold hover:underline">Sign Out</a>
        </div>
    </div>

    <div class="container mx-auto p-8">
        <div class="my-8">
            <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-xl font-bold mb-2">Add Property</h3>
                    <p class="text-gray-600">You Can Add Properties from here.</p>
                    <a href="add_property.php" class="block mt-4 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Add Property</a>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-xl font-bold mb-2">Manage Properties</h3>
                    <p class="text-gray-600">You Can Manage Your Properties From heres.</p>
                    <a href="manage_properties.php" class="block mt-4 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Manage Properties</a>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-xl font-bold mb-2">Requests from Students</h3>
                    <p class="text-gray-600">You can see the requests from the students.</p>
                    <a href="request.php" class="block mt-4 bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">View Requests</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
