<?php
require_once("../../db_connect/db_connect.php");
require_once("../../class/class.php");
$server= new Main_Classes;
$server->admin_session_private();
if(isset($_POST['export']) && !empty($_POST['id']))
{
  $id =  $_POST['id'];
  //$id = str_replace(' ',',',$id);
  $sql = "SELECT tbl_product.P_Id,`S_Id`,`P_Name`,`P_Batch_No`,`P_HSN_No`,`P_Purchase_Price`,IFNULL(SUM(tbl_product_stock.S_Qty),0) as Qty,IFNULL(SUM(tbl_product_stock.S_Qty),0) as Qty,IFNULL(SUM(tbl_product_stock.S_Qty),0)*tbl_product.P_Purchase_Price as total, DATE_FORMAT(S_Date,'%d-%m-%Y %h:%i')S_Date FROM `tbl_product_stock` INNER JOIN tbl_product ON tbl_product.P_Id= tbl_product_stock.P_Id WHERE tbl_product.P_Id IN($id) GROUP BY tbl_product_stock.P_Id";

	if($row =$server->All_Record($sql))
    {
    	if($row>0)
    	{
    	  $data='';
    	  $data .='<table class="table" border="1">
         <tr>
            <th>Sl. No</th>
            <th>Medicine</th>
            <th>BatchNo</th>
            <th>HSN Code</th>
            <th>Purchase Price</th>
            <th>Qty</th>
            <th>Total Price</th>
            <th>Date</th>          
         </tr>
    	';
    	$count = 1;
    	foreach ($server->View_details as $value) {
    		
    		$data.='
              <tr>
               <td>'.$count.'</td>
               <td>'.$value['P_Name'].'</td>
               <td>'.$value['P_Batch_No'].'</td>
               <td>'.$value['P_HSN_No'].'</td>
               <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$value['P_Purchase_Price'].'</td>
               <td>'.$value['Qty'].'</td>
               <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;'.$value['total'].'</td>
               <td>'.$value['S_Date'].'</td>
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
    	    header("location:display_stock.php");
    	}

    	
    }
    else
    {
        echo "<script>alert('Record not found')</script>";
        header("location:display_stock.php");
    } 

  }
  else
  {
     echo "<script>alert('Not Select Any Record')</script>";
     echo "<script>window.location='display_stock.php'</script>";
     // header("location:display_patient.php");
  }  

?>