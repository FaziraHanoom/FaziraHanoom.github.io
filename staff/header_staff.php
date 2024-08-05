<?php
session_start();
if (!isset($_SESSION['name'])) {
$_SESSION['name'] = 'Anggota'; // Default value if 'name' is not set in the session
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
                <li class="active"><a href="dashboard_staff.php">Laman Utama</a></li>
                <li><a href="view_case_all.php#"><i class="ri-add-circle-fill"></i>&nbsp;Operasi</a></li>
                <li><a href="#"><i class="ri-car-line"></i>&nbsp;Logistik</a>
                    <div class="sbm1">
                        <ul>
                            <li><a href="car_report.php">Cek Kenderaan</a></li>
                            <li><a href="view_car.php">Senarai Kenderaan</a></li>
                        </ul>
                    </div>      
                </li>
                <li><a href="#"><i class="ri-team-line"></i>&nbsp;Anggota</a>
                    <div class="sbm1">
                        <ul>
                            <li><a href="view_staff.php">Senarai Anggota</a></li>
                        </ul>
                    </div>      
                </li>
                <li><a href="backup.php" ><i class="ri-file-download-fill"></i>&nbsp;Backup Database</a></li>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <li ><a href="edit-profile.php">ANGGOTA <?php echo $_SESSION['name']; ?></a></li>
                <li style="margin-left: 50px;"><a href="staff_logout.php"><i class="ri-login-box-fill"></i>Log Keluar</a></li>
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