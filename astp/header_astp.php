<?php
session_start();
if (!isset($_SESSION['name'])) {
$_SESSION['name'] = 'ASTP'; // Default value if 'name' is not set in the session
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
                <li class="active"><a href="dashboard_astp.php">Laman Utama</a></li>
                <li><a href="#"><i class="ri-add-circle-fill"></i>&nbsp;Anggota</a>
                    <div class="sbm1">
                        <ul>
                            <li><a href="astp_view_staff.php">Senarai Anggota</a></li>
                            <li><a href="astp_view_astp.php">Senarai ASTP</a></li>
                        </ul>
                    </div>       
                </li>
                <li><a href="view_car.php"><i class="ri-car-line"></i>&nbsp;Logistik</a></li>
                <li><a href="#"><i class="ri-file-text-fill"></i>&nbsp;Laporan</a>
                    <div class="sbm1">
                        <ul>
                            <li><a href="operasi_report.php">Operasi</a></li>
                            <li><a href="car_report.php">Kenderaan</a></li>
                        </ul>
                    </div>      
                </li>
                <li><a href="backup.php" ><i class="ri-file-download-fill"></i>&nbsp;Backup Database</a></li>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <li ><a href="edit-profile.php">ASTP <?php echo $_SESSION['name']; ?> </a></li>
                <li style="margin-left: 50px;"><a href="astp_logout.php"><i class="ri-login-box-fill"></i>Log Keluar</a></li>
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