<?php 
include 'connection.php';
include 'header_astp.php';
$astpp_name = $_SESSION['name'];

// Fetching the astp_id based on the logged-in user's name
$sql1 = "SELECT astp_id FROM `astp` WHERE name='$astpp_name'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$ast_id = $row['astp_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $car_name = $_POST['car_name'];
    $no_plate = $_POST['no_plate'];
    $code_name = $_POST['code_name'];
    $roadtax_expirydate = $_POST['roadtax_expirydate'];
    $category = $_POST['category'];
    $ast_id = $row['astp_id'];


    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO transportation (car_name, code_name, roadtax_expirydate,category,no_plate,astp_id) VALUES (?, ?, ?,?,?,?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssssss", $car_name, $code_name, $roadtax_expirydate,$category,$no_plate,$ast_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Insertion successful
                echo '<script type="text/javascript">
                    alert("Kenderaan berjaya didaftarkan!");
                    window.location.href = "view_car.php";
                    </script>';
            } else {
                // Insertion failed
                echo '<script type="text/javascript">
                    alert("Gagal mendaftarkan kenderaan. Sila cuba lagi.");
                    </script>';
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error in preparing the statement
            echo "Error: " . $conn->error;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate entry error
            echo '<script type="text/javascript">
                alert("Nama kod tersebut sudah wujud. Sila gunakan nama kod yang lain.");
                </script>';
        } else {
            // Other SQL error
            echo '<script type="text/javascript">
                alert("Ralat: ' . $e->getMessage() . '");
                </script>';
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Kenderaan</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
</head>
<style>
.text-orange {
        color: orange;
    }
    
    .mb-4 {
        margin-bottom: 2.0rem;
    }
</style>
<body>
<!-- Form Section -->
<br>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="text-center text-white mb-4">Daftar Kenderaan</h2>
            <p class="text-center text-orange mb-4"><?php echo $_SESSION['branch'];?></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" enctype="multipart/form-data" style="width:100%; min-width: 300px;">
                <!-- Car ID (auto-incremented) -->
                <input type="hidden" name="car_id" value="AUTO_INCREMENT">

                 <!-- Car ID (auto-incremented) -->
                 <input type="hidden" name="astp_id" value="AUTO_INCREMENT">

                <!-- Car Name -->
                    <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Kategori:</label>
                    <div class="col-md-8">
                    <select id="category" class="form-control" name="category">
            <option value="" selected disabled>Pilih Kategori</option>
            <option value="Penyelamat Ringan">Penyelamat Ringan</option>
            <option value="Penyelamat Berat">Penyelamat Berat</option>
            <option value="Ambulans">Ambulans</option>
            <option value="Motosikal">Motosikal</option>
        </select>
                    </div>
                </div>

                <!-- No.plate -->
                        <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">No.Plat:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="no_plate" required>
                    </div>
                </div>

                <!-- Car Name -->
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Model Kenderaan:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="car_name" required>
                    </div>
                </div>

                <!-- Code Name -->
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Nama Kod:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="code_name" required>
                    </div>
                </div>

                <!-- Roadtax Expiry Date -->
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">Tarikh Tamat Cukai Jalan:</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" name="roadtax_expirydate" required>
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="row mb-3">
                    <div class="col-md-8 offset-md-9">
                        <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                        <a href="admin_homepage.php" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
