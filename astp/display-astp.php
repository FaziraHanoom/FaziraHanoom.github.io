<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM astp WHERE astp_id = '$id'";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Maklumat Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
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
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        img.logo {
            max-width: 100px;
            border-radius: 0;
        }
        .profile-container {
            text-align: center;
            margin-top: 20px;
        }
        img.profile {
            max-width: 250px;
            height: auto;
            border-radius: 5px;
        }
        .info-container {
            margin-top: 20px;
        }
        .info-container p {
            margin-bottom: 10px;
        }
        .info-container strong {
            display: inline-block;
            width: 150px;
        }
        .back-button-container, .update-button-container {
            text-align: center;
            margin-top: 20px;
        }
        .update-button-container a {
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button-container a:hover, .update-button-container a:hover {
            background-color: #002060;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-white mb-4">Maklumat Anggota</h2>
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <img src="apmlogo.png" alt="Your Logo" class="logo">
                    </div>
                    <div class="col-md-7">
                        <div class="info-container">
                            <p><strong>No Anggota</strong> <?php echo htmlspecialchars($row['astp_id']); ?></p>
                            <p><strong>Nama Penuh</strong> <?php echo htmlspecialchars($row['position']); ?> <?php echo htmlspecialchars($row['name']); ?></p>
                            <p><strong>Tarikh Lahir</strong> <?php echo htmlspecialchars($row['dob']); ?></p>
                            <p><strong>No. Kad Pengenalan</strong> <?php echo htmlspecialchars($row['no_ic']); ?></p>
                            <p><strong>No. Telefon</strong> <?php echo htmlspecialchars($row['phone_num']); ?></p>
                            <p><strong>Nama Bank</strong> <?php echo htmlspecialchars($row['bank_name']); ?></p>
                            <p><strong>Nombor Akaun Bank</strong> <?php echo htmlspecialchars($row['bank_account']); ?></p>
                            <p><strong>Emel</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                            <p><strong>Cawangan</strong> <?php echo htmlspecialchars($row['branch']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                        <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" class="profile" style="max-width: 200px;" alt="Profile Image">
                    </div>
                </div>
                <div class="back-button-container">
                    <a href="astp_view_astp.php" class="btn btn-danger">Kembali</a>
                    <a href="update-astp.php?id=<?php echo htmlspecialchars($row['astp_id']); ?>" class="btn btn-primary">Kemaskini</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        echo "Record not found.";
    }
} else {
    echo "Invalid ID.";
}
?>
