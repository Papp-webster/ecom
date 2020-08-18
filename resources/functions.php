<?php

// Helper functions

function set_message($msg) {
  if(!empty($msg)){
    
    $_SESSION['message'] = $msg;  
  
} else {
      
    $msg = "";
  
}
}

function display_message() {
    
    if(isset($_SESSION['message'])){
        
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location){
    header("Location: $location");

}

function query($sql) {

    global $connect;

    return mysqli_query($connect, $sql);
}

function confirm($result){
    global $connect;
    if(!$result){
  
        die("Adatbázis hiba:" . mysqli_error($connect));

    }
}

function escape_string($string){
global $connect;

return mysqli_real_escape_string($connect, $string);

}

function fetch_array($result){
    return mysqli_fetch_array($result);
}

function last_id() {
    global $connect;
    return mysqli_insert_id($connect);
}


/* FRONT END FUNCTIONS */

//get products

function get_products() {
    $result = query("SELECT * FROM products");

    confirm($result);

    while($row = fetch_array($result)){
        $p_id = $row['product_id'];
        $price = $row['product_price'];
        $title = $row['product_title'];
        $desc = $row['product_desc'];
        $img = $row['product_img'];

        $product = <<<DELIMITER
         <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id={$p_id}"><img src="{$img}" alt="pic"></a>
                            <div class="caption">
                                <h4 class="pull-right">&#8364;{$price}</h4>
                                <h4><a href="item.php?id={$p_id}">{$title}</a>
                                </h4>
                                <p>{$desc}</p>
                            </div>
                            <a class="btn btn-primary" href="../resources/cart.php?add={$p_id}">Add to cart</a>
                        </div>
                    </div>
        DELIMITER;

        echo $product;
        
    }
}


function get_categories() {

    global $connect;
    $query = query("SELECT * FROM categories");
    confirm($query);
     
    while($row = fetch_array($query)) {
        $cat_id = $row['cat_id'];
        $title = $row['cat_title'];
         $category_link = <<<DELIMITER
          <a href='category.php?id={$cat_id}' class='list-group-item'>{$title}</a>
         
         DELIMITER;

         echo $category_link;

     }
}
function get_prod_in_catpage() {
    
    $result = query(" SELECT * FROM products WHERE product_cat_id= " . escape_string($_GET['id']) . " ");

    confirm($result);

    while($row = fetch_array($result)){
        $p_id = $row['product_id'];
        $price = $row['product_price'];
        $title = $row['product_title'];
        $desc = $row['product_desc'];
        $short = $row['product_short'];
        $img = $row['product_img'];

        $cat_product = <<<DELIMITER
            
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id={$p_id}"><img src="{$img}" alt="pic"></a>
                    <div class="caption">
                        <h3>{$title}</h3>
                        <p>{$short}</p>
                        <p>
                            <a href="../resources/cart.php?add={$p_id}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$p_id}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
            
        DELIMITER;

         echo $cat_product;
    }

}

function get_prod_in_shop() {
    
    $result = query(" SELECT * FROM products");

    confirm($result);

    while($row = fetch_array($result)){
        $p_id = $row['product_id'];
        $price = $row['product_price'];
        $title = $row['product_title'];
        $desc = $row['product_desc'];
        $short = $row['product_short'];
        $img = $row['product_img'];

        $cat_product = <<<DELIMITER
            
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id={$p_id}"><img src="{$img}" alt="pic"></a>
                    <div class="caption">
                        <h3>{$title}</h3>
                        <p>{$short}</p>
                        <p>
                            <a href="../resources/cart.php?add={$p_id}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$p_id}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
            
        DELIMITER;

         echo $cat_product;
    }

}

// LOGIN USER

function login_user() {
   if(isset($_POST['submit'])){
       $username = escape_string($_POST['username']);
       $password = escape_string($_POST['password']);

   $query = query("SELECT * FROM users WHERE username = '{$username}' AND password ='{$password}'");
   confirm($query);

   if(mysqli_num_rows($query) == 0) {
       set_message("Your pass and username are wrong!");
       
    redirect("login.php");
   } else {

    $_SESSION['username'] = $username;
    redirect("admin");
   }

   } 
}

function send_message() {
    if(isset($_POST['send'])){

        $to = "papp.laszlo.web@gmail.com";
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $headers = "From: {$name} {$email}";
        $send_mail = mail($to, $subject, $message, $headers);
        if(!$send_mail){
            set_message("ERROR SENDIN EMAIL!");
            redirect("contact.php");
        }else {
           set_message("EMAIL SENT!");
           redirect("contact.php"); 
        }
    }
}




/* BACK END FUNCTIONS */


function display_orders() {
    $query= query("SELECT * FROM orders");
    confirm($query);

    while($row = fetch_array($query)) {
        $order_id= $row['order_id'];
        $order_amount = $row['order_amount'];
        $order_tx= $row['order_tx'];
        $order_currency= $row['order_currency'];
        $order_status= $row['order_status'];

        $orders = <<<DELIMITER
        <tr>  
            <td>{$order_id}</td>
            <td>{$order_amount}</td>
            <td>{$order_tx}</td>
            <td>{$order_currency}</td>
            <td>{$order_status}</td>
            <td><a href="../../resources/templates/back/delete_order.php?id={$order_id}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
           
DELIMITER;

     echo $orders;

    }

}

function display_products_admin() {
    $query= query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)) {
        $product_id= $row['product_id'];
        $product_title = $row['product_title'];
        $product_cat_id = $row['product_cat_id'];
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $product_img = $row['product_img'];

        $product_view = <<<DELIMITER
        <tr>  
            <td>{$product_id}</td>
            <td><img src="{$product_img}" alt="prod_pic" width = "100"></td>
            <td>{$product_title}</td>
            <td>{$product_cat_id}</td>
            <td>{$product_price}</td>
            <td>{$product_quantity}</td>
            

        </tr>
           
DELIMITER;

     echo $product_view;

    }

}

?>