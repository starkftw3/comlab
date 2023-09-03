<?php
session_start();
if (isset($_SESSION["loggedin"])) {
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
    <link rel="stylesheet" href="../resources/style.css">
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
            <a class="dropdown-item" href="studentregister.php">Student</a>
            <a class="dropdown-item" href="../professor/professorRegister.php">Faculty</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Login</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="studentlogin.php">Student</a>
              <a class="dropdown-item" href="../professor/professorLogin.php"> Faculty</a>
          </li>
      </ul>
    </nav>
    
    <div class="form">
        <div class="container">
            <h1>Student Register</h1>
            <?php
            if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $studentid = $_POST["studentid"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            
            $errors = array();
            
            if (empty($fullName) OR empty($studentid) OR empty($password) OR empty($passwordRepeat)) {
                array_push($errors,"All fields are required");
            }

            if (strlen($password)<8) {
                array_push($errors,"Password must be at least 8 charactes long");
            }

            if ($password!==$passwordRepeat) {
                array_push($errors,"Password does not match");
            }
            if(count($errors)> 0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else{

                require_once "../connection/database.php";
                if($stmt = $conn->prepare('SELECT full_name, password FROM student WHERE studentid = ?')){
                    $stmt->bind_param('s', $_POST['studentid']);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        // Student-ID already exists
                        echo "<div class='alert alert-danger'>Student-ID exists, please choose another!</div>";               
                    
                    } else {
                        // Student-ID doesn't exists, insert new account
                        if ($stmt = $conn->prepare('INSERT INTO student (full_name, studentid, password,status) VALUES (?, ?, ?, ?)')) {
                            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
                            $defaultstatus = 'pending';
                            $stmt->bind_param('ssss', $fullName, $studentid, $passwordhash, $defaultstatus);
                            $stmt->execute();
                            echo "<div class='alert alert-success'>You are registered successfully.</div>";
                        } else {
                            // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
                            echo "<div class='alert alert-danger'>Something went wrong</div>";
                        }
                    }
                    $stmt->close();
                }else {
                    // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
                    echo "<div class='alert alert-danger'>Registration failed due to a technical issue. Please try again later.</div>";
                }
                $conn->close();

            }
        }
            ?>

            <form action="studentregister.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="studentid" placeholder="Student Id:">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password:">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Register" name="submit">
                </div>
            </form>
            <div>
            <div><p>Already Registered <a href="studentlogin.php">Login Here</a></p></div>
        </div>
        </div>
    </div>    

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>