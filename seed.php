<?php

include("_includes/config.inc");
include("_includes/dbconnect.inc");
include("_includes/functions.inc");

// Array of student records
$students = array(
    array('studentid' => '20000001', 'password' => password_hash('dragon', PASSWORD_DEFAULT), 'dob' => '2000-01-01', 'firstname' => 'John', 'lastname' => 'Doe', 'house' => '123 Main St', 'town' => 'Reading', 'county' => 'Berkshire', 'country' => 'UK', 'postcode' => 'AB123CD'),
    array('studentid' => '20000002', 'password' => password_hash('demon', PASSWORD_DEFAULT), 'dob' => '2000-02-02', 'firstname' => 'Jane', 'lastname' => 'Doe', 'house' => '456 Elm St', 'town' => 'Bristol', 'county' => 'Bedfordshire', 'country' => 'UK', 'postcode' => 'EF456GH'),
    array('studentid' => '20000003', 'password' => password_hash('hero', PASSWORD_DEFAULT), 'dob' => '2000-03-03', 'firstname' => 'Alice', 'lastname' => 'Smith', 'house' => '789 Oak St', 'town' => 'York', 'county' => 'Essex', 'country' => 'UK', 'postcode' => 'IJ789KL'),
    array('studentid' => '20000004', 'password' => password_hash('lord', PASSWORD_DEFAULT), 'dob' => '2000-04-04', 'firstname' => 'Bob', 'lastname' => 'Johnson', 'house' => '1011 Pine St', 'town' => 'London', 'county' => 'Cambridgeshire', 'country' => 'UK', 'postcode' => 'MN1011OP'),
    array('studentid' => '20000005', 'password' => password_hash('angel', PASSWORD_DEFAULT), 'dob' => '2000-05-05', 'firstname' => 'Emily', 'lastname' => 'Davis', 'house' => '1213 Cedar St', 'town' => 'Derby', 'county' => 'Derbyshire', 'country' => 'UK', 'postcode' => 'QR1213ST')
);

// Insert records into the database
foreach ($students as $student) {
    $sql = "INSERT INTO student (studentid, password, dob, firstname, lastname, house, town, county, country, postcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $student['studentid'], $student['password'], $student['dob'], $student['firstname'], $student['lastname'], $student['house'], $student['town'], $student['county'], $student['country'], $student['postcode']);
    $stmt->execute();
}

echo "Records inserted successfully.";

// Close the database connection
$conn->close();

?>