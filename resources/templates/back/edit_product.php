


        
<?php 


if(isset($_GET['id'])) {
 
  $query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
 confirm($query);

 while($row = fetch_array($query)) {
        $title = $row['product_title'];
        $product_cat_id = $row['product_cat_id'];
        $price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $desc = $row['product_desc'];
        $short = $row['product_short'];
        $img = $row['product_img'];

$product_img = display_image($img);

}

update_products(); 

}


?>

<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product

</h1>


</div>
               


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control" value ="<?php echo $title; ?>">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php echo $desc; ?></textarea>
    </div>

    <div class="form-group">
           <label for="product-title">Product Short Description</label>
      <textarea name="product_short" id="" cols="30" rows="3" class="form-control"><?php echo $short; ?></textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" name="product_price" class="form-control" size="60" value ="<?php echo $price; ?>">
      </div>
    </div>




    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
    </div>


     <!-- Product Categories-->

    <div class="form-group">
         <label for="product-title">Product Category</label>
          
        <select name="product_cat_id" id="" class="form-control">
        <option value="<?php echo $product_cat_id; ?>">  <?php echo show_prod_categories_title($product_cat_id); ?> </option>
            <?php show_categories(); ?>
           
        </select>


</div>




    
<div class="form-group">
      <label for="product-title">Product Quantity</label>
         <input type="number" name="product_quantity" class="form-control" value ="<?php echo $product_quantity; ?>">
    </div>



    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="image">

        <img src="../../resources/<?php echo $product_img; ?>" alt="prod_img" width="100"/>
      
    </div>



</aside><!--SIDEBAR-->


    
</form>



                



           