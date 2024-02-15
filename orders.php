<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php');
?>

<body>

<?php
if (isset($_SESSION['status'])) {

  if ($_SESSION['status'] == "delete") {
    echo "<script>Swal.fire(
        'Great!',
        'Delete Successfully!',
        'success'
    );
    </script>";
  }
  else {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something Went Wrong!',
      })
    </script>";
  }
  unset($_SESSION['status']);
}
?>
  <!-- tap on top start -->
  <div class="tap-top">
    <span class="lnr lnr-chevron-up"></span>
  </div>
  <!-- tap on tap end -->

  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php include('includes/header.php');
    ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <?php include('includes/sidebar.php');
      ?>

      <!-- Order section Start -->
      <div class="page-body">
        <!-- Table Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-body">
                  <div class="title-header option-title">
                    <h5>Order List</h5>
                  </div>
                  <div>
                    <div class="table-responsive">
                      <table class="table all-package order-table theme-table" id="table_id">
                        <thead>
                          <tr>
                            <th>Order Code</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Order Status</th>
                            <th>Delivery Status</th>
                            <th>Amount</th>
                            <th>Option</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $status = '';
                          $admin_id = 0;
                          if (isset($_SESSION['loginInfo']["id"])) {
                            $admin_id = $_SESSION['loginInfo']["id"];
                          }

                          settype($admin_id, "integer");

                          $fetchPrdQuery = "SELECT * FROM orders WHERE `pharmacy_id`=$admin_id";

                          $query_result = mysqli_query($conn, $fetchPrdQuery);

                          if ($query_result == true) {
                            $count = mysqli_num_rows($query_result);
                            $slNo = 1;
                            if ($count > 0) {
                              echo "<tbody>";
                              while ($rows = mysqli_fetch_assoc($query_result)) {
                                $ord_id = $rows['id'];
                                $ord_date = $rows['created_date'];
                                $ord_code = $rows['order_code'];
                                $amount = $rows['sale_amount'];
                                $pay_method = $rows['payment_method'];
                                $status = $rows['delivery_status'];
                                $orderStatus = $rows['order_status'];
                                $customer_id = $rows['cust_id'];

                                $exploded_date = explode(" ", $ord_date);
                                $newDate = date("jS F Y", strtotime($exploded_date[0]));

                                ?>
                                <!-- data-bs-toggle = "offcanvas"  -->
                                <tr href="#order-details">
                                  <td>
                                    <?php echo $ord_code; ?>
                                  </td>

                                  <td>
                                    <?php echo $newDate; ?>
                                  </td>
                                  <td>
                                    <?php echo $pay_method; ?>
                                  </td>
                                  <td class="<?php echo "order-" . strtolower($orderStatus); ?>"
                                    id='<?= $ord_id . "-ordStatus" ?>'>
                                    <span id='<?= $ord_id . "_ord_span" ?>'>
                                      <?php echo $orderStatus; ?>
                                    </span>
                                  </td>

                                  <td class="<?php echo "delivery-" . str_replace(" ", "-", strtolower($status)); ?>"
                                    id='<?= $ord_id . "_deliveryStatus" ?>'>
                                    <span id='<?= $ord_id . "_deliver_span" ?>'>
                                      <?php echo $status; ?>
                                    </span>
                                  </td>

                                  <td>$
                                    <?php echo $amount; ?>
                                  </td>

                                  <td>
                                    <ul>
                                      <li>
                                        <a href="<?php echo "order-detail.php?ord_id=" . $ord_id; ?>">
                                          <i class="ri-eye-line"></i>
                                        </a>

                                      </li>
                                      <li>
                                        <!-- <a href="#">
                                          <i class="ri-edit-2-line" style="color:#009289;"></i>
                                        </a> -->
                                        <!-- Button trigger modal -->
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                          data-bs-target="#exampleEditOrderModal"
                                          onclick="setDefaultStatus('<?= $status ?>' , '<?= $orderStatus ?>')">
                                          <i class="ri-edit-2-line" style="color:#009289;"></i>
                                        </a>

                                      </li>
                                      <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#sendMailToggle"
                                          onclick="handleClickSendEmail('<?= $customer_id ?>','<?= $ord_id ?>')">
                                          <i class="ri-mail-line" style="color:#00ACC1;"></i>
                                        </a>
                                      </li>

                                      <li>
                                        <a href="javascript:void(0)"
                                          onClick="<?php echo "del_product('$ord_code')"; ?>"
                                          data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                          <i class="ri-delete-bin-line"></i>
                                        </a>
                                      </li>
                                    </ul>
                                  </td>
                                </tr>
                              <?php }
                            }
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Table End -->
        <script>
          const del_product = (ordId) => {
            console.log(ordId);
            sessionStorage.setItem("tableName", "order");
            sessionStorage.setItem("del_id", ordId);

          }
          const setDefaultStatus = (deliveryStatus, orderStatus) => {
            console.log(deliveryStatus, orderStatus, deliveryStatus.toLowerCase())
            $('#deliveryStatus').val(deliveryStatus.toLowerCase());
            $('#ordStatus').val(orderStatus.toLowerCase());
          }

          $(document).ready(function () {

            let request;

            $("#orderStatusForm").submit(function (event) {

              event.preventDefault();
              if (request) {
                request.abort();
              }
              var form = $(this);
              var serializedData = form.serialize();

              request = $.ajax({
                url: "querryCode/updateOrderStatus.php",
                type: "post",
                data: serializedData,
              });

              request.done(function (response, textStatus, jqXHR) {
                console.log(response);
                const jsonData = $.parseJSON(response);

                if (jsonData?.isSuccess) {
                  console.log(jsonData);
                  const { orderId, deliveryStatus, orderStatus } = jsonData.data;

                  console.log(orderId, deliveryStatus, orderStatus, `delivery-${deliveryStatus.toLowerCase()}`)

                  $(`#${orderId}-ordStatus`).removeClass().addClass(`order-${orderStatus.toLowerCase()}`);
                  $(`#${orderId}_ord_span`).text(orderStatus);

                  $(`#${orderId}_deliveryStatus`).removeClass().addClass(`delivery-${deliveryStatus.toLowerCase().replace(/ /g, "-")}`);
                  $(`#${orderId}_deliver_span`).text(deliveryStatus);


                  Swal.fire({
                    title: "Good job!",
                    text: "Status Changed Successfully",
                    icon: "success"
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to Update Status",
                  });
                }
              });

              request.fail(function (jqXHR, textStatus, errorThrown) {
                console.error("The following error occurred: " + textStatus, errorThrown);
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Something went wrong!",
                });
              });
              request.always(function () { });
            });
          })

          const handleClickSendEmail = (customerId, orderId) => {
            $('#orderId_Input').val(orderId)
            $('#customerId_Input').val(customerId);

            console.log(customerId, orderId);
          }

          const sendEmailToCustomer = () => {
            const orderId = $('#orderId_Input').val();
            const customerId = $('#customerId_Input').val();

            const data = {
              orderId: orderId,
              customerId: customerId,
            }

            $.ajax({
              url: "querryCode/sendMailCode.php",
              type: "POST",
              data: data,
              success: function (response) {
                console.log(response)
                const jsonData = $.parseJSON(response);


                console.log(jsonData);

                if (jsonData.isSuccess) {
                  $(`#${orderId}_ord_span`).text("completed");
                  $(`#${orderId}-ordStatus`).removeClass();
                  $(`#${orderId}-ordStatus`).addClass("delivery-completed");

                  $(`#${orderId}_deliver_span`).text("completed");
                  $(`#${orderId}_deliveryStatus`).removeClass();
                  $(`#${orderId}_deliveryStatus`).addClass("delivery-completed");

                  $('#loaderCancelBTN').click();
                  Swal.fire({
                    title: "Great job!",
                    text: "Mail sended successfully to "+jsonData.data.customerName+"! (mail: "+jsonData.data.destinationMail+")",
                    icon: "success",
                    
                  });
                }




              },
              error: function (xhr, status, error) {
                // Handle errors
                console.log("AJAX request failed:", status, error);
                console.log(xhr.responseText);

                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Something went wrong! Failed to send email.",
                });
              }
            });

          }




        </script>

        <?php include('includes/footer.php');
        ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <?php include('includes/scripts.php');
  ?>

  <!-- update delivery status Modal Box Start -->
  <div class="modal fade theme-modal remove-coupon" id="exampleEditOrderModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">
        <form id="orderStatusForm">
          <div class="modal-header d-block text-center my-3">
            <h5 class="modal-title w-100" id="exampleModalLabel22">Change Order Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body" style="min-height:120px">
            <input type="text" name="order_id" value=<?= $ord_id ?> style="display:none">
            <p class="mb-0">Order Status</p>
            <div class="remove-box d-flex justify-content-center mb-3">

              <select class="form-select" id="ordStatus" name="ordStatus" aria-label="Default select example"
                style="border-radius:10px">
                <option selected>Select Order Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="completed">Completed</option>
              </select>
            </div>
            <p class="mb-0">Delivery Status</p>
            <div class="remove-box d-flex justify-content-center">
              <select class="form-select" id="deliveryStatus" name="deliveryStatus" aria-label="Default select example"
                style="border-radius:10px">
                <option selected>Select Deliver Status</option>
                <option value="pending">Pending</option>
                <option value="packaging">Packaging</option>
                <option value="on-the-way">On the Way</option>
                <option value="completed">Completed</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-animation btn-md fw-bold" name="changeOrderStatus"
              data-bs-dismiss="modal">Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>


  <!-- modal  -->
  <!-- send mail -->
  <div class="modal fade theme-modal remove-coupon" id="sendMailToggle" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-block text-center">
          <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="remove-box">
            <p>Send the delivery confirmation email to Customer.</p>
            <input type="text" class='d-none' id="orderId_Input">
            <input type="text" class='d-none' id="customerId_Input">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-animation btn-md fw-bold" onClick="sendEmailToCustomer()"
            data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loaderModal">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- loader modal -->
  <div class="modal fade theme-modal remove-coupon" id="loaderModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-block text-center">

        </div>
        <div class="modal-body text-center ">
          <div class="spinner-border text-success p-4" role="status">
            <span class="sr-only">Loading...</span>
            
          </div>
          <p>Loading...</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="loaderCancelBTN" class="btn btn-animation btn-md fw-bold d-none"
            data-bs-dismiss="modal">No</button>

        </div>
      </div>
    </div>







</body>

</html>