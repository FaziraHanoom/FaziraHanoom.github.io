<?php
include 'connection.php';

$update_success = false;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM astp WHERE astp_id = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $id);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
    } else {
        echo "Record not found.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Corrected name to match the hidden input field
    $name = $_POST['name'];
    $position = $_POST['position'];
    $dob = $_POST['dob'];
    $no_ic = $_POST['no_ic'];
    $phone_num = $_POST['phone_num'];
    $bank_name = $_POST['bank_name'];
    $bank_account = $_POST['bank_account'];
    $email = $_POST['email'];
    $branch = $_POST['branch'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $target = "../images/" . basename($image); // Path to images folder outside admin
        // Check if the file is an image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // Update the image path in the database
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        $image = $row['image'];
    }

    $query = "UPDATE astp SET name=?, position=?, dob=?, no_ic=?, phone_num=?, bank_name=?, bank_account=?, email=?, branch=?, image=? WHERE astp_id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssssssss', $name, $position, $dob, $no_ic, $phone_num, $bank_name, $bank_account, $email, $branch, $image, $id);

    if (mysqli_stmt_execute($stmt)) {
        $update_success = true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kemaskini Maklumat Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            background-color: #4668CE;
            padding-bottom: 100px;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-body {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #004080;
            border: none;
        }
        .btn-primary:hover {
            background-color: #002060;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-white mb-4">Kemaskini Maklumat Anggota</h2>
        <div class="card">
            <div class="card-body">
                <form action="update-astp.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['astp_id']); ?>">
                    <div class="form-group">
                        <label for="name">Nama Penuh</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="position">Pangkat</label>
                        <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($row['position']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Tarikh Lahir</label>
                        <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($row['dob']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_ic">No. Kad Pengenalan</label>
                        <input type="text" name="no_ic" class="form-control" value="<?php echo htmlspecialchars($row['no_ic']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_num">No. Telefon</label>
                        <input type="text" name="phone_num" class="form-control" value="<?php echo htmlspecialchars($row['phone_num']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bank_name">Nama Bank</label>
                        <input type="text" name="bank_name" class="form-control" value="<?php echo htmlspecialchars($row['bank_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bank_account">Nombor Akaun Bank</label>
                        <input type="text" name="bank_account" class="form-control" value="<?php echo htmlspecialchars($row['bank_account']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Emel</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="branch">Cawangan</label>
                        <input type="text" name="branch" class="form-control" value="<?php echo htmlspecialchars($row['branch']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar Profil</label>
                        <input type="file" name="image" class="form-control">
                        <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" class="mt-3" style="max-width: 100px;" alt="Current Profile Image">
                    </div>
                    <div class="form-group text-center">
                        <a href="astp_view_astp.php" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ($update_success): ?>
        <script>
            alert('Maklumat anggota berjaya dikemaskini.');
            window.location.href = "display-astp.php?id=<?php echo htmlspecialchars($row['astp_id']); ?>";
        </script>
    <?php endif; ?>
</body>
</html>


