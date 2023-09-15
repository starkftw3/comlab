<?php
    require_once "../connection/database.php";
?>
<div class="main-content">
    <header>
        <h2>
            <label for="nav-toggle">
                <span class="fa fa-bars"></span>
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
</div>