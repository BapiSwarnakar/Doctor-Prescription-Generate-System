<?php
require_once("../db_connect/db_connect.php");
require_once("../class/class.php");
$server= new Main_Classes;
$server->admin_session_private();
if(isset($_POST['export']) && !empty($_POST['id']))
{
  $id =  $_POST['id'];
  //$id = str_replace(' ',',',$id);
  $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`,DATE_FORMAT(Patient_Date,'%d-%m-%Y %h:%i')Patient_Date FROM `tbl_patient_details` WHERE Patient_Id IN($id) AND Patient_Status!='1'";

	if($row =$server->All_Record($sql))
    {
    	if($row>0)
    	{
    	  $data='';
    	  $data .='<table class="table" border="1">
         <tr>
            <th>Sl. No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Mobile</th>
            <th>For Visit</th>
            <th>Date</th>           
         </tr>
    	';
    	$count = 1;
    	foreach ($server->View_details as $value) {
    		
    		$data.='
              <tr>
               <td>'.$count.'</td>
               <td>'.$value['Patient_Name'].'</td>
               <td>'.$value['Patient_Gender'].'</td>
               <td>'.$value['Patient_Address'].'</td>
               <td>'.$value['Patient_Contact'].'</td>
              
              ';
                if($value['Patient_Visit_Status']=="0")
                {
                   $data .= '<td><span class="badge bg-danger">Pending</span></td>';
                }
                else
                {
                  $data .= '<td><span class="badge bg-success">Success</span></td>';
                }


              $data .='
               <td>'.$value['Patient_Date'].'</td>
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
    	    header("location:display_patient.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_patient.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_patient.php'</script>";
     // header("location:display_patient.php");
  }  

?>