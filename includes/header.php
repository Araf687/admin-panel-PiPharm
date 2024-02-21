<!-- Page Header Start-->
<div class="page-header" style="z-index:100">
  <div class="header-wrapper m-0">
    <div class="header-logo-wrapper p-0">
      <div class="logo-wrapper">
        <a href="index.php">
          <img class="img-fluid main-logo" src="assets/images/logo/1.png" alt="logo">
          <img class="img-fluid white-logo" src="assets/images/logo/1-white.png" alt="logo">
        </a>
      </div>
      <div class="toggle-sidebar">
        <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
        <!-- <a href="index.php">
          <img src="assets/images/logo/1.png" class="img-fluid" alt="">
        </a> -->
      </div>
    </div>

    <div class="nav-right col-6 pull-right right-header p-0">
      <ul class="nav-menus">

        <li class="position-relative me-3" id="dropdownMenuButton" class="rounded-circle dropdown-toggle"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="ri-notification-3-line" style="cursor:pointer"></i>
          <span class="badge bg-danger rounded-circle d-flex justify-content-center align-items-center"
            style="width:20px;height:20px; position:absolute;left:49%;" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            $pharmacy_id = $_SESSION['loginInfo']['id'];
            $sql = "SELECT * from notifications WHERE `pharmacy_id`=$pharmacy_id AND `notification_user_type`='pharmacy' AND `status`=0";
            $result = mysqli_query($conn, $sql);
            $row_count = mysqli_num_rows($result);
            echo $row_count;
            ?>
          </span>
          <ul class="dropdown-menu rounded px-2 py-3" style="width:260px">
            <?php
            $i = 0;
            // Fetch and display notification details from the database
            while ($row = mysqli_fetch_assoc($result)) {
              $notificationId = $row['id'];
              $i = $i + 1;
              if ($i < 6) {
                ?>
                <li>
                  <a href='<?= "show-notification.php?id=" . $notificationId ?>' class="p-0 m-0"
                    style="text-decoration:none;color:black">
                    <div class="d-flex">
                      <div>
                        <i class="ri-shopping-bag-fill fs-4" style="color:#6670bd"></i>
                      </div>
                      <div class="ps-2">
                        <span style="font-weight:600; font-size:14px;" class="lh-0">
                          <?= $row['title'] ?>
                        </span>
                        <small style="font-size:12px;line-height:0px">
                          <?= explode("on", $row['description'])[0] ?>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <?php
              }
            }
            if($i>1){
              echo "<hr/>";
            }
            if ($row_count > 5) {
              ?>
              <li class="text-center">
                <small><strong>See more..</strong></small>
              </li>
            <?php }
            if($row_count<1){
              echo "<li class='p-1 text-center'><strong>Empty!</strong></li>";
            } ?>
          </ul>

        </li>
        <li>
          <div class="mode">
            <i class="ri-moon-line"></i>
          </div>
        </li>

        <li class="profile-nav onhover-dropdown pe-0 me-0">
          <div class="media profile-media">
            <?php
            $admin_img = "assets/images/default.jpg";
            $isPharmacyAdmin = $_SESSION['loginInfo']['adminType'] === "pharmacy";
            if (isset($_SESSION['loginInfo']['adminImg']) && $_SESSION['loginInfo']['adminImg'] != ' ') {
              $admin_img = $isPharmacyAdmin ? "assets/images/pharmacy_admins/" . $_SESSION['loginInfo']['adminImg'] : "assets/images/admins/" . $_SESSION['loginInfo']['adminImg'];
            }
            ?>
            <img class="user-profile rounded-circle" src="<?= $admin_img ?>" alt="">

            <div class="user-name-hide media-body">
              <span>
                <?php echo $_SESSION['loginInfo']['firstName'] . ' ' . $_SESSION['loginInfo']['lastName']; ?>
              </span>

              <p class="mb-0 font-roboto">
                <?= $_SESSION['loginInfo']['adminType'] == "admin" ? "Admin" : "Pharmacy" ?>
                <i class="middle ri-arrow-down-s-line"></i>
              </p>

            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div">
            <li>
              <a href="reset-password.php">
                <i data-feather="repeat"></i>
                <span>Reset Password</span>
              </a>
            </li>
            <li>
              <a href="setting.php">
                <i data-feather="settings"></i>
                <span>Settings</span>
              </a>
            </li>
            <li>
              <a data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="javascript:void(0)">
                <i data-feather="log-out"></i>
                <span>Log out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

</div>
<!-- Page Header Ends-->