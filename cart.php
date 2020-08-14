<?php  require_once("./resources/config.php"); ?>

<?php

// add product
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
// remove product
if(isset($_GET['remove'])) {
    $_SESSION['product_' . $_GET['remove']]--;
    if($_SESSION['product_' . $_GET['remove']] < 1){

        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        
        redirect("checkout.php");
    } else {
        
        redirect("checkout.php");
    }
}

// delete product
if(isset($_GET['delete'])) {
    
    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);

    redirect("checkout.php");

}

function cart() {

    $total = 0;
    $item_quantity = 0;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;
    

    foreach ($_SESSION as $name => $value) {

        if($value > 0) {
               
        if(substr($name, 0, 8) == "product_") {

            $length = strlen($name - 8);

            $id = substr($name, 8, $length);

            $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
       confirm($query);

    while($row = fetch_array($query)) {

        $p_id = $row['product_id'];
        $title = $row['product_title'];
        $price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $sub_total = $price * $value;
       $item_quantity += $value;
        
     $cart = <<<DELIMITER
         <tr>
                <td>{$title}</td>
                <td>&#8364;{$price}</td>
                <td>{$value}</td>
                <td>&#8364;{$sub_total}</td>
                <td><a href="cart.php?add={$p_id}" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span></a></td>
                <td><a href="cart.php?remove={$p_id}" class="btn btn-warning"><span class='glyphicon glyphicon-minus'></span></a></td>
                <td><a href="cart.php?delete={$p_id}" class="btn btn-danger"><span class='glyphicon glyphicon-remove'></span></a></td>
              
            </tr>
            <input type="hidden" name="item_name_{$item_name}" value="{$p_id}">
            <input type="hidden" name="item_number_{$item_number}" value="{$p_id}">
            <input type="hidden" name="amount_{$amount}" value="{$price}">
            <input type="hidden" name="quantity_{$quantity}" value="{$value}">

     DELIMITER;

     echo $cart;
     
     $item_name++;
     $item_number++;
     $amount++;
     $quantity++;
    
      }

      $_SESSION['item_total'] = $total += $sub_total;
      $_SESSION['item_quantity'] = $item_quantity;

      

        }

        }
        
     
    }

  
} // end cart function

//paypal button

function show_paypal() {

 if(isset($_SESSION['item_quantity'])) {

    $paypal_button = <<<DELIMITER
    
    <input type="image" name="upload"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">

    DELIMITER;
    return $paypal_button;
}

}

?>