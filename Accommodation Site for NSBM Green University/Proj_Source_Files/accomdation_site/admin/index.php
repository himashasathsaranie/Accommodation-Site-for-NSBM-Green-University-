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

// Define an array to store all users
$users = array();

// Fetch all users from the database
$sql = "SELECT user_id, username, user_type FROM users";
$result = mysqli_query($link, $sql);

if ($result) {
    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex justify-between bg-blue-500 p-4">
        <div class="text-white font-bold">Accommodation Management System</div>
        <div class="flex">
            <a href="register.php" class="mx-2 text-white">Register User</a>
            <a href="ads.php" class="mx-2 text-white">Add Ads</a>
            <a href="../logout.php" class="mx-2 text-white">Sign Out</a>
        </div>
    </div>

    <div class="container mx-auto p-8">
        <div class="page-header">
            <h1 class="text-3xl font-bold">Hi, <span class="text-blue-500"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>. Welcome to our site.</h1>
        </div>

        <div class="my-8">
            <h2 class="text-2xl font-bold mb-4">All Users</h2>
            <div class="overflow-x-auto">
                <table class="table-auto border-collapse border border-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-200 border border-gray-700">ID</th>
                            <th class="px-4 py-2 bg-gray-200 border border-gray-700">Username</th>
                            <th class="px-4 py-2 bg-gray-200 border border-gray-700">User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td class="px-4 py-2 border border-gray-700"><?php echo $user['user_id']; ?></td>
                                <td class="px-4 py-2 border border-gray-700"><?php echo $user['username']; ?></td>
                                <td class="px-4 py-2 border border-gray-700"><?php echo $user['user_type']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
