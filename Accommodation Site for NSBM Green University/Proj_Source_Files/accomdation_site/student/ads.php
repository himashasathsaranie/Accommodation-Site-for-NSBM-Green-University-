<?php
// Include config file
require_once "../config/config.php";

// Define an array to store all ads
$ads = array();

// Fetch all ads from the database
$sql = "SELECT * FROM ads";
$result = mysqli_query($link, $sql);

if ($result) {
    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $ads[] = $row;
    }
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ads</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-4">Ads</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($ads as $ad) : ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="<?php echo $ad['image_path']; ?>" alt="Ad Image" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2"><?php echo $ad['description']; ?></h3>
                        <!-- Add more details if needed -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
