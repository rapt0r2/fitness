<?php

    session_start();
    require_once("db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];
        $heightInCm = $_POST["height"];
        $weightInKg = $_POST["weight"];
        $bmiCategory = "";
        $bmi = $weightInKg / (($heightInCm / 100) * ($heightInCm / 100));

        //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $formattedBMI = number_format($bmi, 2);

        if ($bmi < 18.5) {
            $bmiCategory = "Underweight";
        } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
            $bmiCategory = "Normal";
        } else {
            $bmiCategory = "Overweight";
        }


          // Check if the email already exists
        $checkQuery = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) == 1) {
            // User found, fetch the user data
            // Email already exists, set an error message and store it in a session variable
            $loginError = "Email Already Exists";
        } else {
            // Email doesn't exist, proceed with registration
            $query = "INSERT INTO `users` (`uid`, `fname`, `lname`, `uname`, `email`, `gender`, `upassword`, `bmi`, `bmi_category`) 
                  VALUES ('0','$firstName','$lastName','$username','$email','$gender','$password','$formattedBMI', '$bmiCategory')";
            if (mysqli_query($conn, $query)) {
                header("Location: login.html");
                exit();
            } 
            else {
                echo "Error: " . mysqli_error($conn);
            }
        }
        $loginError = urlencode($loginError);
        header("Location: signup.html?error=$loginError");
        exit();
    }
    mysqli_close($conn);

        ?>
