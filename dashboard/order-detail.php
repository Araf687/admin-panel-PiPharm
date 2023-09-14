<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php'); ?>

<body>
  <!-- tap on top start -->
  <div class="tap-top">
    <span class="lnr lnr-chevron-up"></span>
  </div>
  <!-- tap on tap end -->

  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php include('includes/header.php'); ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <?php include('includes/sidebar.php'); ?>

      <!-- tracking section start -->
      <div class="page-body">
        <!-- tracking table start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
              <?php 
                  include "config/dbConn.php";
                    $ord_id=$_GET['ord_id'];

                    $fetchCatQuerry="SELECT * FROM orders WHERE id='$ord_id' LIMIT 1";
                    $querry_result=mysqli_query($conn,$fetchCatQuerry);

                    if($querry_result==true){
                        $count=mysqli_num_rows($querry_result);
                        $slNo=1;

                        if( $count>0){
                            while($rows=mysqli_fetch_assoc($querry_result)){
                                  $ord_date=$rows['created_date'];
                                  $ord_code=$rows['order_code'];
                                  $amount=$rows['sale_amount'];
                                  $pay_method=$rows['payment_method'];
                                  $status=$rows['delivery_status'];
                                  $total_items=$rows['total_items'];
                                  $shippingCost=$rows['shipping_cost'];
                                  $tax=$rows['tax'];

                                  $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $ord_date);
                                  $date = $myDateTime->format('jS F Y');
                                  $time = $myDateTime->format('g:ia');//11:47am

                                  $address=explode("@",$rows['shipping_address']);
                                  $contact=$rows['contact_no'];
            ?>
                <div class="card-body">
                  <div class="title-header title-header-block package-card">
                    <div>
                      <h5>Order #<?php echo $ord_code;?></h5>
                    </div>
                    <div class="card-order-section">
                      <ul>
                        <li><?php echo $date." at ".$time;?></li>
                        <li><?php echo $total_items;?> items</li>
                        <li>Total $<?php echo $amount;?></li>
                      </ul>
                    </div>
                  </div>
                  <div class="bg-inner cart-section order-details-table">
                    <div class="row g-4">
                      <div class="col-xl-8">
                        <div class="table-responsive table-details">
                          <table class="table cart-table table-borderless">
                            <thead>
                              <tr>
                                <th colspan="2">Items</th>
                                <th class="text-end" colspan="2">
                                  <a href="javascript:void(0)" class="theme-color">Edit
                                    Items</a>
                                </th>
                              </tr>
                            </thead>

                            <tbody>
                            <?php 
                              $fetchCatQuerry="SELECT o.order_code as ordCode, o.prod_id, o.attr_value, o.qty, o.subTotal, p.prd_id as pID, p.prd_name, p.prd_image FROM orderitems o, product p WHERE o.prod_id=p.prd_id AND o.order_code='$ord_code' ORDER BY o.order_code DESC";

                                
                              // $fetchCatQuerry="SELECT * FROM orderitems WHERE ord_id=$ord_id";
                              $querry_result=mysqli_query($conn,$fetchCatQuerry);
                              
                              $totalAmount=0;
                              if($querry_result==true){
                                  $cartTotal=0;
                                  $count=mysqli_num_rows($querry_result);
                                  $slNo=1;

                                  if( $count>0){
                                      while($rows=mysqli_fetch_assoc($querry_result)){

                                        $item_image=explode('@',$rows['prd_image'])[0];
                                        $qty=$rows['qty'];
                                        $product_name=$rows['prd_name'];
                                        $subTotal=$rows['subTotal'];
                                        $attr_name=$rows['attr_value'];
                                        
                                        $totalAmount=$totalAmount+$subTotal;                                 
                                        $slNo++;                               
                              ?>
                                <tr class="table-order">
                                  <td>
                                    <a href="javascript:void(0)">
                                      <img src='<?php echo "assets/images/product/$item_image"?>' class="img-fluid blur-up lazyload" alt="">
                                    </a>
                                  </td>
                                  
                                  <td>
                                    <p class="mb-1">Product Name</p>
                                    <h6 class="text-wrap"><?php echo "<strong>$product_name</strong>"?></h6>
                                    <p class="text-wrap">
                                      <?php
                                      if($attr_name!=""){
                                        echo "(".$attr_name.")";
                                      }
                                      ?>
                                    </p>
                                  </td>
                                  <td>
                                    <p>Quantity</p>
                                    <h6><?php echo $qty;?></h6>
                                  </td>
                                  <td>
                                    <p>Price</p>
                                    <h6>$<?php echo $subTotal?></h6>
                                  </td>
                                </tr>
                              <?php
                                      
                                  }}
                                  else{
                                      echo "<h5 class='text-center'>Order Detail Cart Is empty</h5>";
                                  }
                              
                              }
                              ?>
                            </tbody>

                            <tfoot>
                              <tr class="table-order">
                                <td colspan="3">
                                  <h5>Subtotal :</h5>
                                </td>
                                <td>
                                  <h4>$<?php echo $totalAmount?></h4>
                                </td>
                              </tr>

                              <tr class="table-order">
                                <td colspan="3">
                                  <h5>Shipping :</h5>
                                </td>
                                <td>
                                  <h4>$<?php echo $shippingCost;?></h4>
                                </td>
                              </tr>

                              <tr class="table-order">
                                <td colspan="3">
                                  <h5>Tax(GST) :</h5>
                                </td>
                                <td>
                                  <h4>$<?php echo $tax;?></h4>
                                </td>
                              </tr>
                              <tr class="table-order">
                                <td colspan="3">
                                  <h4 class="theme-color fw-bold">Total Price :</h4>
                                </td>
                                <td>
                                  <h4 class="theme-color fw-bold">$<?php echo $amount;?></h4>
                                </td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                      <div class="col-xl-4">
                        <div class="order-success">
                          <div class="row g-4">
                            <h4>summery</h4>
                            <ul class="order-details">
                              <li>Order ID: <?php echo $ord_code;?></li>
                              <li>Order Date: <?php echo $date;?></li>
                              <li>Order Total: $<?php echo $amount;?></li>
                            </ul>

                            <h4>shipping address</h4>
                            <ul class="order-details">
                              <li><?php echo $address[0];?></li>
                              <li><?php echo $address[1]?></li>
                              <li><?php echo $address[2]." Contact No. ".$contact;?></li>
                            </ul>

                            <div class="payment-mode">
                              <h4>payment method</h4>
                              <p>
                                <!-- Pay on Delivery (Cash/Card). Cash on delivery (COD)
                                available. Card/Net banking acceptance subject to device
                                availability. -->
                                <?php echo $pay_method;?>

                              </p>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- section end -->
                </div>
              <?php }}}?>
              </div>
            </div>
          </div>
        </div>
        <!-- tracking table end -->
        
        <?php include('includes/footer.php'); ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <?php include('includes/scripts.php'); ?>
</body>

</html>
