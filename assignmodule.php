<?php
include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if user is logged in
if (isset($_SESSION['id'])) {
    // Include header and navigation
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // If a module has been selected
    if (isset($_POST['selmodule'])) {
        $moduleCode = mysqli_real_escape_string($conn, $_POST['selmodule']);
        
        // Check if the module is already assigned to the user
        $checkQuery = "SELECT * FROM studentmodules WHERE studentid = '" . $_SESSION['id'] . "' AND modulecode = '$moduleCode'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Display Bootstrap alert for duplicate module assignment
            echo "<div class='container mt-4'>";
            echo "<div class='alert alert-warning' role='alert'>You have already been assigned to the selected module.</div>";
            echo "</div>";
        } else {
            // Prepare and bind parameters for the insert query
            $insertQuery = "INSERT INTO studentmodules (studentid, modulecode) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $_SESSION['id'], $moduleCode);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Display success message
                echo "<div class='container mt-4'>";
                echo "<div class='alert alert-success' role='alert'>The module $moduleCode has been assigned to you successfully.</div>";
                echo "</div>";
            } else {
                // Display error message
                echo "<div class='container mt-4'>";
                echo "<div class='alert alert-danger' role='alert'>An error occurred while assigning the module. Please try again.</div>";
                echo "</div>";
            }
            // Close the prepared statement
            $stmt->close();
        }
    } else { // If a module has not been selected
        // Build SQL statement that selects all the modules
        $sql = "SELECT * FROM module";
        $result = mysqli_query($conn, $sql);

        // Start building the form with Bootstrap classes
        $data['content'] .= "<div class='container'>";
        $data['content'] .= "<form name='frmassignmodule' action='' method='post'>";
        $data['content'] .= "<label for='selmodule'>Select a module to assign</label><br/>";
        $data['content'] .= "<select name='selmodule' class='form-select'>";
        // Display the module names in a drop-down selection box
        while($row = mysqli_fetch_array($result)) {
            $data['content'] .= "<option value='" . htmlspecialchars($row['modulecode'], ENT_QUOTES) . "'>" . htmlspecialchars($row['name'], ENT_QUOTES) . "</option>";
        }
        $data['content'] .= "</select><br/>";
        $data['content'] .= "<button type='submit' name='confirm' class='btn btn-primary'>Save</button>";
        $data['content'] .= "</form>";
        $data['content'] .= "</div>";
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
