<?php  require_once("./resources/config.php"); ?>

<?php 
if(isset($_GET['add'])) {

$query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) . " ");
confirm($query);

while($row = fetch_array($query)){
    $quantity = $row['product_quantity'];
    $title = $row['product_title'];
    if($quantity != $_SESSION['product_' . $_GET['add']]) {
        $_SESSION['product_' . $_GET['add']] +=1;
        redirect("checkout.php");
    }
    else {
 set_message("We only have " . $quantity . " {$title} " . "available");
 redirect("checkout.php");
}
 

}
}

?>