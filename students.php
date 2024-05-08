<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if user is logged in
if (isset($_SESSION['id'])) {
    // Include header and navigation
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // Retrieve all student records from the database
    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);

    // Start building the table
    $data['content'] .= "<form action='deletestudents.php' method='POST'>";
    $data['content'] .= "<div class='container'>";
    $data['content'] .= "<h2>Student Records</h2>";
    $data['content'] .= "<div class='table-responsive'>";
    $data['content'] .= "<table class='table table-striped table-hover'>";
    $data['content'] .= "<thead class='thead-dark'>";
    $data['content'] .= "<tr><th>Select</th><th>Student ID</th><th>DOB</th><th>First Name</th><th>Last Name</th><th>House</th><th>Town</th><th>County</th><th>Country</th><th>Postcode</th><th>Profile Image</th></tr>";
    $data['content'] .= "</thead>";
    $data['content'] .= "<tbody>";

    // Display student records in the table
    while ($row = mysqli_fetch_array($result)) {
        $data['content'] .= "<tr>";
        // Add checkbox for deletion
        $data['content'] .= "<td><input type='checkbox' name='students[]' value='{$row['studentid']}'></td>";
        // Display student data
        $data['content'] .= "<td>{$row['studentid']}</td>";
        $data['content'] .= "<td>{$row['dob']}</td>";
        $data['content'] .= "<td>{$row['firstname']}</td>";
        $data['content'] .= "<td>{$row['lastname']}</td>";
        $data['content'] .= "<td>{$row['house']}</td>";
        $data['content'] .= "<td>{$row['town']}</td>";
        $data['content'] .= "<td>{$row['county']}</td>";
        $data['content'] .= "<td>{$row['country']}</td>";
        $data['content'] .= "<td>{$row['postcode']}</td>";
        // Display profile image
        $data['content'] .= "<td><img src='uploads/{$row['profile_image']}' class='img-thumbnail' width='100'></td>";
        $data['content'] .= "</tr>";
    }
    $data['content'] .= "</tbody>";
    $data['content'] .= "</table>";
    $data['content'] .= "</div>"; // Close table-responsive div

    // Add delete button
    $data['content'] .= "<div class='text-center mt-3'>";
    $data['content'] .= "<input type='submit' class='btn btn-danger' name='deletebtn' value='Delete'>";
    $data['content'] .= "</div>"; // Close text-center div

    // End form
    $data['content'] .= "</div>"; // Close container div
    $data['content'] .= "</form>";

    // Render the template
    echo template("templates/default.php", $data);

    // Include footer
    echo template("templates/partials/footer.php");
} else {
    // Redirect to index.php if not logged in
    header("Location: index.php");
}

?>
