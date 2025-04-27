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

// Fetch approved properties from the database
$sql_approved = "SELECT * FROM properties WHERE warden_status = 'approved'";
$result_approved = mysqli_query($link, $sql_approved);

// Check if query was successful
if (!$result_approved) {
    echo "Error fetching properties: " . mysqli_error($link);
    exit;
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<?php include 'navbar.php'; ?>


<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="max-w-lg mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Available Properties</h2>
                <?php if (mysqli_num_rows($result_approved) > 0) : ?>
                    <ul>
                        <?php while ($row = mysqli_fetch_assoc($result_approved)) : ?>
                            <li class="border-b border-gray-300 py-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold"><?php echo $row['address']; ?></h3>
                                        <p class="text-gray-500"><?php echo $row['description']; ?></p>
                                        <p class="text-gray-500">Rental Amount: $<?php echo $row['rental']; ?></p>
                                    </div>
                                    <div>
                                        <img src="<?php echo $row['image_path']; ?>" alt="Property Photo" class="w-32 h-32 object-cover rounded-md">
                                    </div>
                                    <div class="flex items-center">
                                        <a href="reserve_property.php?id=<?php echo $row['property_id']; ?>" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Reserve</a>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-gray-500">No available properties.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
