<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addAttribute'] ) ) {
        $user_id = $_SESSION['loginInfo']["id"];

        $attr_name = $_POST['attribute_name'];
        $attr_values = explode( ", ", $_POST['all_attributes'] );

        if ( $attr_values[0] != "" && $attr_name != "" ) {
            $addAttr_query = "INSERT INTO attribute (`attr_name`, `admin_id`) VALUES ('$attr_name',$user_id)";
            $run_addAttrQuery = mysqli_query( $conn, $addAttr_query );
            if ( $run_addAttrQuery ) {
                $attr_id = mysqli_insert_id( $conn );
                foreach ( $attr_values as $value ) {
                    //code to be executed;

                    $addAttrValue_query = "INSERT INTO attributevalues (`attr_id`, `attr_value`) VALUES ($attr_id,'$value')";
                    $run_addAttrValueQuery = mysqli_query( $conn, $addAttrValue_query );

                    if ( $run_addAttrValueQuery ) {
                        $_SESSION['status'] = "Added Successfully";
                        header( "Location: ../attributes.php" );
                    } else {
                        $_SESSION['status'] = "failed to add attribute value";
                        header( "Location: ../attributes.php" );
                    }

                }
            } else {
                $_SESSION['status'] = "something went wrong";
                header( "Location: ../attributes.php" );
            }
        } else {
            $_SESSION['status'] = "Empty attribute";
            header( "Location: ../attributes.php" );
        }

    } else if ( isset( $_POST['editAttribute'] ) ) {
        $attr_id = $_POST['attr_id'];
        $attr_name = $_POST['attribute_name'];
        $user_id = $_SESSION['loginInfo']["id"];
        settype( $user_id, "integer" );

        $attr_values = explode( ", ", $_POST['all_attributes'] );

        $prevAttr_values = json_decode( $_POST['previous_attributes'] );
        $keys = array_keys( get_object_vars( $prevAttr_values ) );

        settype( $attr_id, "integer" );

        if ( $attr_values[0] != "" && $attr_name != "" ) {
            // finding newy added values
            $updateAttr_query = "UPDATE attribute SET attr_name='$attr_name' WHERE `id`=$attr_id AND `admin_id`=$user_id";
            $run_updateAttrQuery = mysqli_query( $conn, $updateAttr_query );
            if ( $run_updateAttrQuery ) {

                // removing delted attribute value from both attribute value table and product attribute value table
                for ( $i = 1; $i < count( $keys );
                $i++ ) {
                    if ( in_array( $keys[$i], $attr_values ) != 1 ) {
                        $deltedId = $prevAttr_values-> {
                            $keys[$i]}
                            ;
                            
                            settype( $deltedId, "integer" );

                            $deletePrevAttValue = "DELETE FROM attributevalues WHERE `attrValue_id`=$deltedId";
                            $run_query = mysqli_query( $conn, $deletePrevAttValue );

                            $deleteProdAttValue = "DELETE FROM prod_attribute_values WHERE `attr_val_id`=$deltedId";
                            $run_query = mysqli_query( $conn, $deletePrevAttValue );

                        } else {
                            unset( $attr_values[array_search( $keys[$i], $attr_values )] );
                        }
                    }

                    $fetchProductId = "SELECT DISTINCT `prd_id` FROM prod_attribute_values WHERE `attr_id` = $attr_id";
                    $run_query = mysqli_query( $conn, $fetchProductId );
                    if ( $run_query == true ) {
                        if ( mysqli_num_rows( $run_query ) > 0 ) {

                            foreach ( $attr_values as $value ) {
                                $addAttrValue_query = "INSERT INTO attributevalues (`attr_id`, `attr_value`) VALUES ($attr_id,'$value')";

                                $run_addAttrValueQuery = mysqli_query( $conn, $addAttrValue_query );

                                if ( $run_addAttrValueQuery ) {
                                    $attrValueId = mysqli_insert_id( $conn );
                                    foreach ( $run_query as $rows ) {

                                        $prd_id = $rows['prd_id'];

                                        $addPrdExtVal_querry = "INSERT INTO prod_attribute_values (`prd_id`, `attr_id`, `attr_val_id`, `extended_price`) VALUES ($prd_id,$attr_id,$attrValueId,0.00)";

                                        $run_addExtValQuerry = mysqli_query( $conn, $addPrdExtVal_querry );
                                    }
                                } else {
                                    $_SESSION['status'] = "attributes value cannot be added";
                                    header( "Location: ../attributes.php" );
                                }
                            }
                            $_SESSION['status'] = "Added Successfully";
                            header( "Location: ../attributes.php" );
                        } else {
                            foreach ( $attr_values as $value ) {
                                $addAttrValue_query = "INSERT INTO attributevalues (`attr_id`, `attr_value`) VALUES ($attr_id,'$value')";

                                $run_addAttrValueQuery = mysqli_query( $conn, $addAttrValue_query );

                                if ( $run_addAttrValueQuery ) {
                                    $_SESSION['status'] = "Added Successfully";
                                } else {
                                    $_SESSION['status'] = "attributes value cannot be added";
                                    header( "Location: ../attributes.php" );
                                }
                            }
                            header( "Location: ../attributes.php" );
                        }
                    } else {
                        $_SESSION['status'] = "something went wrong";
                        header( "Location: ../attributes.php" );
                    }

                } else {
                    $_SESSION['status'] = "something went wrong";
                    header( "Location: ../attributes.php" );
                }
            } else {
                $_SESSION['status'] = "Empty attribute";
                header( "Location: ../attributes.php" );
            }

        } else if ( isset( $_GET['del_id'] ) ) {
            $attr_id = $_GET['del_id'];
            settype( $attr_id, "integer" );

            $delAttrValue_query = "DELETE FROM `attributevalues` WHERE `attr_id`=$attr_id";
            $run_delAttrValueQuery = mysqli_query( $conn, $delAttrValue_query );
            if ( $run_delAttrValueQuery == true ) {
                $delAttr_query = "DELETE FROM `attribute` WHERE `id`=$attr_id";
                $run_delAttrQuery = mysqli_query( $conn, $delAttr_query );
                if ( $run_delAttrQuery ) {
                    $_SESSION['status'] = "Deleted Successfully";
                    header( "Location: ../attributes.php" );
                } else {
                    $_SESSION['status'] = "something went wrong";
                    header( "Location: ../attributes.php" );
                }

            } else {
                $_SESSION['status'] = "something went wrong";
                header( "Location: ../attributes.php" );
            }

        }
    } else {
        header( "Location: login.php" );
    }
    ?>