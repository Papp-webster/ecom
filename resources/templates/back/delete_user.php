<?php require_once("../../config.php");

if(isset($_GET['id'])) {
 $query = query("DELETE FROM users WHERE user_id = " . escape_string($_GET['id']) . " ");
 confirm($query);

 set_message("User was deleted!");

 redirect("../../../shop/admin/index.php?users");

} else {

    redirect("../../../shop/admin/index.php?users");
}



?>