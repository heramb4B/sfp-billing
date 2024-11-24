<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php
$type = isset($_GET['type']) ? $_GET['type'] : 1 ;
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `order_list` where md5(id) = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
$tax_rate = isset($tax_rate) ? $tax_rate : $_settings->info('tax_rate');
$user_id = $_settings->userdata('id');
// var_dump($user_id);	
//var_dump($_SESSION['system_info']['sgst_rate']);
//var_dump($_SESSION['system_info']['cgst_rate']);
//var_dump($_SESSION['userdata']['firstname']);
//var_dump($_SESSION['userdata']['lastname']);
// var_dump($_SESSION["system_info"]);

$first_name = isset($_SESSION['userdata']['firstname']) ? $_SESSION['userdata']['firstname'] : 'NA';
$last_name = isset($_SESSION['userdata']['lastname']) ? $_SESSION['userdata']['lastname'] : 'NA';

$sgst_rate = isset($_SESSION['system_info']['sgst_rate']) ? $_SESSION['system_info']['sgst_rate'] : 5;
$cgst_rate = isset($_SESSION['system_info']['cgst_rate']) ? $_SESSION['system_info']['cgst_rate'] : 5;


$item_arr = array();
if(isset($id)){
if($type == 1)
	// $items = $conn->query("SELECT i.*,p.description,p.id as pid,p.product as `name`,p.category_id as cid FROM invoices_items i inner join product_list p on p.id = i.form_id where i.invoice_id = '{$id}' ");
// else
	// $items = $conn->query("SELECT i.*,s.description,s.id as `sid`,s.`service` as `name`,s.category_id as cid FROM invoices_items i inner join service_list s on s.id = i.form_id where i.invoice_id = '{$id}' ");
while($row=$items->fetch_assoc()):
	$category = $conn->query("SELECT * FROM `category_list` where id = {$row['cid']}");
	$cat_count = $category->num_rows;
	$res = $cat_count > 0 ? $category->fetch_assoc(): array();
	$row['cat_name'] = $cat_count > 0 ? $res['name'] : "N/A";
	$row['description'] = stripslashes(html_entity_decode($row['description']));
	$item_arr[] = $row;
endwhile;
}
?>
<style>
#item-list th, #item-list td{
	padding:5px 3px!important;
}

#card_fields input[type="text"], #cheque_fields input[type="text"], #upi_fields input[type="text"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
        font-size: 16px;
    }
</style>
<div class="card card-outline rounded-0 card-maroon">
	<div class="card-header">
	<h3 class="card-title"><?php echo !isset($_GET['id']) ? "New Order" :"Edit Order" ?></h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<form action="" id="invoice-form">
				<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="invoice_code" class="control-label">Order Code</label>
							<input type="text" name="order_code" value="<?php echo isset($order_code) ? $order_code : ''; ?>"  class="form-control form-control-sm" required readonly>
						</div>
						<div class="form-group">
							<label for="customer_name" class="control-label">Customer Name</label>
							<input name="customer_name" id="customer_name" class="form-control form no-resize" value="<?php echo isset($customer_name) ? $customer_name : ''; ?>" />
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="type" class="control-label">Type</label>
							<select name="type" id="type" class="custom-select custom-select-sm select" disabled>
							<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Product</option>
							<!-- <option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Services</option> -->
							</select>
						</div>
						<div class="col-md-6">
					<div class="form-group">
								<label for="customer_address" class="control-label">Customer Address</label>
								<input name="customer_address" id="customer_address" class="form-control form no-resize" style="width: 210%" value="<?php echo isset($customer_address) ? $customer_address : ''; ?>" />
						</div>
					</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
								<label for="customer_mobile" class="control-label">Customer Mobile</label>
								<input name="customer_mobile" minLength="10" maxLength="10" placeholder="Skip countrycode (+91)" id="customer_mobile" class="form-control form no-resize" value="<?php echo isset($customer_mobile) ? $customer_mobile : ''; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
								<label for="customer_email" class="control-label">Customer Email</label>
								<input name="customer_email" type="email" id="customer_email" class="form-control form no-resize" value="<?php echo isset($customer_email) ? $customer_email : ''; ?>" />
						</div>
					</div>
				</div>

				<!-- <div class="row">
					<div class="col-md-6">
					<div class="form-group">
								<label for="customer_gstin" class="control-label">Customer GSTIN (if any):</label>
								<input name="customer_gstin" minLength="15" maxLength="15" placeholder="" id="customer_gstin" class="form-control form no-resize" value="<?php echo isset($customer_gstin) ? $customer_gstin : ''; ?>" />
						</div>
					</div>
					<div class="col-md-6">
						
					</div>
				</div> -->
				<!-- <div class="row">
					<div class="col-md-6">
					<div class="form-group">
								<label for="customer_name" class="control-label">Customer Email</label>
								<input name="customer_name" id="customer_name" class="form-control form no-resize" value="<?php echo isset($customer_name) ? $customer_name : ''; ?>" />
						</div>
					</div>
					
				</div> -->
				<hr>
				<h4>Item Form:</h4>
				<div class="row align-items-end">
					<div class="col-md-3">
						<div class="form-group">
						<label for="category_id" class="control-label">Product Id</label>
							<select id="category_id" class="custom-select custom-select-sm select select2">
								<?php 
									$i = 0;
									$qry = $conn->query("SELECT * FROM category_list where `type` = {$type} ");
									while($row = $qry->fetch_assoc()):
									$i++;
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo $i == 1 ? 'selected': '' ?>><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
						<label for="form_id" class="control-label">Product Name</label>
							<select  id="form_id" class="custom-select custom-select-sm select2">
								<option selected="" disabled>Select Category First</option>
								<?php 
								$data_json = array();
									if($type == 1):
										$qry2 = $conn->query("SELECT * FROM product_list ");
									else:
										$qry2 = $conn->query("SELECT * FROM service_list ");
									endif;
									while($row = $qry2->fetch_assoc()):
										$name = ($type == 1) ? $row['product'] : $row['service'];
										$row['description'] = stripslashes(html_entity_decode($row['description']));
										$row['name'] = $name;
										$data_json[$row['id']] = $row;
								?>
								<!-- <option value="<?php echo $row['id'] ?>" ><?php echo $name ?></option> -->
								<?php endwhile; ?>
							</select>
							<small id="price"></small>
						</div>
					</div>	
					<!-- <div class="col-md-2">
						<div class="form-group">
							<label for="unit" class="control-label">Unit</label>
							<input type="text" id="unit"  class="form-control">
						</div>
					</div> -->
					<div class="col-md-2">
						<div class="form-group">
							<label for="qty" class="control-label">Quantity</label>
							<input type="number" min='1' id="qty"  class="form-control text-right">
						</div>
					</div>
					<!-- <div class="col-md-2">
						<div class="form-group">
							<label for="discount" class="control-label">Discount</label>
							<input type="number" min='1' id="discount"   class="form-control text-right">
						</div>
					</div> -->
					<div class="col-md-2 pb-1">
						<div class="form-group">
							<button class="btn btn-flat btn-default bg-maroon" type="button" id="add_item"><i class="fa fa-plus"></i> Add</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered" id="item-list">
							<colgroup>
								<col width="50%">
								<col width="50%">
								<!-- <col width="10%">
								<col width="15%">
								<col width="15%">
								<col width="1%"> -->
							</colgroup>
							<thead>
                                    <th class="text-center">Product</th>
									<th class="text-center">Qty (in kg)</th>
									<!-- <th class="text-center">Cost (in INR)</th> -->
									<!-- <th class="text-center">Total</th> -->
									<!-- <th class="text-center"></th> -->
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<!-- <tr>
									<th class="text-right" colspan="4">Sub Total</th>
									<th class="text-right" id="sub_total">0</th>
									<th><input type="hidden" name="sub_total" value="0"></th>
								</tr> -->
								<!-- <tr>
									<th class="text-right" colspan="4">GST</th>
									<th class="text-right" id="tax_rate"><?php echo $cgst_rate ?>%</th>
									<th><input type="hidden" name="tax_rate" value="<?php echo $cgst_rate ?>"></th>
								</tr> -->
								<!-- <tr>
									<th class="text-right" colspan="4">SGST</th>
									<th class="text-right" id="tax_rate"><?php echo $sgst_rate ?>%</th>
									<th><input type="hidden" name="tax_rate" value="<?php echo $sgst_rate ?>"></th>
								</tr> -->
								<!-- <tr>
									<th class="text-right" colspan="4">Total GST Amount</th>
									<th class="text-right" id="tax_rate111"></th>
									<th><input type="hidden" name="total_tax_amount" value="0"></th>
									<th><input type="hidden" name="tax_rate" value="<?php //echo $sgst_rate ?>"></th>
								</tr> -->
								<!-- <tr>
									<th class="text-right" colspan="4">Grand Total</th>
									<th class="text-right" id="gtotal" name="grand_total"></th>
									<th><input type="hidden" name="grand_total" value="0"></th>
								</tr> -->
								
							</tfoot>
						</table>
					</div>
				</div>
				
				
				<br><br>
				<div class="row">
					<div class="col-md-7">
						<div class="form-group">
						<label for="remarks" class="control-label">Status</label>
							<select name="status" id="status" class="custom-select custom-select-sm select select2" style="width: 50%" required>
								<option value="" selected>Select</option>
								<?php if(isset($status)): ?>
								<option value="DELIVERED" <?php echo ($status === 'DELIVERED') ? 'selected' : ''; ?>>DELIVERED</option>
								<option value="PENDING" <?php echo ($status === 'PENDING') ? 'selected' : ''; ?>>PENDING</option>
								<option value="CANCELLED" <?php echo ($status === 'CANCELLED') ? 'selected' : ''; ?>>CANCELLED</option>
								<option value="NEW" <?php echo ($payment_mode === 'NEW') ? 'selected' : ''; ?>>NEW</option>
								<?php else: ?>
								<option value="DELIVERED">DELIVERED</option>
								<option value="PENDING" >PENDING</option>
								<option value="CANCELLED" >CANCELLED</option>
								<option value="NEW">NEW</option>
								<?php endif ?>
							</select>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-7">
						<div class="form-group">
						<label for="remarks" class="control-label">Payment Mode</label>
						<select name="payment_mode" id="payment_mode" onchange="showFields()" class="custom-select custom-select-sm select select2" style="width: 50%" required>
							<option value="" selected>Select</option>
							<?php if(isset($payment_mode)): ?>
							<option value="cash" <?php echo ($payment_mode === 'cash') ? 'selected' : ''; ?>>Cash</option>
							<option value="card" <?php echo ($payment_mode === 'card') ? 'selected' : ''; ?>>Card</option>
							<option value="cheque" <?php echo ($payment_mode === 'cheque') ? 'selected' : ''; ?>>Cheque</option>
							<option value="upi" <?php echo ($payment_mode === 'upi') ? 'selected' : ''; ?>>UPI</option>
							<?php else: ?>
							<option value="cash">Cash</option>
							<option value="card" >Card</option>
							<option value="cheque" >Cheque</option>
							<option value="upi">UPI</option>
							<?php endif ?>
						</select>
						<br><br>
						<div id="card_fields" style="display: none">
							Card Number: <input type="text" id="card_number" name="card_number" class="" minlength='16' maxLength='16'><br><br>
							Card Expiry Date: <input type="text" id="card_expiry_date" name="card_expiry_date"><br><br>
							Bank Name: <input type="text" id="bank_name" name="bank_name"><br><br>
							
						</div>

						<div id="cheque_fields" style="display: none">
							Cheque Number: <input type="text" id="cheque_number" name="cheque_number" minLength='6' maxLength='6'><br>
							Bank Name: <input type="text" id="cheque_bank_name" name="cheque_bank_name"><br>
						</div>

						<div id="upi_fields" style="display: none">
							Transaction ID: <input type="text" id="transaction_id" name="transaction_id"><br>
							UPI App: <input type="text" id="upi_app" name="upi_app"><br>
							Bank Name: <input type="text" id="upi_bank_name" name="upi_bank_name"><br>
						</div>
						
						<?php if(isset($payment_mode)): ?>
						<?php if($payment_mode === 'card'): ?>
							<table style="width: 100%; border-collapse: collapse;">
							<tr>
								<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Card Number:</td>
								<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($card_number) ? $card_number : 'NA' ?></td>
							</tr>
							<tr>
								<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Card Expiry Date:</td>
								<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($card_expiry_date) ? $card_expiry_date : 'NA' ?></td>
							</tr>
							<tr>
								<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Card Bank Name:</td>
								<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($bank_name) ? $bank_name : 'NA' ?></td>
							</tr>
						</table>

						<?php endif ?>

						<?php if($payment_mode === 'cheque'): ?>
							<table style="width: 100%; border-collapse: collapse;">
								<tr>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Cheque Number:</td>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($cheque_number) ? $cheque_number : 'NA' ?></td>
								</tr>
								<tr>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Cheque Bank Name:</td>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($cheque_bank_name) ? $cheque_bank_name : 'NA' ?></td>
								</tr>
							</table>

						<?php endif ?>

						<?php if($payment_mode === 'upi'): ?>
							<table style="width: 100%; border-collapse: collapse;">
								<tr>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Transaction Id:</td>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($transaction_id) ? $transaction_id : 'NA' ?></td>
								</tr>
								<tr>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">UPI App Name:</td>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($upi_app) ? $upi_app : 'NA' ?></td>
								</tr>
								<tr>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">UPI Bank Name:</td>
									<td style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;"><?php echo isset($upi_bank_name) ? $upi_bank_name : 'NA' ?></td>
								</tr>
							</table>

						<?php endif ?>
						<?php endif ?>
						</div>
					</div>
				</div> -->
				
				<!-- <div class="row">
					<div class="col-md-7">
						<label for="remarks" class="control-label">Recieved Amount</label>
						<?php if(isset($recd_amt)): ?>
							<input type="number" id="recvd_amt" name="recd_amt"  class="form-control text-right" style="width: 30%" value="<?php echo $recd_amt ?>">
						<?php else: ?>
							<input type="number" id="recvd_amt" name="recd_amt"  class="form-control text-right" style="width: 30%">
						<?php endif; ?>
					</div>					
				</div> -->
		
				
				<!-- <div class="row">
					<div class="col-md-7">
						<label for="remarks" class="control-label">Pending Amount:</label><br>
						<input type="text" class="form-control text-right" style="width: 30%" value="<?php echo isset($recd_amt) && isset($grand_total) ? $grand_total-$recd_amt : '';  ?>" readonly> 
						<?php //if(isset($grand_total) && isset($recd_amt)): ?>
							<?php //$pending = $grand_total-$recd_amt ?> 
						<?php //endif ?>
						<?php //$pending ?>
						<?php //echo isset($recd_amt) && isset($grand_total) ? $pending=$grand_total-$recd_amt : 25;  ?>
						<input type="hidden" id="pending_amt" name="pending_amt" value="">
						
					</div>					
				</div> -->
				
				<div class="row">
					<div class="col-md-7">
						<div class="form-group">
							<label for="remarks" class="control-label">Order Taken By:</label>
							<p><?php echo isset($first_name) ? $first_name : 'NA' ?>  <?php echo isset($last_name) ? $last_name : 'NA' ?></p>
							
						</div>
					</div>
				</div>
				<input type ="hidden" name="created_by" value=<?php echo isset($user_id) ? $user_id : ''; ?> id="created_by" cols="30" rows="2" class="form-control form no-resize summernote">  </input>
				<!-- <div class="row">
					<div class="col-md-7">
						<div class="form-group">
							<label for="remarks" class="control-label">Remarks</label>
							<textarea name="remarks" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($remarks) ? $remarks : ''; ?></textarea>
							
						</div>
					</div>
				</div> -->
				
		
				
				
				
			</form>
		</div>
		<div class="card-footer">
		<button class="btn btn-flat btn-sm btn-default bg-maroon" form="invoice-form" >Save</button>
				<a class="btn btn-flat btn-sm btn-default" href="./?page=orders">Cancel</a>
		</div>
	</div>
</div>

<!-- <script>
	function cal_pending(){

		console.log("Inside calPending");
		// var grandTotal = parseFloat('<?php //echo $grand_total ?>');
		// var recdAmount = parseFloat('<?php //echo $recd_amt ?>');

		var grandTotal = document.getElementById("gtotal").innerHTML;
		var recdAmt = document.getElementById("recvd_amt").value;
		
		console.log("grandTotal>>", parseInt(grandTotal));
		console.log("recdAmt>>", parseInt(recdAmt));

		var pendingAmt = grandTotal - recdAmt;
		console.log("pendingAmt>>", parseInt(pendingAmt));

		$('[name="pending_amt"]').val(pendingAmt);
	}
</script> -->

<script>
var item_arr = $.parseJSON('<?php echo json_encode($item_arr) ?>');
	function generate_order_code(){
		start_loader();
		$.ajax({
			url:_base_url_+'classes/Master.php?f=generate_order_code',
			method:'POST',
			data:{type:'<?php echo $type ?>'},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast(' An error occured while generating order code','error')
			},
			success:function(resp){
				if(resp.status == 'success'){
					$('[name="order_code"]').val(resp.code)
				}else{
					console.log(resp)
					alert_toast(' An error occured while generating order code','error')
				}
				end_loader(); 
			}
		})
	}
	// function calc_total(){
	// 	var total = 0;
	// 	// calc_pendingAmount();
	// 	// var tax_rate = parseFloat('<?php echo $tax_rate ?>') /100;
		
	// 	$('#item-list tbody tr').each(function(){
	// 		var tr = $(this)
	// 			total += parseFloat(tr.find('[name="total[]"]').val());
	// 	})
	// 	var cgst_rate = parseFloat('<?php echo $cgst_rate ?>') ;
	// 	var sgst_rate = parseFloat('<?php echo $sgst_rate ?>') ;

	// 	console.log("total>>", total);
	// 	console.log("cgst>>", cgst_rate);
	// 	console.log("sgst>>", sgst_rate);
	// 	$('[name="sub_total"]').val(total)
	// 	$('#sub_total').text(parseFloat(total).toLocaleString('en-US'))
	// 	// var tax = parseFloat(total) * parseFloat(cgst_rate) * parseFloat(sgst_rate);
	// 	var gtotal = (total*cgst_rate)/100;
	// 	var grand_total = total + gtotal;
	// 	console.log("gtotal>>", gtotal)
	// 	console.log("grand total>>", grand_total)
	// 	//var gtotal = 78;
	// 	// var gtotal = parseFloat(tax) + parseFloat(total);
	// 	// $('#tax').text(parseFloat(tax).toLocaleString('en-US'))
	// 	$('#gtotal').text(parseFloat(grand_total).toLocaleString('en-US'))
	// 	$('#tax_rate111').text(parseFloat(gtotal).toLocaleString('en-US'))
	// 	$('[name="total_tax_amount"]').val(gtotal)
	// 	$('[name="grand_total"]').val(grand_total)

	// 	var pending_amount = 0;
	// 	var grand_total = document.getElementById("gtotal").innerHTML;
	// 	//console.log("grand_total from calculate pending amount function>>", parseInt(grand_total));

	// 	var recd_amt = document.getElementById("recvd_amt");
	// 	//console.log("recd amt>>", recd_amt);


	// }

	
	function rem_item(_this){
		_this.closest('tr').remove();
		// calc_total()
	}
	function add_item($obj = null){
		var tr, td, item_id='', created_by='', qty='', unit='',form_name,form_id='',price,total, description, category;
		if($obj == null){
		start_loader();
			var prod_d = $.parseJSON('<?php echo json_encode($data_json) ?>')
				prod_d = prod_d[$('#form_id').val()]
			qty = $('#qty').val();
			unit = $('#unit').val();
			form_id = $('#form_id').val();
			category = $('#category_id option:selected').text();
			// price = parseFloat(prod_d.price)
			form_name = prod_d.name
			description = prod_d.description
			// total = parseFloat(price) * parseFloat(qty)
		}else{
			item_id = $obj.id
			created_by = $obj.id
			qty = $obj.quantity;
			unit = $obj.unit;
			form_id = $obj.form_id;
			category = $obj.cat_name;
			// price = parseFloat($obj.price)
			form_name = $obj.name
			description = $obj.description
			// total = parseFloat($obj.price) * parseFloat(qty)
		}
		if($('#item-list tbody').find('[name="form_id[]"][value="'+form_id+'"]').length > 0){
			alert_toast(' Item already on the list.','warning')
			end_loader();
			return false;
		}

		
		
		tr = $("<tr>")
		// details column
		td = $("<td>")
			td.html("<p class='m-0'><small><b>Product Id:</b> "+category+"</small></p>"+
					"<p class='m-0'><small><b>Name: </b>"+form_name+"</p>"+
					"<div class='m-0'><b>Notes: </b>"+description+"</div>");
			tr.append(td)
		// quantity column
			td = $("<td>")
			td.addClass('text-center')
			td.text(qty)
			td.append("<input type='hidden' name='item_id[]' value='"+item_id+"' />") //item id input
			td.append("<input type='hidden' name='form_id[]' value='"+form_id+"' />") //item product/service input
			td.append("<input type='hidden' name='quantity[]' value='"+qty+"' />") //item quantity input
			// td.append("<input type='hidden' name='unit[]' value='"+unit+"' />") //item unit input
			// td.append("<input type='hidden' name='price[]' value='"+price+"' />") //item price input
			// td.append("<input type='hidden' name='total[]' value='"+total+"' />") //item total input
			// td.append("<input type='hidden' name='created_by[]' value='"+created_by+"' />") //item id input
			tr.append(td)
		// unit column
			//td = $("<td>")
			//td.addClass('text-center')
			//td.text(unit)
			//tr.append(td)
		
		// cost column
		// td = $("<td>")
		// 	td.addClass('text-right')
		// 	td.text(parseFloat(price).toLocaleString('en-US'))
		// 	tr.append(td)

		// total column
		    // td = $("<td>")
			// td.addClass('text-right')
			// td.text(parseFloat(total).toLocaleString('en-US'))
			// tr.append(td)

		// action column
		// td = $("<td>")
		// 	td.addClass('text-center')
		// 	td.append("<button class='btn btn-sm btn-outline-danger' type='button' onclick='rem_item($(this))'><i class='fa fa-trash'></i></button>")
		// 	tr.append(td)

		$('#item-list tbody').append(tr)
		$('#qty').val('').trigger('change')
		$('#unit').val('').trigger('change')
		$('#form_id').val('').trigger('change')
		// calc_total()
		if($obj == null)
		end_loader();
	}
	function load_items(){
		Object.keys(item_arr).map(k=>{
			add_item(item_arr[k])
		})
		end_loader()
	}
	$(document).ready(function(){
		$('.select2').select2()
		if('<?php echo isset($_GET['id']) ? 1 : 0 ?>' == 0)
		generate_order_code();
		
		if(Object.keys(item_arr).length > 0)
			load_items();
		$('[name="type"]').change(function(){
			location.href = "./?page=orders/manage&type="+$(this).val()
		})
		$('#add_item').click(function(){
			if($('#qty').val() == '' ||$('#unit').val() == '' || $('#form_id').val() == ''){
				alert_toast("Please complete the Item form first.",'warning')
				return false;
			}
			add_item()
		})
		$('#category_id').change(function(){
			var cid = $(this).val()
			prods = $.parseJSON('<?php echo json_encode($data_json) ?>')
			$('#form_id').html('')
			Object.keys(prods).map(k=>{
				if(prods[k].category_id == cid){
					opt = "<option value='"+k+"'>"+prods[k].name+"</option>"
					$('#form_id').append(opt)
				}
			})
			$('#form_id').select2()
		})
		$('#category_id').trigger('change')
			$('[name="order_code"]').on('input',function(){
				$(this).removeClass('border-danger')
				$(this).removeClass('border-success')
				$.ajax({
				url:_base_url_+'classes/Master.php?f=code_availability',
				method:'POST',
				data:{id:'<?php echo isset($id) ? $id : 0 ?>',code:$(this).val()},
				dataType:"json",
				error:err=>{
					console.log(err)
					alert_toast(' An error occured','error')
				},
				success:function(resp){
					if(resp.status == 'available'){
						$('[name="order_code"]').addClass('border-success')
					}else if(resp.status == 'taken'){
						$('[name="order_code"]').addClass('border-danger')
					}else{
						console.log(resp)
						alert_toast(' An error occured while validating order code','error')
					}
					end_loader(); 
				}
			})
		})
		$('#invoice-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			if($('#item-list tbody tr').length <= 0){
				alert_toast("No Items Listed.",'warning')
				return false;
			}
			if($('[name="order_code"]').hasClass('border-danger') == true){
				alert_toast("Order Code already exist.",'warning')
				return false;
			}

			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_order",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				
			})
		})
        
	})

// 	function showFields() {
//     var paymentMode = document.getElementById("payment_mode").value;
    
//     var cardFields = document.getElementById("card_fields");
//     var chequeFields = document.getElementById("cheque_fields");
//     var upiFields = document.getElementById("upi_fields");
    
//     // Reset all fields
//     cardFields.style.display = "none";
//     chequeFields.style.display = "none";
//     upiFields.style.display = "none";
    
//     // Fade out the fields
//     cardFields.style.opacity = "0";
//     chequeFields.style.opacity = "0";
//     upiFields.style.opacity = "0";
    
//     if (paymentMode === "card") {
//         cardFields.style.display = "block";
//         fadeIn(cardFields);
//     } else if (paymentMode === "cheque") {
//         chequeFields.style.display = "block";
//         fadeIn(chequeFields);
//     } else if (paymentMode === "upi") {
//         upiFields.style.display = "block";
//         fadeIn(upiFields);
//     }
// }

// function fadeIn(element) {
//     var op = 0.1;  // initial opacity
//     element.style.opacity = op;
//     var timer = setInterval(function () {
//         if (op >= 1) {
//             clearInterval(timer);
//         }
//         element.style.opacity = op;
//         op += op * 0.1;
//     }, 10);
// }


document.addEventListener("DOMContentLoaded", function () {
        var typeDropdown = document.getElementById("type");
        typeDropdown.disabled = true;
    });
</script>


