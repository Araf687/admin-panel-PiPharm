<?php
include 'config/session.php';
include 'config/dbConn.php';


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php
include('includes/head.php');
?>

<body>

    <?php
    if (isset($_SESSION['status'])) {

        if ($_SESSION['status'] == "Added Successfully") {
            echo "<script>Swal.fire(
            'Great!',
            'Added Successfully!',
            'success'
        );
        </script>";
        } else if ($_SESSION['status'] == "Updated Successfully") {
            echo "<script>Swal.fire(
            'Great!',
            'Updated Successfully!',
            'success'
        );
        </script>";
        } else if ($_SESSION['status'] == "Data already exist") {
            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Failed to add Store!',
            footer: 'Data already exist'
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

            <!-- Settings Section Start -->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Details Start -->
                                    <form class="theme-form theme-form-2 mega-form" action="querryCode/storeCode.php"
                                        method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="title-header option-title">
                                                    <h5>Store Setting</h5>
                                                </div>

                                                <?php
                                                $admin_id = $_SESSION['loginInfo']["id"];
                                                $pharmacy_id=$_SESSION['loginInfo']['id'];
                                                settype($admin_id, "integer");

                                                // $fetchCatQuerry = "SELECT * FROM store WHERE `admin_id`=$admin_id LIMIT 1";
                                                
                                                $fetchCatQuerry ="SELECT pharmacy_admin.*, pharmacy_address.* 
                                                FROM pharmacy_admin 
                                                INNER JOIN pharmacy_address ON pharmacy_admin.id = pharmacy_address.pharmacy_id WHERE pharmacy_admin.id=$pharmacy_id";

                                                $querry_result = mysqli_query($conn, $fetchCatQuerry);

                                                $store_id = "";
                                                $store_name = "";
                                                $phone = "";
                                                $Store_location = "";
                                                $email = "";
                                                $logo = "";
                                                $banner = "";
                                                $img_src_logo = "";
                                                $img_src_banner = "";

                                                if ($querry_result == true) {
                                                    $count = mysqli_num_rows($querry_result);
                                                    $slNo = 1;
                                                    if ($count > 0) {

                                                        while ($rows = mysqli_fetch_assoc($querry_result)) {
                                                            $store_id = $rows['id'];
                                                            $store_name = $rows['shop_name'];
                                                            $phone = $rows['admin_phone'];
                                                            $Store_location = $rows['address'];
                                                            $email = $rows['admin_email'];
                                                            $logo = $rows['brand_logo'];
                                                            $banner = $rows['shop_image'];
                                                            $img_src_logo = "assets/images/store/logo/" . $logo;
                                                            $img_src_banner = "assets/images/store/banner/" . $banner;

                                                            //pharmacy address
                                                            $street_address = $rows['address'];
                                                            $country = $rows['country'];
                                                            $zipCode = $rows['zip_code'];
                                                            $state = $rows['state'];
                                                            $city = $rows['city'];
                                                            $latitude = $rows['latitude'];
                                                            $longitude = $rows['longitude'];

                                                            $latLong = $latitude . " " . $longitude;
                                                            
                                                    

                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="row">
                                                    <!-- hidden input store id -->
                                                    <input type="text" value="<?php echo $store_id; ?>" name="store_id"
                                                        style="display:none;">
                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Store Name</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" name="shop_name"
                                                                value="<?php echo $store_name; ?>" type="text"
                                                                placeholder="Enter Your Store Name">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Store
                                                            Location</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" name="store_location"
                                                                value="<?php echo $Store_location; ?>" type="text"
                                                                placeholder="Enter Your Store Location">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Store
                                                            Phone</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" value="<?php echo $phone; ?>"
                                                                name="store_phone" type="number"
                                                                placeholder="Enter Your Store Phone">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Store
                                                            Email</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" name="store_email"
                                                                value="<?php echo $email; ?>" type="email"
                                                                placeholder="Enter Your Store Email">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="col-sm-2 col-form-label form-label-title">Store
                                                            Logo</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="prevLogo" value='<?=$logo?>' class='d-none'>
                                                            <input class="form-control form-choose"
                                                                onChange="handleLogo(event)" name="store_logo"
                                                                type="file" id="formFileMultiple">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <img src="<?php echo $img_src_logo; ?>" alt="2"
                                                                class="rounded m-1" id="logoImg" width="100">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="col-sm-2 col-form-label form-label-title">Store
                                                            Banner</label>
                                                        <div class="form-group col-sm-6">
                                                            <div class="dropzone-wrapper" style="cursor:pointer"
                                                                onClick="dropzoneAreaClick()">
                                                                <div class="dropzone-desc">
                                                                    <i class="ri-upload-2-line"></i>
                                                                    <p id="image-name">Choose an image file or drag it
                                                                        here.</p>
                                                                </div>
                                                                <input type="text" name="prevBanner" value='<?= $banner ?>'
                                                                    class="d-none">
                                                                <input type="file" id="bannerInput" name="store_banner"
                                                                    onChange="handleChangeFile(event)"
                                                                    accept="image/jpeg, image/png, image/jpg"
                                                                    class="dropzone">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <img src="<?php echo $img_src_banner; ?>" alt=""
                                                                class="rounded mt-2" id="bannerImg" width="280">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="title-header option-title">
                                                    <h5>Pharmacy Address</h5>
                                                </div>
                                                <!-- //hidden input to send number of address data in the backend -->
                                                <input type="number" value="1" style="display:none;" id="addresses"
                                                    name="noOfAddress">
                                                <div id="allAddresses">
                                                    <div class="mb-5 row align-items-center" id="address1">
                                                        <label
                                                            class="form-label-title col-lg-2 col-md-3 mb-0">Address</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <div class="mb-3">
                                                                <label>Street Address</label>
                                                                <input name="addr_main" value='<?= $street_address ?>'
                                                                    class="form-control" type="text">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 col-lg-6 mb-2">
                                                                    <label>City</label>
                                                                    <input name="addr_city" value='<?= $city ?>'
                                                                        class="form-control" type="text">
                                                                </div>
                                                                <div class="col-md-6 col-lg-6 mb-2">
                                                                    <label>State</label>
                                                                    <input name="addr_state" value='<?= $state ?>'
                                                                        class="form-control" type="text">
                                                                </div>
                                                                <div class="col-md-6 col-lg-6 mb-2">
                                                                    <label>Country</label>
                                                                    <input name="addr_country" value='<?= $country ?>'
                                                                        class="form-control" type="text">
                                                                </div>
                                                                <div class="col-md-6 col-lg-6 mb-2">
                                                                    <label>Zip Code</label>
                                                                    <input name="addr_zip" value='<?= $zipCode ?>'
                                                                        class="form-control" type="text">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="getLocationFromBrowser()">Current
                                                                Location</button>
                                                            <div id="myHiddenDiv" style="display: none;">
                                                                <p class="text-danger mt-1">location is required. Press
                                                                    on current
                                                                    location button.</p>
                                                            </div>

                                                            <div class="ms-2 d-none"><span>Latitude & Longitude</span>
                                                                <div><input type="text" name='latLong' id="LatLong"
                                                                        value=<?= $latLong ?>></div>

                                                            </div>
                                                            <div id="map" class="my-2 rounded shadow"
                                                                style="height:450px;opacity: 0.5; pointer-events: none; z-index: 1;">
                                                            </div>

                                                            <p class="text-center" style="font-size:18px">You can also
                                                                drag the blue marker to set the specific
                                                                location.
                                                            </p>

                                                            <?php
                                                            if ($latitude && $longitude) {
                                                                echo "<script> $(document).ready(function() {showUserLocationOnMap($latitude, $longitude ); }); </script>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($store_name == " ") { ?>
                                            <div style="padding-right:30px !important; margin-bottom:20px;">
                                                <button name="addStore" type="submit"
                                                    class="btn ms-auto theme-bg-color text-white">Add
                                                    Store Information</button>
                                            </div>
                                            <?php
                                        } else {
                                            echo "<script> let logo=document.getElementById('logoImg'); let banner=document.getElementById('bannerImg'); </script>";
                                            ?>

                                            <div>
                                                <button style="margin-bottom:20px;" name="UpdateStore" id="updateProfileBtn"
                                                    type="submit" class="btn theme-bg-color text-white">Update</button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                    <!-- Details End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include('includes/footer.php');
                ?>
            </div>
            <!-- index body end -->
            <script>
                function dropzoneAreaClick() {
                    console.log("here click upcontent");
                    document.getElementById('bannerInput').click();
                }

                function handleChangeFile(event) {
                    console.log("hi");
                    var imageContent = document.getElementById('bannerInput');
                    var imageName = imageContent.files.item(0).name;

                    document.getElementById('image-name').innerText = imageName;

                    let preview = document.getElementById('bannerImg');
                    preview.style.display = "block"
                    console.log(event.target.files[0]);
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    preview.onload = function () {
                        URL.revokeObjectURL(preview.src) // free memory
                    }

                }
                const handleLogo = (event) => {
                    let preview = document.getElementById('logoImg');
                    preview.style.display = "block"
                    console.log(event.target.files[0]);
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    preview.onload = function () {
                        URL.revokeObjectURL(preview.src) // free memory
                    }

                }
            </script>
            <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script src="assets/js/map/map.js"></script>


        </div>
        <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    <?php include('includes/scripts.php');
    ?>
</body>

</html>