<?php include('header.php');?>


<?php 
    if(!$_SESSION['id']){
        header("Location: login.php");
    }
    if($_SESSION['who']!=1){
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
    $sql = "select * from users where users.id = '$_SESSION[id]' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
       $error = "Something is wrong!";
    }
    
    $query5 = "select * from complaints where acked = '0'";
    $complaints = $conn->query($query5) or die("Error");

    $conn->close();
?>
    <h3>supervisor</h3>    
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Profile')" id="defaultOpen">Profile</button>
        <button class="tablinks" onclick="openTab(event, 'Change password')">Change password</button>
        <button class="tablinks" onclick="openTab(event, 'Complaints/Requests')" id="defaultOpen">Compliants/Requests</button>
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
      <div id="Complaints/Requests" class="tabcontent">
        <div class="panel panel-success">
            <div class="panel-heading">Complaints/Requests</div>
            <div class="panel-body">

                <table id="tabletosmall">
                    <thead>
                            <td>title</td>
                            <td>Complaint</td>
                            <td>Type</td>
                            <td>Acknowledge</td>
                    </thead>
                    <?php
                        while( $complaint = $complaints -> fetch_assoc()){
                    ?>
                        <tr><td><?php echo $complaint['title'];?></td><td><?php echo $complaint['complaint'];?></td><td><?php echo $complaint['type'];?></td>  <td><button onclick="ack_complaint(this, '<?php echo $complaint['id'];?>')" >Ack</button></td></tr>
                        <?php } ?>
                    
                </table>

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

    function ack_complaint(a,id){
        a.innerHTML = 'updaing..';
        $.post("ack_complaint.php", { id : id}, function(data,status){
                a.innerHTML = "Acked";
                if (data == 'SUCCESS'){
                    alert("Acked!!");
                    a.innerHTML = "Acked";
                }
                else{
                    alert(data);
                    a.innerHTML = "Ack";
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
        height: 230px;
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
    #tabletosmall{
        font-size: 12px;
    }
    </style>