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
    $sql = "insert into leave_request(student_id,where_to,reason,from_date,to_date,approved) values('$_SESSION[id]','$_POST[to_where]','$_POST[reason]','$_POST[fromdate]','$_POST[todate]','0')";
    if ($conn->query($sql) === TRUE) {
    $status =  "SUCCESS";
    } else {
        $status=  "ERROR" . $conn->error;
    }
    echo $status;
    $conn->close();

?>