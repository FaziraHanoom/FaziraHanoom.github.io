<?php 
include "connection.php";
include 'header_staff.php';

$stap_id = $_SESSION['staff_id'];
$sql1 = "SELECT * FROM `staff` WHERE staff_id='$stap_id'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$staff_name = $row['name']; 
$email = $row['email']; 
$image = $row['image'];

if(isset($_POST['update_profile'])){
    $staff_name = $_POST['name'];
    $email = $_POST['email'];  

    // Check if password fields are filled
    $new_password = $_POST['new_password'];
    $retype_password = $_POST['retype_password'];

    if(!empty($new_password) && !empty($retype_password)){
        if($new_password === $retype_password){
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql2 = "UPDATE `staff` SET name = '$staff_name', email = '$email', password = '$hashed_password' WHERE staff_id = '$stap_id'";
        } else {
            echo '<script type="text/javascript">alert("Passwords do not match.")</script>';
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=edit-profile.php\">";
            exit;
        }
    } else {
        $sql2 = "UPDATE `staff` SET name = '$staff_name', email = '$email' WHERE staff_id = '$stap_id'";
    }

    $result = mysqli_query($conn, $sql2);

    if($result){
        echo '<script type="text/javascript">alert("Profile updated")</script>';
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=dashboard_astp.php\">";
    } else {
        die(mysqli_error($conn));
    }
}
?> 
<!DOCTYPE html>
<html>
<head>
    <title>Profil Saya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .menu {
            text-align: center;
            background: #ffffff;
        }
        .menu ul {
            list-style-type: none;
            display: inline-flex;
            text-transform: capitalize;
            font-size: 15px;
        }
        .menu ul li {
            margin: 10px;
            padding: 10px;
            width: 100px;
        }
        .menu ul li a {
            color: #000000;
            text-decoration: none;
        }
        .active {
            background: #4668CE;
            border-radius: 2px;
            color: #ffffff;
        }
        .active, .menu ul li:hover {
            background: #4668CE;
            border-radius: 2px;
            color: #ffffff;
        }  
        .form-label {
            text-align: right;
            padding-right: 15px; /* Add padding to align with input fields */
        }
        .form-control {
            width: calc(100% - 130px); /* Adjust width to fit input fields */
        }
        .image-fit {
            width: 300px;
            height: 300px;
            object-fit: cover; /* This ensures the image covers the dimensions while maintaining its aspect ratio */
        }
    </style>
</head>
<body>
<div class="container-sm">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form action="" method="POST" enctype='multipart/form-data'>
                <div class="login_form"><br>
                    <center>
                        <img src="../images/<?php echo htmlspecialchars($image); ?>" class="image-fit" alt="user"><br><br>
                    </center>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label>Nama Anggota</label>
                            </div>
                            <div class="col">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($staff_name); ?>" class="form-control">
                            </div>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label>Emel</label>
                            </div>
                            <div class="col">
                                <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control">
                            </div>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label>Kata Laluan Baru</label>
                            </div>
                            <div class="col">
            <input type="password" class="form-control" name="new_password" id="passwordInput" minlength="8" maxlength="12" required>
                        </div>
    </div>
                    </div><br>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-3">
                                <label>Ulangi Kata Laluan</label>
                            </div>
                            <div class="col">
            <input type="password" class="form-control" name="retype_password" id="passwordInput" minlength="8" maxlength="12" required>
      </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <br>
                        <div class="col-sm-6">
                            <center>
                                <button class="btn btn-success" name="update_profile">Simpan Profil</button>&nbsp;&nbsp;
                                <button class="btn btn-dark">
                                    <a href="dashboard_staff.php" style="text-decoration:none;color:white;">Kembali</a>
                                </button>
                            </center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
