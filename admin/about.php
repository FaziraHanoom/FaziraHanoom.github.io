<?php 
include 'connection.php';
include 'header_admin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laman Utama Admin</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link href="styles.css" rel="stylesheet">
    <style>
    body {
    background-color: #4668CE;
    width: 100%;
    display: flex;
    flex-direction: column;
    padding-bottom: 100px; /* Adjust this value to create enough space for the footer */
    margin: 0; /* Add this to remove default margin */
    }
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .menu {
            text-align: center;
            background: #ffffff; /*menu nav backround*/
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

        .menu ul li:hover .sbm1 ul li a {
            color: #000000;
        }

        .menu ul li:hover .sbm1 ul li a:hover {
            color: #4668CE;
        }

        .branch-info {
            background: #ffffff;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            color: #000000;
        }

        .branch-info h2 {
            margin-bottom: 10px;
        }

        .branch-info ul {
            list-style-type: none;
            padding: 0;
        }

        .branch-info ul li {
            margin-bottom: 10px;
        }

        .branch-info ul li span {
            font-weight: bold;
        }
        .menu .logo {
            height: 70px;
        }
        #map-container {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        #map {
            height: 450px;
            width:1000px;
            margin: 20px;
        }
        #branch-search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        #branch-search {
            width: 50%;
            margin-right: 10px;
        }
        #search-button {
            padding: 10px 20px;
            background-color: #1e90ff;
            border: none;
            color: white;
            cursor: pointer;
        }
        #search-button:hover {
            background-color: #007bff;
        }
        .text-center {
        text-align: center;
    }

    .text-orange {
        color: orange;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    </style>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
<div class="text-center text-white mb-4">&nbsp;
 		<h2>Carian Pusat Kawalan Operasi</h2>
 		<p class="text-center text-orange mb-4">Papar carian, terdapat no.telefon pusat kawalan operasi.</p>

 	</div>
    <!-----branch search--->
    <div id="branch-search-container">
    <select id="branch-search" class="form-control">
            <option value="" selected disabled>Pilih cawangan</option>
            <option value="PKOD Melaka Tengah">PKOD Melaka Tengah</option>
            <option value="Perlis Kangar">Perlis Kangar</option>
            <option value="Kedah Alor Setar">Kedah Alor Setar</option>
            <option value="Pulau Pinang Timur Laut (Georgetown)">Pulau Pinang Timur Laut (Georgetown)</option>
            <option value="Perak Kinta Ipoh (Pusat Kawalan Operasi Negeri)">PKON Perak Kinta Ipoh</option>
            <option value="Selangor Klang">Selangor Klang</option>
            <option value="WP Kuala Lumpur">WP Kuala Lumpur</option>
            <option value="Pahang Kuantan">Pahang Kuantan</option>
            <option value="Terengganu Kuala Terengganu">Terengganu Kuala Terengganu</option>
            <option value="Kelantan Kota Bharu">Kelantan Kota Bharu</option>
            <option value="Negeri Sembilan Seremban">Negeri Sembilan Seremban</option>
        </select>
        <button id="search-button" class="btn btn-info d-flex align-items-center">
        <i class="ri-search-fill"></i> Cari
            </button>
    </div>

    <!-----map--->
    <div id="map-container">
        <div id="map"></div>
    </div>

    <script>
        var map = L.map('map').setView([4.2105, 101.9758], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var branches = [
            { "name": "PKOD Melaka Tengah", "coords": [2.2008, 102.2405], "phone": "03-12345678" },
            { "name": "Perlis Kangar", "coords": [6.4414, 100.1989], "phone": "04-9777991, 04-9778991" },
            { "name": "Kedah Alor Setar", "coords": [6.1210, 100.3678], "phone": "04-7323810, 04-7323801" },
            { "name": "Pulau Pinang Timur Laut (Georgetown)", "coords": [5.4141, 100.3288], "phone": "04-2263876" },
            { "name": "Perak Kinta Ipoh (Pusat Kawalan Operasi Negeri)", "coords": [4.5975, 101.0901], "phone": "05-5278715" },
            { "name": "Selangor Klang", "coords": [3.0517, 101.4437], "phone": "03-33710820" },
            { "name": "WP Kuala Lumpur", "coords": [3.1390, 101.6869], "phone": "03-26871400" },
            { "name": "Pahang Kuantan", "coords": [3.8270, 103.3275], "phone": "09-5171991" },
            { "name": "Terengganu Kuala Terengganu", "coords": [5.3302, 103.1408], "phone": "09-6668246, 09-6672991" },
            { "name": "Kelantan Kota Bharu", "coords": [6.1254, 102.2381], "phone": "09-7474091" },
            { "name": "Negeri Sembilan Seremban", "coords": [2.7252, 101.9378], "phone": "06-7645755" }
        ];

        // Create a map of branch markers
        var branchMarkers = {};
        branches.forEach(function(branch) {
            var marker = L.marker(branch.coords).addTo(map)
                .bindPopup('<b>' + branch.name + '</b><br>' + branch.phone);
            branchMarkers[branch.name.toLowerCase()] = marker;
        });

        // Search functionality
        document.getElementById('search-button').addEventListener('click', function() {
            var searchValue = document.getElementById('branch-search').value.toLowerCase();
            var foundBranches = branches.filter(branch => branch.name.toLowerCase().includes(searchValue));

            if (foundBranches.length > 0) {
                var firstBranch = foundBranches[0];
                var marker = branchMarkers[firstBranch.name.toLowerCase()];
                map.setView(marker.getLatLng(), 10);
                marker.openPopup();
            }
        });
    </script>

    <!-----map end--->
    <!-----branch info--->
    <!--<div class="branch-info">
        <h2>Info No. Telefon Cawangan</h2>
        <ul>
            <li><span>PKOD Melaka Tengah:</span> 03-12345678</li>
            <li><span>Cawangan Selangor:</span> 03-87654321</li>
            <li><span>Cawangan Johor:</span> 07-1234567</li>
            <li><span>Cawangan Penang:</span> 04-7654321</li>
            <li><span>Perlis Kangar:</span> 04-9777991, 04-9778991</li>
            <li><span>Kedah Alor Setar:</span> 04-7323810, 04-7323801</li>
            <li><span>Pulau Pinang Timur Laut (Georgetown):</span> 04-2263876</li>
            <li><span>Perak Kinta Ipoh (Pusat Kawalan Operasi Negeri):</span> 05-5278715</li>
            <li><span>Selangor Klang:</span> 03-33710820</li>
            <li><span>WP Kuala Lumpur:</span> 03-26871400</li>
            <li><span>Pahang Kuantan:</span> 09-5171991</li>
            <li><span>Terengganu Kuala Terengganu:</span> 09-6668246, 09-6672991</li>
            <li><span>Kelantan Kota Bharu:</span> 09-7474091</li>
            <li><span>Negeri Sembilan Seremban:</span> 06-7645755</li>
        </ul>
    </div>-->
    <!-----branch info end--->
</body>
</html>

