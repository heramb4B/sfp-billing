<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<head>
<style>
    .table-responsive {
        overflow-x: auto;
    }

    @media (max-width: 767px) {
        .table-responsive {
            width: 100%;
            margin-bottom: 1rem;
            overflow-y: hidden;
            -ms-overflow-style: -ms-autohiding-scrollbar;
            border-radius: .25rem;
        }
    }
</style>
</head>
<?php endif;?>
<div class="card card-outline rounded-0 card-maroon">
	<div class="card-header">
		<h3 class="card-title">List of Invoices</h3>
		<div class="card-tools">
			<a href="./?page=invoice/manage" class="btn btn-flat btn-default bg-maroon"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
		<div class="table-responsive">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
    <tr>
        <th>#</th>
        <th>Date Created</th>
        <th>Invoice Code</th>
        <th>Customer Name</th>
        <th>Details</th>
		<?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
        <th>Action</th>
		<?php endif ?>
        <th>Sales Person ID</th>
        <th>Sales Person</th>
    </tr>
</thead>
<tbody>
    <?php 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	$errorLogPath = 'error.log'; 
	ini_set('error_log', $errorLogPath);


    $i = 1;
	$id = $_settings->userdata('id');
	$isAdmin = $_settings->userdata('type') == 1;
	// var_dump( $isAdmin );
	if (isset($_SESSION['loggedInUserId'])):
    $loggedInUserId = $_SESSION['loggedInUserId']; // Assuming you have the logged-in user's ID stored in the session variable 'loggedInUserId'
	endif;
    $qry = $isAdmin ? $conn->prepare("SELECT * FROM `invoice_list` WHERE doc_type = 'invoice' ORDER BY DATE(date_created) DESC") : $conn->prepare("SELECT * FROM `invoice_list` WHERE created_by = $id ORDER BY DATE(date_created) DESC");
    // $qry->bind_param("s", $loggedInUserId);
    $qry->execute();
    $result = $qry->get_result();

    while($row = $result->fetch_assoc()):
		$create_by = $row[ 'created_by' ];
		// var_dump( $create_by );

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
		// $query2 = $conn->prepare("SELECT firstname from `users` where id = $create_by "); 
		// $query2->execute();
        $row['remarks'] = strip_tags(stripslashes(html_entity_decode($row['remarks'])));
        $items = $conn->query("SELECT * FROM invoices_items WHERE invoice_id = {$row['id']}")->num_rows;
    ?>
        <tr>
            <td class="text-center"><?php echo $i++; ?></td>
            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
            <td><?php echo $row['invoice_code'] ?></td>
            <td><?php echo $row['customer_name'] ?></td>
            <td>
                <p class="m-0"><small><b>Invoice Type: </b><?php echo $row['type'] == 1 ? "Product":"Service" ?></small></p>
                <p class="m-0"><small><b>Item Count: </b> <?php echo number_format($items) ?></small></p>
                <p class="m-0"><small><b>Total Amount: </b><?php echo number_format($row['grand_total']) ?></small></p>
            </td>
			<?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
            <td align="center">
                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    Action
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item edit_data" href="./?page=invoice/manage&id=<?php echo md5($row['id']) ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                </div>
            </td>
			<?php endif ?>
			
			<td align="center">
			<?php echo $create_by ?> 
            </td>

			<td align="center">
			<?php echo $name;echo ' '; echo $name2 ?> 
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

			</table>
			</div>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this invoice permanently?","delete_invoice",[$(this).attr('data-id')])
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
	function delete_invoice($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_invoice",
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