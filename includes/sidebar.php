
<?php 

$adminType=$_SESSION['loginInfo']["adminType"];
$admin=$_SESSION['loginInfo']["adminType"]=="admin";
?>
<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
  <div id="sidebarEffect"></div>
  <div>
    <div class="logo-wrapper logo-wrapper-center text-center">
      <a href="index.php" data-bs-original-title="" title="">
        <img class="img-fluid for-white" src="assets/images/logo/piPharm.png" alt="logo" style="height:40px">
      </a>
      <div class="back-btn">
        <i class="fa fa-angle-left"></i>
      </div>
      
          <!-- <div class="toggle-sidebar">
            <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
          </div> -->
         
    </div>
    <div class="logo-icon-wrapper" style="margin-bottom: 50px;">
      <a href="index.php">
        <img class="img-fluid main-logo main-white" src="assets/images/logo/logo.png" alt="logo">
        <img class="img-fluid main-logo main-dark" src="assets/images/logo/logo-white.png" alt="logo">
      </a>
    </div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow">
        <i data-feather="arrow-left"></i>
      </div>

      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          <li class="back-btn"></li>

          <li class="sidebar-list" style="margin-top: 50px;">
            <a class="sidebar-link sidebar-title link-nav" href="index.php">
              <i class="ri-home-line"></i>
              <span>Dashboard</span>
            </a>
          </li>

          <li class="sidebar-list" style=<?=$admin?"display:none":"display:block"?>>
            <a class="sidebar-link sidebar-title" href="javascript:void(0)">
            <i class="ri-shape-line"></i>
              <span>Orders</span>
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="orders.php">Orders</a>
              </li>
            </ul>
          </li> 

          <li class="sidebar-list" 
          style=<?=$admin?"display:none":"display:block"?>
          >
            <a class="linear-icon-link sidebar-link sidebar-title"  href="javascript:void(0)">
              <i class="ri-store-3-line"></i>
              <span>Product</span>
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="products.php">Products</a>
              </li>

              <li>
                <a href="add-product.php">Add Product</a>
              </li>
            </ul>
          </li>

          <li class="sidebar-list"
          style=<?=$admin?"display:block":"display:none"?>
          >
            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)" >
              <i class="ri-list-check-2"></i>
              <span>Category</span>
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="category.php">Categories</a>
              </li>

              <li>
                <a href="add-category.php">Add Category</a>
              </li>
            </ul>
          </li>

          <li class="sidebar-list" style=<?=$admin?"display:none":"display:block"?>>
            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
              <i class="ri-price-tag-3-line"></i>
              <span>Sub Category</span>
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="sub-category.php">Sub Categories</a>
              </li>

              <li>
                <a href="add-sub-category.php">Add Sub Category</a>
              </li>
            </ul>
          </li>

          <li class="sidebar-list"
          style=<?=!$admin?"display:none":"display:block"?>
          >
                <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                  <i class="ri-user-3-line"></i>
                  <span>Pharmacy Admin</span>
                </a>
                <ul class="sidebar-submenu">
                  <li>
                    <a href="all-pharmacy.php">All Pharmacy Admin</a>
                  </li>
                  <li>
                    <a href="add-pharmacy.php">Add Pharmacy admin</a>
                  </li>
                </ul>
              </li>


          
              <li class="sidebar-list"
              style=<?=!$admin?"display:none":"display:block"?>
              >
                <a class="sidebar-link sidebar-title"  href="javascript:void(0)">
                  <i class="ri-admin-line"></i>
                  <span>Admin</span>
                </a>
                <ul class="sidebar-submenu">
                  <li>
                    <a href="all-admin.php">All Admin</a>
                  </li>
                  <li>
                    <a href="add-admin.php">Add admin</a>
                  </li>
                </ul>
              </li>
             

          <li class="sidebar-list" style=<?=$admin?"display:none":"display:block"?>>
            <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
              <i class="ri-settings-line"></i>
              <span>Settings</span>
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a href="store-setting.php">Store Setting</a>
              </li>
              <li>
                <a href="slider.php">Slider</a>
              </li>
            </ul>
          </li>

        </ul>
      </div>

      <div class="right-arrow" id="right-arrow">
        <i data-feather="arrow-right"></i>
      </div>
    </nav>
  </div>
</div>
<!-- Page Sidebar Ends-->