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

        <?php
        $notification_id = $_GET['id'];
        $update_notification_sql = "UPDATE notifications SET status=1 WHERE id = $notification_id";
        $update_result = mysqli_query($conn, $update_notification_sql);
        if ($update_result) {
            include('includes/header.php');
        }

        ?>

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <?php include('includes/sidebar.php');
            ?>

            <!-- tracking section start -->
            <div class="page-body">
                <!-- tracking table start -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <h3>Notification Details</h3>
                                    <?php
                                    $notification_id = $_GET['id'];

                                    // Your SQL query with a JOIN operation
                                    $sql = "SELECT n.*, user.name,user.email,user.phone
                                            FROM notifications n       
                                            INNER JOIN user ON n.customer_id = user.id AND n.id=$notification_id";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result == true) {
                                        $count = mysqli_num_rows($result);
                                        $slNo = 1;

                                        if ($count > 0) {

                                            $row = mysqli_fetch_assoc($result);
                                            $order_id = $row['order_id'];
                                            $created_date = $row['created_at'];
                                            $ord_code = $row['order_code'];
                                            $title = $row['title'];
                                            $description = $row['description'];
                                            $user_name = $row['name'];
                                            $user_email = $row['email'];
                                            $user_phone = $row['phone'];


                                            $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $created_date);
                                            $date = $myDateTime->format('jS F Y');
                                            $time = $myDateTime->format('g:ia');
                                            //11:47am
                                    


                                            ?>
                                            <div class="title-header title-header-block package-card mt-3">

                                                <div class="card-order-section">
                                                    <ul>
                                                        <li>
                                                            <?php echo $date . " at " . $time; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="bg-inner cart-section order-details-table">
                                                <div class="row g-4">
                                                    <div class="col-xl-12">
                                                        <h2 class="mb-3">
                                                            <?= $title ?>
                                                        </h2>
                                                        <h4>
                                                            <?= $description ?>
                                                        </h4>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-2">
                                                            Order Code:
                                                            <?php echo $ord_code; ?>
                                                        </h5>
                                                        <h5 class="mb-2">
                                                            Customer Name:
                                                            <?php echo $user_name; ?>
                                                        </h5>
                                                        <h5 class="mb-2">
                                                            Customer Email:
                                                            <?php echo $user_email; ?>
                                                        </h5>
                                                        <h5 class="mb-2">
                                                            Customer Phone:
                                                            <?php echo $user_phone ? $user_phone : "N/A"; ?>
                                                        </h5>
                                                    </div>
                                                    <div>
                                                        <a href='<?= "order-detail.php?ord_id=" . $order_id ?>'><button
                                                                class="btn theme-bg-color text-white">Order Details</button></a>

                                                    </div>


                                                </div>
                                            </div>

                                            <!-- section end -->
                                        </div>
                                        <?php
                                        }
                                    } ?>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- tracking table end -->

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
</body>

</html>