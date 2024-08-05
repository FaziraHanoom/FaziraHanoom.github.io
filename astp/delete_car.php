<?php 
include 'connection.php';
include 'header_astp.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Delete car data from the database
    $sql = "DELETE FROM transportation WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
            alert("Kenderaan berjaya dipadam!");
            window.location.href = "view_car.php";
            </script>';
    } else {
        echo '<script type="text/javascript">
            alert("Gagal memadam kenderaan. Sila cuba lagi.");
            </script>';
    }

    $stmt->close();
    $conn->close();
}
?>
