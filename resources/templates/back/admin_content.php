 
  <!-- Page Heading -->
  <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        
                        
                    </div>
                </div>
 
 
 
 <!-- /.row -->
 <div class="row">

<div class="col-lg-4 col-md-6">
<div class="panel panel-yellow">
<div class="panel-heading">
    <div class="row">
        <div class="col-xs-3">
            <i class="fa fa-shopping-cart fa-5x"></i>
        </div>
        <div class="col-xs-9 text-right">
            <div class="huge"><?php echo recordCount('orders'); ?></div>
            <div>New Orders!</div>
        </div>
    </div>
</div>
<a href="index.php?orders">
    <div class="panel-footer">
        <span class="pull-left">View Details</span>
        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
    </div>
</a>
</div>
</div>


<div class="col-lg-4 col-md-6">
<div class="panel panel-red">
<div class="panel-heading">
    <div class="row">
        <div class="col-xs-3">
            <i class="fa fa-support fa-5x"></i>
        </div>
        <div class="col-xs-9 text-right">
            <div class="huge"><?php echo recordCount('products'); ?></div>
            <div>Products!</div>
        </div>
    </div>
</div>
<a href="index.php?products">
    <div class="panel-footer">
        <span class="pull-left">View Details</span>
        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
    </div>
</a>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="panel panel-green">
<div class="panel-heading">
    <div class="row">
        <div class="col-xs-3">
            <i class="fa fa-tasks fa-5x"></i>
        </div>
        <div class="col-xs-9 text-right">
            <div class="huge"><?php echo recordCount('categories'); ?></div>
            <div>Categories!</div>
        </div>
    </div>
</div>
<a href="index.php?categories">
    <div class="panel-footer">
        <span class="pull-left">View Details</span>
        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        <div class="clearfix"></div>
    </div>
</a>
</div>
</div>


</div>

<!-- /.row -->


<!-- SECOND ROW WITH TABLES-->

<div class="row">
<div class="col-lg-6">
<div class="panel panel-default">
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
</div>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                <th>id</th>
                <th>Amount</th>
                <th>Transactions</th>
                <th>Currency</th>
                <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php display_orders_panel(); ?>
            </tbody>
        </table>
    </div>
    <div class="text-right">
        <a href="index.php?orders" class="btn bg-info">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
</div>
</div>







<div class="col-lg-6">
<div class="panel panel-default">
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Reports Panel</h3>
</div>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                <th>Id</th>
                 <th>Order Id</th>
                 <th>Product Id</th>
                 <th> Price</th>
                 <th> Title</th>
                 <th> Quantity</th>
                </tr>
            </thead>
            <tbody>
            <?php display_reports_main_admin(); ?>
            </tbody>
        </table>
    </div>
    <div class="text-right">
        <a href="index.php?reports" class="btn bg-info">View All Reports <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
</div>
</div>



</div>
<!-- /.row -->