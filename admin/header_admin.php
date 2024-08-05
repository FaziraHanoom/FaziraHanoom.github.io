<?php
session_start();
if (!isset($_SESSION['name'])) {
$_SESSION['name'] = 'Admin'; // Default value if 'name' is not set in the session
}
?>
<!DOCTYPE html>
<html>
<head>
     <!-----header--->
     <header>
        <div class="menu">
            <ul>
                <li><img src="apmlogo.png" alt="Your Logo" class="logo"></li>
                <li class="active"><a href="dashboard_admin.php">Laman Utama</a></li>
                <li><a href="reg_astp.php"><i class="ri-add-circle-fill"></i>&nbsp;Daftar ASTP</a></li>
                <li><a href="admin_view_astp.php"><i class="ri-edit-2-fill"></i>&nbsp;Senarai ASTP</a></li>
                <li><a href="about.php"><i class="ri-map-pin-fill"></i>&nbsp;Peta APM</a></li>
                <li><a href="backup.php"><i class="ri-file-download-fill"></i>&nbsp;Backup Database</a></li>
                <li ><a href="#">ADMIN <?php echo $_SESSION['name']; ?> </a></li>
                <li style="margin-left: 50px;"><a href="admin_logout.php"><i class="ri-login-box-fill"></i>Log Keluar</a></li>
            </ul>
        </div>
    </header>
    <!-----header end--->
</head>
<body>
<footer>
        <div class="footer-content">
            <p>&copy; Angkatan Pertahanan Awam Malaysia.</p>
        </div>
    </footer>
</body>
</html>