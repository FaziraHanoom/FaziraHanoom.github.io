<?php
// Include necessary files and start session if not already started
include 'connection.php';
include 'header_astp.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_plate = $_POST['no_plate'];
    $date_check = $_POST['date_check'];

    // Query to fetch equipment details for the selected no_plate and date_check
    $query = "SELECT tec.*, e.*
    FROM transportation_equipment_check tec
    JOIN equipment e ON tec.equipment_id = e.equipment_id
    WHERE tec.no_plate = ? AND tec.date_check = ?";
$stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $no_plate, $date_check);
    $stmt->execute();
    $result = $stmt->get_result();
    $equipmentDetails = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Papar Senarai Semak Kenderaan</title>
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
        <h2 class="text-center text-white mb-4">Senarai Semak <?php echo htmlspecialchars($no_plate); ?></h2>
        <h3 class="text-center text-white mb-4"> Tarikh : <?php echo htmlspecialchars($date_check); ?></h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Peralatan</th>
                    <th>Status</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipmentDetails as $equipment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipment['equipment_name']); ?></td>
                        <td><?php echo htmlspecialchars($equipment['status']); ?></td>
                        <!-- Add more cells for additional details -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
