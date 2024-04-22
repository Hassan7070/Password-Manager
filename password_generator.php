<?php
// Function to generate random password
function generateRandomPassword($length = 12) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_';
    $password = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[mt_rand(0, $max)];
    }

    return $password;
}

// Initialize variables
$password_length = 12;
$generated_password = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_password'])) {
    $password_length = $_POST['password_length'];
    $generated_password = generateRandomPassword($password_length);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
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
        <a href="password_checker.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Checker</a>
        <a href="password_generator.php" class="px-4  py-2 transition hover:-translate-y-1 hover:text-teal-500">Generator</a>
    </nav>


    <div class="bg-black w-screen h-screen opacity-70 -z-10 absolute top-0 right-0"></div>
    <img src="lockimg.jpg" alt="Hero Image" class="absolute -z-20 top-0 right-0 w-full ">
    <div
        class=" mx-auto  p-8 w-1/2 mt-20  bg-gray-400 rounded-md bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100">
        <h1 class="text-3xl text-white font-bold mb-8 ">Password Generator</h1>

        <form method="post" action="password_generator.php" class="mb-8">
            <label for="password_length" class="block mb-2 text-white ">Password Length:</label>
            <input type="number" id="password_length" name="password_length" min="8" max="32" value="<?php echo $password_length; ?>" class="w-full py-2 px-4 mb-4 leading-tight appearance-none border rounded-md focus:outline-none focus:shadow-outline" required>
            <input type="submit" name="generate_password" value="Generate Password" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>

        <?php if (!empty($generated_password)): ?>
            <div class="bg-gray-200 p-4 rounded mb-4">
                <strong class="text-teal-700">Generated Password:</strong><br>
                <?php echo $generated_password; ?>
            </div>
        <?php endif; ?>

        <!-- Button to go back to Password Manager homepage -->
        <button class="my-10 bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="window.location.href='Passwordmanager.php'">Go back to Password Manager</button>
    </div>

</body>

</html>