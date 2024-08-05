<?php
include 'connection.php';
include 'header_astp.php';

// Function to get the astp_id based on the logged-in user's name and branch
function getAstpIdByNameAndBranch($conn, $name, $branch_name) {
    $sql = "SELECT astp_id FROM `astp` WHERE name = ? AND branch = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $name, $branch_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['astp_id'];
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
        <div class="row mb-3">
                    <div class="col text-end">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='reg_car.php'">
                <i class="ri-add-circle-fill"></i> Tambah Kenderaan
            </button>
                    </div>
                </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                <th colspan="6" style="background-color: #FB6303;"><?php echo $_SESSION['branch'];?></th>
            </tr>
                    <tr>
                        <th>ID Kenderaan</th>
                        <th>Model Kenderaan</th>
                        <th>Nama Kod</th>
                        <th>Tarikh Tamat Cukai Jalan</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
<?php if (!empty($transportationList)): ?>
    <?php foreach ($transportationList as $car): ?>
        <tr>
            <td><?php echo htmlspecialchars($car['car_id']); ?></td>
            <td><?php echo htmlspecialchars($car['car_name']); ?></td>
            <td><?php echo htmlspecialchars($car['code_name']); ?></td>
            <td><?php echo htmlspecialchars($car['roadtax_expirydate']); ?></td>
            <td>
                <a href='edit_car.php?car_id=<?php echo urlencode($car['car_id']); ?>' class='btn btn-primary btn-sm'>Kemaskini</a>
                <a href='delete_car.php?car_id=<?php echo urlencode($car['car_id']); ?>' class='btn btn-danger btn-sm' onclick='return confirm("Adakah anda pasti?")'>Padam</a>
            </td>
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

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeModalLabel">Kemaskini Kenderaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="update_car.php" method="post">
                    <input type="hidden" id="update_car_id" name="car_id">
                    <div class="mb-3">
                        <label for="update_car_name" class="form-label">Nama Kenderaan:</label>
                        <input type="text" class="form-control" id="update_car_name" name="car_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_code_name" class="form-label">Nama Kod:</label>
                        <input type="text" class="form-control" id="update_code_name" name="code_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_roadtax_expirydate" class="form-label">Tarikh Tamat Cukai Jalan:</label>
                        <input type="date" class="form-control" id="update_roadtax_expirydate" name="roadtax_expirydate" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openCompleteModal(car_id, car_name, code_name, roadtax_expirydate) {
    console.log('Modal Opened with ID:', car_id); // Debugging
    document.getElementById('update_car_id').value = car_id;
    document.getElementById('update_car_name').value = car_name;
    document.getElementById('update_code_name').value = code_name;
    document.getElementById('update_roadtax_expirydate').value = roadtax_expirydate;
    var completeModal = new bootstrap.Modal(document.getElementById('completeModal'));
    completeModal.show();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kaWa70b33E8fjmr8i8fw1BA5GZfKaN1i3V5p56P75I2Q6RNE00BJs1pu5pM3L5Cp" crossorigin="anonymous"></script>
</body>
</html>


