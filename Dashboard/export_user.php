<?php
require_once("../../db_connect/db_connect.php");
require_once("../../class/class.php");
$server= new Main_Classes;
$server->admin_session_private();
if(isset($_POST['export']) && !empty($_POST['id']))
{
  $id =  $_POST['id'];
  //$id = str_replace(' ',',',$id);
  $sql = "SELECT `User_Id`, `User_Name`, `User_Gender`, `User_Dob`, `User_Email`, `User_Mobile`, `Agent_Id`, `User_Address`, `User_Flag`, `User_Password`, DATE_FORMAT(User_Date,'%d-%m-%Y %h:%i')User_Date FROM `tbl_user`WHERE User_Id IN($id)";

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
           <th>Dob</th>
           <th>Email</th>
           <th>Mobile No</th>
           <th>Agent</th>
           <th>Address</th>
           <th>Status</th>
           <th>Date</th>           
         </tr>
    	';
    	$count = 1;
    	foreach ($server->View_details as $value) {
    		
    		$data.='
              <tr>
               <td>'.$count.'</td>
               <td>'.$value['User_Name'].'</td>
               <td>'.$value['User_Gender'].'</td>
               <td>'.$value['User_Dob'].'</td>
               <td>'.$value['User_Email'].'</td>
               <td>'.$value['User_Mobile'].'</td>
               <td>'.$value['Agent_Id'].'</td>
               <td>'.$value['User_Address'].'</td>'; 
               if($value['User_Flag'] !=0)
               {
                 $data .= '<td><span class="badge bg-success">Success</span></td>';
               }
               else
               {
                 $data .= '<td><span class="badge bg-danger">Pending</span></td>';
               }

              $data.='<td>'.$value['User_Date'].'</td>
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
    	    header("location:display_user.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_user.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_user.php'</script>";
     // header("location:display_patient.php");
  }  

?>