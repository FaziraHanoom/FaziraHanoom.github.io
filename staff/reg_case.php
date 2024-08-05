<?php
include 'connection.php';
include 'header_staff.php';

$stafff_name   = $_SESSION['name'];
$sql1          = "SELECT staff_id FROM `staff` WHERE `name`='$stafff_name'";
$result1       = mysqli_query($conn,$sql1);
$row           = mysqli_fetch_assoc($result1);

if (isset($_POST['submit'])) {
    $complainant_name = $_POST['complainant_name'];
    $no_phonecomp = $_POST['no_phonecomp'];
    $incident_location = $_POST['incident_location'];
    $case_source = $_POST['case_source'];
    $case_date = $_POST['case_date'];
    $receivecase_time = $_POST['receivecase_time'];
    $case_status = $_POST['case_status'];
    $description = $_POST['description'];
    $staff_id = $row['staff_id'];
    $casetype_id = $_POST['casetype_id'];

    // Insert the case into the database
    $sql = "INSERT INTO `case` (complainant_name, no_phonecomp, incident_location, case_source, case_date, receivecase_time, case_status, description, staff_id, casetype_id) VALUES ( '$complainant_name', '$no_phonecomp', '$incident_location', '$case_source', '$case_date', '$receivecase_time', '$case_status', '$description', '$staff_id', '$casetype_id')";

    $result = mysqli_query($conn,$sql);
    if($result){
		echo '<script type="text/javascript">
                        alert("Kes berjaya dilaporkan.")
                        </script>';
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=view_case_all.php\">";
		
	}
	else{
		die(mysqli_error($conn));
	}
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daftar Kes</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        .form-control, .form-select, textarea {
            border: 2px solid #ced4da;
            box-shadow: none;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus, textarea:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }
        label {
            font-weight: bold;
        }
        #map-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px; /* Set the height of the map container */
            width: 100%;   /* Set the width of the map container */
        }

        #map {
            height: 100%;  /* Set the map height to fill the container */
            width: 100%;   /* Set the map width to fill the container */
        }
    </style>
</head>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center text-white mb-4">DAFTAR KES</h2><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="map-container">
                    <div id="map"></div>
                </div>
                <form action="reg_case.php" method="post" enctype="multipart/form-data" style="width:100%; min-width: 300px; margin-top: 20px;">
                    <!-- Map integration fields here -->
                    <div class="row mb-3">
        <label class="col-md-2 col-form-label text-md-end">Tarikh Kes:</label>
        <div class="col-md-4">
            <input type="date" class="form-control" id="case_date" name="case_date" required>
        </div>
                        <label class="col-md-2 col-form-label text-md-end">Waktu Terima Kes:</label>
                        <div class="col-md-4">
                            <input type="time" class="form-control" name="receivecase_time" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Status Kes:</label>
                        <div class="col-md-4">
                            <input type="output" name="case_status" class="form-control" value="Terima" readonly>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">Deskripsi:</label>
                        <div class="col-md-4">
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <input type="hidden" name="staff_id" value="<?php echo $_SESSION['staff_id'];?>" required>
                        <label class="col-md-2 col-form-label text-md-end">Jenis Kes:</label>
                        <div class="col-md-4">
                            <select name="casetype_id" class="form-control" required>
                                <option value="">--- Pilih ---</option>
                                <?php
                                $result = $conn->query("SELECT * FROM case_type ORDER BY case_name ASC");
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['casetype_id'] . '">' . $row['case_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label text-md-end">Nama Pengadu:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="complainant_name" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                        <label class="col-md-2 col-form-label text-md-end">No. Telefon Pengadu:</label>
                        <div class="col-md-4">
                            <input type="tel" class="form-control" name="no_phonecomp" pattern="[0-9]{10,11}" title="Please enter a valid phone number (numeric, 10 or 11 digits)" maxlength="11" required>
                        </div>
                    </div>
                    <div class="row mb-3">
    <label class="col-md-2 col-form-label text-md-end">Lokasi Kejadian:</label>
    <div class="col-md-4">
        <textarea class="form-control" id="incident_location" name="incident_location" rows="3" required></textarea>
    </div>
    <label class="col-md-2 col-form-label text-md-end">Sumber Kes:</label>
    <div class="col-md-4">
        <select name="case_source" class="form-control" required>
            <option value="">--- Pilih ---</option>  
            <option value="TMRC">TMRC</option> 
            <option value="PDRM">PDRM</option> 
            <option value="JBPM">JBPM</option>
            <option value="HOSPITAL">HOSPITAL</option>
            <option value="LAIN-LAIN">LAIN-LAIN</option>
        </select>
    </div>
</div>

                    <div class="row mb-3">
                        <div class="col text-end">
                            <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                            <a href="dashboard_staff.php" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([2.20084, 102.25056], 13); // Example coordinates centered on Melaka

        // Add a tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Add the search control to the map
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        }).on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]).addTo(map);
            map.fitBounds(poly.getBounds());
            document.getElementById('incident_location').value = e.geocode.name;
        }).addTo(map);

        // Add a marker on click
        var marker;
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('incident_location').value = e.latlng.lat + ", " + e.latlng.lng;
        });
    </script>
        <script>
        // This function sets the date input to the current date
        function setCurrentDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById('case_date').value = today;
        }

        // Execute the function when the window loads
        window.onload = function() {
            setCurrentDate();
        };
    </script>
</body>
</html>
