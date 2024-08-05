<?php 
include 'connection.php';
include 'header_staff.php';

// Function to get the staff_id and branch based on the logged-in user's name 
function getStaffIdAndBranchByName($conn, $name,$branch) {
    $sql = "SELECT staff.staff_id, astp.branch 
            FROM `staff` 
            INNER JOIN `astp` ON staff.astp_id = astp.astp_id 
            WHERE staff.name = ? AND branch =?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $name,$branch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['staff_id'];
}

// Function to get the monthly case count for a given branch
function getMonthlyCase($conn, $branch, $month, $year) {
    $query = "SELECT COUNT(*) as case_count FROM `case` 
              INNER JOIN staff ON `case`.staff_id = staff.staff_id
              INNER JOIN astp ON staff.astp_id = astp.astp_id
              WHERE MONTH(`case`.case_date) = ? AND YEAR(`case`.case_date) = ? AND astp.branch = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iis', $month, $year, $branch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['case_count'];
}

// Function to get the yearly case count for a given branch
function getYearlyCases($conn, $year, $branch) {
    $query = "SELECT COUNT(*) as yearly_case_count FROM `case` 
                 INNER JOIN staff ON `case`.staff_id = staff.staff_id
          INNER JOIN astp ON staff.astp_id = astp.astp_id
                 WHERE YEAR(`case`.case_date) = ? AND astp.branch = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $year, $branch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['yearly_case_count'];
}

function getStaffCount($conn, $branch) {
    $query = "SELECT COUNT(*) as staff_count FROM staff WHERE astp_id IN (SELECT astp_id FROM astp WHERE branch = ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $branch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['staff_count'];
}


// Function to get the logistics count for a given branch
function getLogisticsCount($conn, $branch) {
    $query = "SELECT COUNT(DISTINCT transportation.car_id) as logistics_count
FROM transportation
INNER JOIN astp ON transportation.astp_id = astp.astp_id
INNER JOIN staff ON staff.astp_id = astp.astp_id
WHERE astp.branch = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $branch);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['logistics_count'];
}

// Usage example
$stap_name = $_SESSION['name'];

// Fetching the astp_id based on the logged-in user's name
$sql1 = "SELECT staff_id FROM `staff` WHERE name='$stap_name'";
$result1 = mysqli_query($conn, $sql1);
$row = mysqli_fetch_assoc($result1);
$staff_id = $row['staff_id'];

// Fetching the branch name based on the astp_id
$sql2 = "SELECT astp.branch 
            FROM `staff` INNER JOIN `astp` ON staff.astp_id = astp.astp_id 
            WHERE staff.staff_id='$staff_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$branch_name = $row2['branch'];

// Storing the branch name in session
$_SESSION['branch'] = $branch_name;


// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Get the case count for the current month and year
$caseCount = getMonthlyCase($conn, $branch_name, $currentMonth, $currentYear);

// Get the yearly case count for the current year
$yearlyCaseCount = getYearlyCases($conn, $currentYear, $branch_name);

// Get the staff count for the branch
$staffCount = getStaffCount($conn, $branch_name);

// Get the logistics count for the branch
$logisticsCount = getLogisticsCount($conn, $branch_name);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <style>
        body {
            background-image: url('apms.png');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .content {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 10px;
            margin-right: 150px; /* Adjust this value to move the dashboard to the left */
        }

        .card-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 20px;
        }

        .card {
            width: 300px;
            height: 100px; /* Set a fixed height for the cards */
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-title {
            font-weight: bold;
        }

        .card-text {
            font-size: 2em;
            font-weight: bold;
            color: #004085;
        }
    </style>
</head>
<body><br>
    <div class="content">
        <div class="card-container">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Kes Bulan Ini</h5>
                    <p class="card-text"><?php echo $caseCount; ?></p>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kes Tahunan</h5>
                    <p class="card-text"><?php echo $yearlyCaseCount; ?></p>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Staf</h5>
                    <p class="card-text"><?php echo $staffCount; ?></p>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Logistik</h5>
                    <p class="card-text"><?php echo $logisticsCount; ?></p>
                </div>
            </div>
        </div>
    </div>
</head>
<body>
 
    

</body>
</html>