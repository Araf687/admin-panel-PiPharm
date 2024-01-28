<!-- Modal Start -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h5 class="modal-title" id="staticBackdropLabel">Logging Out</h5>
        <p>Are you sure you want to log out?</p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="button-box">
          <button type="button" class="btn btn--no" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn  btn--yes btn-primary" onClick="logout()">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->

<!-- Delete Modal Box Start -->
<div class="modal fade theme-modal remove-coupon" id="exampleModalToggle" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header d-block text-center">
        <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="remove-box">
          <p>Are you sure you want to remove this item? This action can not be undone.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-animation btn-md fw-bold" onClick="confirmDel()" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- upload product Modal Box Start -->
<div class="modal fade" id="exampleModalToggle_UploadProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h5 class="modal-title" id="staticBackdropLabel">Upload Multiple Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="card">
          <div class="card-body">
            <form class="theme-form theme-form-2 mega-form" action="querryCode/productCode.php" method="POST" enctype="multipart/form-data">
              <div class="mb-4 row align-items-center">
                <div class="form-group col-sm-12">
                  <div class="dropzone-wrapper" onClick="dropzoneClick()" style="cursor:pointer;">
                    <div class="dropzone-desc">
                      <i class="ri-upload-2-line"></i>
                      <p id="file-name">Choose an excel file or drag it here.</p>
                    </div>
                    <input type="file" name="excel" id="excelInput" class="dropzone" onChange="handleChangeExcelFile()" accept="XLS,XLSX" required>

                  </div>
                </div>
              </div>
              <div class="button-box">
                <button name="uploadProductExcelFIle" type="submit" class="btn  btn--yes btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade theme-modal remove-coupon" id="exampleModalToggle2" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="remove-box text-center">
          <div class="wrapper">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>
          </div>
          <h4 class="text-content">It's Removed.</h4>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Modal Box End -->

<!-- Offcanvas Box Start -->
<div class="offcanvas offcanvas-end order-offcanvas" tabindex="-1" id="order-details" aria-labelledby="offcanvasExampleLabel" aria-expanded="false">
  <div class="offcanvas-header">
    <h4 class="offcanvas-title" id="offcanvasExampleLabel">Takeaway #573-685572</h4>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div class="offcanvas-body">
    <div class="order-date">
      <ul class="order-details">
        <li>Order Date: February 22, 2023</li>
        <li>Order Total: $160.50</li>
      </ul>
      <a href="javascript:void(0)" class="d-block mt-1">Cancel Order</a>
    </div>

    <div class="accordion accordion-flush custome-accordion" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
            Order List
          </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">

            <div class="table-responsive table-details">
              <table class="table cart-table table-borderless">
                <tbody>
                  <tr class="table-order">
                    <td>
                      <h5>Aata Buscuit <span class="attribute">(Big)</span></h5>
                    </td>
                    <td>
                      <h5>1</h5>
                    </td>
                  </tr>
                  <tr class="table-order">
                    <td>
                      <h5>Aata Buscuit <span class="attribute">(Medium)</span></h5>
                    </td>
                    <td>
                      <h5>1</h5>
                    </td>
                  </tr>
                  <tr class="table-order">
                    <td>
                      <h5>Aata Buscuit <span class="attribute">(Small)</span></h5>
                    </td>
                    <td>
                      <h5>1</h5>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
            Payment Status
          </button>
        </h2>
        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            Pay on Delivery (Cash/Card). Cash on delivery (COD) available. Card/Net banking acceptance subject to device availability.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            Delivery Status
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">

            <ul class="order-details">
              <li>Gerg Harvell</li>
              <li>568, Suite Ave.</li>
              <li>Austrlia, 235153 Contact No. 48465465465</li>
            </ul>

            <ul class="status-list mt-3">
              <li>
                <b>Status:</b> <a href="javascript:void(0)">Pending</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Offcanvas Box End -->

<!-- js for del data(category, product, attribute) -->
<script>
  const confirmDel = () => {
    const tableName = sessionStorage.getItem("tableName");
    const del_id = sessionStorage.getItem("del_id");
    console.log(tableName, del_id);
    if (tableName == "category") {
      window.location = "querryCode/categoryCode.php?del_id=" + del_id;
    } 
    else if (tableName == "sub_category") {
      window.location = "querryCode/subCategoryCode.php?del_id=" + del_id;
    } else if (tableName == "attribute") {
      window.location = "querryCode/attributeCode.php?del_id=" + del_id;
    } else if (tableName == "user") {
      window.location = "querryCode/userCode.php?del_id=" + del_id;
    } else if (tableName == "product") {
      window.location = "querryCode/productCode.php?del_id=" + del_id;
    } else if (tableName == "order") {
      window.location = `querryCode/orderCode.php?del_id=${del_id}`;
    } 
    else if (tableName == "slider") {
      window.location = "querryCode/slideCode.php?del_id=" + del_id;
    }
    else if (tableName == "Pharmacy_admin") {
      window.location = "querryCode/pharmacy-code.php?del_id=" + del_id;
    }
    else if (tableName == "admin") {
      window.location = "querryCode/adminCode.php?del_id=" + del_id;
    }
    sessionStorage.removeItem("tableName");
    sessionStorage.removeItem("del_id");
  }
  const logout = () => {
    window.location = "logout.php";
  }

  function dropzoneClick() {
    console.log("here click upcontent");
    document.getElementById('excelInput').click();
  }

  function handleChangeExcelFile() {
    var imageContent = document.getElementById('excelInput');
    var imageName = imageContent.files.item(0).name;

    document.getElementById('file-name').innerText = imageName;

  }

</script>

<!-- latest js -->
<script src="assets/js/jquery-3.6.0.min.js"></script>

<!-- Bootstrap js -->
<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>

<!-- feather icon js -->
<script src="assets/js/icons/feather-icon/feather.min.js"></script>
<script src="assets/js/icons/feather-icon/feather-icon.js"></script>

<!-- scrollbar simplebar js -->
<script src="assets/js/scrollbar/simplebar.js"></script>
<script src="assets/js/scrollbar/custom.js"></script>

<!-- Sidebar jquery -->
<script src="assets/js/config.js"></script>

<!-- tooltip init js -->
<script src="assets/js/tooltip-init.js"></script>

<!-- Plugins JS -->
<script src="assets/js/sidebar-menu.js"></script>

<!-- ck editor js -->
<script src="assets/js/ckeditor.js"></script>
<script src="assets/js/ckeditor-custom.js"></script>

<!-- Apexchar js -->
<script src="assets/js/chart/apex-chart/apex-chart1.js"></script>
<script src="assets/js/chart/apex-chart/moment.min.js"></script>
<script src="assets/js/chart/apex-chart/apex-chart.js"></script>
<script src="assets/js/chart/apex-chart/stock-prices.js"></script>
<script src="assets/js/chart/apex-chart/chart-custom.js"></script>
<script src="assets/js/chart/apex-chart/chart-custom1.js"></script>


<!-- slick slider js -->
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/custom-slick.js"></script>

<!-- ratio js -->
<script src="assets/js/ratio.js"></script>

<!-- sidebar effect -->
<script src="assets/js/sidebareffect.js"></script>

<!-- Theme js -->
<script src="assets/js/script.js"></script>
