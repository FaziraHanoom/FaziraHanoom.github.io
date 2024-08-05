<?php 
include 'connection.php';
include 'reg_astpDB.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar ASTP</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>
<style>
    body {
    background-color: #4668CE;
    padding-bottom: 30px;
    height: 100vh;
}
</style>
<header>
    <div class="menu">
        <ul>
            <li><img src="apmlogo.png" alt="Your Logo" class="logo"></li>
            <li class="active"><a href="dashboard_admin.php">Laman Utama</a></li>
            <li><a href="reg_astp.php"><i class="ri-add-circle-fill"></i>&nbsp;Daftar ASTP</a></li>
            <li><a href="admin_view_astp.php"><i class="ri-edit-2-fill"></i>&nbsp;Senarai ASTP</a></li>
            <li><a href="about.php"><i class="ri-file-text-fill"></i>&nbsp;Tentang APM</a></li>
            <li><a href="backup.php"><i class="ri-file-download-fill"></i>&nbsp;Backup Database</a></li>
            <li><a href="edit-profile.php">ADMIN <?php echo $_SESSION['name']; ?></a></li>
            <li style="margin-left: 50px;"><a href="admin_logout.php"><i class="ri-login-box-fill"></i>Log Keluar</a></li>
        </ul>
    </div>
</header>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center text-white mb-4">Daftar Anggota Sukarelawan Tugas Pejabat</h2><br>
            </div>
        </div>
        <form action="reg_astpDB.php" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-md-2 col-form-label text-md-end">No.Anggota:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="astp_id" oninput="this.value = this.value.toUpperCase()" maxlength="15" required>
                </div>
                <label class="col-md-2 col-form-label text-md-end">Nama penuh:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" oninput="this.value = this.value.toUpperCase()" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-2 col-form-label text-md-end">Tarikh Lahir:</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="dob" required>
                </div>
                <label class="col-md-2 col-form-label text-md-end">No. Kad Pengenalan:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_ic" pattern="\d{12}" title="Please enter 12 digits without dashes" maxlength="12" required>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-2 col-form-label text-md-end">No.Telefon:</label>
                <div class="col-md-4">
                    <input type="tel" class="form-control" name="phone_num" pattern="[0-9]{10,11}" title="Please enter a valid phone number (numeric, 10 or 11 digits)" maxlength="11" required>
                </div>
                <label class="col-md-2 col-form-label text-md-end">Nama Bank:</label>
                <div class="col-md-4">
                    <select name="bank_name" class="form-control" required>
                        <option value="">--- Pilih Bank ---</option>
                        <option value="maybank">Maybank</option>
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
            </div>
            <div class="row mb-3">
                <label class="col-md-2 col-form-label text-md-end">Nombor Akaun Bank:</label>
                <div class="col-md-4">
                    <input type="int" class="form-control" name="bank_account" required>
                </div>
                <label class="col-md-2 col-form-label text-md-end">Pangkat:</label>
                <div class="col-md-4">
                    <select name="position" class="form-control" required>
                        <option value="">--- Pilih ---</option>
                        <option value="LTM(PA)">LTM(PA)</option>
                        <option value="SJN(PA)">SJN(PA)</option>
                        <option value="KPL(PA)">KPL(PA)</option>
                        <option value="L/KPL">L/KPL(PA)</option>
                        <option value="PBT(PA)">PBT(PA)</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-md-2 col-form-label text-md-end">Emel:</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="email" required>
                </div>
                <label class="col-md-2 col-form-label text-md-end">Cawangan:</label>
                <div class="col-md-4">
                    <select name="branch" class="form-control" required>
                        <option value="">--- Pilih ---</option>
                        <option value="PKOD Melaka Tengah">PKOD Melaka Tengah</option>
                        <option value="PKOD Jasin">PKOD Jasin</option>
                        <option value="PKOD Alor Gajah">PKOD Alor Gajah</option>
                        <option value="PKOD Perlis Kangar">PKOD Perlis Kangar</option>
                        <option value="PKOD Kedah Alor Setar">Kedah Alor Setar</option>
                        <option value="PKOD Pulau Pinang Timur Laut (Georgetown)">Pulau Pinang Timur Laut (Georgetown)</option>
                        <option value="PKON Perak Kinta Ipoh">PKON Perak Kinta Ipoh</option>
                        <option value="Selangor Klang">Selangor Klang</option>
                        <option value="WP Kuala Lumpur">WP Kuala Lumpur</option>
                        <option value="Pahang Kuantan">Pahang Kuantan</option>
                        <option value="Terengganu Kuala Terengganu">Terengganu Kuala Terengganu</option>
                        <option value="Kelantan Kota Bharu">Kelantan Kota Bharu</option>
                        <option value="Negeri Sembilan Seremban">Negeri Sembilan Seremban</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2 text-md-end">
                    <label class="form-label">Gambar:</label>
                </div>
                <div class="col-md-4">
                    <input type="file" class="form-control" name="image" required>
                    <small class="text-danger">Format: jpg, jpeg, dan png</small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 col-form-label text-md-end">
                    <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                    <a href="dashboard_admin.php" class="btn btn-danger">Batal</a>
                </div>
            </div>
        </form>
    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; Angkatan Pertahanan Awam Malaysia.</p>
</div>
</footer>

</body>
</html>
