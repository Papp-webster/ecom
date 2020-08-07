<?php

// Helper functions

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
                            <a class="btn btn-primary" href="#">Show</a>
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
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$p_id}" class="btn btn-default">More Info</a>
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
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$p_id}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
            
        DELIMITER;

         echo $cat_product;
    }

}

/* BACK END FUNCTIONS */

?>