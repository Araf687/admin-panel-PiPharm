<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php
include( 'includes/head.php' );
?>

<body>
  <!-- tap on top start -->
  <div class="tap-top">
    <span class="lnr lnr-chevron-up"></span>
  </div>
  <!-- tap on tap end -->

  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
<?php include( 'includes/header.php' );
?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
<?php include( 'includes/sidebar.php' );
?>

      <div class="page-body">

        <!-- New Product Add Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-xxl-8 col-lg-10 m-auto">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-header-2">
                        <h5>Update Attribute</h5>

                      </div>

                      <form action="querryCode/attributeCode.php" method="POST" class="theme-form theme-form-2 mega-form">

<?php
$attr_id = $_GET['attr_id'];
$user_id = $_SESSION['loginInfo']["id"];
settype( $attr_id, "integer" );
settype( $user_id, "integer" );
$fetchAttrQuerry = "SELECT * FROM attribute WHERE `id`=$attr_id AND `admin_id`=$user_id LIMIT 1";
$querry_result = mysqli_query( $conn, $fetchAttrQuerry );

if ( $querry_result == true ) {
    $count = mysqli_num_rows( $querry_result );
    $slNo = 1;

    if ( $count > 0 ) {
        echo "<tbody>";
        while ( $rows = mysqli_fetch_assoc( $querry_result ) ) {
            $attr_id = $rows['id'];
            $attr_name = $rows['attr_name'];

            ?>
                        <div class="mb-4 row align-items-center">
                          <label class="form-label-title col-sm-3 mb-0">Attribute
                            Name</label>
                          <div class="col-sm-9">
                            <!-- hidden attribute id for update operation-->
                            <input class="form-control" value="<?php echo $attr_id; ?>" type="text" style="display:none;" name="attr_id">

                            <input class="form-control" value="<?php echo $attr_name; ?>" type="text" name="attribute_name" placeholder="Attribute Name">
                          </div>
                        </div>

                        <div class="mb-4 row align-items-start">
                          <label class="col-sm-3 col-form-label form-label-title">Attribute
                            Value</label>
                          <div class="col-sm-9">
                            <div class="row g-sm-4 g-3">
                              <div class="col-sm-10 col-9">
                                <input class="form-control" type="text" id="attribute_input" placeholder="Attribute Value">
                              </div>

                              <div class="col-sm-2 col-3">
                                <span onClick="handleAddValue()" class="btn text-white theme-bg-color w-25">Add</span>
                              </div>
                              <div id="attribute-value-sec" class="col-sm-12">

            <?php
            $fetchAttrQuerry = "SELECT `attrValue_id`, `attr_value` FROM attributevalues WHERE `attr_id`=$attr_id";
            $querry_result = mysqli_query( $conn, $fetchAttrQuerry );

            $attrValue_string = "";
            if ( $querry_result == true ) {
                $count = mysqli_num_rows( $querry_result );
                $inc = 1;
                $json_data[] = array();

                if ( $count > 0 ) {
                    while ( $valueRows = mysqli_fetch_assoc( $querry_result ) ) {
                        $json_data[$valueRows['attr_value']] = $valueRows['attrValue_id'];
                        $attr_value = $valueRows['attr_value'];
                        if ( $inc != $count ) {
                            $attrValue_string = $attrValue_string . $attr_value . ", ";
                        } else if ( $inc == $count ) {
                            $attrValue_string = $attrValue_string . $attr_value;
                        }
                        $inc++;
                        if ( $attr_value != "" ) {

                            ?>
                                <span class='p-1 m-1 bg-primary rounded'>
                                  <?php echo $attr_value ?><i onclick="handleRemoveValue('<?php echo $attr_value; ?>')" class="ri-close-circle-line attrRemoveIcon"></i>
                                </span>
                                <?php }
                        }

                    }
                }
                ?>
                                <!-- hidden input to send all attribute value to backend via form -->
                                <input type="text" value="<?php echo $attrValue_string; ?>" style="display:none" id="allAttributes" name="all_attributes">

                                <!-- hidden input to send previous value to differentiate with new values backend via form -->
                                <input type="text" value="<?php echo json_encode($json_data);?>" style="display:none" id="allAttributes" name="previous_attributes">
                <?php
                echo "<script> localStorage.setItem(\"attributeValues\"," . "\"$attrValue_string\"" . "); </script>";
                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button name="editAttribute" onClick="clickSubmitAttribute()" type="submit" class="btn ms-auto theme-bg-color text-white">Update Attribute</button>
                        <?php } } } ?>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- New Product Add End -->
        <script type="text/javascript" src="./assets/js/pages/edit-attribute.js"></script>

        <?php include( 'includes/footer.php' );
        ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <?php include( 'includes/scripts.php' );
        ?>
</body>

</html>
