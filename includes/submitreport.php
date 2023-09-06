<?php
    if(isset($_POST["submit-report"])){
        $report = $_POST["report"];
        $description = $_POST["description"];

        if (empty($report) OR empty($description)) {
        echo "<div class='alert alert-danger'>All fields are required</div>"; 
        }

        else{
            //this is not done..
            require_once "connection/database.php";

            if($stmt = $conn->prepare('SELECT studentid, password FROM student WHERE studentid = ?')){
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