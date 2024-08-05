<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $code_name = $_POST['code_name'];
    $roadtax_expirydate = $_POST['roadtax_expirydate'];

    // Prepare the SQL statement
    $sql = "UPDATE transportation SET car_name = ?, code_name = ?, roadtax_expirydate = ? WHERE car_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssi", $car_name, $code_name, $roadtax_expirydate, $car_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Update successful
            echo '<script type="text/javascript">
                alert("Kenderaan berjaya dikemaskini!");
                window.location.href = "view_car.php";
                </script>';
        } else {
            // Update failed
            echo '<script type="text/javascript">
                alert("Gagal mengemaskini kenderaan. Sila cuba lagi.");
                window.location.href = "view_car.php";
                </script>';
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
