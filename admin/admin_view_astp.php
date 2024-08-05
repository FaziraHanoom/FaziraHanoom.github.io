<?php 
include 'connection.php';
include 'header_admin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Senarai ASTP</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <style>
     
        .container {
            margin-top: 30px;
            padding-bottom: 1000px;
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

        .sbm1 {
            display: none;
            z-index: 2;
        }

        .menu ul li:hover .sbm1 {
            position: absolute;
            display: block;
            margin-top: 10px;
            margin-left: -15px;
            background: #ffffff;
        }

        .menu ul li:hover .sbm1 ul {
            display: block;
            margin: 15px;
        }

        .menu ul li:hover .sbm1 ul li {
            border-bottom: 1px solid grey;
            background: transparent;
            width: 120px;
            padding: 15px;
            text-align: left;
        }

        .menu ul li:hover .sbm1 ul li:last-child {
            border: none;
        }
        
        .form-label {
            text-align: right;
        }
        .menu .logo {
            height: 70px;
        }
        .img-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update ASTP Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateForm" action="update-astp.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="updateAstpId" name="astp_id">
                    <div class="form-group">
                        <label for="updateName">Full Name</label>
                        <input type="text" class="form-control" id="updateName" name="name">
                    </div>
                    <div class="form-group">
                        <label for="updateDob">Date of Birth</label>
                        <input type="date" class="form-control" id="updateDob" name="dob">
                    </div>
                    <div class="form-group">
                        <label for="updateNoIc">Identity Card Number</label>
                        <input type="text" class="form-control" id="updateNoIc" name="no_ic">
                    </div>
                    <div class="form-group">
                        <label for="updatePhoneNum">Phone Number</label>
                        <input type="text" class="form-control" id="updatePhoneNum" name="phone_num">
                    </div>
                    <div class="form-group">
                        <label for="updateBankName">Bank Name</label>
                        <input type="text" class="form-control" id="updateBankName" name="bank_name">
                    </div>
                    <div class="form-group">
                        <label for="updateBankAccount">Bank Account Number</label>
                        <input type="text" class="form-control" id="updateBankAccount" name="bank_account">
                    </div>
                    <div class="form-group">
                        <label for="updatePosition">Position</label>
                        <input type="text" class="form-control" id="updatePosition" name="position">
                    </div>
                    <div class="form-group">
                        <label for="updateEmail">Email</label>
                        <input type="email" class="form-control" id="updateEmail" name="email">
                    </div>
                    <div class="form-group">
                        <label for="updateBranch">Branch</label>
                        <input type="text" class="form-control" id="updateBranch" name="branch">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openUpdateModal(astpId, name, dob, noIc, phoneNum, bankName, bankAccount, position, email, branch) {
        document.getElementById('updateAstpId').value = astpId;
        document.getElementById('updateName').value = name;
        document.getElementById('updateDob').value = dob;
        document.getElementById('updateNoIc').value = noIc;
        document.getElementById('updatePhoneNum').value = phoneNum;
        document.getElementById('updateBankName').value = bankName;
        document.getElementById('updateBankAccount').value = bankAccount;
        document.getElementById('updatePosition').value = position;
        document.getElementById('updateEmail').value = email;
        document.getElementById('updateBranch').value = branch;
        $('#updateModal').modal('show');
    }
</script>

<div class="container">
    <h2 class="text-center text-white mb-4">Senarai Anggota Sukarelawan Tugas Pejabat</h2>

    <form method="GET" class="text-center mb-4">
        <div class="form-group d-inline-flex align-items-center">
            <label for="branchSelect" class="text-white me-2">Pilih Cawangan:</label>
            <select name="branch" id="branchSelect" class="form-control me-2" style="display:inline-block; width:auto;">
                <option value="">Semua</option>
                <?php
                // Get distinct branches from the database
                $branchQuery = "SELECT DISTINCT branch FROM astp";
                $branchResult = mysqli_query($conn, $branchQuery);
                while ($branchRow = mysqli_fetch_assoc($branchResult)) {
                    echo "<option value='" . $branchRow['branch'] . "'>" . $branchRow['branch'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-info d-flex align-items-center">
                <i class="ri-filter-fill me-2"></i> Tapis
            </button>
        </div>
    </form>

    <table class="table table-hover table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>No Anggota</th>
                <th>Nama Penuh</th>
                <th>Emel</th>
                <th>No.Telefon</th>
                <th>Gambar</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $branchFilter = isset($_GET['branch']) && !empty($_GET['branch']) ? "WHERE branch = '" . $_GET['branch'] . "'" : '';
            $query = "SELECT * FROM astp $branchFilter";
            $result = mysqli_query($conn, $query);
            $cnt = 1;
            while ($row = mysqli_fetch_array($result)) { 
            ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $row['astp_id']; ?></td>
                <td><?php echo $row['position'] . " " . $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone_num']; ?></td>
                <td><img src="../images/<?php echo htmlspecialchars($row['image']); ?>" class="img-thumbnail" name="image" style="max-width: 100px;" alt="Profile Image"></td>
                <td>
                   <a href="update-astp.php?id=<?php echo htmlspecialchars($row['astp_id']); ?>" class="btn btn-primary"><i class="ri-edit-2-fill"></i></a>
                    <a href="display-astp.php?id=<?php echo $row['astp_id']; ?>" class="btn btn-success"><i class="ri-eye-fill"></i></a>
                    <a href="delete_astp.php?id=<?php echo $row['astp_id']; ?>" class="btn btn-danger" onclick="return confirm('Adakah anda pasti untuk buang?');"><i class="ri-delete-bin-6-fill"></i></a>
                </td>
            </tr>
            <?php $cnt++; } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-GTkURxihUH2kfyKAsd8rYZASf3zEwt65PO1cOgIWUmWqqoWtX4VqZ8iEfpFIYZ39" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9fz45gC7EOBksb9JgJoAOQ2bKcImqXij1mgN4+7X5RSoxmFO1R9iTcQ" crossorigin="anonymous"></script>
</body>
</html>
