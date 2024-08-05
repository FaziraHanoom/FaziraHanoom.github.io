<?php
// Include the connection file and header file
include 'connection.php';
include 'header_staff.php';

// Get the staff name from the session
$staff_name = $_SESSION['name'];

// Retrieve the branch name using the staff name
$sql_branch = "SELECT astp.branch 
               FROM staff 
               INNER JOIN astp ON staff.astp_id = astp.astp_id 
               WHERE staff.name = ?";
$stmt_branch = $conn->prepare($sql_branch);
$stmt_branch->bind_param('s', $staff_name);
$stmt_branch->execute();
$result_branch = $stmt_branch->get_result();
$row_branch = $result_branch->fetch_assoc();
$branch_name = $row_branch['branch'];

// Retrieve the staff ID using the staff name
$sql_staff = "SELECT staff_id FROM staff WHERE name=?";
$stmt_staff = $conn->prepare($sql_staff);
$stmt_staff->bind_param('s', $staff_name);
$stmt_staff->execute();
$result_staff = $stmt_staff->get_result();
$row_staff = $result_staff->fetch_assoc();
$staff_id = $row_staff['staff_id'];

// Retrieve all cases from the database with only specific columns from the case table
$sql_cases = "SELECT c.*, ct.case_name, t.car_name,
              a.action_id, a.om_out, a.time_out, a.om_arrive, a.time_arrive, a.time_in, a.om_in, a.people_incharge, a.time_done, a.done_action, a.driver,
              staff.name AS staff_name, astp.branch 
              FROM `case` c 
              JOIN case_type ct ON c.casetype_id = ct.casetype_id
              LEFT JOIN action a ON c.case_id = a.case_id
              LEFT JOIN transportation t ON a.car_id = t.car_id
              INNER JOIN staff ON c.staff_id = staff.staff_id
              INNER JOIN astp ON staff.astp_id = astp.astp_id
              WHERE astp.branch = ?";
$stmt_cases = $conn->prepare($sql_cases);
$stmt_cases->bind_param('s', $branch_name);
$stmt_cases->execute();
$result3 = $stmt_cases->get_result();

// Retrieve all cars based on the branch
$sql_cars = "SELECT DISTINCT t.*
              FROM transportation t
              INNER JOIN staff s ON t.astp_id = s.astp_id
              INNER JOIN astp a ON s.astp_id = a.astp_id
              WHERE a.branch = ?";
$stmt_cars = $conn->prepare($sql_cars);
$stmt_cars->bind_param('s', $branch_name);
$stmt_cars->execute();
$cars = $stmt_cars->get_result();

// Retrieve all staff based on the branch
$sql_staff = "SELECT s.staff_id, s.name
              FROM staff s
              JOIN astp a ON s.astp_id = a.astp_id
              WHERE a.branch = ?";
$stmt_staff = $conn->prepare($sql_staff);
$stmt_staff->bind_param('s', $branch_name);
$stmt_staff->execute();
$staff = $stmt_staff->get_result();

// Retrieve all staff based on the branch driver
$sql_staff1 = "SELECT s.staff_id, s.name
              FROM staff s
              JOIN astp a ON s.astp_id = a.astp_id
              WHERE a.branch = ?";
$stmt_staff1 = $conn->prepare($sql_staff1);
$stmt_staff1->bind_param('s', $branch_name);
$stmt_staff1->execute();
$staff1 = $stmt_staff1->get_result();

// Check if the form is submitted and update the case status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $case_id = $_POST['case_id'];
    $new_status = $_POST['case_status'];

    $update_success = false;
    $insert_success = false;

    // Check the new status and perform the necessary action
    if ($new_status == 'Keluar') {
        $out_time = $_POST['time_out'];
        $out_odometer = $_POST['om_out'];
        $car_id = $_POST['car_id'];
        $staff_incharge = $_POST['people_incharge'];
        $driver_incharge = $_POST['driver'];

        // Insert into action table for "Keluar" status
        $insert_sql = "INSERT INTO action (case_id, car_id, people_incharge, time_out, om_out,driver) VALUES (?, ?, ?, ?, ?,?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param('iiisss', $case_id, $car_id, $staff_incharge, $out_time, $out_odometer,$driver_incharge);

        $insert_success = $stmt->execute();

    } elseif ($new_status == 'Sampai') {
        $arrive_time = $_POST['time_arrive'];
        $arrive_odometer = $_POST['om_arrive'];

        // Insert into action table for "Sampai" status
        $update_sql = "UPDATE action SET time_arrive = ?, om_arrive = ? WHERE case_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('sii', $arrive_time, $arrive_odometer, $case_id);

        $insert_success = $stmt->execute();

    } elseif ($new_status == 'Selesai') {
        $done_time = $_POST['time_done'];
        $action_done = $_POST['action_done'];

        // Update the action table for "Selesai" status
        $update_sql = "UPDATE action SET time_done = ?, done_action = ? WHERE case_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('ssi', $done_time, $action_done, $case_id);

        $insert_success = $stmt->execute();
    } elseif ($new_status == 'Tutup') {
        $in_time = $_POST['time_in'];
        $in_odometer = $_POST['om_in'];

        // Update the action table for "Tutup" status
        $update_sql = "UPDATE action SET time_in = ?, om_in = ? WHERE case_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('ssi', $in_time, $in_odometer, $case_id);
        
        $insert_success = $stmt->execute();
    }

    // If insertion was successful, update the case status
    if ($insert_success) {
        $update_sql = "UPDATE `case` SET case_status = ? WHERE case_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('si', $new_status, $case_id);
        $update_success = $stmt->execute();
    }

    // Display a success message and redirect if update was successful
    if ($update_success) {
        echo '<script type="text/javascript">
                    alert("Case status has been updated.");
                    window.location.href = "view_case_all.php";
                  </script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$serial_number = 1; // Initialize the serial number

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Senarai Kes</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <style>
        body {
            background-color: #4668CE;
        }
        .container {
            margin-top: 30px;
        }
        table {
    background-color: #fff;
    border-collapse: separate;
    border-spacing: 0;
    box-shadow: 0 2px 15px rgba(64, 64, 64, .7);
    border-radius: 12px;
    overflow: hidden;
    width: 50%; /* Make the table take up the full width of its container */
}

th, td {
    padding: 20px; /* Increase padding */
    text-align: center;
    font-size: 16px; /* Increase font size */
}

        th {
            background-color: #4668CE;
            color: black;
            font-weight: 600;
        }
        td {
            border-bottom: 1px solid #E3F1D5;
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

        .form-label {
            text-align: right;
        }
        .menu .logo {
            height: 70px;
        }

        /* Row color styles */
        .status-Keluar {
            background-color: #6699CC;
        }
        .status-Sampai {
            background-color: yellow;
        }
        .status-Selesai {
            background-color: #90EE90;
        }
        .status-Terima {
            background-color:#FF3131;
        }
        .status-Tutup {
            background-color: #ffff;
        }

    </style>
</head>
<body>
    <div class="container">
                <h2 class="text-center text-white">Senarai Kes</h2>
                <div class="row">
        <div class="col">
        <div class="row mb-4">
                    <div class="col text-end">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='reg_case.php'">
                <i class="ri-add-circle-fill"></i> Daftar Kes
            </button>
                    </div>
                </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="6" style="background-color: #FB6303;"><?php echo $_SESSION['branch'];?></th>
            </tr>
                <tr>
                    <th>ID Kes</th>
                    <th>Nama Pemanggil</th>
                    <th>Lokasi</th>
                    <th>Nama Kes</th>
                    <th>Status Kes</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result3->fetch_assoc()): ?>
                <tr class="status-<?= $row['case_status'] ?>">
                    <td><?= $serial_number++ ?></td>
                    <td><?= $row['complainant_name'] ?></td>
                    <td><?= $row['incident_location'] ?></td>
                    <td><?= $row['case_name'] ?></td>
                    <td><?= $row['case_status'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary update-status-btn" data-case-id="<?= $row['case_id'] ?>" data-status="<?= $row['case_status'] ?>" data-bs-toggle="modal" data-bs-target="#updateModal">
                            Lapor
                        </button>
                        <a href="update_case.php?id=<?php echo urlencode($row['case_id']); ?>" class="btn btn-success">Papar</a>
                        <button type="button" class="btn btn-danger batal-btn">Batal</button>

                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="view_case_all.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Kemaskini Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="case_id" id="case_id">
                        <div class="mb-3">
                            <label for="case_status" class="form-label">Status Kes</label>
                            <select name="case_status" id="case_status" class="form-select">
                                <option value="Keluar">Keluar</option>
                                <option value="Sampai">Sampai</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Tutup">Tutup</option>
                            </select>
                        </div>
                        <div id="keluar-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="car_id" class="form-label">Kenderaan</label>
                                <select name="car_id" id="car_id" class="form-select">
                                    <?php while ($car = $cars->fetch_assoc()): ?>
                                        <option value="<?= $car['car_id'] ?>"><?= $car['code_name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="people_incharge" class="form-label">Anggota terlibat dengan operasi</label>
                                 <input type="number" name="people_incharge" id="people_incharge" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="time_out" class="form-label">Masa Keluar</label>
                                <input type="time" name="time_out" id="time_out" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="om_out" class="form-label">Odometer Keluar</label>
                                <input type="number" name="om_out" id="om_out" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="driver" class="form-label">Pemandu</label>
                                <select name="driver" id="driver" class="form-select">
                                    <?php while ($driver_member = $staff1->fetch_assoc()): ?>
                                        <option value="<?= $driver_member['staff_id'] ?>"><?= $driver_member['name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div id="sampai-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="time_arrive" class="form-label">Masa Sampai</label>
                                <input type="time" name="time_arrive" id="time_arrive" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="om_arrive" class="form-label">Odometer Sampai</label>
                                <input type="number" name="om_arrive" id="om_arrive" class="form-control">
                            </div>
                        </div>
                        <div id="selesai-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="time_done" class="form-label">Masa Selesai</label>
                                <input type="time" name="time_done" id="time_done" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="action_done" class="form-label">Tindakan Selesai</label>
                                <input type="text" name="action_done" id="action_done" class="form-control">
                            </div>
                        </div>
                        <div id="tutup-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="time_in" class="form-label">Masa Masuk</label>
                                <input type="time" name="time_in" id="time_in" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="om_in" class="form-label">Odometer Masuk</label>
                                <input type="number" name="om_in" id="om_in" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="update_status" class="btn btn-primary">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.update-status-btn').forEach(button => {
            button.addEventListener('click', function () {
                const caseId = this.getAttribute('data-case-id');
                const caseStatus = this.getAttribute('data-status');
                document.getElementById('case_id').value = caseId;
                document.getElementById('case_status').value = caseStatus;
                toggleFields(caseStatus);
            });
        });

        document.getElementById('case_status').addEventListener('change', function () {
            toggleFields(this.value);
        });

        document.querySelectorAll('.batal-btn').forEach(button => {
    button.addEventListener('click', function () {
        const caseId = this.parentElement.parentElement.querySelector('.update-status-btn').getAttribute('data-case-id');
        if (confirm('Adakah anda pasti untuk membatalkan kes ini?')) {
            window.location.href = 'cancel_case.php?id=' + caseId;
        }
    });
});


        function toggleFields(status) {
            document.getElementById('keluar-fields').style.display = (status === 'Keluar') ? 'block' : 'none';
            document.getElementById('sampai-fields').style.display = (status === 'Sampai') ? 'block' : 'none';
            document.getElementById('selesai-fields').style.display = (status === 'Selesai') ? 'block' : 'none';
            document.getElementById('tutup-fields').style.display = (status === 'Tutup') ? 'block' : 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
