<?php
    session_start();

    require_once("db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Step 1: Check if the user with the provided email exists
        $query = "SELECT * FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // User found, fetch the user data
            $userRow = mysqli_fetch_assoc($result);

            // Step 2: Check if the entered password is correct using password_verify
            //if (password_verify($password, $userRow["upassword"])) {
            if ($password == $userRow["upassword"]) {
                // Password is correct, set session variables
                $_SESSION["username"] = $userRow["uname"];
                $_SESSION["bmi"] = $userRow["bmi"];
                $_SESSION["bmi_category"] = $userRow["bmi_category"];

                switch ($_SESSION["bmi_category"]) {
                    case "Underweight":
                        header("Location: underweight.html");
                        
                        break;
                    case "Normal":
                        header("Location: normal.html");
                        break;
                    case "Overweight":
                        header("Location: overweight.html");
                        break;
                    default: 
                        // Handle other cases as needed
                        break;
                }
                exit();
            } else {
                // Invalid password
                $loginError = "Invalid credentials. Please check your email or password and try again.";
            }
        } else {
            // User not found
            $loginError = "User not found. Please check your email or password and try again.";
        }

        // Encode the error message as a URL parameter
        $loginError = urlencode($loginError);
        // Redirect back to the login page with the error message
        header("Location: login.html?error=$loginError");
        exit();
    }

    mysqli_close($conn);
?>
