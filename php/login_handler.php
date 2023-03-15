<?php
        session_start();
        
        $email = filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL);
        $_SESSION['log_email'] = "$email";
        echo($email);
        $password = $_POST['log_password'];
        $_SESSION['log_password'] = $_POST['log_password'];


        setcookie("cookie[one]", "$email");

        $conn = new mysqli("localhost", "root", "", "login");
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $check_database_query = mysqli_query($conn,"SELECT * FROM details WHERE email = '$email' AND password = '$password'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if($check_login_query == 1){
            $row = mysqli_fetch_array($check_database_query);
            $username =$row['user_name'];
            $age =$row['age'];
            $dob =$row['dob'];
            $contact =$row['contact'];

            header('Location: homepage.php');
        }
        else{
            echo($email);
            echo($password);
            echo($check_login_query);
            echo("Invalid login");
        }
?>