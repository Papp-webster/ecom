<h1 class="page-header">
   All Reports

</h1>

<h4 class="text-center bg-success"><?php display_message(); ?></h4>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Order Id</th>
           <th>Product Id</th>
           <th>Product Price</th>
           <th>Product Title</th>
           <th>Product Quantity</th>
           <th>Delete</th>
      </tr>
    </thead>
    <tbody>

    <?php display_reports_admin(); ?>
      


  </tbody>
</table>