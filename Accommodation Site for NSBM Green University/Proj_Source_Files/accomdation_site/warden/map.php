<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Properties Map</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Set the size of the map */
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    // Include config file
    require_once "../config/config.php";

    // Fetch available properties from the database
    $sql = "SELECT address, rental FROM properties WHERE status = 'available'";
    $result = mysqli_query($link, $sql);

    // Check if query was successful
    if (!$result) {
        echo "Error fetching properties: " . mysqli_error($link);
        exit;
    }
    ?>

    <!-- Navbar -->
    <nav class="bg-blue-500 p-6">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-white font-semibold">Accommodation Management System</span>
            </div>
            <div class="flex items-center">
                <a href="index.php" class="text-white hover:text-gray-300 mr-4">View Properties</a>
                <a href="map.php" class="text-white hover:text-gray-300 mr-4">View on Map</a>
                <a href="../logout.php" class="text-white hover:text-gray-300">Sign Out</a>
            </div>
        </div>
    </nav>

    <!-- Display Google Map -->
    <div id="map"></div>

    <script>
        function initMap() {
            // Create a map object and specify the DOM element for display.
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 8
            });

            // Create markers for each property
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                var address = "<?php echo $row['address']; ?>";
                var rental = "<?php echo $row['rental']; ?>";
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'address': address }, function(results, status) {
                    if (status === 'OK') {
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            title: "Address: " + address + "\nRental: $" + rental // Include additional details here
                        });
                    } else {
                        console.error('Geocode was not successful for the following reason: ' + status);
                    }
                });
            <?php endwhile; ?>
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe7NguNKV2rc0xkBxLhEXYE5o0ATiZg9Q&callback=initMap" async defer></script>
</body>

</html>
