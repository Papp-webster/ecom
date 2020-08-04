<div class="col-md-3">
    <p class="lead">Shop Name</p>
    <div class="list-group">
     <?php
     $query = "SELECT * FROM categories";
     $send_query = mysqli_query($connect, $query);
     confirm($send_query);
     
     
     while($row = mysqli_fetch_array($send_query)) {
        $cat_title = $row['cat_title'];
        echo "<a href='#' class='list-group-item'>{$cat_title}</a>";
     }
     
     
     ?>





        
                    </div>
            </div>