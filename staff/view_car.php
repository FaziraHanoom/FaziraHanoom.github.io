<?php
include 'connection.php';
include 'header_staff.php';

// Function to get the staff_id and branch based on the logged-in user's name 
function getStaffIdAndBranchByName($conn, $name,$branch) {
    $sql = "SELECT staff.staff_id, astp.branch 
            FROM `staff` 
            INNER JOIN `astp` ON staff.astp_id = astp.astp_id 
            WHERE staff.name = ? AND branch =?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $name,$branch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['staff_id'];
}

// Function to get the list of transportation items for a given branch
function getTransportationList($conn, $branch_name) {
    $query = "SELECT DISTINCT t.*
              FROM transportation t
              INNER JOIN staff s ON t.astp_id = s.astp_id
              INNER JOIN astp a ON s.astp_id = a.astp_id
              WHERE a.branch = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $branch_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $transportationList = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $transportationList[] = $row;
    }
    mysqli_stmt_close($stmt);
    return $transportationList;
}

// Usage example
$stap_name = $_SESSION['name'];

// Fetching the astp_id based on the logged-in user's name
$sql1 = "SELECT staff_id FROM `staff` WHERE name='$stap_name'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$staff_id = $row['staff_id'];

// Fetching the branch name based on the astp_id
$sql2 = "SELECT astp.branch 
            FROM `staff` INNER JOIN `astp` ON staff.astp_id = astp.astp_id 
            WHERE staff.staff_id='$staff_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$branch_name = $row2['branch'];

// Storing the branch name in session
$_SESSION['branch'] = $branch_name;

// Usage example
$transportationList = getTransportationList($conn, $branch_name);


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lihat Kenderaan</title>
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

        .sbm1 {
            display: none;
            z-index: 2;
        }

        .menu ul li:hover .sbm1 {
            position: absolute;
            display: block;
            margin-top: 10px;
            margin-left: -15px;
            background: #ffffff;
        }

        .menu ul li:hover .sbm1 ul {
            display: block;
            margin: 15px;
        }

        .menu ul li:hover .sbm1 ul li {
            border-bottom: 1px solid grey;
            background: transparent;
            width: 120px;
            padding: 15px;
            text-align: left;
        }

        .menu ul li:hover .sbm1 ul li:last-child {
            border: none;
        }

        .menu ul li:hover .sbm1 ul li a {
            color: #000000;
        }

        .menu ul li:hover .sbm1 ul li a:hover {
            color: #4668CE;
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
<h2 class="text-center text-white mb-4">Senarai Kenderaan</h3>
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                <tr>
                <th colspan="6" style="background-color: #FB6303;"><?php echo $_SESSION['branch'];?></th>
            </tr>
                    <tr>
                        <th>ID Kenderaan</th>
                        <th>No.Plat</th>
                        <th>Model Kenderaan</th>
                        <th>Nama Kod</th>
                        <th>Tarikh Tamat Cukai Jalan</th>
                    </tr>
                </thead>
                <tbody>
<?php if (!empty($transportationList)): ?>
    <?php foreach ($transportationList as $car): ?>
        <tr>
            <td><?php echo htmlspecialchars($car['car_id']); ?></td>
            <td><?php echo htmlspecialchars($car['no_plate']); ?></td>
            <td><?php echo htmlspecialchars($car['car_name']); ?></td>
            <td><?php echo htmlspecialchars($car['code_name']); ?></td>
            <td><?php echo htmlspecialchars($car['roadtax_expirydate']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan='5'>Tiada rekod ditemui</td>
    </tr>
<?php endif; ?>
</tbody>

            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kaWa70b33E8fjmr8i8fw1BA5GZfKaN1i3V5p56P75I2Q6RNE00BJs1pu5pM3L5Cp" crossorigin="anonymous"></script>
</body>
</html>

