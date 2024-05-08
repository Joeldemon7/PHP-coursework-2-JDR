<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            echo "<div class='alert alert-success'>Image Uploaded Successfully - " . $check["mime"] . ".</div>";
            $uploadOk = 1;
        } else {
            echo "<div class='alert alert-danger'>File is not an image.</div>";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            // Escape user inputs for security
            $studentid = mysqli_real_escape_string($conn, $_POST['txtstudentid']);
            $hashed_password = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);
            $dob = mysqli_real_escape_string($conn, $_POST['txtdob']);
            $firstname = mysqli_real_escape_string($conn, $_POST['txtfirstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['txtlastname']);
            $house = mysqli_real_escape_string($conn, $_POST['txthouse']);
            $town = mysqli_real_escape_string($conn, $_POST['txttown']);
            $county = mysqli_real_escape_string($conn, $_POST['txtcounty']);
            $country = mysqli_real_escape_string($conn, $_POST['txtcountry']);
            $postcode = mysqli_real_escape_string($conn, $_POST['txtpostcode']);
            $profile_image = basename($_FILES["profile_image"]["name"]);

            // Build SQL statement to insert student details
            $sql = "INSERT INTO student (studentid, password, dob, firstname, lastname, house, town, county, country, postcode, profile_image) VALUES ('$studentid', '$hashed_password', '$dob', '$firstname', '$lastname', '$house', '$town', '$county', '$country', '$postcode', '$profile_image')";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>Student added successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light flex-column">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="modules.php">My Modules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="students.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addstudent.php">Add Student</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="assignmodule.php">Assign Module</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="details.php">My Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <!-- Search button -->
                <li class="nav-item">
                        <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Add New Student</h2>
                    </div>
                    <div class="card-body">
                        <form name="frmaddstudent" action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="txtstudentid" class="form-label">Student ID:</label>
                                <input name="txtstudentid" type="text" class="form-control"/>
                            </div>
                            <div class="mb-3">
                                <label for="txtpassword" class="form-label">Password:</label>
                                <div class="input-group">
                                    <input name="txtpassword" id="txtpassword" type="password" class="form-control"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="checkbox" onclick="togglePassword()"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="txtfirstname" class="form-label">First Name:</label>
                                    <input name="txtfirstname" type="text" class="form-control"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="txtlastname" class="form-label">Last Name:</label>
                                    <input name="txtlastname" type="text" class="form-control"/>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="txtdob" class="form-label">Date of Birth:</label>
                                <input name="txtdob" type="date" class="form-control"/>
                            </div>
                            <div class="mb-3">
                                <label for="txthouse" class="form-label">Number and Street:</label>
                                <input name="txthouse" type="text" class="form-control"/>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="txttown" class="form-label">Town:</label>
                                    <input name="txttown" type="text" class="form-control"/>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="txtcounty" class="form-label">County:</label>
                                    <input name="txtcounty" type="text" class="form-control"/>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="txtcountry" class="form-label">Country:</label>
                                <input name="txtcountry" type="text" class="form-control"/>
                            </div>
                            <div class="mb-3">
                                <label for="txtpostcode" class="form-label">Postcode:</label>
                                <input name="txtpostcode" type="text" class="form-control"/>
                            </div>
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image:</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("txtpassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


