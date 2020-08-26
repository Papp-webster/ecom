<?php

$upload_directory = "uploads";

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

        $product_photo = display_image($img);

        $product = <<<DELIMITER
         <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id={$p_id}"><img class"img-responsive" src="../resources/{$product_photo}" alt="pic"></a>
                            <div class="caption">
                                <h4 class="pull-right">&#8364;{$price}</h4>
                                <h4><a href="item.php?id={$p_id}">{$title}</a>
                                </h4>
                                <p>{$desc}</p>
                            </div>
                            <a class="btn btn-primary" href="../resources/cart.php?add={$p_id}">Add to cart</a> <a href="item.php?id={$p_id}" class="btn btn-default">More Info</a>
                        </div>
                    </div>
        DELIMITER;

        echo $product;
        
    }
}


function get_categories_menu() {

    
    $query = query("SELECT * FROM categories");
    confirm($query);
     
    while($row = fetch_array($query)) {
        $cat_id = $row['cat_id'];
        $title = $row['cat_title'];
         $category_link = <<<DELIMITER
         <li><a href="category.php?id={$cat_id}">{$title}</a></li>
                  
          
         
         DELIMITER;

         echo $category_link;

     }
}

function get_categories_side() {

    
    $query = query("SELECT * FROM categories");
    confirm($query);
     
    while($row = fetch_array($query)) {
        $cat_id = $row['cat_id'];
        $title = $row['cat_title'];
         $category_side = <<<DELIMITER
         
                  
          <a href='category.php?id={$cat_id}' class='list-group-item'>{$title}</a>
         
         DELIMITER;

         echo $category_side;

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

        $product_photo = display_image($img);

        $cat_product = <<<DELIMITER
            
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id={$p_id}"><img src="../resources/{$product_photo}" alt="pic"></a>
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
    
    $result = query("SELECT * FROM products");

    confirm($result);

    while($row = fetch_array($result)){
        $p_id = $row['product_id'];
        $price = $row['product_price'];
        $title = $row['product_title'];
        $desc = $row['product_desc'];
        $short = $row['product_short'];
        $img = $row['product_img'];

        $product_photo = display_image($img);

        $cat_product = <<<DELIMITER
            
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id={$p_id}"><img src="../resources/{$product_photo}" alt="pic"></a>
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

/* ADMIN PRODUCTS */

function display_image($picture) {

global $upload_directory;
return $upload_directory . DS . $picture;
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

        $category = show_prod_categories_title($product_cat_id);

        $product_photo = display_image($product_img);

        $product_view = <<<DELIMITER
        <tr>  
            <td>{$product_id}</td>
            <td><a href="index.php?edit_product&id={$product_id}"><img src="../../resources/{$product_photo}" alt="prod_pic" width = "100"></a></td>
            <td>{$product_title}</td>
            <td>{$category}</td>
            <td>{$product_price}</td>
            <td>{$product_quantity}</td>
            <td><a href="index.php?edit_product&id={$product_id}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a></td>
            <td><a href="../../resources/templates/back/delete_product.php?id={$product_id}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
            

        </tr>
           
DELIMITER;

     echo $product_view;

    }

}


function show_prod_categories_title($product_category) {

$category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category}' ");
confirm($category_query);

while($category_row = fetch_array($category_query)) {

    return $category_row['cat_title'];

}

}


/* ADD PRODUCTS */

function add_products() {
    
    if(isset($_POST['publish'])) {
     $product_title = escape_string($_POST['product_title']);
     $product_cat_id = escape_string($_POST['product_cat_id']);
     $product_desc = escape_string($_POST['product_desc']);
     $product_short = escape_string($_POST['product_short']);
     $product_quantity = escape_string($_POST['product_quantity']);
     $product_price = escape_string($_POST['product_price']);
     $product_image = escape_string($_FILES['image']['name']);
     $image_temp_location = escape_string($_FILES['image']['tmp_name']);

     

    move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $product_image);

    

     $query = query("INSERT INTO products(product_title, product_cat_id, product_price, product_quantity, product_desc, product_short, product_img) VALUES ('{$product_title}', '{$product_cat_id}', '{$product_price}', '{$product_quantity}', '{$product_desc}', '{$product_short}', '{$product_image}')");
     
     $last_id = last_id();
     confirm($query);
     set_message("New product number {$last_id} added!");
     redirect("index.php?products");
     


    }
}

function show_categories() {

    global $connect;
    $query = query("SELECT * FROM categories");
    confirm($query);
     
    while($row = fetch_array($query)) {
        $cat_id = $row['cat_id'];
        $title = $row['cat_title'];
         
        $category_option = <<<DELIMITER
         <option value="{$cat_id}">{$title}</option>
         
         DELIMITER;

         echo $category_option;

     }
}


/* Edit PRODUCTS */

function update_products() {
    
    if(isset($_POST['update'])) {
     
     $product_title = escape_string($_POST['product_title']);
     $product_cat_id = escape_string($_POST['product_cat_id']);
     $product_price = escape_string($_POST['product_price']);
     $product_quantity = escape_string($_POST['product_quantity']);
     $product_description = escape_string($_POST['product_desc']);
     $product_short = escape_string($_POST['product_short']);
     $product_image = escape_string($_FILES['image']['name']);
     $image_temp_loc = escape_string($_FILES['image']['tmp_name']);

     $location = "uploads";

     if(empty($product_image)) {
         $get_pic = query("SELECT product_img FROM products WHERE product_id = ". escape_string($_GET['id']) ." ");
         confirm($get_pic);
         
         while($pic = fetch_array($get_pic)) {
             
            $product_image = $pic['product_img'];

         }
     }

    move_uploaded_file($image_temp_loc , "$location/$product_image" );

$query = "UPDATE products SET ";
$query .= "product_title            = '{$product_title}', ";
$query .= "product_cat_id           = '{$product_cat_id}', ";
$query .= "product_price            = '{$product_price}', ";
$query .= "product_quantity         = '{$product_quantity}', ";
$query .= "product_desc             = '{$product_description}', ";
$query .= "product_short            = '{$product_short}', ";
$query .= "product_img              = '{$product_image}'          ";
$query .= "WHERE product_id=" . escape_string($_GET['id']);

     
     
    
    $send_query = query($query);
     confirm($send_query);
     set_message("This product updated!");
     redirect("index.php?products");
     


    }
}

/* Categories in admin */

function show_categories_in_admin() {

    $cat_query = query("SELECT * FROM categories");
    confirm($cat_query);

    while($row = fetch_array($cat_query)) {
     $cat_id = $row['cat_id'];
     $cat_title = $row['cat_title'];

     $category = <<<EOF
     <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td><a href="../../resources/templates/back/delete_category.php?id={$cat_id}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
     
     
     EOF;
     
     echo $category;
    }

}

function add_category_in_admin() {


    if(isset($_POST['add_category'])) {
     $cat_title = escape_string($_POST['cat_title']);
     
     if(empty($cat_title) || $cat_title == " "){
       echo "<p class =' text-center bg-warning'>This field cannot be empty!</p>";
     } else{
    
     
     $insert_query = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
     confirm($insert_query);
     set_message("Category created!");
     

     }

    }
    
}

/************************ADMIN users***********************/



function display_users() {


$user_query = query("SELECT * FROM users");
confirm($user_query);


while($row = fetch_array($user_query)) {

$user_id = $row['user_id'];
$username = $row['username'];
$email = $row['email'];
$password = $row['password'];
$photo = $row['user_photo'];

$user_photo = display_image($photo);

$user = <<<DELIMETER


<tr>
    <td>{$user_id}</td>
    <td>{$username}</td>
     <td>{$email}</td>
     <td><img src="../../resources/{$user_photo}" alt="user_pic" width = "100"></td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$user_id}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

echo $user;



    }



}


function add_user() {


if(isset($_POST['add_user'])) {


$username   = escape_string($_POST['username']);
$email      = escape_string($_POST['email']);
$password   = escape_string($_POST['password']);
$user_photo = escape_string($_FILES['file']['name']);
$photo_temp = escape_string($_FILES['file']['tmp_name']);


move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);


$users_query = query("INSERT INTO users(username,email,password, user_photo) VALUES('{$username}','{$email}','{$password}', '{$user_photo}')");
confirm($users_query);

set_message("USER CREATED");

redirect("index.php?users");



}



}

function display_reports_admin() {
    $report_query= query("SELECT * FROM reports");
    confirm($report_query);

    while($row = fetch_array($report_query)) {

        

        $report_id= $row['report_id'];
        $order_id= $row['order_id'];
        $product_id= $row['product_id'];
        $product_title = $row['product_title'];
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        

        

        $reports_view = <<<DELIMITER
        <tr>  
            <td>{$report_id}</td>
             <td>{$order_id}</td>
              <td>{$product_id}</td>
            <td>{$product_price}</td>
            <td>{$product_title}</td>
            <td>{$product_quantity}</td>
            <td><a href="../../resources/templates/back/delete_report.php?id={$report_id}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
            

        </tr>
           
DELIMITER;

     echo $reports_view;

    }
}


/********** SLIDER *****************/

function add_slides() {

if(isset($_POST['add_slide'])) {
    $slide_title = escape_string($_POST['slide_title']);
    $slide_img = escape_string($_FILES['file']['name']);
    $slide_img_loc = escape_string($_FILES['file']['tmp_name']);

    if(empty($slide_title) || empty($slide_img)) {
        echo "<p class='text-center bg-warning'>This field is empty!</p>";
    } else {
        move_uploaded_file($slide_img_loc, UPLOAD_DIRECTORY . DS . $slide_img);

        $query = query("INSERT INTO slides(slide_title, slide_img) VALUES('{$slide_title}', '{$slide_img}') ");
        confirm($query);
        set_message("Slide added!");
        redirect("index.php?slides");
    }
}

}

function get_current_slide() {
 $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while($row = fetch_array($query)) {
        $slide_id = $row['slide_id'];
        $slide_img = $row['slide_img'];

        $product_img = display_image($slide_img);

        $active_slides_admin = <<<EOF
         
         <img class="img-responsive" src="../../resources/{$product_img}" alt="slide_img">
          
        EOF;

        echo $active_slides_admin;
    }


}

function get_active() {
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while($row = fetch_array($query)) {
        $slide_id = $row['slide_id'];
        $slide_img = $row['slide_img'];

        $product_img = display_image($slide_img);

        $active_slides = <<<EOF
         <div class="item active">
         <img class="slide-image" src="../resources/{$product_img}" alt="slide_img">
          </div>
        EOF;

        echo $active_slides;
    }


}

function get_slides() {

    $query = query("SELECT * FROM slides");
    confirm($query);

    while($row = fetch_array($query)) {
        $slide_id = $row['slide_id'];
        $slide_img = $row['slide_img'];

        $product_img = display_image($slide_img);

        $slides = <<<EOF
         <div class="item">
         <img class="slide-image" src="../resources/{$product_img}" alt="slide_img">
          </div>
        EOF;

        echo $slides;
    }

   
}

function get_slide_thumbnails() {

    $query = query("SELECT * FROM slides ORDER BY slide_id ASC ");
    confirm($query);

    while($row = fetch_array($query)) {
        $slide_id = $row['slide_id'];
        $slide_title = $row['slide_title'];
        $slide_img = $row['slide_img'];

        $product_img = display_image($slide_img);

        $slides_thumb = <<<EOF
          <div class="col-xs-6 col-md-3" id="img_box">
                 
          <a href="../../resources/templates/back/delete_slides.php?id={$slide_id}" class="">
          <img width="200" src="../../resources/{$product_img}" alt="" class="img-responsive slide_image"></a>
          <div class="caption"><p>{$slide_title}</p></div>  
          </div>
       
       
EOF;

        echo $slides_thumb;
    }



}

?>