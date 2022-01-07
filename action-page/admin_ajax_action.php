<?php
require_once("../sending_mail/PHPMailerAutoload.php");
require_once ("../sending_mail/class.phpmailer.php");
require_once("../assets/Excel_Bulk/Classes/PHPExcel.php");
require_once("../assets/Excel_Bulk/Classes/PHPExcel/IOFactory.php");
require_once("../db_connect/db_connect.php");
require_once("../class/class.php");
$server= new Main_Classes;

if(isset($_POST['action']))
{
  date_default_timezone_set("Asia/Kolkata");
  $current_date = date('d-M-Y h:i');
  ////////////////////////  ADMIN LOGIN Start ///////////////////////////////////
    if($_POST['page']=="Admin_form")
    {
        $username = $server->clean_data($_POST['Userame']);
        $password = $server->clean_data($_POST['Password']);

        $sql = "SELECT `Admin_Id`, `Admin_Username`, `Admin_Password`,`Admin_Check` FROM `tbl_admin` WHERE Admin_Username='$username'";
        if($server->All_Record($sql))
        {
            foreach ($server->View_details as $key => $value) {
                # code...
            }
            if($value['Admin_Username']!=$username)
            {
                $output = array(
                     'error' =>'Invalid Userame !'
                    );
            }
            else
            {
                if($value['Admin_Password']!=$password)
                {
                    $output = array(
                     'error' =>'Invalid Password !'
                    );
                }
                else
                {
                    $_SESSION['Admin_logged_in']= $value['Admin_Id'];
                    $_SESSION['Admin_Status']=$value['Admin_Check'];
                    $output = array(
                     'success' =>'Login Successfully'
                    );
                }
                
            }
            
        }
        else
        {
            $output = array(
             'error' =>'Invalid Userame or Password !'
            );
        }
        

     echo json_encode($output);
    }

///////////////////////////// Admin Login Exit


// Forget Password

    if($_POST['page']=="_Email_Forget_Password_Form")
    {
       $sql = "SELECT `Admin_Username`, `Admin_Password` FROM `tbl_admin` WHERE Admin_Username='$_POST[email]'";
       $output = array();
       if($server->All_Record($sql))
       {
          foreach ($server->View_details as $value) {
            # code...
          } 
        $email = $value['Admin_Username'];
        $subject = 'Reminded Password';
        $body ='Email : '.$value['Admin_Username'].'<br>Password : '.$value['Admin_Password'].'';
        if($server->Send_email($email,$subject,$body))
        {
          $output['success']='Please Checking You E-Mail';
        }
        else
        {
          $output['error']='Technical issue, Please try again..!';
        }
       }
       else
       {
         $output['error']='This E-Mail is Not Register..!';
       }

    echo json_encode($output);
  }
/////////////////////////  PATIENT MASTER /////////////
    // Add Patient
  if($_POST['page']=="Add_Patient")
  {
    $output = array();
    $sql = "SELECT `Patient_Id` FROM `tbl_patient_details` WHERE  `Patient_Contact`='$_POST[contact]'";
    if($server->All_Record($sql))
    {
      $output['error']='This Contact No Already Exist !';
    }
    else
    {
      if(empty($_POST['year']))
      {
          $year = '0';
      }
      else
      {
        $year = $_POST['year'];  
      }
      
      if(empty($_POST['month']))
      {
          $month = '0';
      }
      else
      {
        $month = $_POST['month'];  
      }
      if(empty($_POST['day']))
      {
          $day = '0';
      }
      else
      {
        $day = $_POST['day'];  
      }
      $age = $year.'-'.$month.'-'.$day;
       $sql ="INSERT INTO `tbl_patient_details`(`Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`) 
        VALUES (
        '$_POST[name]',
        '$age',
        '$_POST[gender]',
        '$_POST[height]',
        '$_POST[weight]',
        '$_POST[address]',
        '$_POST[contact]',
        '0',
        '0'
        )";
       if($server->Data_Upload($sql))
       {
         $output['success']='New Patient Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display Patient

  if($_POST['page']=="Display_Patient_All")
  {
     $date="";
      if($_POST['from_date'] !='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
      }
      if($_POST['from_date'] =='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date)<= '$_POST[to_date]'"; 
      }
      if($_POST['from_date'] !='' && $_POST['to_date'] =='')
      {
         $date .="AND DATE(Patient_Date) >= '$_POST[from_date]'"; 
      }
      if(is_numeric($_POST['search_val']) !='')
      {
        $date .="AND Patient_Contact LIKE '%$_POST[search_val]%'";
      }
      else
      {
        $date .="AND Patient_Name LIKE '%$_POST[search_val]%'";
      }

      if($_POST['status'] =='1')
      {
        $date .="AND Patient_Visit_Status='0'";
      }
      else if ($_POST['status'] =='2') {

        $date .="AND Patient_Visit_Status='1'";
      }
      else
      {
        $date.='';
      }
     $now = date('Y-m-d');
     $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`,DATE_FORMAT(Patient_Date,'%d-%m-%Y %h:%i')Patient_Date FROM `tbl_patient_details` WHERE  Patient_Id !='' AND Patient_Status !='1' AND DATE(Patient_Date)='$now' ".$date." ORDER BY Patient_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
          
           $explode = explode('-',$value['Patient_Age']);
           $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Patient_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Patient_Name'].'</td>
               <td>'.$age.'</td>
               <td>'.$value['Patient_Height'].'</td>
               <td>'.$value['Patient_Weight'].'</td>
              
              ';
              if($value['Patient_Visit_Status']=="0")
              {
                 $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['Patient_Visit_Status'].'" data-id="'.$value['Patient_Id'].'"><span class="badge bg-danger">Pending Tranfer</span></a></td>';
              }
              else
              {
                $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['Patient_Visit_Status'].'" data-id="'.$value['Patient_Id'].'"><span class="badge bg-success">Success Tranfer</span></a></td>';
              }


            $output .='
             <td>'.$value['Patient_Date'].'</td>
             <td><a href="view_patient.php?id='.$value['Patient_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
     else
     {
      echo "<tr><td class='text-danger text-center' colspan='9'> Patient Not Found </td></tr>";
     }
  }


  // Delete Patient 

  if($_POST['page']=="Delete_Patient_")
  {
    $output = array();
    $sql = "DELETE FROM `tbl_patient_details` WHERE Patient_Id IN($_POST[id])";
    if($server->Data_Upload($sql))
    {
       $output['success']='Patient Delete Successfully';
    }
    else
    {
      $output['error']='Technical issue, Please try again..!';
    }

  echo json_encode($output);
  }

  // Update Patient

  if($_POST['page']=="Edit_Patient")
  {
    $output = array();
    $sql = "SELECT * FROM `tbl_patient_details` WHERE Patient_Contact='$_POST[contact]' AND Patient_Id !='$_POST[id]'";
    if($server->All_Record($sql))
    {
      $output['error']='This Contact No Already Exist !';
    }
    else
    {
      if(empty($_POST['year']))
      {
          $year = '0';
      }
      else
      {
        $year = $_POST['year'];  
      }
      
      if(empty($_POST['month']))
      {
          $month = '0';
      }
      else
      {
        $month = $_POST['month'];  
      }
      if(empty($_POST['day']))
      {
          $day = '0';
      }
      else
      {
        $day = $_POST['day'];  
      }
      $age = $year.'-'.$month.'-'.$day;
       $sql ="UPDATE `tbl_patient_details` SET 
       `Patient_Name`='$_POST[name]',
       `Patient_Age`='$age',
       `Patient_Gender`='$_POST[gender]',
       `Patient_Height`='$_POST[height]',
       `Patient_Weight`='$_POST[weight]',
       `Patient_Address`='$_POST[address]',
       `Patient_Contact`='$_POST[contact]' 
        WHERE `Patient_Id`='$_POST[id]'";

       if($server->Data_Upload($sql))
       {
         $output['success']='Patient Details Update Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }


  if($_POST['page']=="Patient_Visited_Status_")
  {
    $status ='';
    if($_POST['value']=='0')
    {
      $status .='1';
    }
    else
    {
      $status .='0';
    }

    $sql = "UPDATE `tbl_patient_details` SET `Patient_Visit_Status`='$status' WHERE `Patient_Id`='$_POST[id]'";
    $output = array();
    if($server->Data_Upload($sql))
    {
      $output['success']= " Patient Visited Activate Update Successfully";
    }
    else
    {
      $output['error']= "Technical issue. Please try again..!";
    }
  echo json_encode($output);
  }



  // Display PENDING Patient LIST

  if($_POST['page']=="Display_Pending_Patient_All")
  {
     $date="";
      if($_POST['from_date'] !='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
      }
      if($_POST['from_date'] =='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date)<= '$_POST[to_date]'"; 
      }
      if($_POST['from_date'] !='' && $_POST['to_date'] =='')
      {
         $date .="AND DATE(Patient_Date) >= '$_POST[from_date]'"; 
      }
      if(is_numeric($_POST['search_val']) !='')
      {
        $date .="AND Patient_Contact LIKE '%$_POST[search_val]%'";
      }
      else
      {
        $date .="AND Patient_Name LIKE '%$_POST[search_val]%'";
      }

      if($_POST['status'] =='1')
      {
        $date .="AND Patient_Visit_Status='0'";
      }
      else if ($_POST['status'] =='2') {

        $date .="AND Patient_Visit_Status='1'";
      }
      else
      {
        $date.='';
      }
     $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`,DATE_FORMAT(Patient_Date,'%d-%m-%Y %h:%i')Patient_Date FROM `tbl_patient_details` WHERE  Patient_Id !='' AND Patient_Status !='1' ".$date." ORDER BY Patient_Id DESC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {

           $explode = explode('-',$value['Patient_Age']);

           $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Patient_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Patient_Name'].'</td>
               <td>'.$age.'</td>
               <td>'.$value['Patient_Height'].'</td>
               <td>'.$value['Patient_Weight'].'</td>
              
              ';
              if($value['Patient_Visit_Status']=="0")
              {
                 $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['Patient_Visit_Status'].'" data-id="'.$value['Patient_Id'].'"><span class="badge bg-danger">Pending</span></a></td>';
              }
              else
              {
                $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['Patient_Visit_Status'].'" data-id="'.$value['Patient_Id'].'"><span class="badge bg-success">Success</span></a></td>';
              }


            $output .='
             <td>'.$value['Patient_Date'].'</td>
             <td><a href="view_patient.php?id='.$value['Patient_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
     else
     {
      echo "<tr><td class='text-danger text-center' colspan='9'> Patient Not Found </td></tr>";
     }
  }


  /////////////////////////// Exit Brand ///////////////////////////



  /////////////////////////  MEDICINE MASTER /////////////
    // Add MEDICINE
  if($_POST['page']=="Add_Medicine")
  {
    $output = array();
    $sql = "SELECT `M_Id` FROM `tbl_medicine_master` WHERE `M_Code`='$_POST[code]'";
    if($server->All_Record($sql))
    {
      $output['error']='This Medicine Code Already Exist !';
    }
    else
    {
             
      $sql ="INSERT INTO `tbl_medicine_master`(`M_Name`, `M_Code`, `MT_Id`, `Dosage_Id`, `M_Menu`, `M_Status`)
       VALUES (
        '$_POST[name]',
        '$_POST[code]',
        '$_POST[nature]',
        '$_POST[direction]',
        '$_POST[menu]',
        '1'
      )";
      if($server->Data_Upload($sql))
      {
       $output['success']='New Medicine Added Successfully';
       }
      else
       {
        $output['error']='Technical issue. Please try again..!';
       }
        
    }
    
    echo json_encode($output);
  }
// Display MEDICINE

  if($_POST['page']=="Display_Medicine_All")
  {
     $sql = "SELECT `M_Id`, `M_Name`, `M_Code`,tbl_medicine_type.MT_Type,tbl_dosage_type.Dosage_Name, `M_Menu`, `M_Status`,DATE_FORMAT(M_Date,'%d-%m-%Y %h:%i')M_Date FROM `tbl_medicine_master` INNER JOIN tbl_dosage_type ON tbl_medicine_master.Dosage_Id=tbl_dosage_type.Dosage_Id INNER JOIN tbl_medicine_type ON tbl_medicine_type.MT_Id=tbl_medicine_master.MT_Id ORDER BY M_Code ASC";

     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['M_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['M_Code'].'</td>
               <td>'.$value['M_Name'].'</td>
               <td>'.$value['MT_Type'].'</td>
               <td>'.$value['M_Menu'].'</td>
               <td>'.$value['Dosage_Name'].'</td>
               <td>'.$value['M_Date'].'</td>
               <td><a href="view_medicine.php?id='.$value['M_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>         
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete MEDICINE 

  if($_POST['page']=="Delete_Medicine_")
  {
    $output = array();
    $select = "SELECT `MG_Id`,`MG_Date` FROM `tbl_medicine_for_generate_prescription` WHERE `M_Id` IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Prescription generated..!';
      }
      else
      {
        $sql = "DELETE FROM `tbl_medicine_master` WHERE  M_Id IN($_POST[id])"; 
        if($server->Data_Upload($sql))
        {
         $output['success']='Medicine Delete Successfully';
        }
        else
        {
          $output['error']='Technical issue, Please try again..!';
        }
      }
    
        
  echo json_encode($output);
  }

  // Update MEDICINE

  if($_POST['page']=="Edit_Medicine")
  {
    $output = array();
    $sql = "SELECT `M_Id` FROM `tbl_medicine_master` WHERE `M_Code`='$_POST[code]' AND M_Id !='$_POST[id]'";
    if($server->All_Record($sql))
    {
      $output['error']='This Medicine Code Already Exist !';
    }
    else
    {
             
      $sql ="UPDATE `tbl_medicine_master` SET `M_Name`='$_POST[name]',`M_Code`='$_POST[code]',`MT_Id`='$_POST[nature]',`Dosage_Id`='$_POST[direction]',`M_Menu`='$_POST[menu]' WHERE `M_Id`='$_POST[id]'";
      if($server->Data_Upload($sql))
      {
       $output['success']='Update Medicine Successfully';
       }
      else
       {
        $output['error']='Technical issue. Please try again..!';
       }
        
    }
    
    echo json_encode($output);
  }


  // /////////////////////// EXIT CATEGORY ////////////////////

  /////////////////////////  DIGIS MASTER /////////////
    // Add DIGIS
  if($_POST['page']=="Add_Digis")
  {
    $output = array();
    $sql = "SELECT `Digis_Id` FROM `tbl_digis` WHERE Digis_Code='$_POST[code]'";
    if($server->All_Record($sql))
    {
      $output['error']='This Digis Code Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_digis`(`Digis_Name`, `Digis_Code`, `Digis_Menu`, `Digis_Status`) VALUES ('$_POST[name]','$_POST[code]','$_POST[menu]','1')";
       if($server->Data_Upload($sql))
       {
         $output['success']='New Digis Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display DIGIS

  if($_POST['page']=="Display_Digis_All")
  {
     $sql = "SELECT `Digis_Id`, `Digis_Name`, `Digis_Code`, `Digis_Menu`, `Digis_Status`,DATE_FORMAT(Digis_Date,'%d-%m-%Y %h:%i')Digis_Date FROM `tbl_digis` ORDER BY Digis_Code ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Digis_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Digis_Name'].'</td>
               <td>'.$value['Digis_Code'].'</td>
               <td>'.$value['Digis_Menu'].'</td>
               <td>'.$value['Digis_Date'].'</td>
               <td><a href="view_digis.php?id='.$value['Digis_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete DIGIS 

  if($_POST['page']=="Delete_Digis_")
  {
    $output = array();
    $select = "SELECT `DG_Id`, `User_Id` FROM `tbl_digis_for_generate_prescription` WHERE `Digis_Id` IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Prescription generated..!';
      }
      else
      {
        $sql = "DELETE FROM `tbl_digis` WHERE Digis_Id IN($_POST[id])";
        if($server->Data_Upload($sql))
        {
           $output['success']='Digis Delete Successfully';
        }
        else
        {
          $output['error']='Technical issue, Please try again..!';
        }
      }
    

  echo json_encode($output);
  }

  // Update DIGIS

  if($_POST['page']=="Edit_Digis")
  {
    $output = array();
    $sql = "SELECT `Digis_Id` FROM `tbl_digis` WHERE Digis_Code='$_POST[code]' AND Digis_Id !='$_POST[id]'";
    if($server->All_Record($sql))
    {
      $output['error']='This Digis Code Already Exist !';
    }
    else
    {
       $sql ="UPDATE `tbl_digis` SET `Digis_Name`='$_POST[name]',`Digis_Code`='$_POST[code]',`Digis_Menu`='$_POST[menu]' WHERE `Digis_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
         $output['success']='Digis Update Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }

  /////////////////////////// Exit UNIT ///////////////////////////

  /////////////////////////  USER/RETAILER MASTER /////////////
    // Add USER
  if($_POST['page']=="Add_User")
  {
    $output = array();
    $sql = "SELECT `User_Id` FROM `tbl_user` WHERE User_Mobile='$_POST[mobile]' AND User_Email='$_POST[email]'";
    if($server->All_Record($sql))
    {
      $output['error']='This User Mobile/Email Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_user`(`User_Name`, `User_Gender`, `User_Dob`, `User_Email`, `User_Mobile`, `Agent_Id`,`User_Address`, `User_Flag`, `User_Password`) VALUES ('$_POST[name]','$_POST[gender]','$_POST[dob]','$_POST[email]','$_POST[mobile]','$_POST[agent]','$_POST[address]','0','$_POST[password]')";
       if($server->Data_Upload($sql))
       {
         $output['success']='New User Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display USER/RETAILER

  if($_POST['page']=="Display_User_All")
  {
     $sql = "SELECT `User_Id`, `User_Name`, `User_Gender`, `User_Dob`, `User_Email`, `User_Mobile`,tbl_agent.Agent_Name,tbl_agent.Agent_Id ,`User_Address`, `User_Flag`, `User_Password`, DATE_FORMAT(User_Date,'%d-%m-%Y %h:%i')User_Date FROM `tbl_user` INNER JOIN tbl_agent ON tbl_user.Agent_Id=tbl_agent.Agent_Id ORDER BY User_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['User_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['User_Name'].'</td>
               <td>'.$value['User_Gender'].'</td>
               <td>'.$value['User_Dob'].'</td>
               <td>'.$value['User_Email'].'</td>
               <td>'.$value['User_Mobile'].'</td>
               <td>'.$value['Agent_Name'].'</td>
               <td>'.$value['User_Address'].'</td>';
               
               if($value['User_Flag'] !=0)
               {
                 $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['User_Flag'].'" data-id="'.$value['User_Id'].'"><span class="badge bg-success">Success</span></a></td>';
               }
               else
               {
                 $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['User_Flag'].'" data-id="'.$value['User_Id'].'"><span class="badge bg-danger">Pending</span></a></td>';
               }
              $output.='<td>'.$value['User_Date'].'</td>
               <td><a href="view_user.php?id='.$value['User_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }

  // Update Status User

  if($_POST['page']=="Update_User_Status")
  {
    if($_POST['value'] !='0')
    {
      $status = '0';
    }
    else
    {
      $status = '1';
    }

    $sql = "UPDATE `tbl_user` SET `User_Flag`='$status' WHERE `User_Id`='$_POST[id]'";
    if($server->Data_Upload($sql))
    {
      $output = array(
        'success'=>'Status Update Successfully'
      );
    }
    else
    {
      $output = array(
        'error'=>'Technical issue, Please try again..!'
      );
    }
  echo json_encode($output);
  }


  // Delete USER 

  if($_POST['page']=="Delete_User_")
  {
    $output = array();
    $sql = "DELETE FROM `tbl_user` WHERE User_Id IN($_POST[id])";
    if($server->Data_Upload($sql))
    {
       $output['success']='User Delete Successfully';
    }
    else
    {
      $output['error']='Technical issue, Please try again..!';
    }

   echo json_encode($output);
  }

  // Update USER

  if($_POST['page']=="Edit_User")
  {
    $output = array();
    
       $sql ="UPDATE `tbl_user` SET `User_Name`='$_POST[name]',`User_Gender`='$_POST[gender]',`User_Dob`='$_POST[dob]',`User_Address`='$_POST[address]' WHERE `User_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
         $output['success']='Unit Update Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit USER ///////////////////////////

   /////////////////////////  AGENT MASTER /////////////
    // Add AGENT
  if($_POST['page']=="Add_Agent")
  {
    $output = array();
    $sql = "SELECT `Agent_Id` FROM `tbl_agent` WHERE Agent_Contact='$_POST[mobile]' AND Agent_Email='$_POST[email]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Agent Mobile/Email Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_agent`(`Agent_Name`, `Agent_Gender`, `Agent_Dob`, `Agent_Email`, `Agent_Contact`, `Agent_Aadhar`, `Agent_Address`, `Agent_Password`, `Agent_Flag`) VALUES ('$_POST[name]','$_POST[gender]','$_POST[dob]','$_POST[email]','$_POST[mobile]','$_POST[aadhar]','$_POST[address]','$_POST[password]','0')";
       if($server->Data_Upload($sql))
       {
         $output['success']='New Agent Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display AGENT

  if($_POST['page']=="Display_Agent_All")
  {
     $sql = "SELECT `Agent_Id`,`Agent_Name`, `Agent_Gender`, `Agent_Dob`, `Agent_Email`, `Agent_Contact`, `Agent_Aadhar`, `Agent_Address`,`Agent_Flag`, DATE_FORMAT(Agent_Date,'%d-%m-%Y %h:%i')Agent_Date FROM `tbl_agent`ORDER BY Agent_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Agent_Id'].'"></td>
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

                 $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['Agent_Flag'].'" data-id="'.$value['Agent_Id'].'"><span class="badge bg-success">Success</span></a></td>';
               }
               else
               {
                 $output .= '<td><a href="javascript:void(0)" class="Update_Status" data-value="'.$value['Agent_Flag'].'" data-id="'.$value['Agent_Id'].'"><span class="badge bg-danger">Pending</span></a></td>';
               }
              $output.='<td>'.$value['Agent_Date'].'</td>
               <td><a href="view_agent.php?id='.$value['Agent_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Update Status Agent

  if($_POST['page']=="Update_Agent_Status")
  {
    if($_POST['value'] !='0')
    {
      $status = '0';
    }
    else
    {
      $status = '1';
    }

    $sql = "UPDATE `tbl_agent` SET`Agent_Flag`='$status' WHERE `Agent_Id`='$_POST[id]'";
    if($server->Data_Upload($sql))
    {
      $output = array(
        'success'=>'Status Update Successfully'
      );
    }
    else
    {
      $output = array(
        'error'=>'Technical issue, Please try again..!'
      );
    }
  echo json_encode($output);
  }


  // Delete AGENT 

  if($_POST['page']=="Delete_Agent_")
  {
    $output = array();

    $sql = "SELECT  `Agent_Id` FROM `tbl_user` WHERE Agent_Id='$_POST[id]'";
    if($server->All_Record($sql))
    {
      $output['error']='Delete Permission Denied ! Retailer Added Under Agent !..';
    }
    else
    {
      $sql = "DELETE FROM `tbl_agent` WHERE Agent_Id IN($_POST[id])";
      if($server->Data_Upload($sql))
      {
         $output['success']='Agent Delete Successfully';
      }
      else
      {
        $output['error']='Technical issue, Please try again..!';
      }
    }
    
   echo json_encode($output);
  }

  // Update AGENT

  if($_POST['page']=="Edit_Agent")
  {
    $output = array();
    
       $sql ="UPDATE `tbl_agent` SET `Agent_Name`='$_POST[name]',`Agent_Gender`='$_POST[gender]',`Agent_Dob`='$_POST[dob]',`Agent_Email`='$_POST[email]',`Agent_Contact`='$_POST[mobile]',`Agent_Aadhar`='$_POST[aadhar]' WHERE `Agent_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
         $output['success']='Agent Update Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit AGENT ///////////////////////////

    /////////////////////////  MEDICINE TYPE MASTER /////////////
    // Add MEDICINE TYPE
  if($_POST['page']=="Add_Medicine_Type")
  {
    $output = array();
    $sql = "SELECT `MT_Id`, `MT_Name`, `MT_Type`, `MT_Status`, `MT_Date` FROM `tbl_medicine_type` WHERE MT_Name='$_POST[name]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Nature Name Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_medicine_type`(`MT_Name`, `MT_Type`, `MT_Status`) VALUES ('$_POST[name]','$_POST[type]','1')";
       if($server->Data_Upload($sql))
       {
        $output['success']='New Nature Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display _Medicine_Type_

  if($_POST['page']=="Display_Madicine_Type_All")
  {
     $sql = "SELECT `MT_Id`, `MT_Name`, `MT_Type`, `MT_Status`,DATE_FORMAT(MT_Date,'%d-%m-%Y %h:%i')MT_Date FROM `tbl_medicine_type` ORDER BY MT_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['MT_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['MT_Name'].'</td>
               <td>'.$value['MT_Type'].'</td>
               <td>'.$value['MT_Date'].'</td> 
               ';
               // if($value['P_Flag'] !=0)
               // {
               //   $output .= '<td><span class="badge bg-success">Success</span></td>';
               // }
               // else
               // {
               //   $output .= '<td><a href="javascript:void(0)"><span class="badge bg-danger">Pending</span></a></td>';
               // }
              $output.='
               <td><a href="view_medicine_type.php?id='.$value['MT_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete Delete_Medicine_Type_ 

  if($_POST['page']=="Delete_Medicine_Type_")
  {
    $output = array();
      $select = "SELECT `M_Id`, `Dosage_Id`, `M_Menu`, `M_Status`, `M_Date` FROM `tbl_medicine_master` WHERE `MT_Id` IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Medicine..!';
      }
      else
      {
        $sql = "DELETE FROM `tbl_medicine_type` WHERE MT_Id IN($_POST[id])";
        if($server->Data_Upload($sql))
        {
          $output['success']='Nature Delete Successfully';
        }
        else
        {
          $output['error']='Technical issue, Please try again..!';
        }   
      }
      
   echo json_encode($output);
  }

  // Update _Medicine_Type_

  if($_POST['page']=="Edit_Medicine_Type")
  {
    $output = array();
    $sql = "SELECT `MT_Id`, `MT_Name`, `MT_Type` FROM `tbl_medicine_type` WHERE MT_Name='$_POST[name]' AND MT_Id !='$_POST[id]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Nature Name Already Exist !';
    }
    else
    {
       $sql ="UPDATE `tbl_medicine_type` SET `MT_Name`='$_POST[name]',`MT_Type`='$_POST[type]' WHERE `MT_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
        $output['success']='Update Nature Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit MEDICINE TYPE ///////////////////////////



   /////////////////////////  DOSAGE MASTER /////////////
    // Add DOSAGE
  if($_POST['page']=="Add_Dosage")
  {
    $output = array();
    $sql = "SELECT `Dosage_Id`,`Dosage_Name` FROM `tbl_dosage_type` WHERE Dosage_Name='$_POST[name]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Dosage Name Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_dosage_type`(`Dosage_Name`, `Dosage_Status`) VALUES ('$_POST[name]','1')";
       if($server->Data_Upload($sql))
       {
        $output['success']='New Dosage Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display DOSAGE

  if($_POST['page']=="Display_Dosage_All")
  {
     $sql = "SELECT `Dosage_Id`, `Dosage_Name`, `Dosage_Status`,DATE_FORMAT(Dosage_Date,'%d-%m-%Y %h:%i')Dosage_Date FROM `tbl_dosage_type`ORDER BY Dosage_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Dosage_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Dosage_Name'].'</td>
               <td>'.$value['Dosage_Date'].'</td>
               ';
               // if($value['P_Flag'] !=0)
               // {
               //   $output .= '<td><span class="badge bg-success">Success</span></td>';
               // }
               // else
               // {
               //   $output .= '<td><a href="javascript:void(0)"><span class="badge bg-danger">Pending</span></a></td>';
               // }
              $output.='
               <td><a href="view_dosage.php?id='.$value['Dosage_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete DOSAGE 

  if($_POST['page']=="Delete_Dosage_")
  {
    $output = array();
      $select = "SELECT `M_Id`, `Dosage_Id`, `M_Menu`, `M_Status`, `M_Date` FROM `tbl_medicine_master` WHERE `Dosage_Id` IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Medicine..!';
      }
      else
      {
          $sql = "DELETE FROM `tbl_dosage_type` WHERE Dosage_Id IN($_POST[id])";
          if($server->Data_Upload($sql))
          {
            $output['success']='Dosage Delete Successfully';
          }
          else
          {
            $output['error']='Technical issue, Please try again..!';
          }
      }
         
   echo json_encode($output);
  }

  // Update DOSAGE

  if($_POST['page']=="Edit_Dosage")
  {
    $output = array();
    $sql = "SELECT `Dosage_Id`,`Dosage_Name` FROM `tbl_dosage_type` WHERE Dosage_Name='$_POST[name]' AND Dosage_Id !='$_POST[id]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Dosage Name Already Exist !';
    }
    else
    {
       $sql ="UPDATE `tbl_dosage_type` SET `Dosage_Name`='$_POST[name]' WHERE `Dosage_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
        $output['success']='Update Dosage Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit DOSAGE ///////////////////////////

    /////////////////////////  TEST TYPE MASTER /////////////
    // Add TEST
  if($_POST['page']=="Add_Test")
  {
    $output = array();
    $sql = "SELECT `Test_Id` FROM `tbl_test` WHERE Test_Code='$_POST[code]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Test Code Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_test`(`Test_Name`, `Test_Code`, `Test_Status`) VALUES ('$_POST[name]','$_POST[code]','1')";
       if($server->Data_Upload($sql))
       {
        $output['success']='New Test Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display TEST

  if($_POST['page']=="Display_Test_All")
  {
     $sql = "SELECT `Test_Id`, `Test_Name`, `Test_Code`, `Test_Status`,DATE_FORMAT(Test_Date,'%d-%m-%Y %h:%i')Test_Date FROM `tbl_test` ORDER BY Test_Code Asc";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Test_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Test_Name'].'</td>
               <td>'.$value['Test_Code'].'</td>
               <td>'.$value['Test_Date'].'</td> 
               ';
               // if($value['P_Flag'] !=0)
               // {
               //   $output .= '<td><span class="badge bg-success">Success</span></td>';
               // }
               // else
               // {
               //   $output .= '<td><a href="javascript:void(0)"><span class="badge bg-danger">Pending</span></a></td>';
               // }
              $output.='
               <td><a href="view_test.php?id='.$value['Test_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete TEST 

  if($_POST['page']=="Delete_Test_")
  {
    $output = array();
     $select = "SELECT `TG_Id`, `User_Id` FROM `tbl_test_for_generate_prescription` WHERE `Test_Id` IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Prescription generated..!';
      }
      else
      {
        $sql = "DELETE FROM `tbl_test` WHERE Test_Id IN($_POST[id])";
        if($server->Data_Upload($sql))
        {
          $output['success']='Test Delete Successfully';
        }
        else
        {
          $output['error']='Technical issue, Please try again..!';
        } 
      }
        
   echo json_encode($output);
  }

  // Update TEST

  if($_POST['page']=="Edit_Test")
  {
    $output = array();
    $sql = "SELECT `Test_Id` FROM `tbl_test` WHERE Test_Code='$_POST[code]' AND Test_Id !='$_POST[id]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Test Code Already Exist !';
    }
    else
    {
       $sql ="UPDATE `tbl_test` SET `Test_Name`='$_POST[name]',`Test_Code`='$_POST[code]' WHERE `Test_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
        $output['success']='Update Test Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit TEST ///////////////////////////



/////////////////////////  ADVICE MASTER /////////////
    // Add ADVICE
  if($_POST['page']=="Add_Advice")
  {
    $output = array();
    $sql = "SELECT `Advice_Id` FROM `tbl_advice` WHERE Advice_Code='$_POST[code]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Advice Code Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_advice`(`Advice_Details`, `Advice_Code`, `Advice_Status`) VALUES ('$_POST[name]','$_POST[code]','1')";
       if($server->Data_Upload($sql))
       {
        $output['success']='New Advice Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display ADVICE

  if($_POST['page']=="Display_Advice_All")
  {
     $sql = "SELECT `Advice_Id`, `Advice_Details`, `Advice_Code`, `Advice_Status`,DATE_FORMAT(Advice_Date,'%d-%m-%Y %h:%i')Advice_Date FROM `tbl_advice`  ORDER BY Advice_Code ASC";

     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Advice_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Advice_Code'].'</td>
               <td>'.$value['Advice_Details'].'</td>
               <td>'.$value['Advice_Date'].'</td> 
               ';
               // if($value['P_Flag'] !=0)
               // {
               //   $output .= '<td><span class="badge bg-success">Success</span></td>';
               // }
               // else
               // {
               //   $output .= '<td><a href="javascript:void(0)"><span class="badge bg-danger">Pending</span></a></td>';
               // }
              $output.='
               <td><a href="view_advice.php?id='.$value['Advice_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete ADVICE 

  if($_POST['page']=="Delete_Advice_")
  {
     $output = array();
     $select = "SELECT `AG_Id`, `User_Id` FROM `tbl_advice_for_generate_prescription` WHERE `Advice_Id` IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Prescription generated..!';
      }
      else
      {
        $sql = "DELETE FROM `tbl_advice` WHERE Advice_Id IN($_POST[id])";
        if($server->Data_Upload($sql))
        {
          $output['success']='Advice Delete Successfully';
        }
        else
        {
          $output['error']='Technical issue, Please try again..!';
        } 
      }
        
   echo json_encode($output);
  }

  // Update ADVICE

  if($_POST['page']=="Edit_Advice")
  {
    $output = array();
    $sql = "SELECT `Advice_Id` FROM `tbl_advice` WHERE Advice_Code='$_POST[code]' AND Advice_Id !='$_POST[id]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Advice Code Already Exist !';
    }
    else
    {
       $sql ="UPDATE `tbl_advice` SET `Advice_Details`='$_POST[name]',`Advice_Code`='$_POST[code]' WHERE `Advice_Id`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
        $output['success']='Update Advice Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit ADVICE ///////////////////////////

     /////////////////////////  ADVICE  MEDICINE MASTER /////////////
    // Add Advice Master
  if($_POST['page']=="Add_Advice_Medicine")
  {
    $output = array();
    $sql = "SELECT `AM_ID` FROM `tbl_advice_medicine` WHERE AM_Name='$_POST[name]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Advice Medicine Name Already Exist !';
    }
    else
    {
       $sql ="INSERT INTO `tbl_advice_medicine`(`AM_Name`, `AM_Status`) VALUES ('$_POST[name]','1')";
       if($server->Data_Upload($sql))
       {
        $output['success']='New Advice Medicine Added Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
    
    echo json_encode($output);
  }
// Display ADVICE MEDICINE MASTER

  if($_POST['page']=="Display_Advice_Medicine_All")
  {
     $sql ="SELECT `AM_ID`, `AM_Name`, `AM_Status`, DATE_FORMAT(AM_Date,'%d-%m-%Y %h:%i')AM_Date FROM `tbl_advice_medicine` ORDER BY AM_ID ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['AM_ID'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['AM_Name'].'</td>
               <td>'.$value['AM_Date'].'</td>
               ';
               // if($value['P_Flag'] !=0)
               // {
               //   $output .= '<td><span class="badge bg-success">Success</span></td>';
               // }
               // else
               // {
               //   $output .= '<td><a href="javascript:void(0)"><span class="badge bg-danger">Pending</span></a></td>';
               // }
              $output.='
               <td><a href="view_advice_medicine.php?id='.$value['AM_ID'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // Delete ADVICE MEDICINE MASTER 

  if($_POST['page']=="Delete_Advice_Medicine_")
  {
    $output = array();
      $select = "SELECT `AG_Id` FROM `tbl_advice_for_generate_prescription` WHERE AM_ID IN($_POST[id])";
      if($server->All_Record($select))
      {
         $output['error']='Delete Permission Denied,This is added on Prescription Generated..!';
      }
      else
      {
          $sql = "DELETE FROM `tbl_advice_medicine` WHERE AM_ID IN($_POST[id])";
          if($server->Data_Upload($sql))
          {
            $output['success']='Advice Medicine Delete Successfully';
          }
          else
          {
            $output['error']='Technical issue, Please try again..!';
          }
      }
         
   echo json_encode($output);
  }

  // Update ADVICE MEDICINE MASTER

  if($_POST['page']=="Edit_Advice_Medicine")
  {
    $output = array();
    $sql = "SELECT `AM_ID` FROM `tbl_advice_medicine` WHERE AM_Name='$_POST[name]' AND AM_ID !='$_POST[id]'";

    if($server->All_Record($sql))
    {
      $output['error']='This Advice Medicine Name Already Exist !';
    }
    else
    {
       $sql ="UPDATE `tbl_advice_medicine` SET `AM_Name`='$_POST[name]' WHERE `AM_ID`='$_POST[id]'";
       if($server->Data_Upload($sql))
       {
        $output['success']='Update Advice Medicine Successfully';
       }
       else
       {
        $output['error']='Technical issue. Please try again..!';
       }
    }
   
    
    echo json_encode($output);
  }

  /////////////////////////// Exit ADVICE MEDICINE MASTER ///////////////////////////

// /////////////////////// PATIENT VISITED MASTER  ////////////////

  // Display VISITED PATEINT

  if($_POST['page']=="Display_Patient_Visited_All")
  {
     $date="";
      if($_POST['from_date'] !='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
      }
      if($_POST['from_date'] =='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date)<= '$_POST[to_date]'"; 
      }
      if($_POST['from_date'] !='' && $_POST['to_date'] =='')
      {
         $date .="AND DATE(Patient_Date) >= '$_POST[from_date]'"; 
      }
      if(is_numeric($_POST['search_val']) !='')
      {
        $date .="AND Patient_Contact LIKE '%$_POST[search_val]%'";
      }
      else
      {
        $date .="AND Patient_Name LIKE '%$_POST[search_val]%'";
      }

    if(isset($_POST['status']))
    {
     if($_POST['status'] =='1')
      {
        $date .="AND Patient_Status !='0'";
      }
      else if ($_POST['status'] =='2') {

        $date .="AND Patient_Status !='1'";
      }
      else
      {
        $date.='';
      }
    }
      
     $today = date('Y-m-d');
     $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`,DATE_FORMAT(Patient_Date,'%d-%m-%Y %h:%i')Patient_Date FROM `tbl_patient_details` WHERE  Patient_Id !='' AND Patient_Visit_Status !='0' AND DATE(Patient_Date)= '$today' ".$date." ORDER BY Patient_Id DESC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {

           $explode = explode('-',$value['Patient_Age']);
           $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Patient_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Patient_Name'].'</td>
               <td>'.$age.'</td> 
              <td>'.$value['Patient_Height'].'</td>
               <td>'.$value['Patient_Weight'].'</td>
              
              ';
              // if($value['Patient_Visit_Status']=="0")
              // {
              //    $output .= '<td><span class="badge bg-danger">Pending</span></td>';
              // }
              // else
              // {
              //   $output .= '<td><span class="badge bg-success">Success</span></td>';
              // }

              // if($value['Patient_Status']=="0")
              // {
              //    $output .= '<td><span class="badge bg-danger">Pending</span></td>';
              // }
              // else
              // {
              //   $output .= '<td><span class="badge bg-success">Success</span></td>';
              // }


            $output .='
             <td>'.$value['Patient_Date'].'</td>
             <td><a href="patient_checking.php?id='.$value['Patient_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-check-double"></i>&nbsp;Checking</a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
     else
     {
      echo "<tr><td class='text-danger text-center' colspan='10'> Patient Not Found </td></tr>";
     }
  }



// /////////////////////// PATIENT VISITED MASTER  ////////////////


  // WAITING LIST PATEINT

  if($_POST['page']=="Display_Patient_waiting_All")
  {
     $date="";
      if($_POST['from_date'] !='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
      }
      if($_POST['from_date'] =='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date)<= '$_POST[to_date]'"; 
      }
      if($_POST['from_date'] !='' && $_POST['to_date'] =='')
      {
         $date .="AND DATE(Patient_Date) >= '$_POST[from_date]'"; 
      }
      if(is_numeric($_POST['search_val']) !='')
      {
        $date .="AND Patient_Contact LIKE '%$_POST[search_val]%'";
      }
      else
      {
        $date .="AND Patient_Name LIKE '%$_POST[search_val]%'";
      }

      if($_POST['status'] =='1')
      {
        $date .="AND Patient_Status='0'";
      }
      else if ($_POST['status'] =='2') {

        $date .="AND Patient_Status='1'";
      }
      else
      {
        $date.='';
      }
     $now = date('Y-m-d');
     $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`,DATE_FORMAT(Patient_Date,'%d-%m-%Y %h:%i')Patient_Date FROM `tbl_patient_details` WHERE  Patient_Id !='' AND Patient_Visit_Status !='0' ".$date." AND DATE(Patient_Date)='$now' ORDER BY Patient_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {

           $explode = explode('-',$value['Patient_Age']);
           $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Patient_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Patient_Name'].'</td>
              <td>'.$age.'</td> 
              <td>'.$value['Patient_Height'].'</td>
               <td>'.$value['Patient_Weight'].'</td>
              
              ';
              // if($value['Patient_Visit_Status']=="0")
              // {
              //    $output .= '<td><span class="badge bg-danger">Pending</span></td>';
              // }
              // else
              // {
              //   $output .= '<td><span class="badge bg-success">Success</span></td>';
              // }

              // if($value['Patient_Status']=="0")
              // {
              //    $output .= '<td><span class="badge bg-danger">Pending</span></td>';
              // }
              // else
              // {
              //   $output .= '<td><span class="badge bg-success">Success</span></td>';
              // }


            $output .='
             <td>'.$value['Patient_Date'].'</td>
             <td><a href="patient_checking.php?id='.$value['Patient_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-check-double"></i>&nbsp;Checking</a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
     else
     {
      echo "<tr><td class='text-danger text-center' colspan='10'> Patient Not Found </td></tr>";
     }
  }



  // Display VISITED OLD PATEINT

  if($_POST['page']=="Display_Patient_old_All")
  {
     $date="";
      if($_POST['from_date'] !='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
      }
      if($_POST['from_date'] =='' && $_POST['to_date'] !='')
      {
         $date .="AND DATE(Patient_Date)<= '$_POST[to_date]'"; 
      }
      if($_POST['from_date'] !='' && $_POST['to_date'] =='')
      {
         $date .="AND DATE(Patient_Date) >= '$_POST[from_date]'"; 
      }
      if(is_numeric($_POST['search_val']) !='')
      {
        $date .="AND Patient_Contact LIKE '%$_POST[search_val]%'";
      }
      else
      {
        $date .="AND Patient_Name LIKE '%$_POST[search_val]%'";
      }

  
     $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact`, `Patient_Status`, `Patient_Visit_Status`,DATE_FORMAT(Patient_Date,'%d-%m-%Y %h:%i')Patient_Date FROM `tbl_patient_details` WHERE  Patient_Id !='' AND Patient_Visit_Status !='0' AND Patient_Status!='0' ".$date." ORDER BY Patient_Id ASC";

     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           $explode = explode('-',$value['Patient_Age']);
           $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Patient_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['Patient_Name'].'</td>
               <td>'.$age.'</td> 
              <td>'.$value['Patient_Height'].'</td>
               <td>'.$value['Patient_Weight'].'</td>
              
              ';
              // if($value['Patient_Visit_Status']=="0")
              // {
              //    $output .= '<td><span class="badge bg-danger">Pending</span></td>';
              // }
              // else
              // {
              //   $output .= '<td><span class="badge bg-success">Success</span></td>';
              // }

              // if($value['Patient_Status']=="0")
              // {
              //    $output .= '<td><span class="badge bg-danger">Pending</span></td>';
              // }
              // else
              // {
              //   $output .= '<td><span class="badge bg-success">Success</span></td>';
              // }


            $output .='
             <td>'.$value['Patient_Date'].'</td>
             <td><a href="patient_checking.php?id='.$value['Patient_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-check-double"></i>&nbsp;Checking</a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
     else
     {
      echo "<tr><td class='text-danger text-center' colspan='10'> Patient Not Found </td></tr>";
     }
  }


  /////////////////////// Delete Old Patient  /////////////////////

  if($_POST['page']=="Delete_Patient_Old_All")
  {
    $output = array();
    $advice = "DELETE FROM `tbl_advice_for_generate_prescription` WHERE tbl_advice_for_generate_prescription.User_Id IN('$_POST[id]')";
    if($server->Data_Upload($advice))
    {
      $digis = "DELETE FROM `tbl_digis_for_generate_prescription` WHERE tbl_digis_for_generate_prescription.User_Id IN('$_POST[id]')";
      if($server->Data_Upload($digis))
      {
        $medicine = "DELETE FROM `tbl_medicine_for_generate_prescription` WHERE tbl_medicine_for_generate_prescription.User_Id IN('$_POST[id]')";
        if($server->Data_Upload($medicine))
        {
          $test = "DELETE FROM `tbl_test_for_generate_prescription` WHERE tbl_test_for_generate_prescription.User_Id IN('$_POST[id]')";
          if($server->Data_Upload($test))
          {
            $patient = "UPDATE `tbl_patient_details` SET `Patient_Status`='0',`Patient_Visit_Status`='0' WHERE `Patient_Id` IN($_POST[id])";
            if($server->Data_Upload($patient))
            {
              $output['success']="Generated Prescription Delete Successfully";
            }
            else
            {
              $output['error']="Technical issue, Please try again..!";
            }
          }
          else
          {
            $output['error']="Technical issue, Please try again..!";
          }
        }
        else
          {
            $output['error']="Technical issue, Please try again..!";
          }
      }
      else
          {
            $output['error']="Technical issue, Please try again..!";
          }
    }
    else
          {
            $output['error']="Technical issue, Please try again..!";
          }

 echo json_encode($output);
  }




  ////////////////////////// GENERATE PRESCRIPTION //////////////

if($_POST['page']=="Suggest_Submit_form")
 {

    $sql = '';
    $output = array();
    if (isset($_POST['type'])) {
      
      switch ($_POST['type']) {
        case 'digis':
          $sql .="INSERT INTO `tbl_digis_for_generate_prescription`(`User_Id`,`Digis_Id`,`DG_Suggest`) VALUES ('$_POST[user_id]','$_POST[id]','$_POST[suggest]')";
          break;
        case 'advice':

          //$sql .="INSERT INTO `tbl_advice_for_generate_prescription`(`User_Id`,`Advice_Id`, `AM_ID`, `Qty`, `Day`,`AG_Suggest`) VALUES ('$_POST[user_id]','$_POST[id]','$_POST[am_id]','$_POST[qty]','$_POST[day]','$_POST[suggest]')";
         $sql .="INSERT INTO `tbl_advice_for_generate_prescription`(`User_Id`,`Advice_Id`,`AG_Suggest`) VALUES ('$_POST[user_id]','$_POST[id]','$_POST[suggest]')";

          break;
        case 'medicine':
          $sql .="INSERT INTO `tbl_medicine_for_generate_prescription`(`User_Id`,`M_Id`, `MG_medicine`, `MG_Day`) VALUES ('$_POST[user_id]','$_POST[id]','$_POST[medicine]','$_POST[day]')";
          break;
        case 'test':
          $sql .="INSERT INTO `tbl_test_for_generate_prescription`(`User_Id`,`Test_Id`, `TG_Suggest`) VALUES ('$_POST[user_id]','$_POST[id]','$_POST[suggest]')";
          break;
        default:
          $sql .=" ";
          break;
      }
    }

    if($server->Data_Upload($sql))
    {
      $output['success']="Added Successfully";
    }
    else
    {
      $output['error']="Technical issue, Please try again..!";
    }
   
  echo json_encode($output);
 }

 // ////////////////// DELETE PRESCRIPTION DETAILS  ////////////////////

 if($_POST['page']=="Delete_Prescription_List")
 {
    $sql = '';
    $output = array();
    if (isset($_POST['type'])) {
      
      switch ($_POST['type']) {
        case 'digis':
          $sql .="DELETE FROM `tbl_digis_for_generate_prescription` WHERE DG_Id='$_POST[id]'";
          break;
        case 'advice':
          $sql .="DELETE FROM `tbl_advice_for_generate_prescription` WHERE AG_Id='$_POST[id]'";
          break;
        case 'medicine':
          $sql .="DELETE FROM `tbl_medicine_for_generate_prescription` WHERE MG_Id='$_POST[id]'";
          break;
        case 'test':
          $sql .="DELETE FROM `tbl_test_for_generate_prescription` WHERE TG_Id='$_POST[id]'";
          break;
        default:
          $sql .=" ";
          break;
      }
    }

    if($server->Data_Upload($sql))
    {
      $output['success']="Delete Successfully";
    }
    else
    {
      $output['error']="Technical issue, Please try again..!";
    }
   
  echo json_encode($output);
 }


 // ///////////// PRINT PRESCRIPTION FORM  /////////////////
 if($_POST['page']=="Print_Prescription_form")
 {
   $output = array();
   $sql = "UPDATE `tbl_patient_details` SET `Patient_Status`='1' WHERE `Patient_Id`='$_POST[id_user]'";
   if($server->Data_Upload($sql))
   {
     $output['success']= "Update Successfully";
   }
   else{
    $output['error']= "Technical issue, Please try again..!";
   }

  echo json_encode($output);
 }
























/////////////////////////// STOCK MASTER ////////////////////////

// Display STOCK

  if($_POST['page']=="Display_Stock_All")
  {
     $sql = "SELECT tbl_product.P_Id,`S_Id`,`P_Name`,`P_Batch_No`,`P_HSN_No`,`P_Purchase_Price`,IFNULL(SUM(tbl_product_stock.S_Qty),0) as Qty,IFNULL(SUM(tbl_product_stock.S_Qty),0) as Qty,IFNULL(SUM(tbl_product_stock.S_Qty),0)*tbl_product.P_Purchase_Price as total, DATE_FORMAT(S_Date,'%d-%m-%Y %h:%i')S_Date FROM `tbl_product_stock` INNER JOIN tbl_product ON tbl_product.P_Id= tbl_product_stock.P_Id GROUP BY tbl_product_stock.P_Id  ORDER BY S_Id ASC";
     if($server->All_Record($sql))
     {
       $count=1;
        $output ='';
         foreach ($server->View_details as $value) {
           
           $output .='
             <tr>
             <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['P_Id'].'"></td>
               <td>'.$count.'</td>
               <td>'.$value['P_Name'].'</td>
               <td>'.$value['P_Batch_No'].'</td>
               <td>'.$value['P_HSN_No'].'</td>
               <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$value['P_Purchase_Price'].'</td>
               <td>'.$value['Qty'].'</td>
               <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$value['total'].'</td>
               <td>'.$value['S_Date'].'</td>
               <td><a href="add_stock.php?id='.$value['P_Id'].'&val=+&action=Add Stock Qty" class="btn btn-success btn-sm" title="Add Stock Product"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>&nbsp;&nbsp; <a href="add_stock.php?id='.$value['P_Id'].'&val=-&action=Deduct Stock Qty" class="btn btn-danger btn-sm" title="Delete Stock Product"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                  
            </tr>
          ';
        $count++;
         }
      echo $output;
     }
  }


  // ADD STOCK PRODUCT QTY

  if($_POST['page']=="Add_Stock")
  {
    $output = array();
    $qty = $_POST['val'].$_POST['qty'];

    $sql = "INSERT INTO `tbl_product_stock`(`P_Id`,`S_Qty`) VALUES ('$_POST[id]','$qty')";
    if($server->Data_Upload($sql))
    {
      $output['success']="Stock Update Successfully";
    }
    else
    {
      $output['error']="Technical issue, Please try again..!";
    }

  echo json_encode($output);
  }




  // ///////////////////// PAYMENT DISPLAY ///////////////////

  // Order Display

  //  Payment Report
if($_POST['page']=="Display_All_Order")
{
  $date="";
  if($_POST['from_date'] !='' && $_POST['to_date'] !='')
  {
     $date .="AND DATE(Payment_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
  }
  if($_POST['from_date'] =='' && $_POST['to_date'] !='')
  {
     $date .="AND DATE(Payment_Date)<= '$_POST[to_date]'"; 
  }
  if($_POST['from_date'] !='' && $_POST['to_date'] =='')
  {
     $date .="AND DATE(Payment_Date) >= '$_POST[from_date]'"; 
  }
  if(is_numeric($_POST['search_val']) !='')
  {
    $date .="AND tbl_user.User_Mobile LIKE '%$_POST[search_val]%'";
  }
  else
  {
    $date .="AND tbl_user.User_Name LIKE '%$_POST[search_val]%'";
  }

  if($_POST['status'] =='1')
  {
    $date .="AND tbl_payment.Payment_Status='$_POST[status]'";
  }
  else if ($_POST['status'] =='0') {

    $date .="AND tbl_payment.Payment_Status='$_POST[status]'";
  }
  else
  {
    $date.='';
  }

  //$sql ="SELECT  `Pay_Id`, `Pay_Order_Id`, `Pay_Mode`, `Pay_Type`, `Pay_Amount`, `Pay_Bank`, DATE(Pay_Date) AS P_date,tbl_register.R_Name,tbl_register.R_Mobile,tbl_register.R_EnrollNo FROM `tbl_payment` INNER JOIN tbl_register ON tbl_register.R_Id=tbl_payment.R_Id  ".$date." ORDER BY DATE(Pay_Date) DESC";
  $sql="SELECT Payment_Id,H_Id,Order_Id,User_Name,User_Mobile,Payment_Status,DATE(Payment_Date)Payment_Date,tbl_agent.Agent_Name,tbl_agent.Agent_Contact FROM tbl_payment INNER JOIN tbl_user ON tbl_user.User_Id=tbl_payment.User_Id INNER JOIN tbl_agent ON tbl_agent.Agent_Id=tbl_user.Agent_Id WHERE tbl_payment.Payment_Id !='' ".$date." ORDER BY Payment_Id DESC";
  //echo $sql;
  if($row =$server->All_Record($sql))
  {
    $count =1;
    $output='';
    //$total_amount=0;
    foreach ($server->View_details as $value) {
      $output .='
         <tr>
           <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Payment_Id'].'"></td>
           <td>'.$count.'</td>
           <td>'.$value['Order_Id'].'</td>
           <td>'.$value['User_Name'].'</td>
           <td>'.$value['User_Mobile'].'</td>
           ';
          if($value['Payment_Status']=='0')
          {
            $output.='<td><span class="badge badge-pill badge-danger">Pending</span></td>';
          }
          else
          {
            $output.='<td><span class="badge badge-pill badge-success">Success</span></td>';
          }
          
          $output.=' 
           <td>'.$value['Agent_Name'].' <br> '.$value['Agent_Contact'].' </td>
           <td>'.$value['Payment_Date'].'</td>
           <td><a href="order_product_list.php?id='.$value['Payment_Id'].'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
        </tr>
      ';
    $count++;
    //$total_amount += $value['Pay_Amount'];
    }
    $output .='<tr>
       <td colspan="9">Total Record : '.$row.'</td>
       </tr>';
  echo $output;
  }
  else
  {
    echo "<tr><td class='text-danger' colspan='9'>Record Not Found</td></tr>";
  }
}


/////////////// Display Order Payment Master /////

// Display Order Payment Master

if($_POST['page']=="Display_All_Payment")
{
    $date="";
  if($_POST['from_date'] !='' && $_POST['to_date'] !='')
  {
     $date .="AND DATE(Payment_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
  }
  if($_POST['from_date'] =='' && $_POST['to_date'] !='')
  {
     $date .="AND DATE(Payment_Date)<= '$_POST[to_date]'"; 
  }
  if($_POST['from_date'] !='' && $_POST['to_date'] =='')
  {
     $date .="AND DATE(Payment_Date) >= '$_POST[from_date]'"; 
  }
  if(is_numeric($_POST['search_val']) !='')
  {
    $date .="AND tbl_user.User_Mobile LIKE '%$_POST[search_val]%'";
  }
  else
  {
    $date .="AND tbl_user.User_Name LIKE '%$_POST[search_val]%'";
  }

  if($_POST['status'] =='1')
  {
    $date .="AND tbl_payment.Payment_Status='$_POST[status]'";
  }
  else if ($_POST['status'] =='0') {

    $date .="AND tbl_payment.Payment_Status='$_POST[status]'";
  }
  else
  {
    $date.='';
  }

  //$sql ="SELECT  `Pay_Id`, `Pay_Order_Id`, `Pay_Mode`, `Pay_Type`, `Pay_Amount`, `Pay_Bank`, DATE(Pay_Date) AS P_date,tbl_register.R_Name,tbl_register.R_Mobile,tbl_register.R_EnrollNo FROM `tbl_payment` INNER JOIN tbl_register ON tbl_register.R_Id=tbl_payment.R_Id  ".$date." ORDER BY DATE(Pay_Date) DESC";
  $sql="SELECT Payment_Id,H_Id,Order_Id,Amount,User_Name,User_Mobile,Payment_Status,DATE(Payment_Date)Payment_Date,tbl_agent.Agent_Name,tbl_agent.Agent_Contact FROM tbl_payment INNER JOIN tbl_user ON tbl_user.User_Id=tbl_payment.User_Id INNER JOIN tbl_agent ON tbl_agent.Agent_Id=tbl_user.Agent_Id WHERE tbl_payment.Payment_Id !='' ".$date." ORDER BY Payment_Id DESC";
  //echo $sql;
  if($row =$server->All_Record($sql))
  {
    $count =1;
    $output='';
    //$total_amount=0;
    foreach ($server->View_details as $value) {
      $output .='
         <tr>
           <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Payment_Id'].'"></td>
           <td>'.$count.'</td>
           <td>'.$value['Order_Id'].'</td>
           <td>'.$value['User_Name'].'</td>
           <td>'.$value['User_Mobile'].'</td>
           <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$value['Amount'].'</td>
           ';
          if($value['Payment_Status']=='0')
          {
            $output.='<td><span class="badge badge-pill badge-danger">Pending</span></td>
            <td><span class="badge badge-pill badge-danger">Pending</span></td>
             
            ';
          }
          else
          {
            $output.='<td><span class="badge badge-pill badge-success">Success</span></td>
            <td><span class="badge badge-pill badge-success">Pay Success</span></td>';
          }

          $output.='
           <td>'.$value['Agent_Name'].' <br> '.$value['Agent_Contact'].' </td> 
           <td>'.$value['Payment_Date'].'</td>
           
        </tr>
      ';
    $count++;
    //$total_amount += $value['Pay_Amount'];
    }
    $output .='<tr>
       <td colspan="10">Total Record : '.$row.'</td>
       </tr>';
  echo $output;
  }
  else
  {
    echo "<tr><td class='text-danger' colspan='10'>Record Not Found</td></tr>";
  }
}

// Amount Pay Display
if($_POST['page']=="Payment_Amount")
{
  $sql = "SELECT `Payment_Id`, `Amount` FROM `tbl_payment` WHERE Payment_Id='$_POST[id]'";
  if($server->All_Record($sql))
  {
    foreach ($server->View_details as $value) {
      # code...
    }

   $output = array(
      'success'=>true,
      'amount'=>$value['Amount'],
      'id'=>$value['Payment_Id']
   ); 

  echo json_encode($output);
  }
}

// Amount Pay Submit

if($_POST['page']=="Amount_Submit_form")
{
   $sql = "UPDATE `tbl_payment` INNER JOIN `order_header` ON tbl_payment.H_Id=order_header.H_Id SET `Payment_Status`='1',`Flag`='1',`transaction_flag`='1' WHERE `Payment_Id`='$_POST[id]'";
   if($server->Data_Upload($sql)) {
     
     $output = array(
        'success'=>'Amount Added Successfully'
     );

   }
   else
   {
     $output = array(
       'error'=>'Technical issue, Please try again.. !'
     );
   }

 echo json_encode($output);
}


// Order Reciept Copy

if($_POST['page']=="Order_reciept")
{
   $sql="SELECT tbl_payment.Payment_Id,tbl_payment.Order_Id, Amount,DATE_FORMAT(Payment_Date,'%d-%m-%Y %r')Payment_Date,IFNULL(tbl_wallet.W_Amount,'No')W_Amount,tbl_user.User_Name,tbl_user.User_Mobile,tbl_user.User_Address FROM `tbl_payment` LEFT JOIN tbl_wallet ON tbl_wallet.Payment_Id=tbl_payment.Payment_Id INNER JOIN tbl_user ON tbl_user.User_Id=tbl_payment.User_Id WHERE tbl_payment.Payment_Id='$_POST[id]'";
   if($server->All_Record($sql))
   {
     $output ='';
     foreach ($server->View_details as $value) {
  
       $output.='
         <div class="row mt-4">
            <div class="col-12 col-lg-10 offset-lg-1">
                
                <!-- .row -->

                

                <div class="row">

                    <div class="col-sm-6">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span><br>
                            <span class="text-600 text-110 text-blue align-middle">'.$value['User_Name'].'</span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1">
                                '.$value['User_Address'].'
                            </div>
                            <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600">'.$value['User_Mobile'].'</b></div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">
                            <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                Invoice
                            </div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span>'.$value['Order_Id'].'</div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Order Date:</span>'.$value['Payment_Date'].'</div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="mt-4">
                    <div class="row text-600 text-white bgc-default-tp1 py-25">
                        <div class="d-none d-sm-block col-1">Sl.</div>
                        <div class="col-9 col-sm-5">Item</div>
                        <div class="d-none d-sm-block col-4 col-sm-2">Price</div>
                        <div class="d-none d-sm-block col-4 col-sm-2"> Qty</div>
                        <div class="col-2">Amount</div>
                    </div>
                     '.$server->All_Order_Reciept($value['Payment_Id'],$value['W_Amount'],$value['Amount']).'
       ';
     }
   }

  echo $output;
}

// Display Return Order Master

// Order Display

  //  Payment Report
if($_POST['page']=="Display_All_Return")
{
  $date="";
  if($_POST['from_date'] !='' && $_POST['to_date'] !='')
  {
     $date .="AND DATE(R_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
  }
  if($_POST['from_date'] =='' && $_POST['to_date'] !='')
  {
     $date .="AND DATE(R_Date)<= '$_POST[to_date]'"; 
  }
  if($_POST['from_date'] !='' && $_POST['to_date'] =='')
  {
     $date .="AND DATE(R_Date) >= '$_POST[from_date]'"; 
  }
  if(is_numeric($_POST['search_val']) !='')
  {
    $date .="AND tbl_user.User_Mobile LIKE '%$_POST[search_val]%'";
  }
  else
  {
    $date .="AND tbl_user.User_Name LIKE '%$_POST[search_val]%'";
  }

  if($_POST['status'] =='1')
  {
    $date .="AND tbl_return.R_Flag='$_POST[status]'";
  }
  else if ($_POST['status'] =='0') {

    $date .="AND tbl_return.R_Flag='$_POST[status]'";
  }
  else
  {
    $date.='';
  }

  $sql= "SELECT
order_footer.F_Id,R_Id,`Order_Id`, `transaction_flag`,IFNULL(tbl_return.R_Flag,'Null')R_Flag,R_Qty,`Order_Status`, DATE_FORMAT(R_Date,'%d-%m-%Y %r')R_Date,tbl_product.P_Name,tbl_product.P_Selling_Price,order_footer.Qty,IFNULL(tbl_product.P_Selling_Price*order_footer.Qty,0)total,tbl_category.C_Image,tbl_unit.U_Name,tbl_product.P_Batch_No,tbl_user.User_Name,tbl_user.User_Mobile FROM `order_header` INNER JOIN order_footer ON order_header.H_Id=order_footer.H_Id INNER JOIN tbl_product ON tbl_product.P_Id=order_footer.P_Id INNER JOIN tbl_category ON tbl_category.C_Id=tbl_product.C_Id INNER JOIN tbl_unit ON tbl_unit.U_Id=tbl_product.U_Id INNER JOIN tbl_user ON tbl_user.User_Id=order_header.User_Id LEFT JOIN tbl_return ON tbl_return.F_Id=order_footer.F_Id INNER JOIN tbl_agent ON tbl_agent.Agent_Id=tbl_user.Agent_Id WHERE tbl_agent.Agent_Id='$_SESSION[Agent_logged_in]' ".$date." ORDER BY order_header.H_Id DESC";
  // 
  //echo $sql;
  if($row =$server->All_Record($sql))
  {
    $count =1;
    $output='';
    //$total_amount=0;
    foreach ($server->View_details as $value) {
      $output .='
         <tr>
           <td>'.$count.'</td>
           <td>'.$value['Order_Id'].'</td>
           <td>'.$value['User_Name'].'<br>'.$value['User_Mobile'].'</td>
           <td><img src="../../image/'.$value['C_Image'].'" width="60px"></td>
           <td>'.$value['P_Name'].'</td>
           <td>'.$value['P_Batch_No'].'</td>
           <td>'.$value['R_Qty'].'&nbsp;'.$value['U_Name'].'</td>
           ';

          if($value['R_Flag']=='0')
          {
            $output.='<td><a href="javascript:void(0)" data-id="'.$value['R_Id'].'" class="Update_Status" data-value="'.$value['R_Flag'].'"><span class="badge badge-pill badge-danger">Return Pending</span></a></td>';
          }
          else if ($value['R_Flag']=='1')
          {
            $output.='<td><a href="javascript:void(0)" data-id="'.$value['R_Id'].'" class="Update_Status" data-value="'.$value['R_Flag'].'"><span class="badge badge-pill badge-warning">Return Accepted</span></a></td>';
          }
          else
          {
            $output.='<td><span class="badge badge-pill badge-success">Return Success</span></td>';
          }
         
          
          $output.=' 
           <td>'.$value['R_Date'].'</td>
        </tr>
      ';
    $count++;
    //$total_amount += $value['Pay_Amount'];
    }
    $output .='<tr>
       <td colspan="7">Total Record : '.$row.'</td>
       </tr>';
  echo $output;
  }
  else
  {
    echo "<tr><td class='text-danger' colspan='11'>Record Not Found</td></tr>";
  }
}


// Update Return Status 
if($_POST['page']=="Update_Return_Status")
{
  $sql='';
  if($_POST['value']=='0')
  {
    $status='1';
    $sql .= "UPDATE `tbl_return` SET `R_Flag`='$status' WHERE `R_Id`='$_POST[id]'";
  }
  else 
  {
    $status='2';
    $sql1 = "INSERT INTO `tbl_wallet`(`User_Id`, `W_Amount`, `Payment_Id`)SELECT order_header.User_Id,IFNULL(tbl_product.P_Selling_Price*tbl_return.R_Qty,0)amount,tbl_payment.Payment_Id  FROM tbl_return INNER JOIN order_footer ON tbl_return.F_Id=order_footer.F_Id INNER JOIN tbl_product ON order_footer.P_Id=tbl_product.P_Id INNER JOIN order_header ON order_header.H_Id=order_footer.H_Id INNER JOIN tbl_payment ON tbl_payment.H_Id=order_header.H_Id WHERE tbl_return.R_Id='$_POST[id]'";
    if($server->Data_Upload($sql1))
    {
       $sql .= "UPDATE `tbl_return` SET `R_Flag`='$status' WHERE `R_Id`='$_POST[id]'";
    }
    else
    {
      $output = array(
        'error'=>'Technical issue, Please try again..!'
      );
    }
  }
  if($server->Data_Upload($sql))
  {
    $output = array(
      'success'=>'Update Successfully'
    );
  }
  else
  {
    $output = array(
       'error'=>'Technical issue, Please try again..!'
    );
  }

echo json_encode($output);
}


if($_POST['page']=="Upload_Item_Excel_Form_submit")
 {
    $files = $_FILES['file']['tmp_name'];
    $obj = PHPExcel_IOFactory::load($files);
    foreach ($obj->getWorksheetIterator() as  $value) {
      $getHighestRow = $value->getHighestRow();
      for ($i=0; $i <=$getHighestRow ; $i++) { 
        $code =  $value->getCellByColumnAndRow(0,$i)->getValue();
        $medicine_name =  $value->getCellByColumnAndRow(1,$i)->getValue();
        $type =  $value->getCellByColumnAndRow(2,$i)->getValue();
        $menubar =  $value->getCellByColumnAndRow(3,$i)->getValue();
        $direction =  $value->getCellByColumnAndRow(4,$i)->getValue();
        if($menubar =="Tablet")
        {
          $menu = "Menu-1";
        }
        elseif ($menubar =="Liquid") {
         $menu = "Menu-2";
        }
        else
        {
          $menu = "Menu-3";
        }
       
       if($code !='')
       {  
          $dosage_sql = "INSERT INTO `tbl_dosage_type`(`Dosage_Name`, `Dosage_Status`) VALUES ('$direction','1')";
          if($server->Data_Upload($dosage_sql)) {
            $dosage_lastid = $server->lastid;

            $medicine_sql = "INSERT INTO `tbl_medicine_master`(`M_Name`, `M_Code`, `MT_Id`, `Dosage_Id`, `M_Menu`, `M_Status`) VALUES ('$medicine_name','$code','$type','$dosage_lastid','$menu','1')";
            if($server->Data_Upload($medicine_sql))
            {
               $output = array(
                'success'=>'Uploaded Successfully'
               );
            }
            else
            {
              $output = array(
               'error'=>'Technical issue, Please try again..!'
              );
            }

          }
          else
          {
            $output = array(
             'error'=>'Technical issue, Please try again..!'
            );
          }
 
        
        
      
      }


    }

  }

echo json_encode($output);
}















































 ////////////////////////////////////








// DISPLAY ONLINE RECIEVED ALL APPOINTMENT
if($_POST['page']=="Display_Online_Appointment_All")
{
  $date="";
  if($_POST['from_date'] !='' && $_POST['to_date'] !='')
  {
     $date .="WHERE DATE(B_App_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]' AND  B_Pay_Flag='1'"; 
  }
  if($_POST['from_date'] =='' && $_POST['to_date'] !='')
  {
     $date .="WHERE DATE(B_App_Date) <= '$_POST[to_date]' AND  B_Pay_Flag='1'"; 
  }
  if($_POST['from_date'] !='' && $_POST['to_date'] =='')
  {
     $date .="WHERE DATE(B_App_Date) >= '$_POST[from_date]' AND  B_Pay_Flag='1'"; 
  }

  if($_POST['search_val']  !='' && $_POST['from_date'] !='' || $_POST['to_date'] !='')
  {
    if(is_numeric($_POST['search_val']) !='')
    {
      $date .="AND B_Mobile LIKE '%$_POST[search_val]%'";
    }
    else
    {
      $date .=" AND  tbl_online_booking.B_Name LIKE '%$_POST[search_val]%'";
    }
  }
  else
  {
    if($_POST['search_val'] !='')
    {
      if(is_numeric($_POST['search_val']) !='')
      {
        $date .="WHERE B_Mobile LIKE '%$_POST[search_val]%' AND  B_Pay_Flag='1'";
      }
      else
      {
        $date .=" WHERE tbl_online_booking.B_Name LIKE '%$_POST[search_val]%' AND  B_Pay_Flag='1'";
      }
    }
    
  }

  if($_POST['search_val']  !='' && $_POST['status'] !='' && ($_POST['from_date'] !='' || $_POST['to_date'] !=''))
  {
     $date .="AND Check_Status='$_POST[status]'";
  }
  else if($_POST['status'] !='' && ($_POST['from_date'] !='' || $_POST['to_date'] !=''))
  {
     $date .="AND Check_Status='$_POST[status]'";
  }
  else if($_POST['search_val']  !='' && $_POST['status'] !='')
  {
     $date .="AND Check_Status='$_POST[status]'";
  }
  else
  {
    if($_POST['status'] !='')
    {
      $date .="WHERE Check_Status='$_POST[status]' AND  B_Pay_Flag='1' ";
    }
  }

 if($_POST['search_val'] =='' && $_POST['status'] =='' && $_POST['from_date'] =='' && $_POST['to_date'] =='')
 {
  $date.="WHERE B_Pay_Flag='1'";
 }

  $sql ="SELECT `B_Id`, `B_Name`, `B_Email`, `B_Mobile`, `B_Gender`,tbl_fees_manage.F_Time,tbl_fees_manage.F_Ref, `B_App_Date`,`B_App_To_Date`, `B_Add_Info`, DATE(B_Added_date) AS B_Added_date , `B_Pay_Flag`,`Check_Status` FROM `tbl_online_booking` INNER JOIN tbl_fees_manage ON tbl_online_booking.B_Cov_Time=tbl_fees_manage.F_Id ".$date." ORDER BY B_Id DESC";
  //echo $sql;
  if($row =$server->All_Record($sql))
  {
    $count =1;
    $output='';
    foreach ($server->View_details as $value) {
      $output .='
         <tr>
           <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['B_Id'].'"></td>
           <td>'.$count.'</td>
           <td>'.$value['B_Name'].'</td>
           <td>'.$value['B_Email'].'</td>
           <td>'.$value['B_Mobile'].'</td>
           <td>'.$value['B_Gender'].'</td>
           <td>'.$value['F_Ref']. ' & '.$value['F_Time'].'</td>
           <td>'.$value['B_App_Date'].'</td>
           <td>'.$value['B_App_To_Date'].'</td>
           <td>'.$value['B_Add_Info'].'</td>
           ';
           if($value['B_Pay_Flag'] !=0)
           {
             $output .='<td><span style="color:green;">Payment Success</span></td>';
           }
           else
           {
             $output .='<td><span style="color:red;">Not Payment</span></td>';
           }
        $output .='
           <td>'.$value['B_Added_date'].'</td>';
          if($value['Check_Status'] !=0)
          {
             $output .='<td><input type="button" class="btn btn-success btn-sm Succes_Check" data-id="'.$value['B_Id'].'" value="Success" disabled></td>';
          }
          else
          {
            //$output .='<td><input type="button" class="btn btn-danger btn-sm Pending_Check" data-id="'.$value['B_Id'].'" value="Pending"></td>';
            $output .='<td><a href="add_prescription.php" class="btn btn-danger btn-sm">Pending</a></td>';
          }
      $output .='    
        </tr>
      ';
    $count++;
    }
    $output .="<td colspan='13'>Number of Record : ".$row."</td>";
  echo $output;
  }
  else
  {
    echo "<tr><td class='text-danger' colspan='13'>Record Not Found</td></tr>";
  }
}



if($_POST['page']=="Need_help_request_list_Display")
{
  $sql = "SELECT `Q_Id`, `Q_Name`, `Q_Email`, `Q_Mobile`, `Q_Subject`, `Q_Message`, `Q_Date` FROM `tbl_send_query`  ORDER BY Q_Id Desc";
  if($server->All_Record($sql))
  {
    $output = '';
    $count =1;
    foreach ($server->View_details as $value) {
        $output .='
            <tr>
               <td>'.$count.'</td>
               <td>'.$value['Q_Name'].'</td>
               <td>'.$value['Q_Email'].'</td>
               <td>'.$value['Q_Mobile'].'</td>
               <td>'.$value['Q_Subject'].'</td>
               <td>'.$value['Q_Message'].'</td>
               <td>'.$value['Q_Date'].'</td>
               <td><a href="javascript:void(0)" id="Help_Request_send" data-email="'.$value['Q_Email'].'"><i class="fas fa-share-square"></i></a></td>
            </tr>
        '; 
    }
  echo $output;
  }
}

if($_POST['page']=="Need_help_Request")
{
   $email = $_POST['email'];
   $subject = "Response Neuromax. Your Helping Answer";
   $body = $_POST['desc'];
   if($server->Send_email($email,$subject,$body))
   {
      $output = array(
         'success'=>'Email Sending Successfully'
      );
   }
   else
   {
     $output = array(
        'error'=>'Technical issue . Please try again..!'
     );
   }

  echo json_encode($output);
}




// Add Blog
if($_POST['page']=="news_form_submit")
{
   $sql ="INSERT INTO `tbl_blog`(`Bl_Header`, `Bl_Desc`) VALUES ('$_POST[title]','$_POST[desc]')";
   if($server->Data_Upload($sql))
   {
     $output = array(
        'success'=>'Added Successfully'
     );
   }
   else
   {
     $output = array(
        'error'=>'Technical issue. Please try again..!'
     );
   }

  echo json_encode($output);
}



if($_POST['page']=="All_Register_Student")
{
   $sql = "SELECT `R_Id`, `R_Group`, `R_Name`, `R_Dob`, `R_Gender`, `R_Mobile`, `R_Email`, `R_Password`, `R_EnrollNo`, DATE_FORMAT(R_date,'%d-%m-%Y %h:%i')R_date  FROM `tbl_register` ORDER BY R_Id ASC";
   if($server->All_Record($sql))
   {
     $count=1;
      $output ='';
       foreach ($server->View_details as $value) {
         
         $output .='
                <tr>
                   <td>'.$count.'</td>
                   <td>'.$value['R_Group'].'</td>
                   <td>'.$value['R_Name'].'</td>
                   <td>'.$value['R_Dob'].'</td>
                   <td>'.$value['R_Gender'].'</td>
                   <td>'.$value['R_Mobile'].'</td>
                   <td>'.$value['R_Email'].'</td>
                   <td>'.$value['R_EnrollNo'].'</td>
                   <td>'.$value['R_date'].'</td>
                  
                </tr>
         ';
      $count++;
       }
    echo $output;
   }
}

if($_POST['page']=="Delete_News_Unic")
{
  $sql = "DELETE FROM `tbl_blog` WHERE Bl_Id='$_POST[id]'";
  if($server->Data_Upload($sql))
  {
    $output = array(
      'success'=>'Dalete Successfully'
    );
  }
  else
  {
     $output = array(
        'error'=>'Technical issue. Please try again..!'
     );
  }
echo json_encode($output);
}

if($_POST['page']=="Update_news_form_submit")
{
  $sql ="UPDATE `tbl_blog` SET `Bl_Header`='$_POST[title]',`Bl_Desc`='$_POST[desc]' WHERE `Bl_Id`='$_POST[id]'";
  if($server->Data_Upload($sql))
  {
    $output = array(
       'success'=>'Update Successfully'
    );
  }
  else
  {
    $output = array(
       'error'=>'Technical issue. Please try again..!'
    );
  }

echo json_encode($output);
}


if($_POST['page']=="All_Feedback_")
{
  $sql = "SELECT `F_Id`, `F_Name`, `F_Email`, `F_Mobile`, `F_Comment`, `F_Feedback_value`, DATE(F_Date) AS F_Date FROM `tbl_feedback`  ORDER BY  F_Id Desc";
  if($server->All_Record($sql))
  {
    $count=1;
    $output= '';
    foreach ($server->View_details as $value) {
      
      $output .='
                <tr>
                   <td>'.$count.'</td>
                   <td>'.$value['F_Name'].'</td>
                   <td>'.$value['F_Email'].'</td>
                   <td>'.$value['F_Mobile'].'</td>
                   <td>'.$value['F_Comment'].'</td><td>';
                switch ($value['F_Feedback_value']) {
                  case '1':
                    $output .='
                    <span><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i></span>
                    ';
                    break;
                  case '2':
                    $output .='
                    <span><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i></span>
                    ';
                    break;
                  case '3':
                    $output .='
                    <span><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i></span>
                      ';
                    break;
                  case '4':
                    $output .='
                    <span><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i></span>
                    ';
                    break;
                  default:
                    $output .='
                    <span><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i><i class="fa fa-star" aria-hidden="true" style="font-size: 14px; color: gold;"></i></span>
                      ';
                    break;
                  
            }
            $output .='</td><td>'.$value['F_Date'].'</td>
                </tr>';
      $count++;
       }
    echo $output;
    }
  }


  
if($_POST['page']=="Display_All_Patient")
{
  $date="";
  if($_POST['from_date'] !='' && $_POST['to_date'] !='')
  {
     $date .="WHERE DATE(User_Added_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'"; 
  }
  if($_POST['from_date'] =='' && $_POST['to_date'] !='')
  {
     $date .="WHERE DATE(User_Added_Date) <= '$_POST[to_date]'"; 
  }
  if($_POST['from_date'] !='' && $_POST['to_date'] =='')
  {
     $date .="WHERE DATE(User_Added_Date) >= '$_POST[from_date]'"; 
  }
  if($_POST['search_val'] !='')
  {
    $date .="AND User_Mobile LIKE '%$_POST[search_val]%'";
  }
  $sql ="SELECT `User_Id`, `User_Name`, `User_Gender`, `User_Dob`, `User_Email`, `User_Mobile`, `User_Address`,DATE(User_Added_Date) AS User_Added_Date FROM `tbl_user` ".$date." ORDER BY User_Id DESC";
  
  if($row=$server->All_Record($sql))
  {
    $count =1;
    $output='';
    foreach ($server->View_details as $value) {
      $output .='
         <tr>
         <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['User_Id'].'"></td>
           <td>'.$count.'</td>
           <td>'.$value['User_Name'].'</td>
           <td>'.$value['User_Gender'].'</td>
           <td>'.$value['User_Dob'].'</td>
           <td>'.$value['User_Email'].'</td>
           <td>'.$value['User_Mobile'].'</td>
           <td>'.$value['User_Address'].'</td>
           <td>'.$value['User_Added_Date'].'</td>
          
        </tr>
      ';
    $count++;
     // <td>
     //        <a href="javascript:void(0)" class="btn btn-danger btn-sm change_appointment" data-user_id="'.$value['User_Id'].'">Change</a>
     //       </td>
    }
    $output .="<td colspan='9'>Number of Record : ".$row."</td>";
  echo $output;
  }
  else
  {
    ?>
    <tr>
      <td colspan="9"  class="text-danger">Record Not Found</td>
    </tr>
    <?php
  }
}







//  Payment Report
// if($_POST['page']=="Display_All_Payment")
// {
//   $date="";
//   if($_POST['from_date'] !='' && $_POST['to_date'] !='')
//   {
//      $date .="WHERE DATE(Pay_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
//   }
//   if($_POST['from_date'] =='' && $_POST['to_date'] !='')
//   {
//      $date .="WHERE DATE(Pay_Date)<= '$_POST[to_date]'"; 
//   }
//   if($_POST['from_date'] !='' && $_POST['to_date'] =='')
//   {
//      $date .="WHERE DATE(Pay_Date) >= '$_POST[from_date]'"; 
//   }
//   if(is_numeric($_POST['search_val']) !='')
//   {
//     $date .="AND tbl_register.R_Mobile LIKE '%$_POST[search_val]%'";
//   }
//   else
//   {
//     $date .="AND tbl_register.R_Name LIKE '%$_POST[search_val]%'";
//   }
//   $sql ="SELECT  `Pay_Id`, `Pay_Order_Id`, `Pay_Mode`, `Pay_Type`, `Pay_Amount`, `Pay_Bank`, DATE(Pay_Date) AS P_date,tbl_register.R_Name,tbl_register.R_Mobile,tbl_register.R_EnrollNo FROM `tbl_payment` INNER JOIN tbl_register ON tbl_register.R_Id=tbl_payment.R_Id  ".$date." ORDER BY DATE(Pay_Date) DESC";
//   if($row =$server->All_Record($sql))
//   {
//     $count =1;
//     $output='';
//     $total_amount=0;
//     foreach ($server->View_details as $value) {
//       $output .='
//          <tr>
//            <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['Pay_Id'].'"></td>
//            <td>'.$count.'</td>
//            <td>'.$value['R_Name'].'</td>
//            <td>'.$value['R_Mobile'].'</td>
//            <td>'.$value['R_EnrollNo'].'</td>
//            <td>'.$value['Pay_Order_Id'].'</td>
//            <td>'.$value['Pay_Mode'].'</td>
//            <td>'.$value['Pay_Type'].'</td>
//            <td>'.number_format($value['Pay_Amount'],2).'</td>
//            <td>'.$value['Pay_Bank'].'</td>
//            <td>'.$value['P_date'].'</td>
//         </tr>
//       ';
//     $count++;
//     $total_amount += $value['Pay_Amount'];
//     }
//     $output .='<tr>
//        <td colspan="7">Total Record : '.$row.'</td>
//        <td colspan="5">Total Amount : '.number_format($total_amount,2).'</td>
//        </tr>';
//   echo $output;
//   }
//   else
//   {
//     echo "<tr><td class='text-danger' colspan='11'>Record Not Found</td></tr>";
//   }
// }



// ---------------------- Student Full Submit Application --------------

//  Submit Full Report
if($_POST['page']=="Display_All_Full_Application_Student")
{
  $date="";
  if($_POST['from_date'] !='' && $_POST['to_date'] !='')
  {
     $date .="WHERE DATE(Pay_Date) BETWEEN '$_POST[from_date]' AND '$_POST[to_date]'";
  }
  if($_POST['from_date'] =='' && $_POST['to_date'] !='')
  {
     $date .="WHERE DATE(Pay_Date)<= '$_POST[to_date]'"; 
  }
  if($_POST['from_date'] !='' && $_POST['to_date'] =='')
  {
     $date .="WHERE DATE(Pay_Date) >= '$_POST[from_date]'"; 
  }
  if(is_numeric($_POST['search_val']) !='')
  {
    $date .="AND tbl_register.R_Mobile LIKE '%$_POST[search_val]%'";
  }
  else
  {
    $date .="AND tbl_register.R_Name LIKE '%$_POST[search_val]%'";
  }
  $sql ="SELECT tbl_register.R_Id,`R_Name`, `R_Dob`, `R_Gender`, `R_Mobile`, `R_Email`, DATE(Pay_Date) AS P_date,`R_EnrollNo` FROM `tbl_payment` INNER JOIN tbl_register ON tbl_register.R_Id=tbl_payment.R_Id INNER JOIN tbl_personal_details ON tbl_personal_details.R_Id=tbl_register.R_Id INNER JOIN tbl_document ON tbl_document.R_Id=tbl_register.R_Id ".$date." ORDER BY DATE(Pay_Date) DESC";
  if($row =$server->All_Record($sql))
  {
    $count =1;
    $output='';
    foreach ($server->View_details as $value) {
      $output .='
         <tr>
           <td><input type="checkbox" name="select_record" class="select_record" value="'.$value['R_Id'].'"></td>
           <td>'.$count.'</td>
           <td>'.$value['R_Name'].'</td>
           <td>'.$value['R_EnrollNo'].'</td>
           <td>'.$value['R_Mobile'].'</td>
           <td>'.$value['R_Email'].'</td>
           <td>'.$value['R_Gender'].'</td>
           <td>'.$value['R_Dob'].'</td>
           <td>'.$value['P_date'].'</td>
           <td><a href="view_submit_details.php?id='.base64_encode($value['R_Id']).'" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
        </tr>
      ';
    $count++;
    }
    $output .='<tr>
       <td colspan="11">Total Record : '.$row.'</td></tr>';
  echo $output;
  }
  else
  {
    echo "<tr><td class='text-danger' colspan='11'>Record Not Found</td></tr>";
  }
}


//-----------------Exit ---------------------------------------------------
// Forget Password
if($_POST['page']=="Forget_Password_Page")
{
   $sql = "UPDATE `tbl_admin` SET `Admin_Password`='$_POST[Password]' WHERE  `Admin_Id`=
  '$_SESSION[Admin_logged_in]'";
  if($server->Data_Upload($sql))
  {
     $output = array(
       'success'=>'Password Changed Successfully'
     );
  }
  else
  {
     $output = array(
        'error'=>'Technical issue, Please try again..!'
     );
  }

echo json_encode($output);
}

// Patient Checking 

//  Success
if($_POST['page']=="Success_Patient_")
{
  $sql = "UPDATE `tbl_online_booking` SET `Check_Status`='0' WHERE `B_Id`='$_POST[id]'";
  if($server->Data_Upload($sql))
  {
     $output = array(
        'success'=>'Patients Status Pending'
     );
  }
  else
  {
     $output = array(
        'error'=>'Technical issue, Please try again..!'
     );
  }

echo json_encode($output);
}
// Pending
if($_POST['page']=="Pending_Patient_")
{
  $sql = "UPDATE `tbl_online_booking` SET `Check_Status`='1' WHERE `B_Id`='$_POST[id]'";
  if($server->Data_Upload($sql))
  {
     $output = array(
        'success'=>'Patients Status Success'
     );
  }
  else
  {
     $output = array(
        'error'=>'Technical issue, Please try again..!'
     );
  }

echo json_encode($output);
}

// State Add
if($_POST['page']=="state_form_submit")
{
  $sql = "SELECT `S_Name` FROM `tbl_state` WHERE S_Name='$_POST[state_name]'";
  if($server->All_Record($sql))
  {
    $output = array(
      'error'=>'This Name is Already Exist !'
    );
  }
  else
  {
    $sql= "INSERT INTO `tbl_state`(`S_Name`) VALUES ('$_POST[state_name]')";
    if($server->Data_Upload($sql))
    {
      $output = array(
          'success'=>'State Added Successfully'
      );
    }
    else
    {
       $output = array(
          'error'=>'Technical issue, Please try again..!'
       );
    }
  }
  

echo json_encode($output);
}


if($_POST['page']=="All_State_Display_")
{
  $sql = "SELECT `S_Id`,`S_Name`,DATE_FORMAT(S_Date,'%d-%m-%Y %h:%i')S_Date FROM `tbl_state` ORDER BY  S_Id Desc";
  if($server->All_Record($sql))
  {
    $count=1;
    $output= '';
    foreach ($server->View_details as $value) {
      
      $output .='
                <tr>
                   <td>'.$count.'</td>
                   <td>'.$value['S_Name'].'</td>
                   <td>'.$value['S_Date'].'</td>
                   <td><a href="view_state.php?id='.$value['S_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-sm  Delete_Fees" data-id="'.$value['S_Id'].'"><i class="fas fa-trash"></i></a></td>
                </tr>';
      $count++;
       }
    echo $output;
    }
  }

  // Delete Fees 
  if($_POST['page']=="Delete_State_Unic")
  {
    $sql = "SELECT `D_Id`, `S_Id`, `D_Name`, `D_Date` FROM `tbl_district` WHERE S_Id='$_POST[id]'";
    if($server->All_Record($sql))
    {
      $output = array(
         'error'=>'Permission Denied, Delete First District !'
      );
    }
    else
    {
       $sql = "DELETE FROM `tbl_state` WHERE S_Id='$_POST[id]'";
        if($server->Data_Upload($sql))
        {
          $output = array(
             'success'=>'Delete Successfully'
          );
        }
        else
        {
          $output = array(
             'error'=>'Technical issue, Please try again..!'
          );
        }
    }
    

  echo json_encode($output);
  }

  if($_POST['page']=="Edit_State_form_submit")
  {
       $sql = "SELECT `S_Name` FROM `tbl_state` WHERE S_Name='$_POST[state_name]'";
        if($server->All_Record($sql))
        {
          $output = array(
            'error'=>'This Name is Already Exist !'
          );
        }
        else
        {
          $sql= "UPDATE `tbl_state` SET `S_Name`='$_POST[state_name]' WHERE `S_Id`='$_POST[id]'";
          if($server->Data_Upload($sql))
          {
            $output = array(
                'success'=>'State Update Successfully'
            );
          }
          else
          {
             $output = array(
                'error'=>'Technical issue, Please try again..!'
             );
          }
        }

  echo json_encode($output);
  }



  // Add District

  if($_POST['page']=="district_form_submit")
  {
    $sql = "SELECT `S_Id`, `D_Name` FROM `tbl_district` WHERE S_Id='$_POST[state_name]' AND D_Name='$_POST[district_name]'";
    if($server->All_Record($sql))
    {
      $output = array(
        'error'=>'This Name is Already Exist !'
      );
    }
    else
    {
      $sql= "INSERT INTO `tbl_district`(`S_Id`, `D_Name`) VALUES ('$_POST[state_name]','$_POST[district_name]')";
      if($server->Data_Upload($sql))
      {
        $output = array(
            'success'=>'District Added Successfully'
        );
      }
      else
      {
         $output = array(
            'error'=>'Technical issue, Please try again..!'
         );
      }
    }
  

 echo json_encode($output);
}


// Display All District
 if($_POST['page']=="All_District_Display_")
 {
  $sql = "SELECT `D_Id`, tbl_district.S_Id, `D_Name`, DATE_FORMAT(D_Date,'%d-%m-%Y %h:%i')D_Date,tbl_state.S_Name FROM `tbl_district` INNER JOIN tbl_state ON tbl_state.S_Id=tbl_district.S_Id ORDER BY  S_Id Desc";
  if($server->All_Record($sql))
  {
    $count=1;
    $output= '';
    foreach ($server->View_details as $value) {
      
      $output .='
                <tr>
                   <td>'.$count.'</td>
                   <td>'.$value['S_Name'].'</td>
                   <td>'.$value['D_Name'].'</td>
                   <td>'.$value['D_Date'].'</td>
                   <td><a href="view_district.php?id='.$value['D_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-sm  Delete_District" data-id="'.$value['D_Id'].'"><i class="fas fa-trash"></i></a></td>
                </tr>';
      $count++;
       }
    echo $output;
    }
  }


  // Edit District
  if($_POST['page']=="Edit_district_form_submit")
  {
       $sql = "SELECT `S_Id`, `D_Name` FROM `tbl_district` WHERE S_Id='$_POST[state_name]' AND D_Name='$_POST[district_name]'";
        if($server->All_Record($sql))
        {
          $output = array(
            'error'=>'This Name is Already Exist !'
          );
        }
        else
        {

          $sql ="UPDATE `tbl_district` SET `S_Id`='$_POST[state_name]',`D_Name`='$_POST[district_name]' WHERE D_Id='$_POST[id]'";
          if($server->Data_Upload($sql))
          {
            $output = array(
                'success'=>'District Update Successfully'
            );
          }
          else
          {
             $output = array(
                'error'=>'Technical issue, Please try again..!'
             );
          }
        }

  echo json_encode($output);
  }

   // Delete District 
  if($_POST['page']=="Delete_District_Unic")
  {
    
       $sql = "DELETE FROM `tbl_district` WHERE D_Id='$_POST[id]'";
        if($server->Data_Upload($sql))
        {
          $output = array(
             'success'=>'Delete Successfully'
          );
        }
        else
        {
          $output = array(
             'error'=>'Technical issue, Please try again..!'
          );
        }
   
    

  echo json_encode($output);
  }



  // Board Or University 

  // Board Add
if($_POST['page']=="Board_form_submit")
{
  $sql = "SELECT `B_Id`, `B_Name`, `B_Date` FROM `tbl_board` WHERE B_Name='$_POST[state_name]'";
  if($server->All_Record($sql))
  {
    $output = array(
      'error'=>'This Name is Already Exist !'
    );
  }
  else
  {
    $sql= "INSERT INTO `tbl_board`(`B_Name`) VALUES ('$_POST[state_name]')";
    if($server->Data_Upload($sql))
    {
      $output = array(
          'success'=>'Board/University Added Successfully'
      );
    }
    else
    {
       $output = array(
          'error'=>'Technical issue, Please try again..!'
       );
    }
  }
  

echo json_encode($output);
}


if($_POST['page']=="All_Board_Display_")
{
 
  $sql = "SELECT `B_Id`, `B_Name`,DATE_FORMAT(B_Date,'%d-%m-%Y %h:%i')B_Date FROM `tbl_board` ORDER BY  B_Id Desc";
  if($server->All_Record($sql))
  {
    $count=1;
    $output= '';
    foreach ($server->View_details as $value) {
      
      $output .='
                <tr>
                   <td>'.$count.'</td>
                   <td>'.$value['B_Name'].'</td>
                   <td>'.$value['B_Date'].'</td>
                   <td><a href="view_board.php?id='.$value['B_Id'].'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-sm  Delete_board" data-id="'.$value['B_Id'].'"><i class="fas fa-trash"></i></a></td>
                </tr>';
      $count++;
       }
    echo $output;
    }
  }

  // Delete Fees 
  if($_POST['page']=="Delete_Board_Unic")
  {
      $sql = "DELETE FROM `tbl_board` WHERE B_Id='$_POST[id]'";
        if($server->Data_Upload($sql))
        {
          $output = array(
             'success'=>'Delete Successfully'
          );
        }
        else
        {
          $output = array(
             'error'=>'Technical issue, Please try again..!'
          );
        }
       
  echo json_encode($output);
  }

  if($_POST['page']=="Edit_Board_form_submit")
  {
       $sql = "SELECT `B_Name` FROM `tbl_board` WHERE B_Name='$_POST[state_name]'";
        if($server->All_Record($sql))
        {
          $output = array(
            'error'=>'This Name is Already Exist !'
          );
        }
        else
        {
          $sql= "UPDATE `tbl_board` SET `B_Name`='$_POST[state_name]' WHERE `B_Id`='$_POST[id]'";
          if($server->Data_Upload($sql))
          {
            $output = array(
                'success'=>'Board/University Update Successfully'
            );
          }
          else
          {
             $output = array(
                'error'=>'Technical issue, Please try again..!'
             );
          }
        }

  echo json_encode($output);
  }




  // Exit Board or University


  







// PATIENT SELECT

  if($_POST['page']=="Select_Patient_")
  {
    $sql ="SELECT `B_Id`, `B_Name`, `B_Mobile`, `B_Gender`,`B_Dob`,`B_Address` FROM `tbl_online_booking` WHERE B_Id = '$_POST[id]'";
    if($server->All_Record($sql))
    {
       foreach ($server->View_details as $value) {

          $dateOfBirth = $value['B_Dob'];
          $today = date("Y-m-d");
          $diff = date_diff(date_create($dateOfBirth), date_create($today));
          // echo 'Age is '.$diff->format('%y');
          $value['age']= $diff->format('%y');
          $value['success']= true;
          echo json_encode($value);
       }
    }
  }


// DRUG FORM SUBMIT
  if($_POST['page']=="drug_form_submit")
  {
    $sql = "INSERT INTO `tbl_drug`(`Patient_Id`,`D_Name`, `D_strength`, `D_s_Unit`, `D_Dose`, `D_d_Unit`, `D_preparation`, `D_Route`, `D_Direction`, `D_Frequency`, `D_Duration`, `D_Du_unit`, `D_Total_qty`, `D_other_ins`) VALUES ('$_POST[P_id]','$_POST[drug_name]','$_POST[strength]','$_POST[s_unit]','$_POST[dose]','$_POST[d_unit]','$_POST[preparation]','$_POST[route]','$_POST[direction]','$_POST[frequency]','$_POST[duration]','$_POST[du_unit]','$_POST[total_qty]','$_POST[o_ins]')";
    if($server->Data_Upload($sql))
    {
      $output = array(
        'success'=>'Drug Added Successfully'
      );
    }
    else
    {
      $output = array(
         'error'=>'Technical issue, Please try again..!'
      );
    }

  echo json_encode($output);
  }

// All Drug SHOW
  if($_POST['page']=="All_Drug_Show")
  {
     $sql = "SELECT `D_Id`, `P_Id`, `Patient_Id`, `D_Name`, `D_strength`, `D_s_Unit`, `D_Dose`, `D_d_Unit`, `D_preparation`, `D_Route`, `D_Direction`, `D_Frequency`, `D_Duration`, `D_Du_unit`, `D_Total_qty`, `D_other_ins`, `D_added` FROM `tbl_drug` WHERE Patient_Id='$_POST[id]' AND P_Id=0";
     if($server->All_Record($sql))
     {
       $output = "<ol type='1'>";
       foreach ($server->View_details as $value) {
           
          $output .= '<li>'.$value['D_Name'].' '.$value['D_strength'].' '.$value['D_s_Unit'].' '.$value['D_Dose'].' '.$value['D_d_Unit'].' '.$value['D_Route'].' '.$value['D_Direction'].' '.$value['D_Frequency'].' ---'.$value['D_Duration'].' '.$value['D_Du_unit'].' '.$value['D_other_ins'].'&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-sm Delete_drug" data-id="'.$value['D_Id'].'"><i class="fas fa-trash"></i></a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="btn btn-warning btn-sm Edit_drug" data-id="'.$value['D_Id'].'"><i class="fas fa-edit"></i></a><hr/></li>';

       }

      $output .="</ol>";
      echo $output;
     }
  }


  // Delete Drug
  if ($_POST['page']=="Delete_Drug_") {
    
    $sql = "DELETE FROM `tbl_drug` WHERE D_Id='$_POST[id]'";
    if($server->Data_Upload($sql))
    {
      $output = array(
         'success'=>'Drug Delete Successfully'
      );
    }
    else
    {
        $output = array(
           'error'=>'Technical issue, Please try again..!'
        );
    }

  echo json_encode($output);
  }

  // Edit Drug

  if($_POST['page']=="Edit_Drug_"){

    $sql = "SELECT `D_Id`,`D_Name`, `D_strength`, `D_s_Unit`, `D_Dose`, `D_d_Unit`, `D_preparation`, `D_Route`, `D_Direction`, `D_Frequency`, `D_Duration`, `D_Du_unit`, `D_Total_qty`, `D_other_ins`FROM `tbl_drug` WHERE D_Id='$_POST[id]'";
    if($server->All_Record($sql))
    {
       foreach ($server->View_details as $value) {
          $value['success']= true;
          
       }
      echo json_encode($value);
    }
    else
    {
       $output = array('error'=>'Technical issue, Please try again !');
       echo json_encode($output);
    }
  }
 //Edit Drug Data
  if($_POST['page']=="Edit_Drug_form_submit")
  {
     //$sql = "INSERT INTO `tbl_drug`(`Patient_Id`,`D_Name`, `D_strength`, `D_s_Unit`, `D_Dose`, `D_d_Unit`, `D_preparation`, `D_Route`, `D_Direction`, `D_Frequency`, `D_Duration`, `D_Du_unit`, `D_Total_qty`, `D_other_ins`) VALUES ('$_POST[P_id]','$_POST[drug_name]','$_POST[strength]','$_POST[s_unit]','$_POST[dose]','$_POST[d_unit]','$_POST[preparation]','$_POST[route]','$_POST[direction]','$_POST[frequency]','$_POST[duration]','$_POST[du_unit]','$_POST[total_qty]','$_POST[o_ins]')";

     $sql = "UPDATE `tbl_drug` SET `D_Name`='$_POST[drug_name]',`D_strength`='$_POST[strength]',`D_s_Unit`='$_POST[s_unit]',`D_Dose`='$_POST[dose]',`D_d_Unit`='$_POST[d_unit]',`D_preparation`='$_POST[preparation]',`D_Route`='$_POST[route]',`D_Direction`='$_POST[direction]',`D_Frequency`='$_POST[frequency]',`D_Duration`='$_POST[duration]',`D_Du_unit`='$_POST[du_unit]',`D_Total_qty`='$_POST[total_qty]',`D_other_ins`='$_POST[o_ins]' WHERE  `D_Id`='$_POST[drug_id]'";
    if($server->Data_Upload($sql))
    {
      $output = array(
        'success'=>'Drug Update Successfully'
      );
    }
    else
    {
      $output = array(
         'error'=>'Technical issue, Please try again..!'
      );
    }

  echo json_encode($output);
  }


// Add Prescription Patient Details

  if($_POST['page']=="prescription_form_submit")
  {
    $sql = "INSERT INTO `tbl_prescription`(`Patient_id`, `P_dob`, `P_age`, `P_address`, `P_height`, `P_h_unit`, `P_weight`, `P_u_unit`, `P_diagonosis`, `P_c_comp`, `P_cl_feature`, `P_examination`, `P_investigation`, `P_advice`, `P_notes`) VALUES ('$_POST[patient_id]','$_POST[dob]','$_POST[age]','$_POST[address]','$_POST[height]','$_POST[h_unit]','$_POST[weight]','$_POST[w_unit]','$_POST[diagonosis]','$_POST[c_com]','$_POST[c_feat]','$_POST[examination]','$_POST[investigation]','$_POST[advice]','$_POST[notes]')";
    if($server->Data_Upload($sql))
    {
      $max_id_sql = "SELECT  MAX(P_Id) AS id FROM `tbl_prescription`";
      if($last_id = $server->Max_id($max_id_sql))
      {
          $update_data = "UPDATE `tbl_drug` SET `P_Id`='$last_id' WHERE `Patient_Id`='$_POST[patient_id]' AND `P_Id`='0'";
          if($server->Data_Upload($update_data))
          {
            $update_pending_query ="UPDATE `tbl_online_booking` SET `Check_Status`='1' WHERE `B_Id`=$_POST[patient_id]";
            if($server->Data_Upload($update_pending_query))
            {
              $output = array(
                'success'=>'Prescription Generated Successfully',
                'url'=>'generate_prescription.php?id='.base64_encode($last_id).''
             );
            }
            else
            {
               $output = array(
                  'error'=>'Technical issue, Please try again..!'
               );
            }
             
          }
          else
          {
             $output = array(
                'error'=>'Data Not Found !'
             );
          }
      }
       
    }
    else
    {
       $output = array(
          'error'=>'Technical issue, Please try again..!'
       );
    }

  echo json_encode($output);
  }



  //Display Generate Prescription

  if($_POST['page']=="Generate_Prescription_Display")
  {
     $sql = "SELECT `P_Id`,tbl_online_booking.B_Name,tbl_online_booking.B_Mobile,tbl_online_booking.B_Gender, `P_address`, DATE_FORMAT(P_added,'%d-%m-%Y  %h:%i')P_added FROM `tbl_prescription` INNER JOIN tbl_online_booking ON tbl_prescription.Patient_id=tbl_online_booking.B_Id ORDER BY P_Id ASC";
     if($server->All_Record($sql))
     {
       $data = array();
       foreach ($server->View_details as $value) {
         $value['edit'] = '<a href="generate_prescription.php?id='.base64_encode($value['P_Id']).'"><i class="fas fa-file-pdf"></i></a>';
         $data[]= array_values($value); 
       }

      $value = array_values($data);
      $result['status_code']=1;
      $result['message']='Data Successfully Found';
      $result['data']=$value;
      echo json_encode($result);
     }
  }













}
?>