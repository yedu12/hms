<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Hostel Management System</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--custom CSS-->
    
    <style type="text/css">
        #activities{
            margin-top: 2%;
        }
        #activities ul,#activities li {
            padding: 0;
            list-style-type: none;
            margin: 0;
        }
        #activities li {
            padding: 10px;
            list-style-type: none;
            margin: 0;
                letter-spacing: 5px;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .data-list {
            height: 250px;
            padding: 2rem;
            overflow-y: hidden;
            text-align: center;
        }
        #activities h3, #activities li{
            font-family: 'Times New Roman'
        }
        .col-sm-5{
            border : 2px solid rgb(92, 86, 86);
            box-shadow: 5px 10px #888888;
        }

    </style>
            <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class="jumbotron text-center">
        <div class="row">
            <div class="col-sm-3">
                <img src="images/iit_tirupati_latest_logo.jpg" height="100px">
            </div>
            <div class="col-sm-6">
                <h2><a class="nounderline" href="./index.php">Hostel Management  System</a></h2>
            </div>
            <div class="col-sm-3">
                <a href="#" class="fa fa-facebook"></a>
                <a href="#" class="fa fa-twitter"></a>
                <a href="#" class="fa fa-google"></a>
            </div>
        </div>
        
    </div>
    <nav class="navbar navbar-inverse" role="navigation" style="border-radius: 0%;background-color: black; margin: 0%;">
        <div class="container">
            <div class="navbar-header" >
                <a class="navbar-brand" href="./index.php" style="text-align: left;">Hostel Management  System</a>
            </div>
            <div class="collapse navbar-collapse" style="font-size:medium;">
                <ul class="nav navbar-nav">
                    <li><a href="./index.php">Home</a></li>
                <li><a href="./facilities.php">Facilities</a></li>
                <li><a href="./gallery.php">Gallery</a></li>
                <li><a href="./dosdont.php">Do's & Don'ts</a></li>
                <?php session_start(); if($_SESSION['id']) {?>
                    <li><a href="<?php if($_SESSION['who']=='1'){ echo 'supervisor.php';} elseif($_SESSION['who']=='2'){ echo 'warden.php';} else{ echo 'student.php';} ?>"><?php echo $_SESSION['name'];} else { ?></a></li>
                <li><a href="./login.php">Login Register</a></li> 
                    <?php };?>
                <li><a href="./faq.php">FAQ</a></li>
                <li><a href="./contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>