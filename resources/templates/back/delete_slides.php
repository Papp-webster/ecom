<?php require_once("../../resources/config.php");

if(isset($_GET['slides_id'])) {
 
$query_find_image = query("SELECT slide_img FROM slides WHERE slide_id= " . escape_string($_GET['slides_id']) . " LIMIT 1 ");
confirm($query_find_image);

$row = fetch_array($query_find_image);

$target_path = UPLOAD_DIRECTORY . DS . $row['slide_img'];

unlink($target_path);


 $query = query("DELETE FROM slides WHERE slide_id= " . escape_string($_GET['slides_id']) . " ");
 confirm($query);

 

 

 set_message("Your slide was deleted!");

 redirect("index.php?slides");

} else {

    redirect("index.php?slides");
}



?>