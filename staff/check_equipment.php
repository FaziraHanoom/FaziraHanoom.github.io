<?php
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
if (isset($_POST['submit'])) {
    $date_check = $_POST['date_check'];
    $no_plate = $_POST['no_plate'];
    $category = $_POST['category'];
    $equipment_status = $_POST['equipment_status'];
    $staff_id = $_SESSION['staff_id'];


    foreach ($equipment_status as $equipment_id => $statusArray) {
        $status = $statusArray['status']; // Extract the status value from the array
        $sql = "INSERT INTO transportation_equipment_check (branch, date_check, no_plate, category, equipment_id, status,staff_id)
                VALUES (?, ?, ?, ?, ?, ?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $branch, $date_check, $no_plate, $category, $equipment_id, $status,$staff_id);
        $result = $stmt->execute();

        if (!$result) {
            die("Error: " . $stmt->error);
        }
    }

    echo '<script type="text/javascript">
            alert("Senarai semak berjaya disimpan.");
          </script>';
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=car_report.php\">";
}


if (isset($_POST['add_equipment'])) {
    $new_equipment_name = $_POST['new_equipment_name'];

    // Check if equipment already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM equipment WHERE equipment_name = ?");
    $stmt->bind_param('s', $new_equipment_name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Equipment already exists
        echo '<script type="text/javascript">
                alert("Nama peralatan sudah wujud.");
              </script>';
    } else {
        // Insert new equipment
        $sql = "INSERT INTO equipment (equipment_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $new_equipment_name);
        $result = $stmt->execute();

        if ($result) {
            echo '<script type="text/javascript">
                    alert("Peralatan baru berjaya ditambah.");
                  </script>';
        } else {
            die("Error: " . $stmt->error);
        }
    }
}

if (isset($_POST['delete_equipment'])) {
    $equipment_id = $_POST['equipment_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete from transportation_equipment_check
        $sql = "DELETE FROM transportation_equipment_check WHERE check_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $equipment_id);
        $stmt->execute();
        
        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            // Delete from equipment table
            $sql = "DELETE FROM equipment WHERE equipment_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $equipment_id);
            $stmt->execute();

            // Commit the transaction if both deletions were successful
            if ($stmt->affected_rows > 0) {
                $conn->commit();
                echo '<script type="text/javascript">
                        alert("Peralatan berjaya dibuang.");
                      </script>';
            } else {
                // Rollback if the second deletion failed
                $conn->rollback();
                echo '<script type="text/javascript">
                        alert("Error: Gagal membuang peralatan.");
                      </script>';
            }
        } else {
            // Rollback if the first deletion failed
            $conn->rollback();
            echo '<script type="text/javascript">
                    alert("Error: Gagal membuang peralatan pemeriksaan.");
                  </script>';
        }
        
    } catch (Exception $e) {
        // Rollback the transaction if any error occurred
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}

$cars = $conn->query("SELECT car_id, no_plate, code_name FROM transportation");

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
</head>
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
<body>
<div class="container">
    <div class="row">
        <div class="col"><br>
            <h2 class="text-center text-white mb-4">SENARAI SEMAK KENDERAAN DAN PERALATAN OPERASI</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="check_equipment.php" method="post" enctype="multipart/form-data" style="width:100%; min-width: 300px;">
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label text-md-end">Cawangan:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($branch); ?>" readonly>
                    </div>
                    <label class="col-md-2 col-form-label text-md-end">Tarikh:</label>
                    <div class="col-md-2">
                        <input type="date" class="form-control" name="date_check" id="date_check" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label text-md-end">No.Pendaftaran:</label>
                    <div class="col-md-4">
                    <select name="no_plate" id="no_plate" class="form-select">
                                    <?php while ($car = $cars->fetch_assoc()): ?>
                                        <option value="<?= $car['no_plate'] ?>"><?= $car['no_plate'] ?> (<?= $car['code_name'] ?>)</option>
                                        <?php endwhile; ?>
                                </select>
                    </div>
                    <label class="col-md-2 col-form-label text-md-end">Kategori:</label>
                    <div class="col-md-4">
                    <select id="category" class="form-control" name="category">
            <option value="" selected disabled>Pilih Kategori</option>
            <option value="Penyelamat Ringan">Penyelamat Ringan</option>
            <option value="Penyelamat Berat">Penyelamat Berat</option>
            <option value="Ambulans">Ambulans</option>
            <option value="Motosikal">Motosikal</option>
        </select>
                    </div>
                </div><br>
                <div class="row mb-3">
                    <div class="col text-end">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addEquipmentModal"><i class="ri-add-circle-fill"></i>Tambah Peralatan</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Peralatan</th>
                                    <th>BAIK</th>
                                    <th>ROSAK</th>
                                    <th>TIADA</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    $counter = 1;
    $result = $conn->query("SELECT * from equipment ORDER BY equipment_name ASC");
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $counter . '</td>';
        echo '<td>' . htmlspecialchars($row['equipment_name']) . '</td>';
        echo '<td><input class="form-check-input" type="radio" name="equipment_status[' . $row['equipment_id'] . '][status]" value="BAIK"></td>';
        echo '<td><input class="form-check-input" type="radio" name="equipment_status[' . $row['equipment_id'] . '][status]" value="ROSAK"></td>';
        echo '<td><input class="form-check-input" type="radio" name="equipment_status[' . $row['equipment_id'] . '][status]" value="TIADA"></td>';
        echo '<td>
            <form action="check_equipment.php" method="post" style="display:inline-block;">
                <input type="hidden" name="equipment_id" value="' . $row['equipment_id'] . '">
            </form>
          </td>';
        echo '</tr>';
        $counter++;
    }
    ?>
</tbody>

                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                        <a href="dashboard_staff.php" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Tambah Peralatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="check_equipment.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_equipment_name" class="form-label">Nama Peralatan:</label>
                        <input type="text" class="form-control" id="new_equipment_name" name="new_equipment_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_equipment">Tambah Peralatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const dateInput = document.getElementById('date_check');
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0!
        const dd = String(today.getDate()).padStart(2, '0');

        const currentDate = `${yyyy}-${mm}-${dd}`;
        dateInput.value = currentDate;
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
