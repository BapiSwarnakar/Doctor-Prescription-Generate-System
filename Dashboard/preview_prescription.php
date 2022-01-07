<?php
require_once("../db_connect/db_connect.php");
require_once("../class/class.php");
$server= new Main_Classes;
if($server->Check_Admin_Status())
{
  ?>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script type="text/javascript">
   $(document).ready(function(){
      swal("Error", "Not Access This Page !", "error");
   });
  </script>

  <?php
  exit();
}
$server->admin_session_private();
?>  
<html>
<head>
<style type="text/css">
html{
  overflow:auto;
}
@media print{
  @page{margin:0;}
  body{margin:0cm;}
}
</style>
</head>
<style type="text/css">
.body{
background-color: #000;
}
#newpage{
  width: 21cm;
 
  margin:0 auto;

  background: white;

}
#databoday{
  border: 0px #000 solid;
  width: 90%;
  height: 57%;
  margin: 0 auto;
}

#data1{
  width: 34%;
  height:97%;
  border-right:1px #000 dotted;
  float: left; 
  padding: 0px 15px 0px 0px;
}
#data2{
  width: 60%;
  height: 100%;
  border-right:0px #000 dotted;
  float: left;
}
#options {
  align-content:center;
  align-items:center;
    text-align: center;
}

li{
  background-image: url(); /*or link to a blank image*/
  background-repeat: no-repeat;
  background-position: left;
  padding-left: 12px;
  list-style-type: none;
}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 12px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button2 {background-color: #fff;} /* Blue */
.button3 {background-color: #fff;} /* Red */ 
.button4 {background-color: #e7e7e7; color: black;} /* Gray */ 
.button5 {background-color: #555555;} /* Black */
</style>

 <!-- ............ Attempt #3 ....................... -->

<script>
   function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        //Print the page content
        window.print()
        printButton.style.visibility = 'visible';
    }

</script>
    
</head>

<div id="options">


<a href="javascript:void(0)" onclick="window.history.go(-1); "><input class="button button3" id="" type="button" value="" "/></a>
<!-- <input style="width: 200px" class="button button2" id="printpagebutton" type="button" value="" onclick="printpage()"/> -->

</div>

<body style="background-color:#000;">



<div id="newpage">


<div style="width: 100%;height:12%;">



</div>
<div style="width:95.5%;height:2%; text-align:right; font-family:arial;font-weight:bold; font-size: 14px;">Date: 

<?php
date_default_timezone_set("Asia/Kolkata");
echo "" .date("d-m-Y"); 

?>



</div>
<div style="width: 100%;height: 0%; margin-top: 0%; margin-bottom: 0%; text-align: center; font-family:arial;font-weight:bold; font-size: 15px; ">

</div>




  <div id="databoday">
  
<div style="border-bottom: 1px dotted #000; background-color:#fff;  letter-spacing: 0.5px; height:22px; text-align: center; font-size: 14px; font-weight: bold;"><?php
  $id=$_GET['id'];
  $result = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight` FROM `tbl_patient_details` WHERE Patient_Id='$id'";
  if($server->All_Record($result))
  {
     foreach ($server->View_details as $row) {
         $explode = explode('-',$row['Patient_Age']);
         $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
       ?>
       <div class="deta">
        Name:&#160; <?php echo $row['Patient_Name']; ?>&#160;&#160;&#160;&#160;&#160; Age: <?php echo $age; ?> Height:&#160;<?php echo $row['Patient_Height']; ?>&#160;&#160;&#160;&#160;&#160; Weight: &#160;<?php echo $row['Patient_Weight']; ?>  KG
       </div>
       <?php
     }
  }
  
?>         
</div>

<div id="data1">

<div id='text1' style="font-family: arial;
  font-style: italic;text-decoration: underline;
  font-size: 11px;
  font-weight: bold; margin-top: 10px; margin-left: 5px;margin-bottom:5px ">Diagnosis</div>


 <div style=" font-weight: bold;font-size: 14px; font-family: arial; margin-left:10px;">
  

      <tr style="
  text-align: left;
  font-size: 11px;
  font-family: arial;
  font-weight: bold;
  color: black;" >
      <td>
        <?php 
          echo $server->All_Prescription_Diagnosis($id);
        ?>
      
      </td>
      </tr>
    <br><br>
     
  </div>
<div id='text1' style="font-family: arial;
  font-style: italic;text-decoration: underline;
  font-size: 11px;
  font-weight: bold; margin-top: 10px; margin-left: 5px;margin-bottom:5px ">Tests</div>


 <div style=" font-weight: bold;font-size: 14px; font-family: arial; margin-left:10px;">
 


      <tr style="
  text-align: left;
  font-size: 12px;
  font-family: arial;
  font-weight: bold;
  color: black;margin-left:5px;" >
      <td>
      <?php 
        echo $server->All_Prescription_Test($id);
      ?> 
      </td>
      
    </tr><br><br>
    
</div>


  
</div>





<div id="data2">
<div id='text1' style="font-family: arial;
  font-style: italic;text-decoration: underline;
  font-size: 11px;
  font-weight: bold; margin-top: 10px; margin-left: 5px;margin-bottom:5px ">Advice</div>



  <div style=" font-weight: bold;font-size: 14px; font-family: arial; margin-left:10px;">
     
      <tr class="record" style="margin-bottom:10px" >
      <td>
      
          <?php 
            echo $server->All_Prescription_Medicine($id);
          ?>
           <?php 
                echo $server->All_Prescription_Advice($id);
          ?>
      
    </td>
      
      </tr><br>

  </div>

<!--   <div style=" font-weight:bold; font-size: 13px; font-family: 'AponaLohit', Arial, sans-serif !important; margin-left: 10px;">
       
      <tr class="record">
      <td>  *</td>
      <td >
        <td>
    
          <?php 
                echo $server->All_Prescription_Advice($id);
          ?>
    
      
    </td>
        <br><br>
 </tr></div> -->





    </div>
   
</div>

 
  <div style="text-align: right; color: black; margin-top: 45px; margin-right: 30px; padding-bottom: 25px; font-style: italic; font-size: 14px; font-weight: bold;text-decoration: underline;">
 
  </div>

</body>