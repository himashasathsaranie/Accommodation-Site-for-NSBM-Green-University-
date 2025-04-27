<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include config file
require_once "../config/config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_user_type);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_user_type = $_POST["user_type"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: index.php");
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
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
            <h2 class="text-3xl font-bold mb-4 text-center">Sign Up</h2>
            <p class="text-center text-gray-600 mb-8">Please fill out the form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-4">
                    <label class="block mb-1">Username</label>
                    <input type="text" name="username" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500" value="<?php echo $username; ?>">
                    <span class="text-red-500"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500" value="<?php echo $password; ?>">
                    <span class="text-red-500"><?php echo $password_err; ?></span>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Confirm Password</label>
                    <input type="password" name="confirm_password" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500" value="<?php echo $confirm_password; ?>">
                    <span class="text-red-500"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">User Type:</label>
                    <select name="user_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                        <option value="landlord">Landlord</option>
                        <option value="warden">Warden</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="mb-4 flex justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                    <button type="reset" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reset</button>
                </div>
                <div class="text-center">
                    <a href="../logout.php" class="inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Sign Out</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>



