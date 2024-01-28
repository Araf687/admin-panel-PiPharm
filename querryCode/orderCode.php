<?php
session_start();
include "../config/dbConn.php";

    if ( isset( $_GET['del_id'] ) ) {
        $ord_code = $_GET['del_id'];
        
        $delOrder_querry = "DELETE FROM orders WHERE `order_code`='$ord_code'";
        // print_r($_GET);
        $run_delOrdQuerry = mysqli_query( $conn, $delOrder_querry );


        if ( $run_delOrdQuerry) {

            $delOrderItem_querry = "DELETE FROM orderitems WHERE `order_code`='$ord_code'";
            $run_delOrdItemQuerry = mysqli_query( $conn, $delOrderItem_querry );

            if ( $run_delOrdItemQuerry == true ) {
                $_SESSION['status'] = "delete";
                header( "Location: ../orders.php" );
            } else {
                $_SESSION['status'] = "failedOrderItems";
                header( "Location: ../orders.php" );
            }

        } else {
            $_SESSION['status'] = "failed";
            header( "Location: ../orders.php" );
        }

    }

?>