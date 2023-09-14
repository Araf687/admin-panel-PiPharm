  <!-- Page Header Start-->
  <div class="page-header">
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
          <a href="index.php">
            <img src="assets/images/logo/1.png" class="img-fluid" alt="">
          </a>
        </div>
      </div>

      <div class="nav-right col-6 pull-right right-header p-0">
        <ul class="nav-menus">
          <!--
          
          <li class="onhover-dropdown">
            <div class="notification-box">
              <i class="ri-notification-line"></i>
              <span class="badge rounded-pill badge-theme">4</span>
            </div>
            <ul class="notification-dropdown onhover-show-div">
              <li>
                <i class="ri-notification-line"></i>
                <h6 class="f-18 mb-0">Notitications</h6>
              </li>
              <li>
                <p>
                  <i class="fa fa-circle me-2 font-primary"></i>Delivery processing <span class="pull-right">10 min.</span>
                </p>
              </li>
              <li>
                <p>
                  <i class="fa fa-circle me-2 font-success"></i>Order Complete<span class="pull-right">1 hr</span>
                </p>
              </li>
              <li>
                <p>
                  <i class="fa fa-circle me-2 font-info"></i>Tickets Generated<span class="pull-right">3 hr</span>
                </p>
              </li>
              <li>
                <p>
                  <i class="fa fa-circle me-2 font-danger"></i>Delivery Complete<span class="pull-right">6 hr</span>
                </p>
              </li>
              <li>
                <a class="btn btn-primary" href="javascript:void(0)">Check all notification</a>
              </li>
            </ul>
          </li>
          
          -->
          <li>
            <div class="mode">
              <i class="ri-moon-line"></i>
            </div>
          </li>
          <li class="profile-nav onhover-dropdown pe-0 me-0">
            <div class="media profile-media">
              <?php 
                $admin_img= "assets/images/admins/1676717087.png";
                if(isset($_SESSION['loginInfo']['adminImg'])){
                  $admin_img ="assets/images/admins/".$_SESSION['loginInfo']['adminImg'];
                }
              ?>
              <img class="user-profile rounded-circle" src="<?php echo $admin_img ?>" alt="">
              <div class="user-name-hide media-body">
                <span><?php echo $_SESSION['loginInfo']['firstName'] .' '. $_SESSION['loginInfo']['lastName']; ?></span>
                <p class="mb-0 font-roboto">Admin<i class="middle ri-arrow-down-s-line"></i></p>
              </div>
            </div>
            <ul class="profile-dropdown onhover-show-div">
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
