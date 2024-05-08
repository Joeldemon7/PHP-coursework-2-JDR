<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if user is logged in
if (isset($_SESSION['id'])) {

    // Include header and navigation
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // If the form has been submitted
    if (isset($_POST['submit'])) {
        // Handle profile image upload
        $profileImage = $_FILES['profile_image'];
        if ($profileImage['error'] === UPLOAD_ERR_OK) {
            // Upload directory
            $uploadDir = "uploads/";
            // Generate a unique name for the file
            $fileName = uniqid() . '_' . basename($profileImage['name']);
            // Path to store the uploaded image
            $uploadPath = $uploadDir . $fileName;
            // Move the uploaded file to the destination directory
            if (move_uploaded_file($profileImage['tmp_name'], $uploadPath)) {
                // File uploaded successfully, update the database
                $sqlUpdateImage = "UPDATE student SET profile_image = ? WHERE studentid = ?";
                $stmt = $conn->prepare($sqlUpdateImage);
                $stmt->bind_param("ss", $fileName, $_SESSION['id']);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Build an SQL statement to update the student details
        $sql = "UPDATE student SET firstname = ?, lastname = ?, house = ?, town = ?, county = ?, country = ?, postcode = ? WHERE studentid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $_POST['txtfirstname'], $_POST['txtlastname'], $_POST['txthouse'], $_POST['txttown'], $_POST['txtcounty'], $_POST['txtcountry'], $_POST['txtpostcode'], $_SESSION['id']);
        $stmt->execute();

        echo '<div class="container mt-5">
                <div class="alert alert-success" role="alert">
                    Your details have been updated.
                </div>
            </div>';

        $stmt->close();

    } else {
        // Build a SQL statement to return the student record with the id that matches the session variable
        $sql = "SELECT * FROM student WHERE studentid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        // Form layout using Bootstrap
        $profileImagePath = "uploads/" . $row['profile_image']; // Path to profile image
        $profileImageTag = $row['profile_image'] ? "<img src='{$profileImagePath}' class='img-thumbnail' width='150'>" : "";
        $data['content'] = '
        <div class="container">
            <h2>My Details</h2>
            <form name="frmdetails" action="" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="profile_image" class="col-sm-2 col-form-label">Profile Image</label>
                    <div class="col-sm-10">
                        <input type="file" name="profile_image" class="form-control">
                        ' . $profileImageTag . ' <!-- Display current profile image -->
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtfirstname" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                        <input name="txtfirstname" type="text" class="form-control" value="' . $row['firstname'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtlastname" class="col-sm-2 col-form-label">Surname</label>
                    <div class="col-sm-10">
                        <input name="txtlastname" type="text" class="form-control" value="' . $row['lastname'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txthouse" class="col-sm-2 col-form-label">Number and Street</label>
                    <div class="col-sm-10">
                        <input name="txthouse" type="text" class="form-control" value="' . $row['house'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txttown" class="col-sm-2 col-form-label">Town</label>
                    <div class="col-sm-10">
                        <input name="txttown" type="text" class="form-control" value="' . $row['town'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtcounty" class="col-sm-2 col-form-label">County</label>
                    <div class="col-sm-10">
                        <input name="txtcounty" type="text" class="form-control" value="' . $row['county'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtcountry" class="col-sm-2 col-form-label">Country</label>
                    <div class="col-sm-10">
                        <input name="txtcountry" type="text" class="form-control" value="' . $row['country'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="txtpostcode" class="col-sm-2 col-form-label">Postcode</label>
                    <div class="col-sm-10">
                        <input name="txtpostcode" type="text" class="form-control" value="' . $row['postcode'] . '">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="submit" value="Save" name="submit" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>';

    }

    // Render the template
    echo template("templates/default.php", $data);

    // Include footer
    echo template("templates/partials/footer.php");

} else {
    // Redirect to index.php if not logged in
    header("Location: index.php");
}

?>
