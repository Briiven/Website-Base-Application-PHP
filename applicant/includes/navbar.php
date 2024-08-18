<div class="container-fluid bg-white">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Brand Logo -->
        <div class="brand-logo">
            <a href="index.php">
                <img src="../vendors/images/deskapp-logo-svg.png" alt="">
            </a>
        </div>

        <!-- User Info -->
        <div class="user-info-dropdown">
            <?php 
            $query = mysqli_query($conn, "select * from applicants where appID = '$session_id'") or die(mysqli_error($conn));
            $row = mysqli_fetch_array($query);
            ?>
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <span class="user-icon">
                    <img src="<?php echo (!empty($row['location'])) ? '../uploads/' . $row['location'] : '../uploads/NO-IMAGE-AVAILABLE.jpg'; ?>" alt="">
                </span>
                <span class="user-name"><?php echo $row['firstName'] . " " . $row['lastName']; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                <a class="dropdown-item" href="profile.php"><i class="dw dw-user1"></i> Profile</a>
                <a class="dropdown-item" href="../logout.php"><i class="dw dw-logout"></i> Log Out</a>
            </div>
        </div>
    </div>
</div>

<style>
    .brand-logo img {
        border-bottom: none; /* Remove any border */
        margin-bottom: 0;    /* Ensure no margin at the bottom */
    }
    .brand-logo, .brand-logo a {
        border-bottom: none; /* Ensure no border on container and link */
    }
</style>
