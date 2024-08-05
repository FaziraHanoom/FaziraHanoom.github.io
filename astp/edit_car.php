<?php
include 'connection.php';
include 'header_astp.php';

// Get the car_id from the query parameter
$car_id = $_GET['car_id'];

// Fetch the car data from the database
$sql = "SELECT car_id, car_name,no_plate, code_name, roadtax_expirydate FROM transportation WHERE car_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No record found";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Kenderaan</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-white mb-4">Kemaskini Kenderaan</h2>
            <form action="update_car.php" method="post">
                <input type="hidden" id="car_id" name="car_id" value="<?php echo htmlspecialchars($row['car_id']); ?>">
                <div class="mb-3">
                    <label for="car_name" class="form-label">Model Kenderaan:</label>
                    <input type="text" class="form-control" id="car_name" name="car_name" value="<?php echo htmlspecialchars($row['car_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_plate" class="form-label">No.Plat:</label>
                    <input type="text" class="form-control" id="no_plate" name="no_plate" value="<?php echo htmlspecialchars($row['no_plate']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="code_name" class="form-label">Nama Kod:</label>
                    <input type="text" class="form-control" id="code_name" name="code_name" value="<?php echo htmlspecialchars($row['code_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="roadtax_expirydate" class="form-label">Tarikh Tamat Cukai Jalan:</label>
                    <input type="date" class="form-control" id="roadtax_expirydate" name="roadtax_expirydate" value="<?php echo htmlspecialchars($row['roadtax_expirydate']); ?>" required>
                </div>
                <a href="view_car.php?id=<?php echo htmlspecialchars($row['car_id']); ?>" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-success" name="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kaWa70b33E8fjmr8i8fw1BA5GZfKaN1i3V5p56P75I2Q6RNE00BJs1pu5pM3L5Cp" crossorigin="anonymous"></script>
</body>
</html>
