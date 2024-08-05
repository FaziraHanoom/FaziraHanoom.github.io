<?php
include 'connection.php';

$id = $_GET['id'];

try {
    // Try to delete the record
    $query = "DELETE FROM astp WHERE astp_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id); // Use "s" for string type
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('ASTP telah berjaya dibuang.'); window.location.href = 'admin_view_astp.php';</script>";
    } else {
        throw new Exception("Record not found or couldn't be deleted.");
    }
} catch (mysqli_sql_exception $e) {
    if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
        echo "<script>alert('Tidak boleh dibuang. Anggota ini masih bekerja di APM.'); window.location.href = 'admin_view_astp.php'</script>";
        
    } else {
        echo "<script>alert('Error deleting record: " . $e->getMessage() . "');</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

?>
