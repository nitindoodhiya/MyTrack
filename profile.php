<?php

include('check.php');


// connect to the database
$con = mysqli_connect('localhost','root','','mytrack');
$user_id = $_SESSION['user_id'];
if(empty($_SESSION['fb_login']))
{
  $user = $userObj->userData($user_id);
  $verifyObj->authOnly();
}
// get the details of the user
$p_id=$_GET['p_id'];
    $con = mysqli_connect('localhost','root','','mytrack');
    $q = "SELECT * FROM users WHERE user_id='$p_id'";
    $res = mysqli_query($con,$q);

    // fetching data of the user we are peeking in

    while($row = mysqli_fetch_array($res))
    {
        $prof['user_name'] = $row['username'];
        $prof['name_of_user'] = $row['firstName']." ".$row['lastName'];
        $prof['email'] = $row['email'];
        $prof['descr'] = $row['descr'];
    }

// Get the tv shows which user has added
$q = "SELECT show_id,count(*) FROM tv_shows WHERE user_id='$p_id' GROUP BY show_id";
$res = mysqli_query($con,$q);

$ar = array();
$ep = array();
$names = array();

// make array of tv shows and episodes watched
while($row = mysqli_fetch_array($res))
{
$v = $row['show_id'];

$qu1 = "SELECT status FROM shows WHERE show_id='$v'";
$res1 = mysqli_query($con,$qu1);
$row2 = mysqli_fetch_array($res1);
if($row2['status']==1)
    continue;
    $qu2 = "SELECT * FROM tv WHERE show_id='$v'";
    $res2 = mysqli_query($con,$qu2);
    $row3 = mysqli_fetch_array($res2);
array_push($ar,$v);
array_push($names,$row3['show_name']);
$c = $row['count(*)'];
array_push($ep,$c);

}

?>
<head>
<title>Track it!</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- <script src="dist/progressbar.js"></script> -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.9/css/mdb.min.css" rel="stylesheet">
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.9/js/mdb.min.js"></script>
<script type = text/javascript src="man.js"></script>

  <style>
    .progress {
  width: 150px;
  height: 150px;
  line-height: 150px;
  background: none;
  margin: 0 auto;
  box-shadow: none;
  position: relative;
}
.progress:after {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 7px solid #eee;
  position: absolute;
  top: 0;
  left: 0;
}
.progress > span {
  width: 50%;
  height: 100%;
  overflow: hidden;
  position: absolute;
  top: 0;
  z-index: 1;
}
.progress .progress-left {
  left: 0;
}
.progress .progress-bar {
  width: 100%;
  height: 100%;
  background: none;
  border-width: 7px;
  border-style: solid;
  position: absolute;
  top: 0;
  border-color: #ffb43e;
}
.progress .progress-left .progress-bar {
  left: 100%;
  border-top-right-radius: 75px;
  border-bottom-right-radius: 75px;
  border-left: 0;
  -webkit-transform-origin: center left;
  transform-origin: center left;
}
.progress .progress-right {
  right: 0;
}
.progress .progress-right .progress-bar {
  left: -100%;
  border-top-left-radius: 75px;
  border-bottom-left-radius: 75px;
  border-right: 0;
  -webkit-transform-origin: center right;
  transform-origin: center right;
}
.progress .progress-value {
  display: flex;
  border-radius: 50%;
  font-size: 36px;
  text-align: center;
  line-height: 20px;
  align-items: center;
  justify-content: center;
  height: 100%;
  font-weight: 300;
  padding: 30%;
}

/* .progress .progress-value div {
  margin-top: 10px;
} */
.progress .progress-value span {
  font-size: 12px;
  text-transform: uppercase;
}
/* This for loop creates the 	necessary css animation names 
 Due to the split circle of progress-left and progress right, we must use the animations on each side. 
 */
.progress[data-percentage="10"] .progress-right .progress-bar {
  animation: loading-1 1.5s linear forwards;
}
.progress[data-percentage="10"] .progress-left .progress-bar {
  animation: 0;
}
.progress[data-percentage="20"] .progress-right .progress-bar {
  animation: loading-2 1.5s linear forwards;
}
.progress[data-percentage="20"] .progress-left .progress-bar {
  animation: 0;
}
.progress[data-percentage="30"] .progress-right .progress-bar {
  animation: loading-3 1.5s linear forwards;
}
.progress[data-percentage="30"] .progress-left .progress-bar {
  animation: 0;
}
.progress[data-percentage="40"] .progress-right .progress-bar {
  animation: loading-4 1.5s linear forwards;
}
.progress[data-percentage="40"] .progress-left .progress-bar {
  animation: 0;
}
.progress[data-percentage="50"] .progress-right .progress-bar {
  animation: loading-5 1.5s linear forwards;
}
.progress[data-percentage="50"] .progress-left .progress-bar {
  animation: 0;
}
.progress[data-percentage="60"] .progress-right .progress-bar {
  animation: loading-5 1.5s linear forwards;
}
.progress[data-percentage="60"] .progress-left .progress-bar {
  animation: loading-1 1.5s linear forwards 1.5s;
}
.progress[data-percentage="70"] .progress-right .progress-bar {
  animation: loading-5 1.5s linear forwards;
}
.progress[data-percentage="70"] .progress-left .progress-bar {
  animation: loading-2 1.5s linear forwards 1.5s;
}
.progress[data-percentage="80"] .progress-right .progress-bar {
  animation: loading-5 1.5s linear forwards;
}
.progress[data-percentage="80"] .progress-left .progress-bar {
  animation: loading-3 1.5s linear forwards 1.5s;
}
.progress[data-percentage="90"] .progress-right .progress-bar {
  animation: loading-5 1.5s linear forwards;
}
.progress[data-percentage="90"] .progress-left .progress-bar {
  animation: loading-4 1.5s linear forwards 1.5s;
}
.progress[data-percentage="100"] .progress-right .progress-bar {
  animation: loading-5 1.5s linear forwards;
}
.progress[data-percentage="100"] .progress-left .progress-bar {
  animation: loading-5 1.5s linear forwards 1.5s;
}
@keyframes loading-1 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(36);
    transform: rotate(36deg);
  }
}
@keyframes loading-2 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(72);
    transform: rotate(72deg);
  }
}
@keyframes loading-3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(108);
    transform: rotate(108deg);
  }
}
@keyframes loading-4 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(144);
    transform: rotate(144deg);
  }
}
@keyframes loading-5 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(180);
    transform: rotate(180deg);
  }
}
.progress {
  margin-bottom: 1em;
}

</style>    
<style>
.avtar{
  border-radius:100%;
}
 
    .imgcolumn {
  float: left;
  width: 33.3%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.imgrow::after {
  content: "";
  clear: both;
  display: table;
}
    html, body, h1, h2, h3, h4, h5 {font-family: 'Ubuntu', sans-serif}
    .container, .panel {
    padding: 0.01em 16px;
    }
    
    .content {
    max-width: 980px;
    }
    .content, .auto {
    margin-left: auto;
    margin-right: auto;
    }
    .card, .card-2 {
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
}
.white, .hover-white:hover {
    color: #000!important;
    background-color: #fff!important;
}
.round, .round-medium {
    border-radius: 4px;
    padding: 2%;
}
.w3-row{
    margin: 1%;
}
.center{
    text-align: center;
}
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

 .accordion:hover {
  background-color: #ccc;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}


.panel {
  padding: 1%;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
.w3-col{
    padding-left: 0.5%;
    padding-bottom: 1.5%;
}
.alert{
    border-radius: 3px;
    border:solid black 1px;
}
</style>
<script>
  function openmodal() {
            document.getElementById('id01').style.display='block';
            openCity(event, 'Requests');
            
        }
         // to convert data from php to js
         var id1 = <?php echo json_encode($ar); ?>;
        var epi = <?php echo json_encode($ep); ?>;
        var name1 = <?php echo json_encode($names); ?>;

        console.log(id1);
        console.log(epi);
        console.log(name1);
        // get the statistics of the tv shows which user has added to the account
        if(id1.length>0)
            getnum(id1,name1,epi,0,id1.length);
  </script>

<body style="color: #000 !important;
background-color: black ">
 <div class="wrapper">
    <?php include 'navbar.php'; ?>                      
<div class=" container  content" style="max-width:1400px;margin-top:20px">    
        <!-- The Grid -->
        <div class=" w3-row">
          <!-- Left Column -->
          <div class="w3-col m3">
            <!-- Profile -->
            <div class=" card  round  white">
              <div class=" container">
              <p class=" center"><img class="avtar" src="img_avatar2.png" class=" circle" style="height:106px;width:106px" alt="Avatar"></p>
              <hr>
               <p><i class="fa fa-user fa-fw  margin-right  text-theme"></i><?php echo $prof['name_of_user'];?></p>
               <p><i class="fa fa-at fa-fw  margin-right  text-theme">&nbsp</i><?php echo $prof['user_name'];?></p>
               <p><i class="fa fa-home fa-fw  margin-right  text-theme"></i> <?php echo $prof['email'];?></p>
               <p><i class="fa fa-edit fa-fw  margin-right  text-theme"></i> <?php echo $prof['descr'];?></p>
              </div>
            </div>
            <br>
            
            <!-- Accordion -->
            <!-- <div class=" card  round"> -->
              <!-- <div class=" white"> -->
                        <!-- <button class="accordion" >Section 1</button>
                        <div class="panel">
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        
                        <button class="accordion">Section 2</button>
                        <div class="panel">
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        
                        <button class="accordion">Section 3</button>
                        <div class="panel">
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div> -->
                        
                        <!-- <script>
                        var acc = document.getElementsByClassName("accordion");
                        var i;
                        
                        for (i = 0; i < acc.length; i++) {
                          acc[i].addEventListener("click", function() {
                            this.classList.toggle("active");
                            var panel = this.nextElementSibling;
                            if (panel.style.maxHeight){
                              panel.style.maxHeight = null;
                            } else {
                              panel.style.maxHeight = panel.scrollHeight + "px";
                            } 
                          });
                        }
                        </script> -->
                            <!-- </div>       -->
            <!-- </div> -->
            <br>
            
            <!-- Alert Box -->
            <!-- <div class=" container  alert">
              <span onclick="this.parentElement.style.display='none'" class=" button  theme-l3  display-topright">
                <i class="fa fa-remove"></i>
              </span>
              <p><strong>Hey!</strong></p>
              <p>People are looking at your profile. Find out who.</p>
            </div> -->
          
          <!-- End Left  w3-column -->
          </div>
          
          <!-- Middle  w3-column -->
          <div class="  w3-col m9">
          
            <div class=" row-padding">
              <div class="  w3-col m12">
                <div class=" card  round  white">
                    <h1>My Progress</h1>
                    <!-- <li>Stranger Things<span id="progress"></span></li>
                    <div id="progresss"></div> -->
                    <div class="container">
                            <div class="row" id="stats">
                                                        
                            </div>
                        </div>
                    
    
                </div>
              </div>
              <div class="  w3-col m12">
                    <div class=" card  round  white">
                        
                        <h2>Most Watched</h2>
                        
                        <div class="imgrow">
                        <?php

                              $qu = "SELECT show_id,count(*) from tv_shows WHERE user_id='$p_id' GROUP BY show_id ORDER BY count(*)  DESC LIMIT 9";
                              $res = mysqli_query($con,$qu);
                              while($row = mysqli_fetch_array($res))
                              {
                                  $i = $row['show_id'];
                                  $qu2 = "SELECT status FROM shows WHERE show_id='$i'";
                                  $res3 = mysqli_query($con,$qu2);
                                  $row2 = mysqli_fetch_array($res3);
                                  if($row2['status']==1)
                                    continue;

                                    $qu3 = "SELECT * FROM tv WHERE show_id='$i'";
                                    $res4 = mysqli_query($con,$qu3);
                                    $row3 = mysqli_fetch_array($res4);

                                  ?>
                            <div class="imgcolumn">
                                <img src=<?php echo $row3['show_url'];?> alt="Snow" style="width:70%;">
                                <div class="bottom-left"><?php echo $row3['show_name'];?></div>
                            </div>
                            <?php
                              }
                            ?>
                            </div>
                    </div>
                  </div>
                  <div class="  w3-col m12">
                    <div class=" card  round  white">
                        
                        <h2>Recently Watched</h2>
                        
                        <div class="imgrow">
                        <?php

                            $qu = "SELECT * from shows WHERE user_id='$p_id' AND status=0 ORDER BY last_update DESC LIMIT 10";
                            $res = mysqli_query($con,$qu);
                            
                            while($row = mysqli_fetch_array($res))
                            {
                              $h = $row['show_id'];
                              $qu1 = "SELECT count(*) FROM tv_shows WHERE user_id='$p_id' AND show_id='$h'";
                              $res2 = mysqli_query($con,$qu1);
                              $r2 = mysqli_fetch_array($res2);

                              if($r2['count(*)']==0)
                                  continue;
                                  $qu2 = "SELECT * FROM tv WHERE show_id='$h'";
                                  $res3 = mysqli_query($con,$qu2);
                                  $r3 = mysqli_fetch_array($res3);

                              ?>
                              <div class="imgcolumn">
                                  <img src=<?php echo $r3['show_url'];?> alt="Snow" style="width:70%;">
                                  <div class="bottom-left"><?php echo $r3['show_name'];?></div>
                              </div>
                          <?php
                            }
                          ?>
                              </div>
                    </div>
                  </div>
                  
            </div>
            
                     
          <!-- End Right  w3-column -->
          </div>
          
        <!-- End Grid -->
        </div>
        
      <!-- End Page Container -->
      </div>
      </div>
</body>
<?php
  include('footer.php');
  ?>