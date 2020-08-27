<?php require_once("../../resources/config.php");

if(isset($_GET['report_id'])) {
 $query = query("DELETE FROM reports WHERE report_id= " . escape_string($_GET['report_id']) . " ");
 confirm($query);

 set_message("Your report was deleted!");

 redirect("index.php?reports");

} else {

    redirect("index.php?reports");
}



?>