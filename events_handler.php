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

        $sql = "insert into events(event, from_date, to_date) values('$_POST[event]','$_POST[from]', '$_POST[to]' )";
        if ($conn->query($sql) === TRUE) {
        $status =  "SUCCESS";
        } else {
            $status=  "ERROR" . $conn->error;
        }

    }
    else{

        $sql = "update events set event='$_POST[event]', from_date='$_POST[from]', to_date = '$_POST[to]' where id='$_POST[id]'";
        if ($conn->query($sql) === TRUE) {
        $status =  "SUCCESS";
        } else {
            $status=  "ERROR" . $conn->error;
        }

    }
    echo $status;
    $conn->close();

?>