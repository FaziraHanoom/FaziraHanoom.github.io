<?php
include 'connection.php';
include 'header_staff.php';

if (isset($_POST['submit'])) {
    $branch = $_POST['branch'];
    $date_check = $_POST['date_check'];
    $no_plate = $_POST['no_plate'];
    $category = $_POST['category'];
    $equipment_status = $_POST['equipment_status'];

    foreach ($equipment_status as $equipment_id => $status) {
        $sql = "INSERT INTO transportation_equipment_check (branch, date_check, no_plate, category, equipment_id, status)
                VALUES ('$branch', '$date_check', '$no_plate', '$category', '$equipment_id', '$status')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Error: " . mysqli_error($conn));
        }
    }

    echo '<script type="text/javascript">
            alert("Senarai semak berjaya disimpan.")
          </script>';
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=dashboard_staff.php\">";
}
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
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center text-white mb-4">SENARAI SEMAK KENDERAAN DAN PERALATAN OPERASI</h2><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="check_equipment.php" method="post" enctype="multipart/form-data" style="width:100%; min-width: 300px;">
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Branch:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="branch" required>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">Date Check:</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="date_check" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">No Plate:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="no_plate" required>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">Category:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="category" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Senarai Peralatan:</label>
                        <div class="col-md-10">
                            <?php
                            $result = $conn->query("SELECT * FROM equipment ORDER BY equipment_name ASC");
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" name="equipment_status[' . $row['equipment_id'] . ']" value="GOOD" required> GOOD';
                                echo '<input class="form-check-input" type="radio" name="equipment_status[' . $row['equipment_id'] . ']" value="BAD" required> BAD';
                                echo '<label class="form-check-label">' . $row['equipment_name'] . '</label>';
                                echo '</div>';
                            }
                            ?>
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
</body>
</html>
