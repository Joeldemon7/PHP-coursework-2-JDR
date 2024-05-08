<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Check if the user is logged in
if (isset($_SESSION['id'])) {

    // Include header and navigation
    echo template("templates/partials/header.php");
    echo template("templates/partials/nav.php");

    // Build SQL statement that selects a student's modules
    $sql = "SELECT sm.modulecode, m.name, m.level FROM studentmodules sm INNER JOIN module m ON m.modulecode = sm.modulecode WHERE sm.studentid = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("s", $_SESSION['id']);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any modules
    if ($result->num_rows > 0) {
        ?>
        <div class="container mt-5">
            <h2>Modules</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the modules within the HTML table
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['modulecode']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['level']); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo '<div class="container mt-5"><p>No modules assigned.</p></div>';
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Include footer
    echo template("templates/partials/footer.php");

} else {
    // Redirect to index.php if not logged in
    header("Location: index.php");
}

?>
