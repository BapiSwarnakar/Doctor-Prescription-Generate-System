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
if(isset($_POST['export']) && !empty($_POST['id']))
{
  $id =  $_POST['id'];
  //$id = str_replace(' ',',',$id);
  $sql = "SELECT `MT_Id`, `MT_Name`, `MT_Type`, `MT_Status`,DATE_FORMAT(MT_Date,'%d-%m-%Y %h:%i')MT_Date FROM `tbl_medicine_type` WHERE MT_Id IN($id)";

	if($row =$server->All_Record($sql))
    {
    	if($row>0)
    	{
    	  $data='';
    	  $data .='<table class="table" border="1">
         <tr>
            <th>Sl. No</th>
            <th>Nature Name</th>
            <th>Nature Type</th>  
            <th>Date</th>         
         </tr>
    	';
    	$count = 1;
    	foreach ($server->View_details as $value) {
    		$data.='
              <tr>
               <td>'.$count.'</td>
               <td>'.$value['MT_Name'].'</td>
               <td>'.$value['MT_Type'].'</td>
               <td>'.$value['MT_Date'].'</td>  
            </tr>';

    	 $count++;
    	}
     
	   $data .='</table>';
	   header('Content-type:application/vnd.ms-excel');
	   header('Content-Disposition:attachment;filename='.rand().'.xls');
	   echo $data;
    	}
    	else
    	{
    		echo "<script>alert('Record not found')</script>";
    	    header("location:display_medicine_type.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_medicine_type.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_medicine_type.php'</script>";
     // header("location:display_patient.php");
  }  

?>