<?php
// Include necessary files and start session if not already started
include 'connection.php';
include 'header_staff.php';

$staff_name = $_SESSION['name'];

// Use a prepared statement to fetch the staff_id
$stmt = $conn->prepare("SELECT staff_id FROM `staff` WHERE `name` = ?");
$stmt->bind_param("s", $staff_name);
$stmt->execute();
$stmt->bind_result($staff_id);
$stmt->fetch();
$stmt->close();

// Ensure $staff_id is set
if (isset($staff_id)) {
    // Fetching the branch name based on the staff_id
    $sql2 = "SELECT astp.branch 
             FROM `astp`
             JOIN `staff` ON astp.astp_id = staff.astp_id
             WHERE staff.staff_id = '$staff_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_assoc($result2);
    $branch_name = $row['branch'];

    // Storing the branch name in session
    $_SESSION['branch'] = $branch_name;
}

$branch = $_SESSION['branch'];

if (!isset($_SESSION['branch'])) {
    die("Branch not set in session.");
}

$cars = $conn->query("SELECT car_id, no_plate FROM transportation");

// Process form input for month selection
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
$monthCondition = !empty($selectedMonth) ? "AND MONTH(tec.date_check) = ?" : '';

// Prepare the query with join and filtering by month if selected
$query = "SELECT tec.no_plate, tec.date_check, s.shift, COUNT(tec.check_id) AS check_count
          FROM transportation_equipment_check tec
          JOIN equipment e ON e.equipment_id = tec.equipment_id
          JOIN staff s ON tec.staff_id = s.staff_id
          WHERE tec.branch = ?
          $monthCondition
          GROUP BY tec.no_plate, tec.date_check, s.shift
          ORDER BY tec.no_plate ASC";

$stmt = $conn->prepare($query);
if (!empty($selectedMonth)) {
    $stmt->bind_param("ss", $branch, $selectedMonth);
} else {
    $stmt->bind_param("s", $branch);
}
$stmt->execute();
$result = $stmt->get_result();
$equipmentData = [];
while ($row = $result->fetch_assoc()) {
    $equipmentData[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SENARAI SEMAK KENDERAAN DAN PERALATAN OPERASI</title>
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
    <div class="row">
        <div class="col">
            <h2 class="text-center text-white mb-4">LAPORAN SEMAK KENDERAAN DAN PERALATAN OPERASI</h2>
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
        </div>
    </div>
 
        <div class="row">
        <div class="col">
        <div class="row mb-4">
                    <div class="col text-end">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='check_equipment.php'">
                <i class="ri-add-circle-fill"></i> Cek Kenderaan
            </button>
                    </div>
                </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                <th colspan="5" style="background-color: #FB6303;"><?php echo htmlspecialchars($_SESSION['branch']);?></th>
            </tr>
                    <tr>
                        <th>No</th>
                        <th>No.Plat</th>
                        <th>Tarikh</th>
                        <th>Syif</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipmentData as $index => $equipment): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($equipment['no_plate']); ?></td>
                            <td><?php echo htmlspecialchars($equipment['date_check']); ?></td>
                            <td><?php echo htmlspecialchars($equipment['shift']); ?></td>
                            <td>
                                <form method="POST" action="papar.php">
                                    <input type="hidden" name="no_plate" value="<?php echo htmlspecialchars($equipment['no_plate']); ?>">
                                    <input type="hidden" name="date_check" value="<?php echo htmlspecialchars($equipment['date_check']); ?>">
                                    <button type="submit" class="btn btn-primary">Papar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
