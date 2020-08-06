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
        echo $row['product_price'];
    }
}

?>