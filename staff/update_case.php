<?php
include 'connection.php';

// Check if case_id is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT c.*, ct.*, t.*, a.*
              FROM `case` c
              JOIN case_type ct ON c.casetype_id = ct.casetype_id
              LEFT JOIN action a ON c.case_id = a.case_id
              LEFT JOIN transportation t ON a.car_id = t.car_id
              WHERE c.case_id = '$id'";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butiran Kes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 30px;
        }
        .logo-container {
            text-align: left;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .back-button {
            position: absolute;
            top: 15px;
            left: 15px;
        }
        .details-title {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .details-item {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mt-4">
            <a href="view_case_all.php" class="btn btn-primary back-button">Kembali</a> 
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="logo-container">
                    <img src="apmlogo.png" alt="Logo APM" class="logo">
                </div>
            </div>
            <div class="col-md-8">
                <h2 class="text-center mb-4">Butiran Kes</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="details-title">Tarikh dan Masa</h4>
                                <p class="details-item"><strong>Tarikh Kes:</strong> <?php echo htmlspecialchars($row['case_date']); ?></p>
                                <p class="details-item"><strong>Masa Terima Panggilan:</strong> <?php echo htmlspecialchars($row['receivecase_time']); ?></p>
                                <p class="details-item"><strong>Masa Mula Keluar:</strong> <?php echo htmlspecialchars($row['time_out']); ?></p>
                                <p class="details-item"><strong>Masa Sampai Tempat Kejadian:</strong> <?php echo htmlspecialchars($row['time_arrive']); ?></p>
                                <p class="details-item"><strong>Waktu Masuk:</strong> <?php echo htmlspecialchars($row['time_in']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="details-title">ID Kes & Odometer</h4>
                                <p class="details-item"><strong>ID Kes:</strong> <?php echo htmlspecialchars($row['case_id']); ?></p>
                                <p class="details-item"><strong>Odometer Keluar:</strong> <?php echo htmlspecialchars($row['om_out']); ?></p>
                                <p class="details-item"><strong>Odometer Sampai:</strong> <?php echo htmlspecialchars($row['om_arrive']); ?></p>
                                <p class="details-item"><strong>Odometer Masuk:</strong> <?php echo htmlspecialchars($row['om_in']); ?></p>
                                <?php // Calculate total distance traveled
    $total_distance = $row['om_in'] - $row['om_out'];
    ?>
    <p class="details-item"><strong>Jumlah kilometer perjalanan kenderaan:</strong> <?php echo htmlspecialchars($total_distance); ?></p><br>
                            </div>
                        </div>
                        <div class="details-row">
                            <h4 class="details-title">Butiran Pemanggil</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="details-item"><strong>Panggilan Dari:</strong> <?php echo htmlspecialchars($row['case_source']); ?></p>
                                    <p class="details-item"><strong>Nama Pemanggil:</strong> <?php echo htmlspecialchars($row['complainant_name']); ?></p>
                                    <p class="details-item"><strong>No. Telefon:</strong> <?php echo htmlspecialchars($row['no_phonecomp']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="details-item"><strong>Jenis Kes:</strong> <?php echo htmlspecialchars($row['case_name']); ?></p>
                                    <p class="details-item"><strong>Lokasi Kejadian:</strong> <?php echo htmlspecialchars($row['incident_location']); ?></p>
                                    <p class="details-item"><strong>Deskripsi:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                                </div>
                            </div>
                            <div class="details-row">
                                <h4 class="details-title">Laporan</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="details-item"><strong>Waktu Selesai:</strong> <?php echo htmlspecialchars($row['time_done']); ?></p>
                                        <p class="details-item"><strong>Tindakan:</strong> <?php echo htmlspecialchars($row['done_action']); ?></p>
                                        <p class="details-item"><strong>Anggota terlibat dengan operasi: </strong><?php echo htmlspecialchars($row['people_incharge']); ?></p>                                    </div>
                                    <div class="col-md-6">
                                        <p class="details-item"><strong>Pemandu:</strong> <?php echo htmlspecialchars($row['driver']); ?></p>
                                        <p class="details-item"><strong>Logistik:</strong> <?php echo htmlspecialchars($row['code_name']); ?></p>
                                    </div>
                                </div>
                                <button onclick="printPage()" class="btn btn-primary">Cetak</button>

<!-- JavaScript -->
<script>
    function printPage() {
        window.print();
    }
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    } else {
        echo "Rekod tidak dijumpai.";
    }
} else {
    echo "ID tidak sah.";
}
?>

