<?php
require_once("../../db_connect/db_connect.php");
require_once("../../class/class.php");
$server= new Main_Classes;
$server->admin_session_private();
if(isset($_POST['export']) && !empty($_POST['id']))
{
  $id =  $_POST['id'];
  //$id = str_replace(' ',',',$id);
  $sql = "SELECT `Agent_Id`,`Agent_Name`, `Agent_Gender`, `Agent_Dob`, `Agent_Email`, `Agent_Contact`, `Agent_Aadhar`, `Agent_Address`,`Agent_Flag`, DATE_FORMAT(Agent_Date,'%d-%m-%Y %h:%i')Agent_Date FROM `tbl_agent` WHERE Agent_Id IN($id)";

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
           <th>Aadhar</th>
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
               <td>'.$value['Agent_Name'].'</td>
               <td>'.$value['Agent_Gender'].'</td>
               <td>'.$value['Agent_Dob'].'</td>
               <td>'.$value['Agent_Email'].'</td>
               <td>'.$value['Agent_Contact'].'</td>
               <td>'.$value['Agent_Aadhar'].'</td>
               <td>'.$value['Agent_Address'].'</td>';
               
               if($value['Agent_Flag'] !=0)
               {
                 $data .= '<td><span class="badge bg-success">Success</span></td>';
               }
               else
               {
                 $data .= '<td><span class="badge bg-danger">Pending</span></td>';
               }
              $data.='<td>'.$value['Agent_Date'].'</td>
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
    	    header("location:display_agent.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_agent.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_agent.php'</script>";
     // header("location:display_patient.php");
  }  

?>