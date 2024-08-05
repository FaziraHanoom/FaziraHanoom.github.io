<?php 
include 'connection.php';
include 'header_astp.php';

// Check if the branch is set in the session
if (!isset($_SESSION['branch'])) {
    die('Branch is not set in the session.');
}

// Assuming the branch is stored in the session
$branch = $_SESSION['branch'];

// Prepare the query to select staff based on the branch from the astp table
$stmt = $conn->prepare("
    SELECT s.* 
    FROM staff s 
    JOIN astp a ON s.astp_id = a.astp_id 
    WHERE a.branch = ?");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param('s', $branch);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Senarai Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <style>
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
    <h2 class="text-center text-white mb-4">Senarai Anggota</h2>

    <form method="GET" class="text-center mb-4">
        <div class="form-group d-inline-flex align-items-center">
            <label for="shiftSelect" class="text-white me-2">Pilih Syif:</label>
            <select name="shift" id="shiftSelect" class="form-control me-2" style="display:inline-block; width:auto;">
                <option value="">Semua</option>
                <?php
                // Get distinct branches from the database
                $branchQuery = "SELECT DISTINCT shift FROM staff";
                $branchResult = mysqli_query($conn, $branchQuery);
                while ($branchRow = mysqli_fetch_assoc($branchResult)) {
                    echo "<option value='" . htmlspecialchars($branchRow['shift']) . "'>" . htmlspecialchars($branchRow['shift']) . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-info d-flex align-items-center">
                <i class="ri-filter-fill me-2"></i> Tapis
            </button>
            
        </div>
    </form>
                <div class="row mb-3">
                    <div class="col text-end">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='reg_staff.php'">
                <i class="ri-add-circle-fill"></i> Tambah Anggota
            </button>
                    </div>
                </div>

    <table class="table table-hover table-bordered text-center">
        <thead>
        <tr>
                <th colspan="7" style="background-color: #FB6303;"><?php echo htmlspecialchars($_SESSION['branch']);?></th>
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
            $shiftFilter = isset($_GET['shift']) && !empty($_GET['shift']) ? $_GET['shift'] : '';
            if ($shiftFilter) {
                $stmt = $conn->prepare("
                    SELECT s.* 
                    FROM staff s 
                    JOIN astp a ON s.astp_id = a.astp_id 
                    WHERE a.branch = ? AND s.shift = ?");
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param('ss', $branch, $shiftFilter);
            } else {
                $stmt = $conn->prepare("
                    SELECT s.* 
                    FROM staff s 
                    JOIN astp a ON s.astp_id = a.astp_id 
                    WHERE a.branch = ?");
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param('s', $branch);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $cnt = 1;
            while ($row = $result->fetch_assoc()) { 
            ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo htmlspecialchars($row['staff_id']); ?></td>
                <td><?php echo htmlspecialchars($row['position']) . " " . htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['no_ic']); ?></td>
                <td><?php echo htmlspecialchars($row['no_phone']); ?></td>
                <td><img src="../images/<?php echo htmlspecialchars($row['image']); ?>" class="img-thumbnail" style="max-width: 200px; max-height: 600px;" alt="Profile Image"></td>
                <td>
                <a href="update-staff.php?id=<?php echo htmlspecialchars($row['staff_id']); ?>" class="btn btn-primary"><i class="ri-edit-2-fill"></i></a>
                    <a href="display-staff.php?id=<?php echo htmlspecialchars($row['staff_id']); ?>" class="btn btn-success"><i class="ri-eye-fill"></i></a>
                    <a href="delete_staff.php?id=<?php echo htmlspecialchars($row['staff_id']); ?>" class="btn btn-danger" onclick="return confirm('Adakah anda pasti untuk buang?');"><i class="ri-delete-bin-6-fill"></i></a>
                </td>
            </tr>
            <?php $cnt++; } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-GTkURxihUH2kfyKAsd8rYZASf3zEwt65PO1cOgIWUmWqqoWtX4VqZ8iEfpFIYZ39" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9fz45gC7EOBksb9JgJoAOQ2bKcImqXij1mgN4+7X5RSoxmFO1R9iTcQ" crossorigin="anonymous"></script> 

</body>
</html>
