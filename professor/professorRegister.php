<?php
session_start();
if (isset($_SESSION["professor"])) {
   header("Location: home.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style-professor.css">
</head>
<body>  
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="../index.php">
          <img src="../resources/images/logo.png" width="100" height="30" alt="logo">
        </a>
        <ul class="nav nav-tabs">
        <li class="nav-item">
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Register</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="../student/studentregister.php">Student</a>
            <a class="dropdown-item" href="professorRegister.php">Faculty</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Login</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="../student/studentlogin.php">Student</a>
              <a class="dropdown-item" href="professorLogin.php"> Faculty</a>
          </li>
      </ul>
    </nav>

    <div class="container">
        <div >
            <?php
                $errors = array();
                $success = "";

                if (isset($_POST["professor-submit"])) {
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $middlename = $_POST["middlename"];
                $facultyid = $_POST["facultyid"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                
                

                if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $facultyid)) {
                    array_push($errors,"Invalid student ID format (e.g., 11-22-3333)");
                }
                
                if (empty($firstname) OR empty($lastname) OR empty($email) OR empty($facultyid)  OR empty($passwordRepeat) OR empty($password)) {
                    array_push($errors,"All fields are required");
                }

                if (strlen($password)<8) {
                    array_push($errors,"Password must be at least 8 charactes long");
                }

                if ($password!==$passwordRepeat) {
                    array_push($errors,"Password does not match");

                }else{
                    require_once "../connection/database.php";
                    if($stmt = $conn->prepare('SELECT firstname, password FROM student WHERE studentid = ?')){
                        $stmt->bind_param('s', $_POST['studentid']);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            // Student-ID already exists            
                            array_push($errors,"Student-ID exists, please choose another!");
                        
                        } else {
                            if(empty($middlename)){
                                $middlename = NULL;
                            }
                            // Student-ID doesn't exists, insert new account
                            if ($stmt = $conn->prepare('INSERT INTO faculty (firstname, lastname, middlename, facultyid, email, password, status) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
                                $passwordhash = password_hash($password, PASSWORD_DEFAULT);
                                $defaultstatus = 'pending';
                                $stmt->bind_param('sssssss', $firstname, $lastname, $middlename, $facultyid, $email, $passwordhash, $defaultstatus);
                                $stmt->execute();
                                $success = "You are registered successfully.";

                            } else {
                                array_push($errors,"Something went wrong");
                            }
                        }
                        $stmt->close();
                    }else {
                        array_push($errors,"Registration failed due to a technical issue. Please try again later.");
                    }

                    $conn->close();

                }
                }
            ?>

            <form class="form" action="professorregister.php" method="POST">
                <span class="title">Faculty Register </span>
                <span class="message">Computer Laboratory Monitoring System.</span>
                <?php
                    if(count($errors)> 0){
                        foreach($errors as $error){
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    }
                    if(!empty($success)){
                        echo "<div class='alert alert-success'>$success</div>";
                    }
                    
                ?>
                <label>
                    <input required="" placeholder="Faculty-ID" type="text" name="facultyid" class="input">
                </label>
                <label>
                    <input required="" placeholder="Firstname" type="text" name="firstname" class="input">
                </label>
                <label>
                    <input required="" placeholder="Lastname" type="text" name="lastname" class="input">
                </label>
                <label>
                        <input placeholder="Middlename" type="text" name="middlename" class="input">
                </label>
                    
                <label>
                    <input required="" placeholder="Email" type="email" name="email" class="input">
                </label> 
                <label>
                    <input required="" placeholder="Password" type="password" name="password" class="input">
                </label>
                <label>
                    <input required="" placeholder="Repeat Password" type="password" name="repeat_password" class="input">
                </label>
                <button type="submit" name="professor-submit"class="submit">Submit</button>
                <p class="signin">Already have an acount ? <a href="professorLogin.php">Signin</a> </p>
            </form>
        </div>   
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>