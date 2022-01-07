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
  $sql = "SELECT `M_Id`, `M_Name`, `M_Code`,tbl_medicine_type.MT_Type,tbl_dosage_type.Dosage_Name, `M_Menu`, `M_Status`,DATE_FORMAT(M_Date,'%d-%m-%Y %h:%i')M_Date FROM `tbl_medicine_master` INNER JOIN tbl_dosage_type ON tbl_medicine_master.Dosage_Id=tbl_dosage_type.Dosage_Id INNER JOIN tbl_medicine_type ON tbl_medicine_type.MT_Id=tbl_medicine_master.MT_Id WHERE M_Id IN($id)";

	if($row =$server->All_Record($sql))
    {
    	if($row>0)
    	{
    	  $data='';
    	  $data .='<table class="table" border="1">
         <tr>
            <th>Sl. No</th>
            <th>Code</th>
            <th>Medicine</th>
            <th>Type</th>
            <th>Menubar</th>
            <th>Direction</th>
            <th>Date</th>                
         </tr>
    	';
    	$count = 1;
    	foreach ($server->View_details as $value) {
    		
    		$data.='
              <tr>
               <td>'.$count.'</td>
               <td>'.$value['M_Code'].'</td>
               <td>'.$value['M_Name'].'</td>
               <td>'.$value['MT_Type'].'</td>
               <td>'.$value['M_Menu'].'</td>
               <td>'.$value['Dosage_Name'].'</td>
               <td>'.$value['M_Date'].'</td>
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
    	    header("location:display_medicine.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_medicine.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_medicine.php'</script>";
     // header("location:display_patient.php");
  }  

?>