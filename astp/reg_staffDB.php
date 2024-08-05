<?php
require 'connection.php';
session_start();

$astpp_name = $_SESSION['name'];

// Fetching the astp_id based on the logged-in user's name
$sql1 = "SELECT astp_id FROM `astp` WHERE name='$astpp_name'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$astp_id = $row['astp_id'];

// Fetching the branch name based on the astp_id
$sql2 = "SELECT branch FROM `astp` WHERE astp_id='$astp_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$branch_name = $row2['branch'];

// Storing the branch name in session
$_SESSION['branch'] = $branch_name;

if (isset($_POST["submit"])) {
    $staff_id = $_POST['staff_id'];
    $staff_name = $_POST['name'];
    $staff_dob = $_POST['dob'];
    $no_ic = $_POST['no_ic'];
    $phone_num = $_POST['no_phone'];
    $bank_name = $_POST['bank_name'];
    $bank_account = $_POST['bank_account'];
    $position = $_POST['position'];
    $shift = $_POST['shift'];
    $email = $_POST['email'];
    $astp = $row['astp_id'];
    $default_password = '#staff123';  // Default password

    $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);


    $query = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id='$staff_id'");

    if (mysqli_num_rows($query) > 0) {
        echo "<script>alert('Staff member already exists!')</script>";
        echo "<meta http-equiv=\"refresh\" content=\"1;URL=reg_astp.php\">";
    } else if ($_FILES["image"]["error"] == 4) {
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
                $query = "INSERT INTO staff (staff_id, name, password, dob, no_ic, no_phone, bank_name, bank_account, position, email,shift, image, astp_id) VALUES
                ('$staff_id', '$staff_name', '$hashed_password', '$staff_dob', '$no_ic', '$phone_num', '$bank_name', '$bank_account', '$position', '$email','$shift', '$image', '$astp')";
                mysqli_query($conn, $query);
                echo "<script>alert('Successfully Added');</script>";
                echo "<script>document.location.href = 'astp_view_staff.php';</script>";
            } else {
                echo "<script>alert('Failed to upload image');</script>";
            }
        }
    }
}
?>