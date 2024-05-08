<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

echo template("templates/partials/header.php");
echo template("templates/partials/nav.php");

// Check if search query is provided
if(isset($_GET['q'])) {
    // Sanitize search query to prevent SQL injection
    $search_query = mysqli_real_escape_string($conn, $_GET['q']);
    
    // Perform search in the database
    $sql = "SELECT * FROM student WHERE 
            studentid LIKE '%$search_query%' OR 
            firstname LIKE '%$search_query%' OR 
            lastname LIKE '%$search_query%' OR 
            dob LIKE '%$search_query%' OR 
            house LIKE '%$search_query%' OR 
            town LIKE '%$search_query%' OR 
            county LIKE '%$search_query%' OR 
            country LIKE '%$search_query%' OR 
            postcode LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);

    // Check if any results found
    if(mysqli_num_rows($result) > 0) {
        // Display search results
        echo "<div class='container'>";
        echo "<h2 class='mt-4'>Search Results</h2>";
        echo "<div class='row'>";

        while($row = mysqli_fetch_assoc($result)) {
            // Determine the profile image to display or the prompt
            $profileImage = $row['profile_image'] ? "uploads/{$row['profile_image']}" : "no-profile-image.jpg";
            $altText = $row['profile_image'] ? "Profile Image of {$row['firstname']} {$row['lastname']}" : "Please Update Your Profile Image";

            // Display student details
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card bg-light'>";
            echo "<img src='{$profileImage}' class='card-img-top img-thumbnail' alt='{$altText}' width='200' height='200'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>Student ID: {$row['studentid']}</h5>";
            echo "<h6 class='card-text'>Name: {$row['firstname']} {$row['lastname']}</h6>";
            echo "<h6 class='card-text'>Date of Birth: {$row['dob']}</h6>";
            echo "<h6 class='card-text'>Address: {$row['house']}, {$row['town']}, {$row['county']}, {$row['country']}, {$row['postcode']}</h6>";
            echo "</div>"; // Close card body
            echo "</div>"; // Close card
            echo "</div>"; // Close column
        }

        echo "</div>"; // Close row
        echo "</div>"; // Close container
    } else {
        echo "<p class='mt-4'>No results found.</p>";
    }
} else {
    // Redirect to homepage or display error message
    header("Location: index.php");
    exit();
}

// Close database connection
mysqli_close($conn);

?>
