<?php require_once("../../resources/config.php");

if(isset($_GET['category_id'])) {
 $query = query("DELETE FROM categories WHERE cat_id= " . escape_string($_GET['category_id']) . " ");
 confirm($query);

 set_message("Your categories was deleted!");

 redirect("index.php?categories");

} else {

    redirect("index.php?categories");
}



?>