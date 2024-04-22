<?php
session_start();

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

// Register user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    } elseif (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    } elseif (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[!@#\$%^&*()\-_=+{};:,<.>]/", $password)) {
        array_push($errors, "Password must include at least one lowercase letter, one uppercase letter, one number, and one special character");
    }

    // Check if username already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
    }

    // If no errors, insert user into database
    if (count($errors) == 0) {
        // Hash the password before storing it in the database
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password_hash) VALUES('$username', '$password_hash')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['username'] = $username;
            header('Location: password_storage.php');
            exit();
        } else {
            array_push($errors, "Error registering user: " . mysqli_error($conn));
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager</title>
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

<body class=" ">

    <nav class="text-slate-700 bg-white font-bold p-4 flex justify-end border-b-4 border-teal-600 shadow-sm">
        <a href="Passwordmanager.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Home</a>
        <a href="login.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Login</a>
        <a href="password_checker.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Checker</a>
        <a href="password_generator.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Generator</a>
    </nav>

    <div class="relative ">
        <!-- Image -->
        <div class="relative w-full h-screen overflow-hidden flex flex-col justify-center ">
            <div
                class="ml-20 p-10 w-1/2 bg-gray-400 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100">
                <h1 class="text-white font-bold text-4xl text-white">Make yourself Secure <span
                        class="block text-teal-500">With Strong Passwords</span></h1>
                <p class="text-white w-1/2 mt-4">Forget juggling multiple passwords. Our platform offers a secure, centralized hub for all your credentials. With features like password strength checking and generation, your accounts are safeguarded with strong, unique passwords. Join us for peace of mind in the digital age
   </p>
                

            </div>
            <div class="bg-black w-screen h-[800px] opacity-70 -z-10 absolute top-0 right-0"></div>
            <img src="lockimg.jpg" alt="Hero Image" class="absolute -z-20 top-0 right-0 w-full ">
        </div>
    </div>


    <div class="flex justify-between mx-32 my-64">

        <div class="w-1/3">
            <h1 class="font-bold text-2xl my-2">Check Your Password Strength</h1>
            <h2 class="font-semibold text-xl text-teal-500 my-1">Ensure Your Online Security with Our Password Strength
                Checker</h2>
            <p>Protect your digital assets by verifying the strength of your passwords. Our Password Strength Checker
                evaluates the complexity and resilience of your passwords, helping you create stronger ones to safeguard
                your accounts</p>
            <button onclick="window.location.href='password_checker.php'" type="button"
                class="mt-20 bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:-translate-y-2 transition duration-500">Analyze
                Password Strength</button>
        </div>
        <div class="w-1/2 text-[200px] flex items-center justify-center hover:-translate-y-5 transition duration-300">

            <i class="fa-solid fa-user-secret"></i>
        </div>
    </div>

    <div class="flex justify-between flex-row-reverse mx-32 my-64">

        <div class="w-1/2">
            <h1 class="font-bold text-2xl my-2">Generate Strong Passwords Instantly</h1>
            <h2 class="font-semibold text-xl text-teal-500 my-1">Enhance Your Online Security with Our Password
                Generator</h2>
            <p>Easily create robust and unpredictable passwords with our Password Generator tool. Say goodbye to weak
                and easily guessable passwords. Our generator creates unique combinations of characters, making your
                accounts virtually impenetrable to hackers</p>
            <button onclick="window.location.href='password_generator.php'" type="button"
                class="mt-10 bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:-translate-y-2 transition duration-500">Generate
                Password</button>
        </div>
        <div class="w-1/3 text-[200px] flex items-center justify-center hover:-translate-y-5 transition duration-300 ">

            <i class="fa-solid fa-fingerprint"></i>
        </div>
    </div>

    <div class="flex justify-between flex-row mx-32 my-64">

        <div class="w-1/2">
            <h1 class="font-bold text-2xl my-2"> Register Now!</h1>
            <h2 class="font-semibold text-xl text-teal-500 my-1">Join our community today and gain access to your own Password Manager.</h2>
            <p>Register now to take full advantage of our platform's capabilities. By signing up, you'll gain access to personalized recommendations, secure password management.</p>
            
        </div>
        
        
        <div class="w-full md:w-1/2 mb-8 md:mb-0 border-2 border-slate-400 rounded-lg py-10 px-16 mx-32 ">
        <h2 class="text-2xl font-semibold mb-4">Register</h2>
        
        <form method="post" action="Passwordmanager.php" class="mb-4">
            <?php if (!empty($errors)): ?>
                <div class="error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <label for="username" class="block mb-2">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>"
                    class="w-full py-2 px-3 mb-4 leading-tight appearance-none border rounded-md focus:outline-none focus:shadow-outline"
                    required>
                    <label for="password" class="block mb-2">Password</label>
                    <input type="password" id="password" name="password"
                    class="w-full py-2 px-3 mb-4 leading-tight appearance-none border rounded-md focus:outline-none focus:shadow-outline"
                    required>
                    <input type="submit" name="register" value="Register"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                </form>
                
                <div class="login-link text-center">
                    <p>Already have an account? <a href="login.php" class="text-teal-500">Login</a></p>
                </div>
            </div>
            
            
            
            
         
        </div>
        <div class="footer bg-gray-900 text-white text-center py-4">
            <p>&copy; <?php echo date("Y"); ?> Password Manager. All rights reserved.</p>
        </div>
        </body>
        
        </html>