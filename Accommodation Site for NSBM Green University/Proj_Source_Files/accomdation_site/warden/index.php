<?php
// Initialize the session
session_start();

// Check if the user is logged in and is a warden, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'warden') {
    header("location: ../index.php");
    exit;
}

// Include config file
require_once "../config/config.php";

// Define SQL query to fetch properties for the warden, excluding those already approved
$sql = "SELECT * FROM properties WHERE warden_status != 'approved'";

// Execute the query
$result = mysqli_query($link, $sql);

// Check if query was successful
if (!$result) {
    echo "Error fetching properties: " . mysqli_error($link);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Warden Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <!-- Include the navbar -->
    <?php include_once 'navbar.php'; ?>

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-4">Warden Dashboard</h1>
        <div class="grid grid-cols-3 gap-4">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold"><?php echo $row['address']; ?></h2>
                    <p class="text-gray-500 mb-2">Rental: $<?php echo $row['rental']; ?></p>
                    <p class="text-gray-500 mb-2">Status: <?php echo $row['status']; ?></p>
                    <p class="text-gray-500 mb-2">Description: <?php echo $row['description']; ?></p>
                    <form action="approve.php" method="post" class="mb-2">
                        <input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                    </form>
                    <form action="reject.php" method="post" class="mb-2">
                        <input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>

</html>

<?php
// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($link);
?>
