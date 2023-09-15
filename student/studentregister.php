<?php
session_start();
if (isset($_SESSION["student"])) {
   header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./style-student.css">
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
    <div class="container">
        <div >
        <form class="form" action="studentregister.php" method="POST">
                <span class="title">Student Register </span>
                <span class="message">Computer Laboratory Monitoring System.</span>
            <?php
                $errors = array();

                if (isset($_POST["student-submit"])) {
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $middlename = $_POST["middlename"];
                $studentid = $_POST["studentid"];
                $email = $_POST["email"];
                $section = $_POST["section"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                
                
                if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $studentid)) {
                    array_push($errors,"Invalid student ID format (e.g., 11-22-3333)");
                }
                
                
                if (empty($firstname) OR empty($lastname) OR empty($email) OR empty($section) OR empty($studentid) OR empty($password) OR empty($passwordRepeat) OR empty($password)) {
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
                    if($stmt = $conn->prepare('SELECT firstname, password FROM student WHERE studentid = ?')){
                        $stmt->bind_param('s', $_POST['studentid']);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            // Student-ID already exists            
                            echo "<div class='alert alert-danger'>Student-ID already exist</div>";
                        
                        } else {
                            if(empty($middlename)){
                                $middlename = NULL; 
                            }
                            // Student-ID doesn't exists, insert new account
                            if ($stmt = $conn->prepare('INSERT INTO student (firstname, lastname, middlename, studentid, section, email, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
                                $passwordhash = password_hash($password, PASSWORD_DEFAULT);
                                $defaultstatus = 'pending';
                                $stmt->bind_param('ssssssss', $firstname, $lastname, $middlename, $studentid, $section, $email, $passwordhash, $defaultstatus);
                                $stmt->execute();
                                echo "<div class='alert alert-success'>You Registered Successfully</div>";

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

                <div class="flex">
                    <label>
                        <input required="" placeholder="Student-ID" type="text" name="studentid" class="input">
                    </label>
                    <label>
                        <input required="" placeholder="Section" type="text" name="section" class="input">
                    </label> 
                </div>
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
                <button type="submit" name="student-submit" class="submit">Submit</button>
                <p class="signin">Already have an acount ? <a href="studentlogin.php">Signin</a> </p>
            </form>
        </div>   
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>