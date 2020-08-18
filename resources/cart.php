<?php  require_once("config.php"); ?>

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
        redirect("../shop/checkout.php");
    }
    else {
 set_message("We only have " . $quantity . " {$title} " . "available");
 redirect("../shop/checkout.php");
}
 

}
}
// remove product
if(isset($_GET['remove'])) {
    $_SESSION['product_' . $_GET['remove']]--;
    if($_SESSION['product_' . $_GET['remove']] < 1){

        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        
        redirect("../shop/checkout.php");
    } else {
        
        redirect("../shop/checkout.php");
    }
}

// delete product
if(isset($_GET['delete'])) {
    
    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);

    redirect("../shop/checkout.php");

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
                <td><a href="../resources/cart.php?add={$p_id}" class="btn btn-success"><span class='glyphicon glyphicon-plus'></span></a></td>
                <td><a href="../resources/cart.php?remove={$p_id}" class="btn btn-warning"><span class='glyphicon glyphicon-minus'></span></a></td>
                <td><a href="../resources/cart.php?delete={$p_id}" class="btn btn-danger"><span class='glyphicon glyphicon-remove'></span></a></td>
              
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

 if(isset($_SESSION['item_quantity'])  && $_SESSION['item_quantity']  >= 1) {

    $paypal_button = <<<DELIMITER
    
    <div class="paypal">
    <button type="submit" name="paypal"><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" border="0" alt="PayPal Logo"></button>
     </div>

DELIMITER;
    return $paypal_button;
}

}


function process_transaction() {



    if(isset($_GET['tx'])) {
    
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $transaction = $_GET['tx'];
    $status = $_GET['st'];
    $total = 0;
    $item_quantity = 0;
    
    foreach ($_SESSION as $name => $value) {
    
    if($value > 0 ) {
    
    if(substr($name, 0, 8 ) == "product_") {
    
    $length = strlen($name - 8);
    $id = substr($name, 8 , $length);
    
    // insert orders
    $send_order = query("INSERT INTO orders (order_amount, order_tx, order_status, order_currency ) VALUES('{$amount}', '{$transaction}','{$status}','{$currency}')");
    $last_id = last_id();
    confirm($send_order);
    
    
    
    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id). " ");
    confirm($query);
    
    while($row = fetch_array($query)) {
    $product_price = $row['product_price'];
    $product_title = $row['product_title'];
    $sub = $row['product_price']*$value;
    $item_quantity +=$value;
    
    // insert reports
    $insert_report = query("INSERT INTO reports (order_id, product_id, product_price, product_title, product_quantity) VALUES('{$last_id}','{$id}','{$product_price}','{$product_title}','{$value}')");
    confirm($insert_report);
    
   
    
    }
    
    
    $total += $sub;
    echo $item_quantity;
    
    
               }
    
          }
    
        }
    
    session_destroy();
      } else {
    
    
    redirect("index.php");
    
    
    }
    
    
    
    }
    
  

?>