<?php
session_start();

if (!isset($_SESSION["admin"])) {
   header("Location: adminlogin.php");
   exit();
}

$page = "Dashboard";
include '../partial/sidebar.php';
include '../partial/header.php';

?>

    <div class="main-content">
        <main>
            <div class="cards">
                <a class="card-single" href="">
                    <div>
                        <h1>69</h1>
                        <span>Pending Registration of Students</span>
                    </div>
                    <div>
                        <span class="las la-user"></span>
                    </div>
                </a>
                <a class="card-single" href="">
                    <div>
                        <h1>6</h1>
                        <span>Pending Registration of Faculty Members</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </a>
                <a class="card-single" href="">
                    <div>
                        <h1>19</h1>
                        <span>Total Available Dates</span>
                    </div>
                    <div>
                        <span class="las la-calendar"></span>
                    </div>
                </a>
                <a class="card-single" href="">
                    <div>
                        <h1>190</h1>
                        <span>Total Users</span>
                    </div>
                    <div>
                        <span class="las la-user-circle"></span>
                    </div>
                </a>
            </div>
            <div class="recent-grid">
                <div class="div students">
                    <div class="card">
                        <div class="card-header">
                            <h3>Complaints/Issues</h3>

                            <button>See all <span class="las la-arrow-right">
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

                            <button>See all <span class="las la-arrow-right">
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
                                    <span class="las la-comment"></span>
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
                                    <span class="las la-comment"></span>
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
                                    <span class="las la-comment"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                
            </div>
        </main>
    </div>

    
   