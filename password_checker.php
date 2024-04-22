<?php
// Function to provide detailed feedback on password strength
function providePasswordFeedback($password) {
    $feedback = '';
    $score = 0;

    // Check for minimum length
    if (strlen($password) >= 8) {
        $score += 2;
    } else {
        $feedback .= "Password should be at least 8 characters long.<br>";
    }

    // Check for presence of uppercase letters
    if (preg_match('@[A-Z]@', $password)) {
        $score += 2;
    } else {
        $feedback .= "Password should contain at least one uppercase letter.<br>";
    }

    // Check for presence of lowercase letters
    if (preg_match('@[a-z]@', $password)) {
        $score += 2;
    } else {
        $feedback .= "Password should contain at least one lowercase letter.<br>";
    }

    // Check for presence of numbers
    if (preg_match('@[0-9]@', $password)) {
        $score += 2;
    } else {
        $feedback .= "Password should contain at least one number.<br>";
    }

    // Check for presence of special characters
    if (preg_match('@[^\w]@', $password)) {
        $score += 2;
    } else {
        $feedback .= "Password should contain at least one special character.<br>";
    }

    // Determine overall score and provide feedback
    if ($score >= 8) {
        $feedback .= "Your password is very strong!";
    } elseif ($score >= 6) {
        $feedback .= "Your password is strong, but could be stronger. Consider adding more complexity.";
    } elseif ($score >= 4) {
        $feedback .= "Your password is okay, but it could be improved. Try adding more characters and variety.";
    } elseif ($score >= 2) {
        $feedback .= "Your password is weak. It needs more characters and variety to be secure.";
    } else {
        $feedback .= "Your password is very weak. Please choose a stronger password.";
    }

    return $feedback;
}

// Initialize variables
$password = "";
$feedback_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_password'])) {
    $password = $_POST['password'];

    // Provide detailed feedback on password strength
    $feedback_message = providePasswordFeedback($password);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Checker</title>
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

<body class="bg-slate-900">


    <nav class="text-slate-700 bg-white font-bold p-4 flex justify-end border-b-4 border-teal-600 shadow-sm">
        <a href="Passwordmanager.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Home</a>
        <a href="login.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Login</a>
        <a href="password_checker.php"
            class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Checker</a>
        <a href="password_generator.php"
            class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Generator</a>
    </nav>

    <div class="bg-black w-screen h-screen opacity-70 -z-10 absolute top-0 right-0"></div>
    <img src="lockimg.jpg" alt="Hero Image" class="absolute -z-20 top-0 right-0 w-full ">
    <div
        class=" mx-auto  p-8 w-1/2 mt-20  bg-gray-400 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100">
        <h1 class="text-3xl text-white font-bold mb-8 ">Password Checker</h1>

        <form method="post" action="password_checker.php" class="mb-8">
            <label for="password" class="block mb-2 text-white">Enter your password:</label>
            <input type="password" id="password" name="password"
                class="w-full py-2 px-4 mb-4 leading-tight appearance-none border rounded-md focus:outline-none focus:shadow-outline"
                required>
            <input type="submit" name="check_password" value="Check Password"
                class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>

        <?php if (!empty($feedback_message)): ?>
            <div class="bg-gray-200 p-4 rounded">
                <p class="text-teal-700"><?php echo $feedback_message; ?></p>
            </div>
        <?php endif; ?>

        <!-- Home button -->
        <button
            class="my-10 bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            onclick="window.location.href='Passwordmanager.php'">Go back to Home</button>
    </div>

</body>

</html>