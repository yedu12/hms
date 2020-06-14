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
    if($_POST['type']=="new"){

        $sql = "insert into notification(notification) values('$_POST[update]')";
        if ($conn->query($sql) === TRUE) {
        $status =  "SUCCESS";
        } else {
            $status=  "ERROR" . $conn->error;
        }

    }
    else{

        $sql = "update notification set notification='$_POST[update]' where id='$_POST[id]'";
        if ($conn->query($sql) === TRUE) {
        $status =  "SUCCESS";
        } else {
            $status=  "ERROR" . $conn->error;
        }

    }
    echo $status;
    $conn->close();

?>