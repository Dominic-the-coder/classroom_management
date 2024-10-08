<?php

// 1. collect database info
$host = 'localhost';
$database_name = "classroom_management"; // connecting to which database 
$database_user = "root";
$database_password = "password";

// 2. connect to database (PDO - PHP database object)
$database = new PDO(
    "mysql:host=$host;dbname=$database_name",
    $database_user, // username
    $database_password // password
);

// 3. get all the data from the sign-up page form
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// 4. check for error (make sure all fields are filled)
if ( empty($name) || empty( $email ) || empty( $password ) || empty( $confirm_password ) ) {
   setError ("All the fields are required", '/login' );
}else if ( $password !== $confirm_password ) {
    setError ("the password is not match", '/login' );
}else if ( strlen($password) < 8 ) { // check for the password length (make sure it's at least 8 characters)
    setError ("Your password must be at least 8 characters", '/login' );
}else {
    // 5. create a user account
    //sql command
    $sql = "INSERT INTO users (`name`,`email`,`password`) VALUES (:name, :email, :password)";
    //prepare
    $query = $database->prepare( $sql );
    //execute
    $query->execute([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT )
    ]);
            // redirect to login.php
            header("Location: login.php");
            exit;
}

