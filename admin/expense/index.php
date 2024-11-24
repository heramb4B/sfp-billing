<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-maroon">
	<div class="card-header">
		<h3 class="card-title">Expenses</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_expense" class="btn btn-flat btn-default bg-maroon"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="5%">
					<col width="10%">
					<col width="14%">
					
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<!-- <th>Id</th> -->
						<th>Category</th>
						<th>Sub Category</th>
						<!-- <th>Others (if any)</th> -->
						<th>Quantity</th>
						<th>Amount</th>
						<th>Bill Number/ID</th>
						<!-- <th>Sales Person Id </th> -->
						<th>Sales Person Name </th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
  <?php 
  $user_id = $_settings->userdata('id');
  $isAdmin = $_settings->userdata('type') == 1;
//   var_dump( $isAdmin );
//   var_dump( $user_id);
  
  $i = 1;
  $qry = $isAdmin ? $conn->query("SELECT * FROM `expense_list` ORDER BY id DESC") : $conn-> query("SELECT * FROM `expense_list` WHERE created_by = $user_id ORDER BY id DESC");
  while ($row = $qry->fetch_assoc()):
	
	$create_by = $row[ 'created_by' ];
	$query2 = $conn->prepare("SELECT firstname, lastname FROM `users` WHERE id = ?");
		$query2->bind_param("i", $create_by);
		$query2->execute();
		$result2 = $query2->get_result();
		$user = $result2->fetch_assoc();
		if ($user !== null) {
			$name = $user['firstname'];
			$name2 = $user['lastname'];
		} else {
			$name = "Anonymous"; // or any default value you prefer
			$name2 = "NA";
		}


    $row['sub_category'] = strip_tags(stripslashes(html_entity_decode($row['sub_category'])));
  ?>
  <tr>
    <td class="text-center"><?php echo $i++; ?></td>
    <td><?php echo date("d-m-Y H:i", strtotime($row['date_created'])) ?></td>
    <td><?php echo $row['category'] ?></td>
    <!-- <td><?php //echo $row[''] ?></td> -->
    <td>
      <p class="truncate-1 m-0"><?php echo $row['sub_category'] ?></p>
    </td>
    <!-- <td>
      <p class="truncate-1 m-0"><?php echo $row['others_if_any'] ?></p>
    </td> -->
    <td>
      <p class="truncate-1 m-0"><?php echo $row['quantity'] ?></p>
    </td>
    <td class="text-right"><?php echo number_format($row['total_amount'], 2) ?></td>
    <td class="text-right"><?php echo $row['invoice_number'] ?></td>
    <!-- <td>
      <p class="truncate-1 m-0"><?php echo $row['comment'] ?></p>
    </td> -->
	<!-- <td>
      <p class="truncate-1 m-0"><?php echo $row['created_by'] ?></p>
    </td> -->
	<td align="center">
		<?php echo $name;echo ' '; echo $name2 ?> 
    </td>
    <td align="center">
      <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
        Action
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu" role="menu">
	  <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
      </div>
    </td>
  </tr>
  <?php endwhile; ?>
</tbody>

			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#create_expense').click(function(){
			uni_modal("<i class='fa fa-plus'></i> New Expense","expense/manage.php","mid-large")
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Update Expense","expense/manage.php?id="+$(this).attr('data-id'),"mid-large")
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this expense permanently?","delete_expense",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
		$('#uni_modal').on('shown.bs.modal', function() {
			$('.select2').select2({width:'resolve'})
			$('.summernote').summernote({
				height: 200,
				toolbar: [
					[ 'style', [ 'style' ] ],
					[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
					[ 'fontname', [ 'fontname' ] ],
					[ 'fontsize', [ 'fontsize' ] ],
					[ 'color', [ 'color' ] ],
					[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
					[ 'table', [ 'table' ] ],
					[ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
				]
			})
		})
	})
	function delete_expense($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_expense",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>