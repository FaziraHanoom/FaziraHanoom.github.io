<?php 
include 'connection.php';
include 'header_astp.php';

// Assuming the branch is stored in the session
$branch = $_SESSION['branch'];

// Prepare the query to select members based on the branch from the session
$stmt = $conn->prepare("SELECT * FROM astp WHERE branch = ?");
$stmt->bind_param('s', $branch);
$stmt->execute();
$result = $stmt->get_result();
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
    <style>
        body {
            background-color: #4668CE;
            height: 100vh;
            width: 100%;
        }
        .container {
            margin-top: 30px;
        }
        table {
            background-color: #fff;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 2px 15px rgba(64,64,64,.7);
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 15px 20px;
            text-align: center;
        }
        th {
            background-color: #4668CE;
            color: black;
            font-weight: 600;
        }
        td {
            border-bottom: 1px solid #E3F1D5;
        }
        tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        tr:hover {
            background-color: #E3F1D5;
        }
        .img-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
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
        }
        .menu .logo {
            height: 70px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center text-white mb-4">Senarai Anggota Sukarelawan Tugas Pejabat</h2>
    
<table class="table table-hover table-bordered text-center">
        <thead>
            <tr>
                <th colspan="7" style="background-color: #FB6303;"><?php echo $_SESSION['branch'];?></th>
            </tr>
            <tr>
                <th>No</th>
                <th>No Anggota</th>
                <th>Nama Penuh</th>
                <th>No.Kad Pengenalan</th>
                <th>No.Telefon</th>
                <th>Gambar</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $cnt = 1;
            while ($row = $result->fetch_assoc()) { 
            ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $row['astp_id'] ?></td>
                <td><?php echo $row['position'] . "  " . $row['name']; ?></td>
                <td><?php echo $row['no_ic']; ?></td>
                <td><?php echo $row['phone_num']; ?></td>
                <td><img src="../images/<?php echo htmlspecialchars($row['image']); ?>" class="img-thumbnail" style="max-width: 100px;" alt="Profile Image"></td>
                <td>
                    <a href="update-astp.php?id=<?php echo htmlspecialchars($row['astp_id']); ?>" class="btn btn-primary"><i class="ri-edit-2-fill"></i></a>
                    <a href="display-astp.php?id=<?php echo $row['astp_id']; ?>" class="btn btn-success"><i class="ri-eye-fill"></i></a>
                    <a href="delete_astp.php?id=<?php echo $row['astp_id']; ?>" class="btn btn-danger" onclick="return confirm('Adakah anda pasti untuk buang?');"><i class="ri-delete-bin-6-fill"></i></a>
                </td>
            </tr>
            <?php $cnt++; } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGaZI/PrgqUFEfJp0ieeXBl+0I" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-jjSmVgyd0p3pXB1rRibZUAYoIIyV+k5CRb7x9Ih0zW5Y7QepoyrH9IhTfM9kfnQ3" crossorigin="anonymous"></script>
</body>
</html>
