<!-- <h3 class="text-dark">Welcome <?php echo $_settings->userdata('username') ?>!</h3> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<h3>Dashboard</h3>
<hr>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice"></i></span>

              <div class="info-box-content">
              <?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
                <span class="info-box-text">Total Invoices</span>
              <?php else: ?>
                <span class="info-box-text">Your Invoices</span>
              <?php endif ?>
              
                <?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
                <span class="info-box-number">
                  <?php echo number_format($conn->query("SELECT * FROM invoice_list WHERE doc_type = 'invoice'")->num_rows) ?>
                </span>
                <?php else: ?>
                <span class="info-box-number">
                  <?php
                $userID = $_SESSION['userdata']['id'];
                $result = $conn->query("SELECT * FROM invoice_list WHERE created_by = $userID AND doc_type = 'invoice'");
                $count = $result->num_rows;
                echo number_format($count);
                ?>

                </span>
              <?php endif ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Category</span>
                <span class="info-box-number"> <?php echo number_format($conn->query("SELECT * FROM category_list")->num_rows) ?></span>
              </div>
              /.info-box-content
            </div>
            /.info-box
          </div>
          /.col -->
          <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-money"></i></span>

              <div class="info-box-content">
              <?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
                <span class="info-box-text">Total Expenses</span>
              <?php else: ?>
                <span class="info-box-text">Your Expenses</span>
              <?php endif ?>
              
                <?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
                <span class="info-box-number">
                  <?php echo number_format($conn->query("SELECT * FROM expense_list")->num_rows) ?>
                </span>
                <?php else: ?>
                <span class="info-box-number">
                  <?php
                $userID = $_SESSION['userdata']['id'];
                $result = $conn->query("SELECT * FROM expense_list WHERE created_by = $userID");
                $count = $result->num_rows;
                echo number_format($count);
                ?>

                </span>
              <?php endif ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>       

          <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-shopping-bag"></i></span>

              <div class="info-box-content">
              <?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
                <span class="info-box-text">Total Orders</span>
              <?php else: ?>
                <span class="info-box-text">Your Orders</span>
              <?php endif ?>
              
                <?php if (isset($_SESSION['userdata']['type']) && $_SESSION['userdata']['type'] == 1): ?>
                <span class="info-box-number">
                  <?php echo number_format($conn->query("SELECT * FROM invoice_list WHERE doc_type = 'order' AND status = 'new' OR status = 'in progress' OR status = 'delivered'")->num_rows) ?>
                </span>
                <?php else: ?>
                <span class="info-box-number">
                  <?php
                $userID = $_SESSION['userdata']['id'];
                $result = $conn->query("SELECT * FROM invoice_list WHERE doc_type = 'order' AND status = 'new' OR status = 'in progress' OR status = 'delivered' AND created_by = $userID");
                $count = $result->num_rows;
                echo number_format($count);
                ?>

                </span>
              <?php endif ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div> 
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number"><?php echo number_format($conn->query("SELECT * FROM product_list")->num_rows) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          <!-- /.col -->
          <!-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hands-helping"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Services</span>
                <span class="info-box-number"><?php echo number_format($conn->query("SELECT * FROM service_list")->num_rows) ?></span>
              </div>
             
            </div>
        
          </div> -->


          
          
          
        </div>
    </div>
</section>
