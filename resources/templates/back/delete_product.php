


        





<?php require_once("../../config.php");

if(isset($_GET['id'])) {
 $query = query("DELETE FROM products WHERE product_id= " . escape_string($_GET['id']) . " ");
 confirm($query);

 set_message("Your product was deleted!");

 redirect("../../../shop/admin/index.php?products");

} else {

    redirect("../../../shop/admin/index.php?products");
}



?>
           