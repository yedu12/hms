<?php 
    $servername = "localhost";
    $username = "root";
    session_start();
    // Create connection
    $conn = new mysqli($servername, $username, '','hms');
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $status = '';
    $sql = "update leave_request set approved = '1' where leave_id = '$_POST[id]'";
    if ($conn->query($sql) === TRUE) {
    $status =  "SUCCESS";
    } else {
        $status=  "ERROR" . $conn->error;
    }
    echo $status;
    $conn->close();

?>