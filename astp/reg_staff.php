<?php
include 'connection.php';
include 'reg_staffDB.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>
<style>
.text-orange {
        color: orange;
    }
    
    .mb-4 {
        margin-bottom: 2.0rem;
    }
</style>
<!-----header--->
<header>
        <div class="menu">
            <ul>
            <li><img src="apmlogo.png" alt="Your Logo" class="logo"></li>
                <li class="active"><a href="dashboard_astp.php">Laman Utama</a></li>
                <li><a href="#"><i class="ri-add-circle-fill"></i>&nbsp;Anggota</a>
                    <div class="sbm1">
                        <ul>
                            <li><a href="reg_staff.php">Daftar Anggota</a></li>
                            <li><a href="astp_view_staff.php">Senarai Anggota</a></li>
                            <li><a href="astp_view_astp.php">Senarai ASTP</a></li>
                        </ul>
                    </div>       
                </li>
                <li><a href="#"><i class="ri-car-line"></i>&nbsp;Logistik</a>
                    <div class="sbm1">
                        <ul>
                            <li><a href="reg_car.php">Daftar Kenderaan</a></li>
                            <li><a href="view_car.php">Senarai Kenderaan</a></li>
                        </ul>
                    </div>      
                </li>
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
<body>
    <!-- Form Section -->
    <div class="container">
        <div class="row">
            <div class="col">
            <h2 class="text-center text-white mb-4">Daftar Anggota</h2>
            <p class="text-center text-orange mb-4"><?php echo $_SESSION['branch'];?></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="reg_staffDB.php" method="post" enctype="multipart/form-data" style="width:100%; min-width: 300px;">
                    <!-- Shift and ASTP ID -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Syif:</label>
                        <div class="col-md-4">
                            <select name="shift" class="form-control" required>
                                <option value="">--- Pilih ---</option>
                                <option value="Pagi">Pagi</option>
                                <option value="Petang">Petang</option>
                                <option value="Malam">Malam</option>
                            </select>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">No.Anggota:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="staff_id" oninput="this.value = this.value.toUpperCase()" maxlength="15" required>
                        </div>
                    </div>
                    <!-- Full Name and Date of Birth -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Nama penuh:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="name" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">Tarikh Lahir:</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                    </div>
                    <!-- IC Number and Phone Number -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">No.Kad Pengenalan:</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" name="no_ic" pattern="\d{12}" title="Please enter 12 digits without dashes" maxlength="12" required>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">No.Telefon:</label>
                        <div class="col-md-4">
                        <input type="tel" class="form-control" name="no_phone" pattern="[0-9]{10,11}" title="Please enter a valid phone number (numeric, 10 or 11 digits)" maxlength="11"  required>
                        </div>
                    </div>
                    <!-- Bank Name and Bank Account Number -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Nama Bank:</label>
                        <div class="col-md-4">
                            <select name="bank_name" class="form-control" required>
                                <option value="">--- Pilih Bank ---</option>
                                <option value="Maybank">Maybank</option>
                                <option value="cimb">CIMB</option>
                                <option value="public_bank">Public Bank</option>
                                <option value="rhb">RHB</option>
                                <option value="hong_leong">Hong Leong Bank</option>
                                <option value="ambank">AmBank</option>
                                <option value="uob">UOB</option>
                                <option value="ocbc">OCBC</option>
                                <option value="hsbc">HSBC</option>
                            </select>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">Nombor Akaun Bank:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="bank_account" maxlength="15" required>
                        </div>
                    </div>
                    <!-- Position and Email -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Pangkat:</label>
                        <div class="col-md-4">
                            <select name="position" class="form-control" required>
                                <option value="">--- Pilih ---</option>
                                <option value="LTM(PA)">LTM(PA)</option>
                                <option value="SM(PA)">SM(PA)</option>
                                <option value="SJN(PA)">SJN(PA)</option>
                                <option value="KPL(PA)">KPL(PA)</option>
                                <option value="L/KPL(PA)">L/KPL(PA)</option>
                                <option value="PBT(PA)">PBT(PA)</option>
                            </select>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">Emel:</label>
                        <div class="col-md-4">
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <!-- Image Upload -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Gambar:</label>
                        <div class="col-md-4">
                            <input type="file" class="form-control" name="image" required>
                            <small class="text-danger">Format: jpg, jpeg, dan png</small>
                        </div>
                    </div>
                    <!-- Branch -->
                    <!--<div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Cawangan:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="branch_name" value="<?php echo $_SESSION['branch']; ?>" readonly>
                        </div>
                    </div>
-->
                    <!-- Submit and Cancel Buttons -->
                    <div class="row mb-3">
                        <div class="col text-end">
                            <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                            <a href="dashboard_astp.php" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; Angkatan Pertahanan Awam Malaysia.</p>
        </div>
    </footer>
</body>
</html>
