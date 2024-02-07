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
            if (isset($_SESSION['loginInfo']['adminImg']) && $_SESSION['loginInfo']['adminImg']!=' ') {
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