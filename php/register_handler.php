<?php
    session_start();
    $error_array = [];
    $data = [];
    $name = strtolower($_POST['name']);
    $em = $_POST['email'];
    $p1 = $_POST['password1'];
    $p2 = $_POST['password2'];
    echo($name);
    
    if (empty($name)) {
        $error_array['name'] = 'Name is required.';
    }

    if (empty($em)) {
        $error_array['email'] = 'Email is required.';
    }

    if (empty($p1)) {
        $error_array['password'] = 'password is required.';
    }
    if (!empty($p1) && !empty($p2) && $p1 != $p2){
            array_push($error_array,"Your passwords do not match<br>");
     }
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
    }
    if(filter_var($em,FILTER_VALIDATE_EMAIL)){
        $conn = new mysqli("localhost", "root", "", "login");
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            $e = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);

            $echeck = mysqli_query($conn,"SELECT email from details WHERE email='$e'");

            $num_rows = mysqli_num_rows($echeck);

            if($num_rows > 0){
                array_push($error_array,"Email already in use<br>");
            }
     }
     else{
            array_push($error_array,"INVALID EMAIL FORMAT<br>");
     }
    
     if(empty($error_array)){
         setcookie("cookie[one]", "$em");
         

            $sql = "INSERT INTO details (username, email, password) VALUES ('$name', '$em', '$p1')";

            if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
         
            $_SESSION['reg_name'] = "";
            $_SESSION['reg_email'] = "";
            echo json_encode($data);
            header('Location: homepage.php');
            exit();
      }

?>