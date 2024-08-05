<?php
// Include the connection file
include 'connection.php';

// Check if the case ID is provided in the URL
if (isset($_GET['id'])) {
    $case_id = $_GET['id'];

    // Perform the deletion
    $delete_case_sql = "DELETE FROM `action` WHERE case_id = ?";
    $stmt_case = $conn->prepare($delete_case_sql);
    $stmt_case->bind_param('i', $case_id);
    $stmt_case->execute();

    // Check if the case deletion was successful
    if ($stmt_case->affected_rows > 0) {
        // Delete associated actions
        $delete_action_sql = "DELETE FROM `case` WHERE case_id = ?";
        $stmt_action = $conn->prepare($delete_action_sql);
        $stmt_action->bind_param('i', $case_id);
        $stmt_action->execute();

        // Redirect back to the case list with a success message
        header('Location: view_case_all.php?delete_success=true');
        exit;
    } else {
        // Redirect back to the case list with an error message
        header('Location: view_case_all.php?delete_error=true');
        exit;
    }
} else {
    // Redirect back to the case list with an error message if no case ID is provided
    header('Location: view_case_all.php?delete_error=true');
    exit;
}
?>
