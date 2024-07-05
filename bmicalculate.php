<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $height = $_POST["height"] / 100; //Cinvert height to meters
        $weight = $_POST["weight"];

        $bmi = $weight/ ($height * $height);

        $_SESSION["bmi"] = $bmi;

        header("Location: login.html");
        exit();
    }
?>