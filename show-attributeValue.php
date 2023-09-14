<?php
include "config/session.php";
include "config/dbConn.php";
$attr_id = $_POST['attr_id'];
$attr_no = $_POST['attr_name'];
$fetchQuery = "SELECT * FROM attributevalues WHERE `attr_id`=$attr_id";
$query_result = mysqli_query( $conn, $fetchQuery );

if ( $query_result == true ) {
    $count = mysqli_num_rows( $query_result );
    $slNo = 1;

    if ( $count>0 ) {
        $i = 0;
        while( $rows = mysqli_fetch_assoc( $query_result ) ) {

            $attr_id = $rows['attrValue_id'];
            $attr_value = $rows['attr_value'];
            $i++;
            ?>
<div class="col-sm-3">
  <!-- //hidden input to send id of that attribute to the backend -->
  <input style="display:none" value="<?php echo $attr_id; ?>" name="<?php echo $attr_no."nameId".$i;?>" type="text">
</div>
<label class="col-sm-3 col-form-label form-label-title"><?php echo $attr_value;
            ?></label>
<div class="col-sm-6">
  <div class="bs-example">
    <input class="form-control" name="<?php echo "$attr_no"."value$i"?>" type="number" min="0" step="0.01" value="0.00">
  </div>
</div>

<?php } } echo "<input style=\"display:none\" value=".$i." name=total_$attr_no"."Values type='number'>"; } ?>
