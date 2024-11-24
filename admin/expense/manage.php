<?php
include '../../config.php';
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `expense_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
$user_id = $_settings->userdata('id');
$first_name = isset($_SESSION['userdata']['firstname']) ? $_SESSION['userdata']['firstname'] : 'NA';
$last_name = isset($_SESSION['userdata']['lastname']) ? $_SESSION['userdata']['lastname'] : 'NA';
// var_dump($user_id);
?>
<div class="container-fluid">
<form method="POST" enctype="multipart/form-data" action="upload.php" id="product-form">
  <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>" >
  <div class="form-group">
    <label for="category" class="control-label">Category</label>
    <select name="category" id="expense_type" class="custom-select custom-select-sm select" onchange="updateSubTypeOptions(); updatePrice()" required>
      <option value="0" selected>Select</option>
      <option value="Petty Cash">Petty Cash</option>
      <option value="Pune Warehouse - Operational Expense">Pune Warehouse - Operational Expense</option>
      <option value="Outsourcing">Outsourcing</option>
      <option value="Office Expenses">Office Expenses</option>
      <option value="Marketing Expenses">Marketing Expenses</option>
      <option value="Electricity">Electricity</option>
      <option value="Transportation">Transportation</option>
      <option value="Miscellaneous Expense">Miscellaneous Expense</option>
      <option value="Food Expense">Food Expense</option>
      <option value="Packaging Expense">Packaging Expense</option>
      <option value="Staff Salary and Commission Expense">Staff Salary and Commission Expense</option>
      <option value="Petrol Expense">Petrol Expense</option>
      <option value="Diesel Expense">Diesel Expense</option>
      <option value="Transportation Expense">Transportation Expense</option>
      <option value="Professional Fees">Professional Fees</option>
    </select>
  </div>

  <div class="form-group">
    <label for="sub_category" class="control-label">Sub Category</label>
    <input name="sub_Category" id="sub_Category" class="form-control form" value="" required/>
  </div>

  <div class="form-group">
    <label for="sub_category" class="control-label">Quantity</label>
    <input name="quantity" id="quantity" class="form-control form" value="" required/>
  </div>

  <div class="form-group">
    <label for="sub_category" class="control-label">Comment</label>
    <input name="comment" id="comment" class="form-control form" value="" required/>
  </div>

  <div class="form-group">
    <label for="bill" class="control-label">Invoice Number</label>
    <input name="invoice_number" id="invoice_number" class="form-control form" value="" required/>
  </div>

  <div class="form-group">
    <label for="bill" class="control-label">Total Amount</label>
    <input name="total_amount" id="total_amount" class="form-control form" value="" required/>
  </div>

  <input type ="hidden" name="created_by" value=<?php echo isset($user_id) ? $user_id : ''; ?> id="created_by" >  </input>
</form>
</div>
<script>
	$(document).ready(function(){
		$('#product-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
            var selectedCategory = $('#expense_type').val();
            var subCategory = $('#sub_Category').val();
            var quantity = $('#quantity').val();
            var comment = $('#comment').val();
            var invoiceNumber = $('#invoice_number').val();
            var totalAmount = $('#total_amount').val();

            if (selectedCategory === "0" || subCategory === "" || quantity === "" || invoiceNumber === "" || totalAmount === "") {
                var errorMsg = $('<div>').addClass("alert alert-danger err-msg").text("Please fill in all fields.");
                $(this).prepend(errorMsg);
                errorMsg.show('slow');
            } else {
                start_loader();
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=save_expense",
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    dataType: 'json',
                    error: err => {
                        console.log("err::>>>", err);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    },
                    success: function(resp){
                        if(typeof resp =='object' && resp.status == 'success'){
                            location.reload()
                        } else if(resp.status == 'failed' && !!resp.msg){
                            var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            end_loader()
                        } else {
                            alert_toast("An error occurred", 'error');
                            end_loader();
                            console.log(resp)
                        }
                    }
                })
            }
		});
	});

    // Example usage
    window.addEventListener('load', updatePrice);
    $(document).ready(function() {
        $('#expense_type').change(updateSubTypeOptions);
    });
</script>



<script>


</script>
