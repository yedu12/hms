<?php include('header.php');?>
<?php 
    if(!$_SESSION['id']){
        header("Location: login.php");
    }
    if($_SESSION['who']!=3){
        header("Location: index.php");
    }
    $servername = "localhost";
    $username = "root";

    // Create connection
    $conn = new mysqli($servername, $username, '','hms');
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $status = '';
    $sql = "select * from users,allocation  where users.id = '$_SESSION[id]' and allocation.student_id = users.id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
       $error = "Something is wrong!";
    }
    $query2 = "select * from users,allocation where allocation.room_id = '$row[room_id]' and users.id = allocation.student_id";
    $roommates = $conn->query($query2);

    $query3 = "select * from leave_request where student_id = '$_SESSION[id]'";
    $leave_requests = $conn->query($query3);

    $query4 = "select * from service_request where student_id = '$_SESSION[id]'";
    $service_requests = $conn->query($query4);

    $query5 = "select * from complaints where student_id = '$_SESSION[id]'";
    $complaints = $conn->query($query5);
    
    $conn->close();
?>

    <h3>Warden</h3>    
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Profile')" id="defaultOpen">Profile</button>
        <button class="tablinks" onclick="openTab(event, 'Room details')" >Room details</button>
        <button class="tablinks" onclick="openTab(event, 'Change password')">Change password</button>
        <button class="tablinks" onclick="openTab(event, 'Leave request')">Leave request</button>
        <button class="tablinks" onclick="openTab(event, 'Request a service')">Request a service</button>
        <button class="tablinks" onclick="openTab(event, 'Register a complaint')">Register a complaint</button>
        <button class="tablinks" onclick="openTab(event, 'Fee payment')">Fee payment</button>
        <button class="tablinks" onclick="openTab(event, 'Logout')">Logout</button>
    </div>
    
    <div id="Profile" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Profile</div>
            <div class="panel-body">
            <form class="update" method="POST" action='#' name="user_details_form">
                    <div id="username">
                        <label >FullName: </label>
                        <input name="name" id="username" type="text" placeholder="KV Narayan" value="<?php  echo $row['name'];?>" required="">
                    </div>
                    <div id="phone"> 
                        <label>Mobile No:</label>
                        <input name="phone"  type="number" id="phone1" placeholder="9876543210" value = "<?php echo $row['phone'];?>"required> 
                    </div>
                </form>
                <div>
                    <button class='btn btn-primary' onclick="update_user_details()">Update</button>
                </div>

            </div>
        </div>
    </div>
    <div id="Room details" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Room details : <?php echo $row['room_id'] ?></div>
            <div class="panel-body">
                <table>
                    <thead>
                            <td>ID</td>
                            <td>Name</td>
                        
                    </thead>
                    <?php while( $mate = $roommates -> fetch_assoc()) {?>
                    <tr>
                        <td><?php  echo $mate['id'];?></td>
                        <td><?php  echo $mate['name'];?></td>
                    </tr>
                    <?php }?>
                </table>

            </div>
        </div>
    </div>
    <div id="Change password" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Change password</div>
            <div class="panel-body">
            <form class="update" method="POST" name="update_password_form" >
                <div id="oldpassword">
                    <label >Old Password: </label>
                    <input name="password" id="password" type="password" required="">
                </div>
                <div id="newpassword"> 
                    <label>New Password:</label>
                    <input name="newpassword"  type="password" id="newpassword" required> 
                </div>
            </form>
            <div>
                <button class='btn btn-primary' onclick="update_password()">Update</button>
            </div>
        </div>
    </div>
    </div>
    <div id="Leave request" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Leave request</div>
            
            <div class="panel-body">
                <form action="#">
                <div> 
                    <label>To:</label>
                    <input name="to"  type="text" id="where_to" placeholder="Ex. Hyderabad" required> 
                </div>
                <div> 
                    <label>Reason:</label>
                    <input name="reason"  type="text" id="reason" placeholder="Ex. Wedding of a Friend" required> 
                </div>
                <div> 
                    <label>From date:</label>
                    <input name="fromdate"  type="text" id="fromdate" placeholder="Ex. 11/05/2020" required> 
                </div>
                <div> 
                    <label>To date:</label>
                    <input name="todate"  type="text" id="todate" placeholder="Ex. 15/05/2020" required> 
                </div>
                <div>
                    <input name="submit" value="Submit" type="button" onclick="submit_leave_form(this)">
                 </div>
                 
                </form>
                <table class=table>
                    <th><tr><td>To</td><td>Reason</td><td>From Date</td><td>To Date</td><td>Approved</td></tr></th>
                    <?php
                        while( $leave = $leave_requests -> fetch_assoc()){
                    ?>
                        <tr><td><?php echo $leave['where_to'];?></td><td><?php echo $leave['reason'];?></td><td><?php echo $leave['from_date'];?></td><td><?php echo $leave['to_date'];?></td><td><?php if ($leave['approved']=='1') {echo "Yes";} else {echo "NO";}?></td></tr>
                        <?php } ?>
                </table>
            </div>
        </div>
    </div>
    
    <div id="Request a service" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Request a service</div>
            <div class="panel-body">
                <form action="#">
                    <div> 
                        <label>Service :</label>
                        <input name="service"  type="text" id="service_request" placeholder="Ex. Room cleaning" required> 
                    </div>
                    <div>
                        <input name="submit" value="Submit" type="button" onclick="submit_service_request(this)">
                     </div>
                </form>
                <table class=table>
                    <th><tr><td>Request</td><td>Acknowleged</td></tr></th>
                    <?php
                        while( $reqest = $service_requests -> fetch_assoc()){
                    ?>
                        <tr><td><?php echo $reqest['request'];?></td><td><?php if ($reqest['acked']=='1') {echo "Yes";} else {echo "NO";}?></td></tr>
                        <?php } ?>
                </table>
            </div>
        </div>

      </div>
      <div id="Register a complaint" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Register a complaint</div>
            <div class="panel-body" style="color:black;">


                <div> 
                    <label>Title:</label>
                    <input name="title"  type="text" id="title" placeholder="Ex. Fan is not working" required> 
                </div>
                <div> 
                    <label>Complaint:</label>
                    <input name="complaint"  type="text" id="complaint" placeholder="Ex. Fan is not working" required> 
                </div>
                <div> 
                    <label>Type:</label>
                    <input name="type"  type="text" id="type" placeholder="Ex. Electrical/Plumbing" required> 
                </div>
                <div>
                    <input name="submit" value="Submit" style="color:black;" type="button" onclick="submit_complaint(this)">
                 </div>
                 <table class=table>
                    <th><tr><td>Title</td><td>Complaint</td><td>Type</td><td>Acknowleged</td></tr></th>
                    <?php
                        while( $complaint = $complaints -> fetch_assoc()){
                    ?>
                        <tr><td><?php echo $complaint['title'];?></td><td><?php echo $complaint['complaint'];?></td><td><?php echo $complaint['type'];?></td>  <td><?php if ($complaint['acked']=='1') {echo "Yes";} else {echo "NO";}?></td></tr>
                        <?php } ?>
                </table>   
            </div>
        </div>
      </div>
      <div id="Fee payment" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Fee payment</div>
            <div class="panel-body">
                <table>
                    
                    <thead>
                        <tr>
                            <td>Fee</td>
                            <td>Ammount</td>
                            <td>Payment reference number</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tr>
                        <td>
                            Hostel
                        </td>
                        <td>48,000/-</td>
                        <td>

                        </td>
                        <td>
                            No
                        </td>
                    </tr>
                </table>
               
                <div>
                    <input name="submit" value="Pay" type="button" onclick="test(event)">
                 </div>
            </div>
        </div>
    </div>
      <div id="Logout" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Logout</div>
            <div class="panel-body">
                <h3>
                    <a href="logout.php">Click here to logout</a>
                </h3>
            </div>
        </div>
      </div>

    <script>
        $(document).ready(function (){
        }
)
    function openTab(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
    function submit_leave_form(a){
            data = {
                to_where : document.getElementById("where_to").value,
                reason : document.getElementById("reason").value,
                fromdate: document.getElementById("fromdate").value,
                todate : document.getElementById("todate").value
            };
            a.value = "Submitting...";
            $.post("submit_leave.php", data, function(data,status){
                a.value = "Submit";
                if (data == 'SUCCESS'){
                    alert("Leave request has been submitted!!");
                }
                else{
                    alert(data);
                }
            });
    }
    function submit_service_request(a){
            a.value = "Submitting...";
            $.post("submit_sr.php", { request : document.getElementById('service_request').value }, function(data,status){
                a.value = "Submit";
                if (data == 'SUCCESS'){
                    alert("Service request has been submitted!!");
                }
                else{
                    alert(data);
                }
            });

    }
    function submit_complaint(a){
            data = {
                title : document.getElementById("title").value,
                type : document.getElementById("type").value,
                complaint: document.getElementById("complaint").value,
            };
            a.value = "Submitting...";
            $.post("submit_complaint.php", data, function(data,status){
                a.value = "Submit";
                if (data == 'SUCCESS'){
                    alert("Complaint has been submitted!!");
                }
                else{
                    alert(data);
                }
            });
    }
    function update_user_details(e){
        $.ajax({
            type: "POST",
            url: "update_user_details.php",
            data: $(document.user_details_form).serialize(),
            success: function(data,status,xhr) {
                alert(data);
            },
            error: function (xhr, status, error){
                alert(error);
            }
        });
        return false;
    }
    function update_password(){
        $.ajax({
            type: "POST",
            url: "update_password.php",
            data: $(document.update_password_form).serialize(),
            success: function(data,status,xhr) {
                alert(data);
            },
            error: function (xhr, status, error){
                alert(error);
            }
        });
    }
    </script>
       
</body>
</html>

<style>
        * {box-sizing: border-box}
        body {font-family: "Lato", sans-serif;}
        
        /* Style the tab */
        .tab {
        float: left;
        border: 1px solid white;
        background-color: rgba(245, 241, 241, 0.822);
        width: 30%;
        height: 300px;
        }
        
        /* Style the buttons inside the tab */
        .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
        }
        
        /* Change background color of buttons on hover */
        .tab button:hover {
        background-color: #ccc;
        color: yellow;
        }
        
        /* Create an active/current "tab button" class */
        .tab button.active {
        background-color: black;
        color: yellow;
        }
        
        /* Style the tab content */
        .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid white;
        width: 70%;
        border-left: none;
        text-align: center;
    
        }
        .panel > .panel-heading {
            background-color: black;
            color: yellow;
            font-size: large;
            height: 70px;
        }
        .panel > .panel-body{
            background-color: white;
            color: yellow;
            font-size: large;
            height: 480px;
        }
        form div{

            color: black;
            padding: 15px;
        }
        table{
            color: black;
        }
        table thead td{
            color: red;
        }
        table td{
            width: 10%;
            padding: 10px;
        }
        form div, label, form input[type=text],form{

        color: black;
        padding: 15px;
        }
        table{
        color: black;
        }
        table thead td{
        color: red;
        }
        table td{
        width: 10%;
        padding: 10px;
        }
        #tabletosmall{
        font-size: 12px;
        }
        </style>