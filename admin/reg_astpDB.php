<?php
require 'connection.php';
session_start();

if (isset($_POST["submit"])) {
    $astp_id = $_POST['astp_id'];
    $astp_name = $_POST['name'];
    $dob = $_POST['dob'];
    $no_ic = $_POST['no_ic'];
    $phone_num = $_POST['phone_num'];
    $bank_name = $_POST['bank_name'];
    $bank_account = $_POST['bank_account'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $branch = $_POST['branch'];
    $default_password = '#astp123';  // Default password

    $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

    // Check for duplicate IC number
    $query = mysqli_query($conn, "SELECT * FROM astp WHERE no_ic='$no_ic'");
    if (mysqli_num_rows($query) > 0) {
        echo "<script>alert('No. Kad Pengenalan sudah wujud.')</script>";
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=reg_astp.php\">";
        exit; // Stop further execution
    }

    if ($_FILES["image"]["error"] == 4) {
        echo "<script> alert('No image uploaded'); </script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Invalid image format');</script>";
        } else if ($fileSize > 1000000) {
            echo "<script>alert('Image size too large');</script>";
        } else {
            $image = uniqid() . '.' . $imageExtension;

            // Check if images directory exists, if not create it
            if (!is_dir('images')) {
                mkdir('images', 0777, true);
            }

            if (move_uploaded_file($tmpName, '../images/' . $image)) {
                $query = "INSERT INTO astp (astp_id, name, password, dob, no_ic, phone_num, bank_name, bank_account, position, email, branch, image) VALUES
                ('$astp_id', '$astp_name', '$hashed_password', '$dob', '$no_ic', '$phone_num', '$bank_name', '$bank_account', '$position', '$email', '$branch', '$image')";
                mysqli_query($conn, $query);
                echo "<script>alert('Berjaya tambah maklumat.');</script>";
                echo "<script>document.location.href = 'admin_view_astp.php';</script>";
            } else {
                echo "<script>alert('Gagal muat naik gambar.');</script>";
            }
        }
    }
}
?>
