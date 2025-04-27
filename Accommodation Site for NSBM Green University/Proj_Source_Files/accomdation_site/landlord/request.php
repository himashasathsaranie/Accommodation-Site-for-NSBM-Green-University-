<?php
// Include config file
require_once "../config/config.php";

// Check if the user is logged in and is a landlord, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 'landlord') {
    header("location: ../index.php");
    exit;
}

// Fetch properties with pending reservation requests
$sql_requests = "SELECT * FROM properties WHERE student_request = 'pending'";
$result_requests = mysqli_query($link, $sql_requests);

// Check if query was successful
if (!$result_requests) {
    echo "Error fetching reservation requests: " . mysqli_error($link);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landlord Request Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../navbar.php'; ?>

    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-4">Reservation Requests</h2>
        <?php if (mysqli_num_rows($result_requests) > 0) : ?>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($result_requests)) : ?>
                    <li class="border-b border-gray-300 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold"><?php echo $row['address']; ?></h3>
                                <p class="text-gray-500"><?php echo $row['description']; ?></p>
                                <p class="text-gray-500">Rental Amount: $<?php echo $row['rental']; ?></p>
                            </div>
                            <div class="flex items-center">
                                <form action="approve_request.php" method="post">
                                    <input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">
                                    <button type="submit" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">Approve</button>
                                </form>
                                <form action="reject_request.php" method="post">
                                    <input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">
                                    <button type="submit" class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600">Reject</button>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p class="text-gray-500">No pending reservation requests.</p>
        <?php endif; ?>
    </div>
</body>
</html>

