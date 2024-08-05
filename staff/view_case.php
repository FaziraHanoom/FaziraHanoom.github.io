<?php
include 'connection.php';
include 'header_staff.php';

// Check if case_id is set in the URL
if (!isset($_GET['case_id'])) {
    // Redirect to an error page if no case_id is provided
    header("Location: error.php");
    exit();
}

$case_id = $_GET['case_id'];

// Retrieve the case details from the database
$sql = "SELECT * FROM `case` WHERE case_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $case = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Case</title>
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
                <h3>Case Details</h3><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Kes</th>
                        <td><?php echo $case['case_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama Pengadu</th>
                        <td><?php echo $case['complainant_name']; ?></td>
                    </tr>
                    <tr>
                        <th>No. Telefon Pengadu</th>
                        <td><?php echo $case['no_phonecomp']; ?></td>
                    </tr>
                    <tr>
                        <th>Lokasi Kejadian</th>
                        <td><?php echo $case['incident_location']; ?></td>
                    </tr>
                    <tr>
                        <th>Sumber Kes</th>
                        <td><?php echo $case['case_source']; ?></td>
                    </tr>
                    <tr>
                        <th>Tarikh Kes</th>
                        <td><?php echo $case['case_date']; ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Terima Kes</th>
                        <td><?php echo $case['receivecase_time']; ?></td>
                    </tr>
                    <tr>
                        <th>Status Kes</th>
                        <td><?php echo $case['case_status']; ?></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td><?php echo $case['description']; ?></td>
                    </tr>
                    <tr>
                        <th>ID Anggota</th>
                        <td><?php echo $case['staff_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kes</th>
                        <td><?php echo $case['casetype_id']; ?></td>
                    </tr>
                </table>
                <a href="dashboard_staff.php" class="btn btn-primary">Kembali ke Laman Utama</a>
            </div>
        </div>
    </div>
</body>
</html>
