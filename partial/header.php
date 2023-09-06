<?php
    session_start();
    require_once "../connection/database.php";
?>

<header>
    <h2>
        <label for="nav-toggle">
            <span class="las la-bars"></span>
        </label>
        <?=$page?>
    </h2>

    <div class="user-wrapper">
        <div>
            <h4>
                <?=$_SESSION['name']?>
            </h4>
            <small>Admin</small>
        </div>
    </div>
</header>