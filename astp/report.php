<?php
// Include necessary files and start session if not already started
include 'connection.php';
include 'header_astp.php';

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

// Fetch equipment data from the database
$result = $conn->query("SELECT * FROM equipment ORDER BY equipment_name ASC");
$equipmentData = [];
while ($row = $result->fetch_assoc()) {
    $equipmentData[] = $row;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SENARAI SEMAK KENDERAAN DAN PERALATAN OPERASI - Report</title>
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
            <h2 class="text-center">SENARAI SEMAK KENDERAAN DAN PERALATAN OPERASI - Report</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p><strong>Cawangan:</strong> <?php echo htmlspecialchars($branch); ?></p>
            <!-- Add more details as needed -->
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>Equipment Status</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Peralatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipmentData as $index => $equipment): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($equipment['equipment_name']); ?></td>
                            <!-- You need to fetch the status from the database or define it accordingly -->
                            <td>Status here</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button onclick="window.print()">Print Report</button>
        </div>
    </div>
</div>

</body>
</html>
