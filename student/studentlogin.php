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
    <title>Login Form</title>
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
        <h1>Student Login</h1>
            <?php
            if (isset($_POST["studentlogin"])) {
                 $studentid = $_POST["studentid"];
                 $password = $_POST["password"];
            
                if (empty($studentid) OR empty($password)) {
                    echo "<div class='alert alert-danger'>All fields are required</div>"; 
                    
                }else{        
                    require_once "../connection/database.php";
                    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
                    if ($stmt = $conn->prepare('SELECT full_name, password, status FROM student WHERE studentid = ?')) {
                        $stmt->bind_param('s', $_POST['studentid']);
                        $stmt->execute();
                        // Store the result so we can check if the account exists in the database.
                        $stmt->store_result();
                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($fullname, $dbpassword, $status);
                            $stmt->fetch();
                            // Account exists, now we verify the password.

                            if (password_verify($_POST['password'], $dbpassword)) {
                                if($status === 'pending')
                                echo "<div class='alert alert-success'>Your account is still pending</div>";
                                // Verification success! User has logged-in!
                                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                                else if($status === 'approved'){
                                    session_regenerate_id();
                                    $_SESSION['loggedin'] = TRUE;
                                    $_SESSION['name'] = $fullname;
                                    $_SESSION['studentid'] = $_POST['studentid'];
                                    header('Location: home.php');
                                }
                                else if($status === 'rejected'){
                                    echo "<div class='alert alert-danger'>Your account is reject. Contact Admin. This account will be deleted</div>";
                                }
                            } else {
                                // Incorrect password
                                echo "<div class='alert alert-danger'>Email or Password does not match</div>";
                            }
                        } else {
                            // Incorrect username
                            echo "<div class='alert alert-danger'>Email or Password Email does not match</div>";
                        }
                        $stmt->close();
                    }
                }
                
            }
            ?>
        <form action="studentlogin.php" method="post">
            <div class="form-group">
                <input type="text" placeholder="Enter Student Id:" name="studentid" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="studentlogin" class="btn btn-primary">
            </div>
        </form>
            <div><p>Not registered yet <a href="studentregister.php">Register Here</a></p></div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    

</body>
</html>