<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: Passwordmanager.php');
    exit();
}

// Connect to MySQL (replace these with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "password_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all passwords for the logged-in user
$username = $_SESSION['username'];
$password_query = "SELECT * FROM passwords WHERE username='$username'";
$result = mysqli_query($conn, $password_query);
$passwords = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle password registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_password'])) {
    $newUsername = $_SESSION['username'];
    $newWebsite = $_POST['new_website'];
    $newPassword = $_POST['new_password'];

    // Insert the new password into the passwords table
    $insert_query = "INSERT INTO passwords (username, website, password) VALUES ('$newUsername', '$newWebsite', '$newPassword')";
    if (mysqli_query($conn, $insert_query)) {
        header("Location: password_storage.php"); // Redirect to refresh the page
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Storage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/10a74866da.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
           
            font-style: normal;
        }
    </style>
</head>


<body class="bg-gray-100">

<nav class="bg-white shadow-sm border-b-4 border-teal-600">
        <div class="container mx-auto flex justify-end py-4">
            <a href="logout.php" class="px-4 py-2 transition hover:-translate-y-1 hover:text-teal-500">Logout</a>   
        </div>
    </nav>

    <div class="container mx-auto p-8">
        <h2 class="text-3xl font-bold mb-4">Password Storage</h2>
        <p class="text-lg">Welcome, <?php echo $username; ?>!</p>

        <?php if (!empty($passwords)): ?>
            <h3 class="text-xl font-semibold mt-6">Your Stored Passwords:</h3>
            <ul class="list-disc ml-6 mt-2">
                <?php foreach ($passwords as $password): ?>
                    <li><?php echo $password['website']; ?> - <?php echo $password['password']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="mt-6">No passwords stored yet.</p>
        <?php endif; ?>

        <!-- Password Registration Form -->
        <h3 class="text-xl font-semibold mt-6">Register New Password</h3>
        <form method="post" action="password_storage.php" class="mt-4">
            <label for="new_website" class="block">Website</label>
            <input type="text" id="new_website" name="new_website" placeholder="Enter website name" class="w-full p-3 border rounded-md mt-1" required>
            <label for="new_password" class="block mt-4">Password</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter password" class="w-full p-3 border rounded-md mt-1" required>
            <input type="submit" name="register_password" value="Register Password" class="mt-4 bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>

        <a href="logout.php" class="block mt-6 bg-slate-600 text-white font-bold rounded-md px-4 py-2 w-40  mt-10 text-center">Logout</a>
    </div>

</body>

</html>
