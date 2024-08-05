<?php
// Include the connection file and header file
include 'connection.php';
include 'header_astp.php';

// Get the staff name from the session
$astp_name = $_SESSION['name'];

// Retrieve the staff ID using the staff name
$sql1 = "SELECT astp_id FROM `astp` WHERE `name`='$astp_name'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$astp_id = $row['astp_id'];

// Retrieve all cases from the database with additional details (join with other tables)
$sql = "SELECT c.case_id, c.complainant_name, c.no_phonecomp, c.incident_location, ct.case_name, t.code_name, a.people_incharge, c.case_status, a.done_action,c.case_date, 
        ROW_NUMBER() OVER (ORDER BY c.case_id) AS no_bilangan
        FROM `case` c
        JOIN case_type ct ON c.casetype_id = ct.casetype_id
        LEFT JOIN action a ON c.case_id = a.case_id
        LEFT JOIN transportation t ON a.car_id = t.car_id";
$result = $conn->query($sql);
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
            width: 50px;
            height: 50px;
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


        .active {
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
<div class="container" style="width: 80%; margin-left: auto; margin-right: auto;">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-white mb-4">Laporan Kes</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form method="GET" class="text-center mb-4">
                <div class="form-group d-inline-flex align-items-center">
                    <label for="monthSelect" class="text-white me-2">Pilih Bulan:</label>
                    <select name="month" id="monthSelect" class="form-control me-2" style="display:inline-block; width:auto;">
                        <option value="">Semua</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Mac</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Jun</option>
                        <option value="07">Julai</option>
                        <option value="08">Ogos</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Disember</option>
                    </select>
                    <button type="submit" class="btn btn-info d-flex align-items-center">
                        <i class="ri-search-line me-2"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.Rujukan</th>
                        <th>Tarikh</th>
                        <th>Butiran Pemanggil</th>
                        <th>Lokasi Kejadian</th>
                        <th>Kes</th>
                        <th>Logistik</th>
                        <th>Anggota Terlibat</th>
                        <th>Status Kes</th>
                        <th>Tindakan</th>
                        <th>Borang Penuh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="status-<?php echo htmlspecialchars($row['case_status']); ?>">
                            <td><?php echo htmlspecialchars($row['no_bilangan']); ?></td>
                            <td><?php echo htmlspecialchars($row['case_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['complainant_name']); ?><br><?php echo htmlspecialchars($row['no_phonecomp']); ?></td>
                            <td><?php echo htmlspecialchars($row['incident_location']); ?></td>
                            <td><?php echo htmlspecialchars($row['case_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['code_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['people_incharge']); ?></td>
                            <td><?php echo htmlspecialchars($row['case_status']); ?></td>
                            <td><?php echo htmlspecialchars($row['done_action']); ?></td>
                            <td>
                                <a href="update_case.php?id=<?php echo urlencode($row['case_id']); ?>" class="btn btn-success">Papar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGaZI/PrgqUFEfJp0ieeXBl+0I" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-jjSmVgyd0p3pXB1rRibZUAYoIIyV+k5CRb7x9Ih0zW5Y7QepoyrH9IhTfM9kfnQ3" crossorigin="anonymous"></script>
</body>
</html>
