<?php 
require ('../../config.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include "../inc/header.php" ?>
<body>
<?php
$type = isset($_GET['type']) ? $_GET['type'] : 1 ;
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `invoice_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
$tax_rate = isset($tax_rate) ? $tax_rate : $_settings->info('tax_rate');
$sgst_rate = isset($_SESSION['system_info']['sgst_rate']) ? $_SESSION['system_info']['sgst_rate'] : 5;
$cgst_rate = isset($_SESSION['system_info']['cgst_rate']) ? $_SESSION['system_info']['cgst_rate'] : 5;
$first_name = isset($_SESSION['userdata']['firstname']) ? $_SESSION['userdata']['firstname'] : 'NA';
$last_name = isset($_SESSION['userdata']['lastname']) ? $_SESSION['userdata']['lastname'] : 'NA';

?>

<div class="row">
	<div class="col-md-6">
	<!-- <img src="../../uploads/sfp_logo.png" alt="" width="250" height="250"> -->
	<!-- <h3 > Tax Invoice </h3> -->
	</div>
	<div class="col-md-6">

	</div>
</div>
<div class="row">
	<div class="col-md-3">
	<!-- <img src="../../uploads/sfp_logo.png" alt="" width="250" height="250"> -->
  <?php if ($doc_type == "order"): ?>
    <h2>Order Details</h2>
    <h5>Order Id: <?php echo $invoice_code ?></h5>
    <h4>Status: <?php echo $status ?></h4>
<?php else: ?>
    <h3 style="margin-top: 45%">Tax Invoice</h3>
<?php endif; ?>
	
	</div>
	<div class="col-md-3">
	
	</div>
	<div class="col-md-3">
	
	</div>
	<div class="col-md-3">
	<img src="../../uploads/sfp_logo.png" alt="" width="250" height="250" style="margin-top: -45px">
	</div>
</div>



<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:7px 20px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:7px 20px;word-break:normal;}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-fymr{border-color:inherit;font-weight:bold;text-align:left;vertical-align:top}
.tg .tg-7btt{border-color:inherit;font-weight:bold;text-align:center;vertical-align:top}
.tg .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 989px">
<colgroup>
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 126px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 92px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 94px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 61px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 160px">
<col style="width: 25px">
<col style="width: 25px">
<col style="width: 20px">
<col style="width: 25px">
<col style="width: 36px">
</colgroup>
<thead>
  <tr>
  <?php if ($doc_type == "order"): ?>
    
    <?php else: ?>
    <th class="tg-0pky" colspan="9" rowspan="4"><span style="font-weight:bold">Invoice From: </span><br><br>Sankalp Food Products,<br><br>Shivri, Saswad, Purandhar, Pune - 412301<br><br>+91 8999166623 <br><br><a href="mailto:accounts@sankalpfoodproducts.com" style="text-decoration: none; color: black">accounts@sankalpfoodproducts.com</a><br><br>sfpgstin<br><br><br></th>
    <?php endif; ?>

    <?php if ($doc_type == "order"): ?>
      <th class="tg-0pky" colspan="9" rowspan="4"><span style="font-weight:bold">Order To: </span><br><br><?php echo $customer_name ?><br><br><?php echo $customer_address ?><br><br>+91&nbsp;<?php echo $customer_mobile ?><br><br><a href="mailto:<?php $customer_email ?>" style="text-decoration: none; color: black"><?php echo $customer_email ?></a><br><br>GSTIN (if any): <?php echo $customer_gstin ?></th>
    <?php else: ?>
      <th class="tg-0pky" colspan="9" rowspan="4"><span style="font-weight:bold">Invoice To: </span><br><br><?php echo $customer_name ?><br><br><?php echo $customer_address ?><br><br>+91&nbsp;<?php echo $customer_mobile ?><br><br><a href="mailto:<?php $customer_email ?>" style="text-decoration: none; color: black"><?php echo $customer_email ?></a><br><br>GSTIN (if any): <?php echo $customer_gstin ?></th>
    <?php endif; ?>

    <?php if ($doc_type == "order"): ?>
      <th class="tg-0pky" colspan="5" rowspan="4"><span style="font-weight:bold">Order Id: </span><br><?php echo $invoice_code ?><br><br><span style="font-weight:bold">Dated: </span><br><?php echo date("F d, Y",strtotime($date_created)) ?><br><br><br><span style="font-weight:bold">Mode of Payment: </span><?php echo $payment_mode ?></th>
    <?php else: ?>
    <th class="tg-0pky" colspan="5" rowspan="4"><span style="font-weight:bold">Invoice Number: </span><br><?php echo $invoice_code ?><br><br><span style="font-weight:bold">Dated: </span><br><?php echo date("F d, Y",strtotime($date_created)) ?><br><br><br><span style="font-weight:bold">Mode of Payment: </span><?php echo $payment_mode ?></th>
    <?php endif; ?>
  </tr>
  <tr>
  </tr>
  <tr>
  </tr>
  <tr>
  </tr>
</thead>
<tbody>
	<tr>
    <td class="tg-0pky" colspan="23"></td>
  </tr>
  <tr>
    <td class="tg-fymr" colspan="2">Sr. <br>No.</td>
    <td class="tg-7btt" colspan="3">Prod. ID</td>
    <td class="tg-c3ow" colspan="4"><span style="font-weight:bold">Prod. Name</span></td>
    <td class="tg-c3ow" colspan="4"><span style="font-weight:bold">Qty (in kg)</span></td>
    <td class="tg-c3ow" colspan="4"><span style="font-weight:bold">Rate</span></td>
    <td class="tg-c3ow"><span style="font-weight:bold">Amount</span></td>
    <td class="tg-0pky" colspan="5"></td>
  </tr>
  <?php
$items = $conn->query("SELECT i.*,p.description,p.id as pid,p.product as `name`,p.category_id as cid FROM invoices_items i inner join product_list p on p.id = i.form_id where i.invoice_id = '{$id}' ");
$i = 0;
while($row=$items->fetch_assoc()):
	$category = $conn->query("SELECT * FROM `category_list` where id = {$row['cid']}");
	$cat_count = $category->num_rows;
	$res = $cat_count > 0 ? $category->fetch_assoc(): array();
	$cat_name = $cat_count > 0 ? $res['name'] : "N/A";
	$description = stripslashes(html_entity_decode($row['description']));
	$i++;
?>

  <tr>
    <td class="tg-0pky" colspan="2"><?php echo $i ?></td>
    <td class="tg-0pky" colspan="3"><?php echo $cat_name ?></td>
    <td class="tg-0pky" colspan="4"><?php echo $row['name'] ?></td>
    <td class="tg-0pky" colspan="4"><?php echo $row['quantity'] ?></td>
    <td class="tg-0pky" colspan="4"><?php echo number_format($row['price']) ?></td>
    <td class="tg-0pky"><?php echo number_format($row['total']) ?></td>
    <td class="tg-0pky" colspan="5" rowspan="15"></td>
  </tr>
  <?php endwhile; ?>
  <tr>
    <td class="tg-0pky" colspan="13"></td>
    <td class="tg-fymr" colspan="4">Total Amount:</td>
    <td class="tg-dvpl"><?php echo number_format($sub_total) ?></td>
  </tr>
  <!-- <tr>
    <td class="tg-0pky" colspan="13"></td>
    <td class="tg-fymr" colspan="4">CGST:</td>
    <td class="tg-dvpl">2.5%</td>
  </tr> -->
  <tr>
    <td class="tg-0pky" colspan="13"></td>
    <td class="tg-fymr" colspan="4">Fuel Charges:</td>
    <td class="tg-dvpl">10</td>
  </tr>
  <!-- <tr>
    <td class="tg-0pky" colspan="13" rowspan="3"><span style="font-weight:bold;text-decoration:underline">STATE BANK OF INDIA</span><br><br>A/C No.: 33421910632<br><br>IFS Code: SBIN0004762</td>
    <td class="tg-fymr" colspan="4">SGST:</td>
    <td class="tg-dvpl">2.5%</td>
  </tr> -->
  <tr>
    <td class="tg-0pky" colspan="13" rowspan="3"><span style="font-weight:bold;text-decoration:underline">STATE BANK OF INDIA</span><br><br>A/C No.: 33421910632<br><br>IFS Code: SBIN0004762</td>
    <td class="tg-fymr" colspan="4">Other Charges:</td>
    <td class="tg-dvpl">10</td>
  </tr>
  <!-- <tr>
    <td class="tg-fymr" colspan="4">IGST:</td>
    <td class="tg-dvpl">NA</td>
  </tr> -->
  <tr>
    <td class="tg-fymr" colspan="4">Grand Total:</td>
    <td class="tg-dvpl"><?php echo $grand_total ?></td>
  </tr>
</tbody>
</table>
<hr>
<div class="row">
				</div>
                <div class="row">
					<div class="col-md-7">
						<div class="form-group">
							<label for="remarks" class="control-label">Order Taken By:</label>
							<p><?php echo isset($first_name) ? $first_name : 'NA' ?>  <?php echo isset($last_name) ? $last_name : 'NA' ?></p>
							
						</div>
					</div>
				</div>
						</body>
</html>