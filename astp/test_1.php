<?php
session_start();

$login_error = "";

if (isset($_POST['submit'])) {
    $connection = mysqli_connect("localhost", "root", "1111");
    $db = mysqli_select_db($connection, "casehandling");

    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    if (!empty($id) && !empty($password)) {
        // Check if ID exists in ASTP table
        $query_astp = "SELECT * FROM astp WHERE astp_id = '$id' AND password = '$password'";
        $query_run_astp = mysqli_query($connection, $query_astp);

        if ($row_astp = mysqli_fetch_assoc($query_run_astp)) {
            $_SESSION['astp_id'] = $row_astp['astp_id'];
            $_SESSION['name'] = $row_astp['name'];

            echo '<script type="text/javascript">
                    alert("Selamat datang ASTP")
                  </script>';

            echo "<meta http-equiv=\"refresh\" content=\"0;URL=astp\dashboard_astp.php\">";
        } else {
            // Check if ID exists in STAFF table
            $query_staff = "SELECT * FROM staff WHERE staff_id = '$id' AND password = '$password'";
            $query_run_staff = mysqli_query($connection, $query_staff);

            if ($row_staff = mysqli_fetch_assoc($query_run_staff)) {
                $_SESSION['staff_id'] = $row_staff['staff_id'];
                $_SESSION['name'] = $row_staff['name'];

                echo '<script type="text/javascript">
                        alert("Selamat datang Anggota")
                      </script>';

                echo "<meta http-equiv=\"refresh\" content=\"0;URL=\casehandling\staff\dashboard_staff.php\">";
            } else {
                // Check if ID exists in ADMIN table
                $query_admin = "SELECT * FROM admin WHERE admin_id = '$id' AND password = '$password'";
                $query_run_admin = mysqli_query($connection, $query_admin);

                if ($row_admin = mysqli_fetch_assoc($query_run_admin)) {
                    $_SESSION['admin_id'] = $row_admin['admin_id'];
                    $_SESSION['name'] = $row_admin['name'];

                    echo '<script type="text/javascript">
                            alert("Selamat datang Admin")
                          </script>';

                    echo "<meta http-equiv=\"refresh\" content=\"0;URL=admin\dashboard_admin.php\">";
                } else {
                    $login_error = "ID or Password incorrect!";
                }
            }
        }
    } else {
        $login_error = "Please enter valid ID and Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>APM Case Handling System</title>
<link rel="stylesheet" href="login.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            background-size: cover;
            background-color: #4668CE;
            height: auto;
        }
        .main {
        background-color: skyblue;
        border-radius: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: blue;
        padding: 20px;
        text-align: center;
        width: 80%;
        max-width: 500px;
    }

    .main h1 {
        font-size: 30px;
        margin-bottom: 30px;
        padding: 30px 20px;
        color: blue;
    }

    .logo {
    position: absolute;
    top: 30px; /* Adjusted top position */
    left: 50%;
    transform: translateX(-50%);
    width: 150px; /* Set the width of your logo */
    height: auto; /* Maintain aspect ratio */
    }
        /* unvisited link */
        a:link {
        color: black;
        font-size: 25px;
    }

    /* visited link */
    a:visited {
        color: peru;
    }

    /* mouse over link */
    a:hover {
        color: hotpink;
    }

    /* selected link */
    a:active {
        color: blue;
    }

    .center {
    position: absolute;
    top: 60%; /* Adjusted top position */
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;
    max-width: 500px;
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    }
aside {
position: absolute;
top: 50%;
left: 0;
transform: translateY(-50%);
background-color: rgba(0, 0, 0, 0.8);
color: white;
padding: 10px;
border-radius: 0 10px 10px 0;
font-size: 18px;
}
</style>

</head>
<body>
<?php
require('connection.php');
?>
<aside>Guidance Login<br><br>
    Admin -> M(S)000945 12345678<br>
    ASTP   -> M(S)000946 #astp123<br>
    Staff  -> M(S)000947 #astp123
</aside>
<img src="apmlogo.png" alt="Your Logo" class="logo"> 
<div class="center">
<center><h1><i class="ri-account-circle-fill"></i>&nbsp;&nbsp;MASUK AKAUN</h1></center>
    
    <form action="" method="post">
        <!-- Display error message -->
    <?php if (!empty($login_error)) : ?>
        <div class="error-message">
            <?php echo $login_error; ?>
        </div>
    <?php endif; ?>
    
    <div class="txt_field">
    <input type="text" name="id" maxlength="12" oninput="this.value = this.value.toUpperCase()" required>
    <span></span>
    <label for=""><i class="ri-user-6-fill"></i>&nbsp;&nbsp;&nbsp;No.Anggota/No.ID</label>
</div>
<div class="txt_field">
    <input type="password" name="password" required>
    <span></span>
    <label for=""><i class="ri-lock-fill"></i>&nbsp;&nbsp;&nbsp;Kata Laluan</label>
</div>
<input type="submit" name="submit" value="Login">

<br><br>
</form>
</div>
</div>
</body>
</html>