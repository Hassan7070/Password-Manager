<?php
session_start();

// Redirect to password storage page if user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: password_storage.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "password_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = "";
$password = "";
$errors = array();

// User login handling
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Query to check if username exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['username'] = $username;
            header('Location: password_storage.php');
            exit();
        } else {
            array_push($errors, "Incorrect username or password");
        }
    } else {
        array_push($errors, "Incorrect username or password");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Password Manager</title>
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

<body>




    <div class="relative w-full h-screen overflow-hidden p-20 ">
        <div
            class="  p-10 w-1/2 md:w-1/3 mx-auto block bg-gray-400 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100">

            <div class="text-white ">
                <h1 class="font-bold text-4xl my-4 text-teal-500">Login</h1>

                <form method="post" action="login.php">
                    <?php if (!empty($errors)): ?>
                        <div class="error">
                            <?php foreach ($errors as $error): ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="flex flex-col gap-y-3 my-10">

                        <label class="font-semibold " for="username">Username</label>
                        <input class="p-3 bg-gray-400 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100" type="text" id="username" name="username" value="<?php echo $username; ?>" required>
                        <label for="password">Password</label>
                        <input class="p-3 bg-gray-400 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100" type="password" id="password" name="password" required>
                        <input class="mt-5 p-3 bg-teal-500 text-white hover:bg-teal-600 transition rounded-md "type="submit" name="login" value="Login">
                    </div>
                </form>

                <div class="register-link">
                    <p>Don't have an account? <a href="Passwordmanager.php" class="text-teal-500">Register</a></p>
                </div>
            </div>
        </div>
        <div class="bg-black w-screen h-[800px] opacity-70 -z-10 absolute top-0 right-0"></div>
        <img src="lockimg.jpg" alt="Hero Image" class="absolute -z-20 top-0 right-0 w-full ">
    </div>

</body>

</html>