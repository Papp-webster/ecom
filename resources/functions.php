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

//get products

function get_products() {
    $result = query("SELECT * FROM products");

    confirm($result);

    while($row = fetch_array($result)){

        $price = $row['product_price'];
        $title = $row['product_title'];
        $desc = $row['product_desc'];
        $img = $row['product_img'];

        $product = <<<DELIMITER
         <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="{$img}" alt="pic">
                            <div class="caption">
                                <h4 class="pull-right">&#8364;{$price}</h4>
                                <h4><a href="#">{$title}</a>
                                </h4>
                                <p>{$desc}</p>
                            </div>
                            <a class="btn btn-primary" target="_blank" href="item.php">Add to cart</a>
                        </div>
                    </div>
        DELIMITER;

        echo $product;
        
    }
}

?>