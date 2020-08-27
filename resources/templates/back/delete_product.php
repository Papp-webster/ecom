
<?php require_once("../../resources/config.php");

if(isset($_GET['delete_prod_id'])) {
 $query = query("DELETE FROM products WHERE product_id= " . escape_string($_GET['delete_prod_id']) . " ");
 confirm($query);

 set_message("Your product was deleted!");

 redirect("index.php?products");

} else {

    redirect("index.php?products");
}



?>
           