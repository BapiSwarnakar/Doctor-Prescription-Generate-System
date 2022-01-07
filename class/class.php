<?php

// ................... Main Class ......................
class Main_Classes  extends User
{
	
  var $host;
  var $username;
  var $password;
  var $database;
	var $conn;
	var $lastid;
	var $View_details;	
  var $all_service;
  var $all_client;
  var $all_plan_option;
  var $Global_count;
	public function __construct()
   {
    $this->conn= new mysqli(HOST,USERNAME,PASSWORD,DATABASE);
    if(! $this->conn)
    {
      die("Database Not Found");
    }
    else
    {
       session_start();
    }
  }

  public function Current_URL()
  {
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    {
      $url = "https://";
    }      
    else {
      $url = "http://";   
    } 
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];      
    // Append the requested resource location to the URL   
    //$url.= $_SERVER['REQUEST_URI'];
    $url .=$_SERVER["PHP_SELF"];    
          
    return $url;
  }
  public function redirect($page)
  {
    //header('location:'.$page.'');
   echo "<script>window.location='".$page."'</script>";
    exit;
   }

    public function Root()
    {
      // return "http://neotrionet.com/demo/Neuromax/";
      return "https://mimtedu.in/Doctor_Personal_Site/";
    }
    

    public function RandomUserId()
    {
       return date('dmYhis');
    }

    function RandomPassword() {
      return 123;
    // $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    // $pass = array(); //remember to declare $pass as an array
    // $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    // for ($i = 0; $i < 8; $i++) {
    //     $n = rand(0, $alphaLength);
    //     $pass[] = $alphabet[$n];
    // }
    //  return implode($pass); //turn the array into a string
    }
    

   public function clean_data($data)
     {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }

    public function Data_Upload($data){

      if($this->conn->query($data))
      {

         $this->lastid = $this->conn->insert_id;
         return true;
      }
      else{
       
          return false;
      }

    }

    public function Find_Unic_Value($sql)
      {
      $query= $this->conn->query($sql);
     
      if($query)
      {
        $result = $query->fetch_array(MYSQLI_ASSOC);
        if($query->num_rows>0)
         {
            return true;
        }
      }
      else
       {
          return false;
       }

    }
    public function All_Record($sql){
       $query= $this->conn->query($sql);
        if($count = $query->num_rows)
        {      
            while($result = $query->fetch_array(MYSQLI_ASSOC))
             {
                $this->View_details[] = $result;
             }
        return $count;
          return $this->View_details;     
        }
        else{
            return 0;
        }   

    }

    public function All_Services($sql){
       $query= $this->conn->query($sql);
        if($count = $query->num_rows)
        {      
            while($result = $query->fetch_array(MYSQLI_ASSOC))
             {
                $this->all_service[] = $result;
             }
        return $count;
          return $this->all_service;     
        }
        else{
            return 0;
        }   

    }

    public function All_Client($sql){
       $query= $this->conn->query($sql);
        if($count = $query->num_rows)
        {      
            while($result = $query->fetch_array(MYSQLI_ASSOC))
             {
                $this->all_client[] = $result;
             }
        return $count;
          return $this->all_client;     
        }
        else{
            return 0;
        }   

    }

     public function All_Plan_Option($sql){
       $query= $this->conn->query($sql);
        if($count = $query->num_rows)
        {      
            while($result = $query->fetch_array(MYSQLI_ASSOC))
             {
                $this->all_plan_option[] = $result;
             }
        return $count;
          return $this->all_plan_option;     
        }
        else{
            return 0;
        }   

    }



}



//.................Admin Class Start. ..................

/**
 * 
 */
class Admin_Class
{

   public function admin_session_private()
    {
      if(!isset($_SESSION['Admin_logged_in']))
      {
        $this->redirect($this->Root().'');
      }
    }
    // Login Session Checking
    public function login_session_Check()
      {
      if(isset($_SESSION['Admin_logged_in']))
      {
        $this->redirect($this->Root().'Dashboard/dashboard.php');
      }
    } 

    

    

    

    public function User_details($id){
       $query= $this->conn->query("SELECT `User_Id`, `User_Name`, `User_Email`, `User_Mobile`, `User_Password`, `User_Created` FROM `tbl_user_signup` WHERE User_Id='$id'");
        if($query->num_rows)
        {      
            while($result = $query->fetch_array(MYSQLI_ASSOC))
             {
                $this->all_plan_option[] = $result;
             }
          return $this->all_plan_option;     
        }
        else{
            return 0;
        }   

    }

    public function Upload_Image($tmp_file,$path,$image)
    {
       return move_uploaded_file($tmp_file,$path.$image);
    }

    public function Cart_Quantity($item,$user){
       $query= $this->conn->query("SELECT `Cart_ItemId`, `Cart_Quantity`, `Cart_UserId` FROM `tbl_cart` WHERE Cart_ItemId='$item' AND Cart_UserId='$user'");
        if($count = $query->num_rows)
        {   
           while($result = $query->fetch_array(MYSQLI_ASSOC))
             {
                 return $result['Cart_Quantity']; 
             }     
        }
        else{
            return 0;
        }   

    }


    public function All_Image_Item_Id_Wise($item_id)
    {
      $sql = "SELECT `lmage_Id`, `Item_Id`, `Image` FROM `tbl_product_image` WHERE Item_Id='$item_id'";
      $result = $this->conn->query($sql);
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<img src="../../item_images/'.$fetch['Image'].'" width=250px height=250px />&nbsp;';
               } 
              return $output;
         }
    }


    public function All_Images_($item_id)
    {
      $sql = "SELECT `lmage_Id`, `Item_Id`, `Image` FROM `tbl_product_image` WHERE Item_Id='$item_id'";
      $result = $this->conn->query($sql);
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<a href="javascript:void(0)" class="Zoom_image" data-url="'.$fetch['Image'].'"> <img src="../../item_images/'.$fetch['Image'].'"  width=60px height="80px"/></a>&nbsp;';
               } 
              return $output;
         }
    }

    public function Cart_Check_Num_Of_Row($item,$user)
    {
        $query= $this->conn->query("SELECT `Cart_ItemId`, `Cart_Quantity`, `Cart_UserId` FROM `tbl_cart` WHERE Cart_ItemId='$item' AND Cart_UserId='$user'");
        if($count = $query->num_rows)
        {   
           return true;   
        }
        else{
            return false;
        }  
    }

  
    

   public function Send_email($receiver_email,$subject,$message)
     {
      $mail = new PHPMailer;

      $mail->IsSMTP();

      $mail->Host = 'smtp.gmail.com';

      $mail->Port = '587';

      $mail->SMTPAuth = true;

      $mail->Username = 'swarnakarr34@gmail.com';

      $mail->Password = 'Software@!123';

      $mail->SMTPSecure = 'tls';

      $mail->From = 'info@Codewithbapi.info';

      $mail->FromName = 'info@Codewithbapi.info';

      $mail->AddAddress($receiver_email, '');

      $mail->IsHTML(true);

      $mail->Subject = $subject;

      $mail->Body = $message;

      //$mail->AddEmbeddedImage('first.png','apple');

      if($mail->Send())
      {
        return true;
      }
      else
      {
        return "{$mail->ErrorInfo}";
      }
      
    }

  public function All_Nature_Medicine_Type()
  {
    
    $sql = "SELECT `MT_Id`, `MT_Name`, `MT_Type` FROM `tbl_medicine_type` WHERE MT_Status !='0'";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['MT_Id'].'">'.ucwords($fetch['MT_Type']).'</option>';
             } 
            return $output;
       }

  }

  public function All_Dosage_Type()
  {
    
    $sql = "SELECT `Dosage_Id`, `Dosage_Name` FROM `tbl_dosage_type` WHERE Dosage_Status !='0'";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['Dosage_Id'].'">'.ucwords($fetch['Dosage_Name']).'</option>';
             } 
            return $output;
       }

  }

  public function All_Advice_Medicine()
  {
    $sql = "SELECT `AM_ID`, `AM_Name` FROM `tbl_advice_medicine` WHERE AM_Status !='0'";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['AM_ID'].'">'.ucwords($fetch['AM_Name']).'</option>';
             } 
            return $output;
       }
  }

  public function All_Brand_()
  {
     $sql = "SELECT `B_Id`, `B_Name` FROM `tbl_brand` ORDER BY B_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['B_Id'].'">'.ucwords($fetch['B_Name']).'</option>';
             } 
            return $output;
       }
  }

  public function All_Unit_()
  {
     $sql = "SELECT `U_Id`, `U_Name` FROM `tbl_unit` ORDER BY U_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['U_Id'].'">'.ucwords($fetch['U_Name']).'</option>';
             } 
            return $output;
       }
  }


  public function All__Category_()
  {
     $sql = "SELECT `C_Id`, `C_Name` FROM `tbl_category` ORDER BY C_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['C_Id'].'">'.ucwords($fetch['C_Name']).'</option>';
             } 
            return $output;
       }
  }




}

// Exit Admin Class

/**
 * 
 */
class Agent extends Admin_Class
{
  

  public function agent_session_private()
    {
      if(!isset($_SESSION['Agent_logged_in']))
      {
        $this->redirect($this->Root().'agent');
      }
    }
    // Login Session Checking
    public function agent_login_session_Check()
      {
      if(isset($_SESSION['Agent_logged_in']))
      {
        $this->redirect($this->Root().'agent/Dashboard/dashboard.php');
      }
    }

    public function Check_Admin_Status()
    {
      if(isset($_SESSION['Admin_Status']) && $_SESSION['Admin_Status'] !="SUPER")
      {
        return true;
      }
    }

    public function Check_Admin_Status_Super()
    {
      if(isset($_SESSION['Admin_Status']) && $_SESSION['Admin_Status'] !="SUB")
      {
        return true;
      }
    }

    public function All_Order_Reciept($id,$wallet,$pay_amount)
    {
      $sql="SELECT tbl_product.P_Name,tbl_product.P_Selling_Price,order_footer.Qty,IFNULL(tbl_product.P_Selling_Price*order_footer.Qty,0)total FROM `tbl_payment` INNER JOIN order_footer ON order_footer.H_Id=tbl_payment.H_Id INNER JOIN tbl_product ON tbl_product.P_Id=order_footer.P_Id WHERE tbl_payment.Payment_Id='$id'";
     $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
          $total =0;
          $count=1;
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<div class="text-95 text-secondary-d3">
                        <div class="row mb-2 mb-sm-0 py-25">
                            <div class="d-none d-sm-block col-1">'.$count.'</div>
                            <div class="col-9 col-sm-5">'.$fetch['P_Name'].'</div>
                            <div class="d-none d-sm-block col-2"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_Selling_Price'].'</div>
                            <div class="d-none d-sm-block col-2">'.$fetch['Qty'].'</div>
                            
                            <div class="col-2 text-secondary-d2"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_Selling_Price']*$fetch['Qty'].'</div>
                        </div>

                 
                    </div>

                   ';
          $count++;
          $total +=$fetch['P_Selling_Price']*$fetch['Qty'];
        }
      $output.=' <div class="row border-b-2 brc-default-l2"></div>

                    <div class="row mt-3">
                        <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                            <!-- Extra note such as company or payment information... -->
                        </div>

                        <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    SubTotal :
                                </div>
                                <div class="col-5">
                                    <span class="text-120 text-secondary-d1"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$total.'</span>
                                </div>
                            </div>';
                            if($wallet !='No')
                            {
                              $output.='<div class="row my-2">
                                <div class="col-7 text-right">
                                   Add Wallet :
                                </div>
                                <div class="col-5">
                                    <span class="text-110 text-secondary-d1"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$wallet.'</span>
                                </div>
                            </div>';
                            }
                            else
                            {
                              $output.='<div class="row my-2">
                                <div class="col-7 text-right">
                                   Not Add Wallet : 
                                </div>
                                <div class="col-5">
                                    <span class="text-110 text-secondary-d1"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;0.00</span>
                                </div>
                            </div>';
                            }

                            
                          $output.='
                            <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                <div class="col-7 text-right">
                                    Total Amount
                                </div>
                                <div class="col-5">
                                    <span class="text-150 text-success-d3 opacity-2"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$pay_amount.'</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    
                </div>
            </div>
        </div>'; 
      return $output;
       }
    }


    public function All_Menu1_Digis()
    {
      $sql ="SELECT `Digis_Id`,SUBSTRING(Digis_Name,1,15)Digis_subname,Digis_Name FROM `tbl_digis` WHERE  `Digis_Status` !=0 AND Digis_Menu='Menu-1' ORDER BY Digis_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['Digis_subname'].'" data-id="'.$fetch['Digis_Id'].'" data-name="'.$fetch['Digis_Name'].'" class="Click_Button_for_Presc" data-type="digis" style="width:100%; color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }

    public function All_Menu2_Digis()
    {
      $sql ="SELECT `Digis_Id`,SUBSTRING(Digis_Name,1,15)Digis_subname,Digis_Name FROM `tbl_digis` WHERE  `Digis_Status` !=0 AND Digis_Menu='Menu-2' ORDER BY Digis_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['Digis_subname'].'" data-id="'.$fetch['Digis_Id'].'" data-name="'.$fetch['Digis_Name'].'" class="Click_Button_for_Presc" data-type="digis" style="width:100%; color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }

    public function All_Advice()
    {
      $sql ="SELECT `Advice_Id`, SUBSTRING(Advice_Details,1,20)Advice_subdetails,Advice_Details FROM `tbl_advice` WHERE Advice_Status !=0 ORDER BY Advice_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['Advice_subdetails'].'" data-name="'.$fetch['Advice_Details'].'" data-id="'.$fetch['Advice_Id'].'" class="Click_Button_for_Presc" data-type="advice" style="width:100%; color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }

    public function All_Tablet()
    {
      $sql ="SELECT `M_Id`,SUBSTRING(M_Name,1,15)M_subname,M_Name FROM `tbl_medicine_master` WHERE `M_Menu`='Menu-1' AND `M_Status` !=0 ORDER BY M_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['M_subname'].'" data-name="'.$fetch['M_Name'].'" data-id="'.$fetch['M_Id'].'" class="Click_Button_for_Presc" data-type="medicine"  style="width:100%; color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }

    public function All_Syrup()
    {
      $sql ="SELECT `M_Id`,SUBSTRING(M_Name,1,15)M_subname,M_Name FROM `tbl_medicine_master` WHERE `M_Menu`='Menu-2' AND `M_Status` !=0 ORDER BY M_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['M_subname'].'"  data-name="'.$fetch['M_Name'].'" data-id="'.$fetch['M_Id'].'" class="Click_Button_for_Presc" data-type="medicine" style="width:100%; color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }

    public function All_Others()
    {
      $sql ="SELECT `M_Id`,SUBSTRING(M_Name,1,15)M_subname,M_Name FROM `tbl_medicine_master` WHERE `M_Menu`='Menu-3' AND `M_Status` !=0 ORDER BY M_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['M_subname'].'"  data-name="'.$fetch['M_Name'].'" data-id="'.$fetch['M_Id'].'" class="Click_Button_for_Presc" data-type="medicine" style="width:100%; color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }

    public function All_Test()
    {
      $sql ="SELECT `Test_Id`, `Test_Name` FROM `tbl_test` WHERE `Test_Status` !=0 ORDER BY Test_Code ASC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<input type="button" name="submit" value="'.$fetch['Test_Name'].'" data-name="'.$fetch['Test_Name'].'" data-id="'.$fetch['Test_Id'].'" class="Click_Button_for_Presc" data-type="test" style=" color:white;background-color:black; border:1px solid green;">';
               } 
        return $output;
       }
    }


    public function All_Patient_Details($id)
    {
      $sql ="SELECT `Patient_Id`, `Patient_Name`,Patient_Age, `Patient_Gender`, `Patient_Height`, `Patient_Weight`,`Patient_Contact` FROM `tbl_patient_details` WHERE Patient_Visit_Status !='0' AND Patient_Id='$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                $explode = explode('-',$fetch['Patient_Age']);
                $age = $explode[0].'&nbsp;&nbsp;Year&nbsp;&nbsp;'.$explode[1].'&nbsp;&nbsp;Month&nbsp;&nbsp;'.$explode[2].'&nbsp;&nbsp;Days';
                  $output .= '
                  <b>Name :'.$fetch['Patient_Name'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Age : '.$age.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Height : '.$fetch['Patient_Height'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  Weight : '.$fetch['Patient_Weight'].'
                  ';
               } 
        return $output;
       }
    }

    public function All_Prescription_Diagnosis($id)
    {
      $sql="SELECT `DG_Id`,`DG_Suggest`,Digis_Name FROM `tbl_digis_for_generate_prescription` INNER JOIN tbl_digis ON tbl_digis_for_generate_prescription.Digis_Id=tbl_digis.Digis_Id WHERE tbl_digis_for_generate_prescription.User_Id='$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
            $count = 1;
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<li style="font-size:13px;">'.$count.". ".$fetch['Digis_Name'].'-'.$fetch['DG_Suggest'].' &nbsp;<a href="javascript:void(0)" data-id="'.$fetch['DG_Id'].'" class="Delete_Prescription" data-type="digis"><i class="fas fa-times-circle"></i></a></li>';
                $count++;
               } 
        return $output;
       }

    }

    public function All_Prescription_Test($id)
    {
      $sql="SELECT TG_Id,TG_Suggest,tbl_test.Test_Name FROM tbl_test_for_generate_prescription INNER JOIN tbl_test ON tbl_test_for_generate_prescription.Test_Id=tbl_test.Test_Id WHERE tbl_test_for_generate_prescription.User_Id='$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
            $count = 1;
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<li style="font-size:13px;">'.$count.". ".$fetch['Test_Name'].'-'.$fetch['TG_Suggest'].' &nbsp;<a href="javascript:void(0)" data-id="'.$fetch['TG_Id'].'" class="Delete_Prescription" data-type="test"><i class="fas fa-times-circle"></i></a></li>';
                $count++;
               } 
        return $output;
       }
    }

    public function All_Prescription_Medicine($id)
    {
      
      $sql="SELECT `MG_Id`, `User_Id`, `MG_medicine`,`MG_Day`,tbl_medicine_master.M_Name,tbl_dosage_type.Dosage_Name,tbl_medicine_type.MT_Type FROM `tbl_medicine_for_generate_prescription` INNER JOIN tbl_medicine_master ON tbl_medicine_master.M_Id=tbl_medicine_for_generate_prescription.M_Id INNER JOIN tbl_dosage_type ON tbl_dosage_type.Dosage_Id=tbl_medicine_master.Dosage_Id INNER JOIN tbl_medicine_type ON tbl_medicine_type.MT_Id=tbl_medicine_master.MT_Id  WHERE tbl_medicine_for_generate_prescription.User_Id='$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
            $count =1;
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<li style="font-size:13px;">'.$count.". ".$fetch['M_Name'].'<br>&nbsp;&nbsp;&nbsp;&nbsp;'.$fetch['MG_medicine'].'-'.strtoupper($fetch['MT_Type']).','.$fetch['Dosage_Name'].'&nbsp;'.$fetch['MG_Day'].'- দিন<a href="javascript:void(0)" data-id="'.$fetch['MG_Id'].'" class="Delete_Prescription" data-type="medicine"><i class="fas fa-times-circle"></i></a></li><br>';
                $count++;
               } 
        $this->Global_count = $count;
        return $output;
       }
    }

    public function All_Prescription_Advice($id)
    {
      $sql="SELECT `AG_Id`, `AG_Suggest`,AM_Name,Qty,Day,tbl_advice.Advice_Details FROM `tbl_advice_for_generate_prescription` INNER JOIN tbl_advice ON tbl_advice_for_generate_prescription.Advice_Id=tbl_advice.Advice_Id LEFT JOIN tbl_advice_medicine ON tbl_advice_medicine.AM_ID=tbl_advice_for_generate_prescription.AM_ID WHERE tbl_advice_for_generate_prescription.User_Id='$id'";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
            $count = $this->Global_count;
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<li style="font-size:13px;">'.$count.". ".$fetch['Advice_Details'].'-'.$fetch['AG_Suggest'].'&nbsp;<a href="javascript:void(0)" data-id="'.$fetch['AG_Id'].'" class="Delete_Prescription" data-type="advice"><i class="fas fa-times-circle"></i></a></li><br>';
                $count++;
               } 
        return $output;
       }
    }

    // <br>'.$fetch['AM_Name'].'-'.$fetch['Qty'].'&nbsp;Quantity&nbsp;'.$fetch['Day'].'&nbsp;Days

    public function All_Active_Patient(){

      $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Contact` FROM `tbl_patient_details` WHERE  Patient_Id !='' AND Patient_Visit_Status !='0' AND Patient_Status !='1' ORDER BY Patient_Id DESC";
      $result = $this->conn->query($sql);
      if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<option value="'.$this->Current_URL().'?id='.$fetch['Patient_Id'].'">'.$fetch['Patient_Name'].'-'.$fetch['Patient_Contact'].'</option>';
               } 
        return $output;
       }
    }











}

/**
 * 
 */
class User extends Agent
{
  
  public function user_session_private()
    {
      if(!isset($_SESSION['User_logged_in']))
      {
        $this->redirect($this->Root().'index.php');
      }
    }
    // Login Session Checking
    public function user_login_session_Check()
      {
      if(isset($_SESSION['User_logged_in']))
      {
        $this->redirect($this->Root().'secure_user/user/home.php');
      }
    }

    public function All_Fetch_Category()
    {
    $sql = "SELECT `C_Id`, `C_Name`, `C_Image`, `C_Flag`, `C_Date` FROM `tbl_category` WHERE C_Flag !='0' ORDER BY C_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<div class="col-4">
                <div class="card catagory-card">
                  <div class="card-body"><a class="text-danger" href="sub-catagory.php?id='.base64_encode($fetch['C_Id']).'&name='.$fetch['C_Name'].'">
                    
                       <img src="../../image/'.$fetch['C_Image'].'" style="height:60px;">
                      <span class="text-center mt-2">'.$fetch['C_Name'].'</span></a></div>
                </div>
              </div>';
             } 
            return $output;
       }
    }


    public function All_Category_Display()
    {
      $sql = "SELECT `C_Id`, `C_Name`, `C_Image`, `C_Flag`, `C_Date` FROM `tbl_category` WHERE C_Flag !='0' ORDER BY C_Id Asc";
      $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<li><a class="text-light" href="sub-catagory.php?id='.base64_encode($fetch['C_Id']).'&name='.$fetch['C_Name'].'">'.$fetch['C_Name'].'</a></li>';
             } 
            return $output;
       }
    }

    public function All_Brand_Display()
    {
      $sql = "SELECT `B_Id`, `B_Name`, `B_Flag`, `B_Date` FROM `tbl_brand`ORDER BY B_Id Asc";
      $result = $this->conn->query($sql);
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<div class="form-check">
                    <input class="form-check-input brand_check" id="'.$fetch['B_Id'].'" type="checkbox" name="'.$fetch['B_Id'].'" value="'.$fetch['B_Id'].'">
                    <label class="form-check-label" for="'.$fetch['B_Id'].'">'.$fetch['B_Name'].'</label>
                  </div>';
               } 
            return $output;
         }
    }


    public function All_Flash_Product(){
       $sql = "SELECT `P_Id`, `P_Name`, `B_Id`,tbl_category.C_Image, `U_Id`, `P_MRP`,`P_Selling_Price`, `P_Flag` FROM `tbl_product` INNER JOIN tbl_category ON tbl_category.C_Id=tbl_product.C_Id WHERE tbl_product.P_Flag !=0  ORDER BY P_Id DESC LIMIT 0,10";

       $result = $this->conn->query($sql);
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  $output .= '<div class="card flash-sale-card">
                                <div class="card-body"><a href="single-product.php?id='.base64_encode($fetch['P_Id']).'"><img src="../../image/'.$fetch['C_Image'].'" alt="" style="height:65px;"><span class="product-title">'.$fetch['P_Name'].'</span>
                                    <p class="sale-price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_Selling_Price'].'<span class="real-price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_MRP'].'</span></p>
                                    <span class="progress-title">
                                      '.$this->Stock_Product($fetch['P_Id']).'
                                    </span>
                                  </a></div>
                              </div>';
               } 
              return $output;
         }

    }

  public function Stock_Product($p_id)
  {
    $sql = "SELECT `P_Id`, IFNULL(SUM(S_Qty),0)qty FROM `tbl_product_stock` WHERE P_Id='$p_id'";
     $result = $this->conn->query($sql);
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                 if($fetch['qty'] !=0)
                 {
                   $output .= '<span class="badge badge-success">In Stock</span>';
                 }
                 else
                 {
                  $output .= '<span class="badge badge-danger">Out off Stock</span>';
                 }
                  
               } 
              return $output;
         }
  }

  public function Stock_Product_Add_Btn($p_id)
  {
    $sql = "SELECT `P_Id`, IFNULL(SUM(S_Qty),0)qty FROM `tbl_product_stock` WHERE P_Id='$p_id'";
     $result = $this->conn->query($sql);
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                 if($fetch['qty'] !=0)
                 {
                   $output .= '<a class="btn btn-success Add_Cart btn-sm" href="javascript:void(0)" data-id='.$p_id.' title="Add to Cart"><i class="lni lni-plus"></i></a>';
                 }
                 else
                 {
                  $output .= '';
                 }
                  
               } 
              return $output;
         }
  }


  public function All_Product_Show($start,$limit,$id,$brand,$min,$max){
     
     $data ='';
     if($id !='0')
     {
      $data .= "AND tbl_category.C_Id='$id'";
     }
     if($brand !='0')
     {
      $data .= "AND tbl_product.B_Id IN($brand)";
     }
     if($min !='0' && $max !='0')
     {
      $data .= "AND tbl_product.P_Selling_Price BETWEEN '$min' AND '$max'";
     }
     
      $sql = "SELECT `P_Id`, `P_Name`, `B_Id`,tbl_category.C_Image, `U_Id`, `P_MRP`,`P_Selling_Price`, `P_Flag` FROM `tbl_product` INNER JOIN tbl_category ON tbl_category.C_Id=tbl_product.C_Id WHERE tbl_product.P_Flag !=0 ".$data." ORDER BY P_Id DESC LIMIT $start,$limit";
       $result = $this->conn->query($sql);
       $output='';
       if($result->num_rows>0)
       {
            $output='';
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  
                  $output .='<div class="col-6 col-md-4 col-lg-3">
                          <div class="card product-card">
                            <div class="card-body">
                              <a class="product-thumbnail d-block" href="single-product.php?id='.base64_encode($fetch['P_Id']).'"><img class="mb-2" src="../../image/'.$fetch['C_Image'].'" alt="" style="height:80px;"></a>
                              <a class="product-title d-block" href="single-product.php?id='.base64_encode($fetch['P_Id']).'">'.$fetch['P_Name'].'</a> 
                              <p class="sale-price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_Selling_Price'].'<span><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_MRP'].'</span></p>
                               '.$this->Stock_Product_Add_Btn($fetch['P_Id']).'
                              <span class="progress-title">
                                  '.$this->Stock_Product($fetch['P_Id']).'
                              </span>
                            </div>
                          </div>
                        </div>';
               } 

              
         }
         else
         {
           $output .='<h4 class="text-center">Not Found</h4>';
         }
      return $output;

  }


// Display Home Page
  public function All_Product_Show_Display_Home_Page($start,$limit){
  
      $sql = "SELECT `P_Id`, `P_Name`, `B_Id`,tbl_category.C_Image, `U_Id`, `P_MRP`,`P_Selling_Price`, `P_Flag` FROM `tbl_product` INNER JOIN tbl_category ON tbl_category.C_Id=tbl_product.C_Id WHERE tbl_product.P_Flag !=0 ORDER BY P_Id DESC LIMIT $start,$limit";
       $result = $this->conn->query($sql);
       $output='';
       if($result->num_rows>0)
       {
            
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  
                  $output .='<div class="col-6 col-md-4 col-lg-3">
                          <div class="card product-card">
                            <div class="card-body">
                              <a class="product-thumbnail d-block" href="single-product.php?id='.base64_encode($fetch['P_Id']).'"><img class="mb-2" src="../../image/'.$fetch['C_Image'].'" alt="" style="height:80px;"></a>
                              <a class="product-title d-block" href="single-product.php?id='.base64_encode($fetch['P_Id']).'">'.$fetch['P_Name'].'</a> 
                              <p class="sale-price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_Selling_Price'].'<span><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_MRP'].'</span></p>
                               '.$this->Stock_Product_Add_Btn($fetch['P_Id']).'
                              <span class="progress-title">
                                  '.$this->Stock_Product($fetch['P_Id']).'
                              </span>
                            </div>
                          </div>
                        </div>';
               
               }

            return $output; 

         }
      

  } 


 // Search Product

   public function All_Search_Product_Show($start,$limit,$query,$brand,$min,$max){
     
     $data ='';
     if($brand !='0')
     {
      $data .= "AND tbl_product.B_Id IN($brand)";
     }
     if($min !='0' && $max !='0')
     {
      $data .= "AND tbl_product.P_Selling_Price BETWEEN '$min' AND '$max'";
     }
     
      $sql = "SELECT `P_Id`, `P_Name`, `B_Id`,tbl_category.C_Image, `U_Id`, `P_MRP`,`P_Selling_Price`, `P_Flag` FROM `tbl_product` INNER JOIN tbl_category ON tbl_category.C_Id=tbl_product.C_Id WHERE tbl_product.P_Flag !=0 AND tbl_product.P_Name LIKE '%$query%' ".$data." ORDER BY P_Id DESC LIMIT $start,$limit";
      // soundex('$query')=soundex(tbl_product.P_Name)
       $result = $this->conn->query($sql);
       $output='';
       if($result->num_rows>0)
       {
            
              while($fetch = $result->fetch_array(MYSQLI_ASSOC))
               {
                  
                  $output .='<div class="col-6 col-md-4 col-lg-3">
                          <div class="card product-card">
                            <div class="card-body">
                              <a class="product-thumbnail d-block" href="single-product.php?id='.base64_encode($fetch['P_Id']).'"><img class="mb-2" src="../../image/'.$fetch['C_Image'].'" alt="" style="height:80px;"></a>
                              <a class="product-title d-block" href="single-product.php?id='.base64_encode($fetch['P_Id']).'">'.$fetch['P_Name'].'</a> 
                              <p class="sale-price"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_Selling_Price'].'<span><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$fetch['P_MRP'].'</span></p>
                               '.$this->Stock_Product_Add_Btn($fetch['P_Id']).'
                              <span class="progress-title">
                                  '.$this->Stock_Product($fetch['P_Id']).'
                              </span>
                            </div>
                          </div>
                        </div>';
               } 

             
         }
         else
         {
           $output .='<h4 class="text-center">Not Found<h4>';

         }
       return $output;

  } 









// OLD CODE ///////////////////////

  public function All_Category()
   {
    $sql = "SELECT `Cat_Id`, `Cat_Name`, `Cat_Created` FROM `tbl_category_master` ORDER BY Cat_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['Cat_Id'].'">'.ucwords($fetch['Cat_Name']).'</option>';
             } 
            return $output;
       }
    
  }

  public function All_Customer_name()
  {
    $sql = "SELECT `User_Id`, `User_Name` FROM `tbl_user_signup` ORDER BY User_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['User_Id'].'">'.ucwords($fetch['User_Name']).'</option>';
             } 
            return $output;
       }
  }

  public function All_Sub_Category()
   {
    $sql = "SELECT `Cat_Id`, `Cat_Name`, `Cat_Created` FROM `tbl_category_master`";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
              $query = "SELECT `Scat_Id`, `Cat_Id`, `Scat_Name`, `Scat_Created` FROM `tbl_sub_category_master` WHERE Cat_Id='$fetch[Cat_Id]'";
              $result1 = $this->conn->query($query);
              if($result1->num_rows>0)
              {
                while($fetch1 = $result1->fetch_array(MYSQLI_ASSOC))
                {
                  $output .= '<option value="'.$fetch1['Scat_Id'].'">'.ucwords($fetch1['Scat_Name']).'</option>';
                }
              }
              else
              {  
                $output .= '<option value="'.$fetch['Cat_Id'].'">'.ucwords($fetch['Cat_Name']).'</option>';
              }
             } 
        return $output;
       }
    
  }
  
  public function All_Item()
   {
    $sql = "SELECT `Item_Id`, `Item_Name` FROM `tbl_item_master` ORDER BY Item_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['Item_Id'].'">'.ucwords($fetch['Item_Name']).'</option>';
             } 
            return $output;
       }
    
  }

  public function All_Brand()
  {
    $sql = "SELECT `Brand_Id`, `Cat_Id`, `Brand_Name`, `Brand_Created` FROM `tbl_brand_master` ORDER BY Brand_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<li><a href="#">'.ucwords($fetch['Brand_Name']).'<i class="fas fa-chevron-down"></i></a></li>';
             } 
            return $output;
       }

  }

  public function All_Category_headerPage()
  {
    $sql = "SELECT `Cat_Id`, `Cat_Name`, `Cat_Created` FROM `tbl_category_master` ORDER BY Cat_Id Asc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
              $sql1 =  "SELECT `Scat_Id`, `Cat_Id`, `Scat_Name`, `Scat_Created` FROM `tbl_sub_category_master` WHERE Cat_Id='$fetch[Cat_Id]' ORDER BY Scat_Id Desc";
              $result1 = $this->conn->query($sql1);
              if($result1->num_rows>0)
              { 
               
                $output .=' <li class="menu-item-has-children"><a href="javascript:void(0)">'.$fetch['Cat_Name'].'</a>
                 <ul class="sub-menu" style="margin-right: 95%;">';


                while ($fetch1 = $result1->fetch_array(MYSQLI_ASSOC)) {

                  $output .='<li><a href="all_product.php?category='.base64_encode($fetch1['Scat_Id']).'&cname='.$fetch1['Scat_Name'].'">'.$fetch1['Scat_Name'].'</a></li>';

                }
                $output .='</ul>';
              }
              else
              {
                $output .='<li><a href="all_product.php?category='.base64_encode($fetch['Cat_Id']).'&cname='.$fetch1['Cat_Name'].'">'.$fetch['Cat_Name'].'</a></li>';
              }

             } 
        return $output;
       }
  }


 public function All_Category_()
  {
    $sql = "SELECT `Cat_Id`, `Cat_Name`, `Cat_Created` FROM `tbl_category_master` ORDER BY Cat_Id Desc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
              $sql1 =  "SELECT `Scat_Id`, `Cat_Id`, `Scat_Name`, `Scat_Created` FROM `tbl_sub_category_master` WHERE Cat_Id='$fetch[Cat_Id]' ORDER BY Scat_Id Desc";
              $result1 = $this->conn->query($sql1);
              if($result1->num_rows>0)
              { 
               
                $output .=' <li class="menu-item-has-children"><a href="javascript:void(0)">'.$fetch['Cat_Name'].'&nbsp;<i class="fas fa-angle-right"></i></a>
                 <ul class="sub-menu">';


                while ($fetch1 = $result1->fetch_array(MYSQLI_ASSOC)) {

                  $output .='<li><a href="all_product.php?category='.base64_encode($fetch1['Scat_Id']).'&cname='.$fetch1['Scat_Name'].'">'.$fetch1['Scat_Name'].'</a></li>';

                }
                $output .='</ul>';
              }
              else
              {
                $output .='<li><a href="all_product.php?category='.base64_encode($fetch['Cat_Id']).'&cname='.$fetch['Cat_Name'].'">'.$fetch['Cat_Name'].'</a></li>';
              }

             } 
        return $output;
       }
  }

// public function All_Sub_Category_headerPage($name,$id)
// {
//   $sql =  "SELECT `Scat_Id`, `Cat_Id`, `Scat_Name`, `Scat_Created` FROM `tbl_sub_category_master` WHERE Cat_Id='$id'";
//   $result = $this->conn->query($sql);
//      if($result->num_rows>0)
//      {
//            $output ='<li class="level1 nav-10-3"> <a href="grid_product_list.php"> <span>'.$name.'</span> </a> </li>
//               <ul class="level2">';
//             while($fetch = $result->fetch_array(MYSQLI_ASSOC))
//              {
//                 $output .= '
//                          <li class="level2 nav-2-1-1 first"><a href="grid_product_list.php"><span>'.ucwords($fetch['Scat_Name']).'</span></a></li>
//                         ';
//              } 
//             $output .=' 
//                     </ul>
//                   </li>';
//             return $output;
//       }
//       else
//       {
//         return false;
//       }
// }

               // $output .='
               //   <div class="owl-item deals_item">
               //    <div class="deals_image"><img src="item_images/'.$fetch['Image'].'" alt="" height="180px" width="50px"></div>
               //    <div class="deals_content">
               //      <div class="deals_info_line d-flex flex-row justify-content-start">
               //        <div class="deals_item_category"><a href="#">'.$fetch['Scat_Name'].'</a></div>
               //        <div class="deals_item_price_a ml-auto">₹'.$fetch['Item_Rate'].'</div>
               //      </div>
               //      <div class="deals_info_line d-flex flex-row justify-content-start">
               //        <div class="deals_item_name">'.$fetch['Item_Name'].'</div>
               //        <div class="deals_item_price ml-auto">₹'.$fetch['Item_Rate'].'</div>
               //      </div>
               //    </div>
               //  </div>
               // ';
public function Our_Best_Product()
{
  // $sql = "SELECT `Item_Code`, tbl_sub_category_master.Scat_Id, tbl_sub_category_master.Scat_Name, `Item_Name`, `Item_Rate`, `Item_Body_Type`,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` INNER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc";
  $sql ="SELECT `Item_Code`,Item_Feature_position, IF(tbl_sub_category_master.Scat_Name !='',tbl_sub_category_master.Scat_Name,tbl_category_master.Cat_Name) AS Scat_Name,IF(tbl_sub_category_master.Scat_Id !='',tbl_sub_category_master.Scat_Id,tbl_category_master.Cat_Id) AS Scat_Id, `Item_Name`, `Item_Rate`, `Item_Body_Type`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` LEFT OUTER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id LEFT OUTER JOIN tbl_category_master ON tbl_category_master.Cat_Id=tbl_item_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE tbl_item_master.Item_Best_Seller_Position='Yes' AND tbl_product_image.Image_Type='Font_Image' GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc ";
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
              $output .='<div class="item">
            <div class="item-inner">
              <div class="item-img">
                <div class="item-img-info"> <a class="product-image" title="'.$fetch['Item_Name'].'" href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&name='.base64_encode($fetch['Item_Name']).'&category='.base64_encode($fetch['Scat_Id']).'"> <img alt="'.$fetch['Item_Name'].'" src="item_images/'.$fetch['Image'].'" height=400px> </a>
                     <div class="actions">
                    <div class="add_cart">
                       '.$this->Stock_Item_Check($fetch['Item_Id']).'
                    </div>
                  </div>
                  <div class="rating">
                    <div class="ratings">
                      <div class="rating-box">
                        <div style="width:80%" class="rating"></div>
                      </div>
                      <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item-info">
                <div class="info-inner">
                  <div class="item-title"> <a title="'.$fetch['Item_Name'].'" href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'">'.$fetch['Item_Name'].'</a> </div>
                  <div class="item-content">
                    <div class="item-price">
                      <div class="price-box"> <span class="regular-price"> <span class="price"><i class="fa fa-inr" aria-hidden="true"></i>'.$fetch['Selling_price'].'';
                    if($fetch['Item_Discount'] !=0)
                    {
                      $output .='</span> </span><span>₹ <del>'.$fetch['Item_Rate'].'</del></span>';
                    }
                       
                       
                   $output.='</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>';
             } 
            return $output;
       }
}


public function Stock_Item_Check($item_id)
{
  $sql = "SELECT 
  tbla.Item_Name, sum(tbla.sale) as sale,sum(tbla.Purchase)as Purchase,(sum(tbla.Purchase)-sum(tbla.sale)) as Stock 
  from
  (SELECT IFNULL(SUM(tbl_sale_details.Sd_Qty),0) as sale,0 as Purchase,
tbl_item_master.Item_Name FROM tbl_sale_details INNER JOIN tbl_item_master ON tbl_item_master.Item_Id=tbl_sale_details.Item_Id WHERE tbl_item_master.Item_Id='$item_id'
  group by tbl_item_master.Item_Name
UNION ALL
SELECT 0 as sale,IFNULL(SUM(Upload_Qty),0) as Purchase,
  tbl_item_master.Item_Name FROM tbl_upload_stock INNER JOIN tbl_item_master ON tbl_item_master.Item_Id=tbl_upload_stock.Item_Id  WHERE tbl_upload_stock.Item_Id='$item_id'
   group by tbl_item_master.Item_Name ) as tbla group by tbla.Item_Name";

  $result = $this->conn->query($sql);
  $output ='';
  if($result->num_rows>0)
   {  
      
      while($fetch = $result->fetch_array(MYSQLI_ASSOC))
        {
           if($fetch['Stock'] !="0")
           {
            // $output .='<button class="button btn-cart product_cart_button Add_Cart" type="button" data-toggle="tooltip" data-placement="right" title="" data-original-title="Add to Cart" data-id="'.$item_id.'"><span>Add to Cart</span></button>';

            $output .='<a class="button product_cart_button Add_Cart" data-toggle="tooltip" data-placement="right" data-original-title="Add to Cart" title="Add to Cart" data-id="'.$item_id.'">Add to Cart</a>';
           }
           else
           {
              $output .='<span class="text-danger font-weight-bold">Sold Out</span>';
           }
        }

      
   }
   else
   {
      $output .='<span class="text-danger font-weight-bold">Out of Stock</span>';
   }

  return $output;
}

public function Tab_Our_Best_Product($start,$limit)
{
  // $sql = "SELECT `Item_Code`, tbl_sub_category_master.Scat_Id, tbl_sub_category_master.Scat_Name, `Item_Name`, `Item_Rate`, `Item_Body_Type`,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` INNER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc";
  //$sql ="SELECT `Item_Code`,Item_Feature_position, IF(tbl_sub_category_master.Scat_Name !='',tbl_sub_category_master.Scat_Name,tbl_category_master.Cat_Name) AS Scat_Name,IF(tbl_sub_category_master.Scat_Id !='',tbl_sub_category_master.Scat_Id,tbl_category_master.Cat_Id) AS Scat_Id, `Item_Name`, `Item_Rate`, `Item_Body_Type`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` LEFT OUTER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id LEFT OUTER JOIN tbl_category_master ON tbl_category_master.Cat_Id=tbl_item_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE  tbl_product_image.Image_Type='Font_Image' GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc LIMIT $start,$limit";

  $sql = "SELECT `Item_Code`,Item_Feature_position, IF(tbl_sub_category_master.Scat_Name !='',tbl_sub_category_master.Scat_Name,tbl_category_master.Cat_Name) AS Scat_Name,IF(tbl_sub_category_master.Scat_Id !='',tbl_sub_category_master.Scat_Id,tbl_category_master.Cat_Id) AS Scat_Id, `Item_Name`, `Item_Rate`, `Item_Body_Type`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` LEFT OUTER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id LEFT OUTER JOIN tbl_category_master ON tbl_category_master.Cat_Id=tbl_item_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE  tbl_product_image.Image_Type='Font_Image' AND (tbl_item_master.Scat_Id=19 || tbl_item_master.Scat_Id=24 || tbl_item_master.Scat_Id=25 || tbl_item_master.Scat_Id=26 || tbl_item_master.Scat_Id=27) GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Desc LIMIT $start,$limit";

  // tbl_item_master.Item_Best_Seller_Position='Yes' AND
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
          $class_name = 'wide-first';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
              
              $output .='
                   <li class="product-item">
                      <div class="product-inner">
                        <div class="product-thumb has-back-image">
                          <a href="product_details.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'" title="'.$fetch['Item_Name'].'"><img src="item_images/'.$fetch['Image'].'" height="400px" alt="'.$fetch['Item_Name'].'"></a>
                          
                        </div>
                        <div class="product-info">
                          <h3 class="product-name"><a href="product_details.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'">'.$fetch['Item_Name'].'</a></h3>
                          <span class="price">
                              <ins class="price-new"><i class="fas fa-rupee-sign"></i>&nbsp;'.$fetch['Selling_price'].'</ins>';
                              if($fetch['Item_Discount'] !=0)
                              {
                                $output .='<del class="price-old"><i class="fas fa-rupee-sign"></i>&nbsp;'.$fetch['Item_Rate'].'</del>';
                              }   
                        $output .='</span>
                          '.$this->Stock_Item_Check($fetch['Item_Id']).'
                        </div>
                      </div>
                    </li>';
                    
                  // <a onclick="cart.add('42', '1');" class="button">Add to Cart</a>
                   // <div class="gorup-button">
                   //          <a class="wishlist" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('42');"><i class="fa fa-heart"></i></a>
                   //          <a class="compare" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('42');"><i class="fa fa-exchange"></i></a>
                   //        </div> 
              
             }
            
            return $output;
       }
}

public function All_Feature_Product_headerPage($start,$limit)
{
  $sql ="SELECT `Item_Code`,Item_Feature_position, IF(tbl_sub_category_master.Scat_Name !='',tbl_sub_category_master.Scat_Name,tbl_category_master.Cat_Name) AS Scat_Name,IF(tbl_sub_category_master.Scat_Id !='',tbl_sub_category_master.Scat_Id,tbl_category_master.Cat_Id) AS Scat_Id, `Item_Name`, `Item_Rate`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price, `Item_Body_Type`,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` LEFT OUTER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id LEFT OUTER JOIN tbl_category_master ON tbl_category_master.Cat_Id=tbl_item_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE tbl_product_image.Image_Type='Font_Image' AND tbl_item_master.Scat_Id=18 GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Desc LIMIT $start,$limit";
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
          $class_name = 'wide-first';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                
              $output .='
                   <li class="product-item">
                      <div class="product-inner">
                        <div class="product-thumb has-back-image">
                          <a href="product_details.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'" title="'.$fetch['Item_Name'].'"><img src="item_images/'.$fetch['Image'].'" height="400px" alt="'.$fetch['Item_Name'].'"></a>
                          
                        </div>
                        <div class="product-info">
                          <h3 class="product-name"><a href="product_details.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'">'.$fetch['Item_Name'].'</a></h3>
                          <span class="price">
                              <ins class="price-new"><i class="fas fa-rupee-sign"></i>&nbsp;'.$fetch['Selling_price'].'</ins>';
                              if($fetch['Item_Discount'] !=0)
                              {
                                $output .='<del class="price-old"><i class="fas fa-rupee-sign"></i>&nbsp;'.$fetch['Item_Rate'].'</del>';
                              }   
                        $output .='</span>
                          '.$this->Stock_Item_Check($fetch['Item_Id']).'
                        </div>
                      </div>
                    </li>';
                    
                  // <a onclick="cart.add('42', '1');" class="button">Add to Cart</a>
                   // <div class="gorup-button">
                   //          <a class="wishlist" data-toggle="tooltip" title="Add to Wish List" onclick="wishlist.add('42');"><i class="fa fa-heart"></i></a>
                   //          <a class="compare" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('42');"><i class="fa fa-exchange"></i></a>
                   //        </div> 
             } 
            return $output;
       }

}


public function All_New_Arrival_Product_headerPage($start,$limit)
{
  $sql ="SELECT `Item_Code`,Item_Feature_position,  IF(tbl_sub_category_master.Scat_Name !='',tbl_sub_category_master.Scat_Name,tbl_category_master.Cat_Name) AS Scat_Name,IF(tbl_sub_category_master.Scat_Id !='',tbl_sub_category_master.Scat_Id,tbl_category_master.Cat_Id) AS Scat_Id, `Item_Name`, `Item_Rate`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,`Item_Body_Type`,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master`LEFT OUTER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id LEFT OUTER JOIN tbl_category_master ON tbl_category_master.Cat_Id=tbl_item_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE tbl_item_master.Item_New_Arrival_Position='Yes' AND tbl_product_image.Image_Type='Font_Image' GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc LIMIT $start,$limit";
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
          $class_name = 'wide-first';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                
               $output .='<li class="item item-animate '.$class_name.'">
                            <div class="item-inner">
                              <div class="item-img">
                                <div class="item-img-info"><a href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'" title="'.$fetch['Item_Name'].'"  class="product-image"><img alt="'.$fetch['Item_Name'].'" src="item_images/'.$fetch['Image'].'" class="image_class"></a>
                       
                                  <div class="actions">
                                  
                                    <div class="add_cart">
                                      '.$this->Stock_Item_Check($fetch['Item_Id']).'
                                    </div>
                                  </div>
                                  <div class="rating">
                                    <div class="ratings">
                                      <div class="rating-box">
                                        <div class="rating" style="width:80%"></div>
                                      </div>
                                      <p class="rating-links"><a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="item-info">
                                <div class="info-inner">
                                  <div class="item-title"><a href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'" title="Retis lapen casen">'.$fetch['Item_Name'].'</a> </div>
                                  <div class="item-content">
                                    <div class="price-box"><span class="regular-price"><span class="price"><i class="fa fa-inr" aria-hidden="true"></i>'.$fetch['Selling_price'].'</span>';
                                    if($fetch['Item_Discount'] !=0)
                                    {
                                      $output .='</span> </span><span>₹ <del>'.$fetch['Item_Rate'].'</del></span>';
                                    }
                                    $output .='</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>';
              $class_name ='';
             } 
            return $output;
       }

}

public function All_Best_Seller_Product_headerPage()
{
  $sql ="SELECT `Item_Code`,Item_Feature_position, tbl_sub_category_master.Scat_Id,tbl_sub_category_master.Scat_Name, `Item_Name`, `Item_Rate`, `Item_Body_Type`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` INNER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE tbl_item_master.Item_Best_Seller_Position='Yes' AND tbl_product_image.Image_Type='Font_Image' GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc";
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                
               $output .='
                 <div class="bestsellers_item discount">
                  <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">
                    <div class="bestsellers_image"><img src="item_images/
                    '.$fetch['Image'].'" alt=""></div>
                    <div class="bestsellers_content">
                      <div class="bestsellers_category"><a href="#">
                      '.$fetch['Scat_Name'].'</a></div>
                      <div class="bestsellers_name"><a href="product.html">
                      '.$fetch['Item_Name'].'</a></div>
                      <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>';
                     // $discount = round($fetch['Item_Rate']-$fetch['discount_price']);
                      $output .= '<div class="bestsellers_price discount">₹'.$fetch['Selling_price'].'<span>₹ <del>'.$fetch['Item_Rate'].'</del></span></div>';
                      // <div class="bestsellers_price discount">₹'.$fetch['Item_Rate'].'<span>₹'.
                      // $fetch['Item_Rate'].'</span></div>
                  $output.='
                    </div>
                  </div>
                  <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>
                  <ul class="bestsellers_marks">
                  ';
                  if($fetch['Item_Discount'] !='' && $fetch['Item_Discount'] !=0)
                      {
                        $output .='<li class="bestsellers_mark bestsellers_discount">'.$fetch['Item_Discount'].'%</li>';
                      }
                      else
                      {
                        $output .='';
                      }
                  $output .='
                    <li class="bestsellers_mark bestsellers_new">new</li>
                  </ul>
                </div>
               ';
             } 
            return $output;
       }

}

public function Recently_View_headerPage()
{
  $sql ="SELECT `Item_Code`,Item_Feature_position, tbl_sub_category_master.Scat_Id, `Item_Name`, `Item_Rate`, `Item_Body_Type`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` INNER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id GROUP BY tbl_product_image.Item_Id ORDER BY tbl_item_master.Item_Id Asc";
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                
               $output .='
                 <div class="owl-item">
                <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                  <div class="viewed_image"><img src="item_images/'.$fetch['Image'].'" alt="" height="100px"></div>
                  <div class="viewed_content text-center">';
                 
                  //$discount = round($fetch['Item_Rate']-$fetch['discount_price']);
                  $output .= '<div class="viewed_price">₹'.$fetch['Selling_price'].'<span>₹'.$fetch['Item_Rate'].'</span></div>';
                $output.='
                    <div class="viewed_name"><a href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'">'.$fetch['Item_Name'].'</a></div>
                  </div>
                  <ul class="item_marks">';
                  if($fetch['Item_Discount'] !='' && $fetch['Item_Discount'] !=0)
                  {
                    $output .='<li class="item_mark item_discount">'.$fetch['Item_Discount'].'%</li>';
                  }
                  else{
                    $output .='';
                  }
                $output .='
                   
                  </ul>
                </div>
              </div>
               ';
             } 
            return $output;
       }
}

public function All_Related_Product($category_id)
{
  $sql ="SELECT `Item_Code`,Item_Feature_position, tbl_sub_category_master.Scat_Id,tbl_sub_category_master.Scat_Name, `Item_Name`, `Item_Rate`, `Item_Body_Type`,Item_Discount,(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100) AS discount_price,ROUND((tbl_item_master.Item_Rate-(tbl_item_master.Item_Rate*tbl_item_master.Item_Discount/100)),2) AS Selling_price,tbl_product_image.Image,tbl_product_image.Item_Id FROM `tbl_item_master` INNER JOIN tbl_sub_category_master ON tbl_item_master.Scat_Id=tbl_sub_category_master.Scat_Id INNER JOIN tbl_product_image ON tbl_item_master.Item_Id=tbl_product_image.Item_Id WHERE tbl_item_master.Scat_Id='$category_id' GROUP BY tbl_product_image.Item_Id";
  $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .='<div class="item">
              <div class="item-inner">
                <div class="item-img">
                  <div class="item-img-info"><a href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'" title="'.$fetch['Item_Name'].'" class="product-image"><img src="item_images/'.$fetch['Image'].'" alt="'.$fetch['Item_Name'].'" height="250px"></a> 
                    <div class="actions">
                      <div class="add_cart">
                       '.$this->Stock_Item_Check($fetch['Item_Id']).'
                      </div>
                    </div>
                    <div class="rating">
                      <div class="ratings">
                        <div class="rating-box">
                          <div class="rating" style="width:80%"></div>
                        </div>
                        <p class="rating-links"><a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="item-info">
                  <div class="info-inner">
                    <div class="item-title"><a href="product_detail.php?id='.base64_encode($fetch['Item_Id']).'&category='.base64_encode($fetch['Scat_Id']).'&name='.base64_encode($fetch['Item_Name']).'" title="Retis lapen casen">'.$fetch['Item_Name'].'</a> </div>
                    <div class="item-content">
                      <div class="item-price">
                         <div class="price-box"><span class="regular-price"><span class="price"><i class="fa fa-inr" aria-hidden="true"></i>'.$fetch['Selling_price'].'</span>';
                          if($fetch['Item_Discount'] !=0)
                          {
                           $output .='</span> </span><span>₹ <del>'.$fetch['Item_Rate'].'</del></span>';
                          }
                      $output .='</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
        }
      return $output;
     }
}

public function Total_Page($sql,$value)
{
   $result = $this->conn->query($sql);
   if($row = $result->num_rows)
    {
       $total_page= ceil($row/$value);
       return $total_page;
    }
    else
    {
      return 0;
    }

}

public function Count_SizeWise_Product($category,$size)
{
  $sql = "SELECT `Item_Id`, `Scat_Id` , `Item_Size` FROM `tbl_item_master` WHERE Scat_Id='$category' AND Item_Size='$size'";
  $result = $this->conn->query($sql);
  if($row = $result->num_rows)
    {
       return $row;
    }
  else
  {
     return 0;
  }
}

public function All_Review_Item_Wise_Show($item_id)
{
  $sql = "SELECT `R_Id`, `R_Name`, `R_Desc`, `R_Rating`, `R_Item_Id`, `R_Added_Date` FROM `tbl_product_review` WHERE R_Item_Id='$item_id'";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
               switch ($fetch['R_Rating']) {
                 case '1':
                  $rating = "Good";
                   break;
                case '2':
                  $rating = "Very Good";
                   break;
                case '3':
                  $rating = "Excellent";
                   break;
                case '4':
                  $rating = "Amazing";
                   break;
                 
                 default:
                  $rating = "Nicely";
                   break;
               }
                $output .= '<div class="review">
                                <h6><a href="#">'.$rating.'</a></h6>
                                <small>Review by <span> '.$fetch['R_Name'].' </span>on '.$fetch['R_Added_Date'].' </small>
                                <div class="review-txt"> '.$fetch['R_Desc'].' .</div>
                              </div>';
             } 
            return $output;
       }
}

public function All_Review_Count_Item_Wise_Show($item_id)
{
  $sql = "SELECT `R_Id`, `R_Name`, `R_Desc`, `R_Rating`, `R_Item_Id`, `R_Added_Date` FROM `tbl_product_review` WHERE R_Item_Id='$item_id'";
    $result = $this->conn->query($sql);
     if($row = $result->num_rows)
     {
      return $row;
     }
     else
     {
       return 0;
     }
}
public function Font_Images($id)
{
   $sql = "SELECT `lmage_Id`, `Item_Id`, `Image`, `Image_Type` FROM `tbl_product_image` WHERE  Item_Id='$id' AND Image_Type='Font_Image'";
   $result = $this->conn->query($sql);
   if($result->num_rows>0)
     {
       $output ='';
       while ($fetch = $result->fetch_array(MYSQLI_ASSOC)) {
          $output.=$fetch['Image'];
       }
    return $output;
     }
}

public function Banner_Image()
{
   $sql = "SELECT `Banner_Image` FROM `tbl_banner_image`";
   $result = $this->conn->query($sql);
   if($result->num_rows>0)
     {
       $output ='';
       while ($fetch = $result->fetch_array(MYSQLI_ASSOC)) {
          $output.='<img src="item_images/'.$fetch['Banner_Image'].'" class="img-responsive banner">';
       }
    return $output;
     }
}


 public function All_Status()
   {
    $sql = "SELECT `Status_Id`, `Status_Name` FROM `tbl_sale_status` ORDER BY Status_Id Desc";
    $result = $this->conn->query($sql);
     if($result->num_rows>0)
     {
          $output='';
            while($fetch = $result->fetch_array(MYSQLI_ASSOC))
             {
                $output .= '<option value="'.$fetch['Status_Id'].'">'.ucwords($fetch['Status_Name']).'</option>';
             } 
            return $output;
       }
    
  }

  

// End Class
}


?>