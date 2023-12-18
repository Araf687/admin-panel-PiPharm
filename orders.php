<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php');
?>

<body>
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
                            <th>Order Type</th>
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
                                $orderType = $rows['order_type'];

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
                                  <td>
                                    <?php echo $orderType; ?>
                                  </td>

                                  <td class="<?php echo "order-" . $status; ?>">
                                    <span>
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
                                          onclick="setDefaultOrderStatus('<?= $status ?>')">
                                          <i class="ri-edit-2-line" style="color:#009289;"></i>
                                        </a>

                                      </li>

                                      <li>
                                        <a href="javascript:void(0)"
                                          onClick="<?php echo "del_product(" . "\"$ord_code\"" . ")"; ?>"
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
          const setDefaultOrderStatus = (status) => {
            console.log(status)
            $('#ordStatus').val("pending");
          }

          $(document).ready(function () {

            let request;

            $("#orderStatusForm").submit(function (event) {

              event.preventDefault();
              if (request) {
                request.abort();
              }
              var $form = $(this);
              var serializedData = $form.serialize();

              request = $.ajax({
                url: "php_backend/user/loginCode.php",
                type: "post",
                data: serializedData,
              });

              request.done(function (response, textStatus, jqXHR) {
                console.log(response);
                const jsonData = $.parseJSON(response);

                if (jsonData?.isSuccess) {
                  console.log(jsonData);
                  Swal.fire({
                    title: "Good job!",
                    text: "Logged In Successfully",
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

  <!-- Delete Modal Box Start -->
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
            <div class="remove-box d-flex justify-content-center">

              <input type="text" name="order_id" value=<?= $ord_id ?> style="display:none">
              <select class="form-select" id="ordStatus" name="ordStatus" aria-label="Default select example"
                style="border-radius:10px">
                <option selected>Select Order Status</option>
                <option value="pending">Pending</option>
                <option value="Packaging">Packaging</option>
                <option value="On the Way">On the Way</option>
                <option value="Completed">Completed</option>
              </select>


            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-animation btn-md fw-bold" data-bs-target="#exampleModalToggle2"
              data-bs-toggle="modal" name="changeOrderStatus" data-bs-dismiss="modal">Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</body>

</html>