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
  $sql = "SELECT `Test_Id`, `Test_Name`, `Test_Code`, `Test_Status`,DATE_FORMAT(Test_Date,'%d-%m-%Y %h:%i')Test_Date FROM `tbl_test` WHERE Test_Id IN($id)";

	if($row =$server->All_Record($sql))
    {
    	if($row>0)
    	{
    	  $data='';
    	  $data .='<table class="table" border="1">
         <tr>
            <th>Sl. No</th>
            <th>Test Name</th>
            <th>Code</th> 
            <th>Date</th>                        
         </tr>
    	';
    	$count = 1;
    	foreach ($server->View_details as $value) {
    		$data.='
              <tr>
               <td>'.$count.'</td>
               <td>'.$value['Test_Name'].'</td>
               <td>'.$value['Test_Code'].'</td>
               <td>'.$value['Test_Date'].'</td>  
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
    	    header("location:display_test.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_test.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_test.php'</script>";
     // header("location:display_patient.php");
  }  

?>