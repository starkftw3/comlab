<?php
    session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: adminlogin.php");
   exit();
}

$page = "Dashboard";
include '../partial/sidebar.php';
include '../partial/header.php';



//how i can get the count of the pending in student
try {
    if ($stmt = $conn->prepare('SELECT COUNT(*) FROM student WHERE status = ?')) {
        $status = 'pending';
        $stmt->bind_param('s', $status);

        if ($stmt->execute()) {
            $stmt->bind_result($studentPendingCount);
            $stmt->fetch();
            $stmt->close();
        } else {
            // Handle the query execution error
            throw new Exception("An error occurred while executing the query.");
        }
    } else {
        // Handle the preparation error
        throw new Exception("An error occurred while preparing the statement.");
    }
} catch (Exception $e) {
    // Display a user-friendly error message
    echo "Oops! Something went wrong. Please try again later.";
    // Log the detailed error for debugging purposes
    error_log($e->getMessage());
}

try {
    if ($stmt = $conn->prepare('SELECT COUNT(*) FROM faculty WHERE status = ?')) {
        $status = 'pending';
        $stmt->bind_param('s', $status);

        if ($stmt->execute()) {
            $stmt->bind_result($facultyPendingCount);
            $stmt->fetch();
            $stmt->close();
        } else {
            // Handle the query execution error
            throw new Exception("An error occurred while executing the query.");
        }
    } else {
        // Handle the preparation error
        throw new Exception("An error occurred while preparing the statement.");
    }
} catch (Exception $e) {
    // Display a user-friendly error message
    echo "Oops! Something went wrong. Please try again later.";
    // Log the detailed error for debugging purposes
    error_log($e->getMessage());
}


?>

    <div class="main-content">
        <main>
            <div class="cards">
                <a class="card-single" href="student.php">
                    <div>
                        <h1><?=$studentPendingCount ?></h1>
                        <span>Pending Registration of Students</span>
                    </div>
                    <div>
                        <span class="fa fa-user"></span>
                    </div>
                </a>
                <a class="card-single" href="facultymember.php">
                    <div>
                        <h1><?=$facultyPendingCount ?></h1>
                        <span>Pending Registration of Faculty Members</span>
                    </div>
                    <div>
                        <span class="fa fa-users"></span>
                    </div>
                </a>
                <a class="card-single" href="">
                    <div>
                        <h1>19</h1>
                        <span>Total Available Dates</span>
                    </div>
                    <div>
                        <span class="fa fa-calendar"></span>
                    </div>
                </a>
                <a class="card-single" href="">
                    <div>
                        <h1>190</h1>
                        <span>Total Users</span>
                    </div>
                    <div>
                        <span class="fa fa-user-circle"></span>
                    </div>
                </a>
            </div>
            <div class="recent-grid">
                <div class="div students">
                    <div class="card">
                        <div class="card-header">
                            <h3>Complaints/Issues</h3>

                            <button>See all <span class="fa fa-arrow-right">
                            </span></button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>Department</td>
                                            <td>Name</td>
                                            <td>Yr & Sec</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Info Tech</td>
                                            <td>Roronoa Zorojuro</td>
                                            <td>IT41</td>
                                            <td>
                                                <span class="status green"></span>
                                                In progress
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Engineering</td>
                                            <td>Roronoa Zorojuro</td>
                                            <td>IT32</td>
                                            <td>
                                                <span class="status pink"></span>
                                                Reviewing
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Entrepreneur</td>
                                            <td>Roronoa Zorojuro</td>
                                            <td>IT42</td>
                                            <td>
                                                <span class="status red"></span>
                                                Tatapon na
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="requests">
                    <div class="card">
                        <div class="card-header">
                            <h3>Requests</h3>

                            <button>See all <span class="fa fa-arrow-right">
                            </span></button>
                        </div>

                        <div class="card-body">
                            <div class="user">
                                <div class="info">
                                    <div>
                                        <h4>Kozuki Oden</h4>
                                        <small>CET Professor</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="fa fa-comment"></span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="user">
                                <div class="info">
                                    <div>
                                        <h4>Kozuki Oden</h4>
                                        <small>CET Professor</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="fa fa-comment"></span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="user">
                                <div class="info">
                                    <div>
                                        <h4>Kozuki Oden</h4>
                                        <small>CET Professor</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="fa fa-comment"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                
            </div>
        </main>
    </div>

    
   