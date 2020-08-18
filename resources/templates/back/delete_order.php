<?php require_once("../../config.php");

if(isset($_GET['id'])) {
 $query = query("DELETE FROM orders WHERE order_id= " . escape_string($_GET['id']) . " ");
 confirm($query);

 set_message("Your order was deleted!");

 redirect("../../../shop/admin/index.php?orders");

} else {

    redirect("../../../shop/admin/index.php?orders");
}



?>