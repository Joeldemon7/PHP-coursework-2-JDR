<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Students</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-theme.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Delete Students</div>
                    <div class="card-body">
                        <?php
                        if(isset($_POST['deletebtn']) && isset($_POST['students'])) {
                            // Prepare the delete statement
                            $sql = "DELETE FROM student WHERE studentid = ?";
                            $stmt = $conn->prepare($sql);

                            foreach($_POST['students'] as $studentid) {
                                // Bind the parameter and execute the statement for each selected student
                                $stmt->bind_param("s", $studentid);
                                if($stmt->execute()) {
                                    echo "<div class='alert alert-success' role='alert'>Student with ID $studentid deleted successfully.</div>";
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>Error deleting student with ID $studentid: " . $conn->error($conn) . "</div>";
                                }
                            }
                            // Close the prepared statement
                            $stmt->close();
                        } else {
                            echo "<div class='alert alert-info' role='alert'>No students selected for deletion.</div>";
                        }
                        // Close the database connection
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
