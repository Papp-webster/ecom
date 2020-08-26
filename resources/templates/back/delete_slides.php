<?php require_once("../../config.php");

if(isset($_GET['id'])) {
 
$query_find_image = query("SELECT slide_img FROM slides WHERE slide_id= " . escape_string($_GET['id']) . " LIMIT 1 ");
confirm($query_find_image);

$row = fetch_array($query_find_image);

$target_path = UPLOAD_DIRECTORY . DS . $row['slide_img'];

unlink($target_path);


 $query = query("DELETE FROM slides WHERE slide_id= " . escape_string($_GET['id']) . " ");
 confirm($query);

 

 

 set_message("Your slide was deleted!");

 redirect("../../../shop/admin/index.php?slides");

} else {

    redirect("../../../shop/admin/index.php?slides");
}



?>