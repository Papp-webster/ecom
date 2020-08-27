<?php require_once("../../resources/config.php"); ?>

<?php include(TEMPLATE_BACK . DS ."/header.php"); ?>

<?php 

if(!isset($_SESSION['username'])) {
    redirect("../../shop");
}


?>

        <div id="page-wrapper">

            <div class="container-fluid">

               
                <!-- /.row -->

                <?php 
                
                if($_SERVER['REQUEST_URI'] == "/ecom/shop/admin/" || $_SERVER['REQUEST_URI'] == "/ecom/shop/admin/index.php") {
                    include(TEMPLATE_BACK . DS ."/admin_content.php");
                }

                if(isset($_GET['orders'])){
                    
                    include(TEMPLATE_BACK . DS ."/orders.php");
                }

                if(isset($_GET['add_product'])){
                    
                    include(TEMPLATE_BACK . DS ."/add_product.php");
                }

                if(isset($_GET['edit_product'])){
                    
                    include(TEMPLATE_BACK . DS ."/edit_product.php");
                }

               if(isset($_GET['categories'])){
                    
                    include(TEMPLATE_BACK . DS ."/categories.php");
                }

                if(isset($_GET['products'])){
                    
                    include(TEMPLATE_BACK . DS ."/products.php");
                }

                if(isset($_GET['delete_prod_id'])){
                    
                    include(TEMPLATE_BACK . DS ."/delete_product.php");
                }

                if(isset($_GET['users'])){
                    
                    include(TEMPLATE_BACK . DS ."/users.php");
                }

                if(isset($_GET['add_user'])){
                    
                    include(TEMPLATE_BACK . DS ."/add_user.php");
                }

                if(isset($_GET['edit_user'])){
                    
                    include(TEMPLATE_BACK . DS ."/edit_user.php");
                }

                if(isset($_GET['reports'])){
                    
                    include(TEMPLATE_BACK . DS ."/reports.php");
                }

                if(isset($_GET['report_id'])){
                    
                    include(TEMPLATE_BACK . DS ."/delete_report.php");
                }

                 if(isset($_GET['slides'])){
                    
                    include(TEMPLATE_BACK . DS ."/slides.php");
                }
                
                if(isset($_GET['delete_slide_id'])){
                    
                    include(TEMPLATE_BACK . DS ."/delete_slides.php");
                }

                if(isset($_GET['delete_order_id'])){
                    
                    include(TEMPLATE_BACK . DS ."/delete_order.php");
                }
                
                
                ?>

                

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include(TEMPLATE_BACK . DS ."/footer.php"); ?>