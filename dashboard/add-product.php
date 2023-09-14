<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php'); ?>

<body>
<?php
  if(isset($_SESSION['status']))
  {
  
    if($_SESSION['status']=="Added Successfully"){
      echo "<script>Swal.fire(
          'Great!',
          'Added Successfully!',
          'success'
      );
      </script>";
    }
    if( $_SESSION['status']=="Data already exist"){
      echo "<script>
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Failed to add Category!',
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
    <?php include('includes/header.php'); ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <?php include('includes/sidebar.php'); ?>

      <div class="page-body">

        <!-- New Product Add Start -->
        <form class="theme-form theme-form-2 mega-form" action="querryCode/productCode.php" method="POST" enctype="multipart/form-data">
          <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col-sm-8 m-auto">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-header-2">
                            <h5>Product Information</h5>
                          </div>

                          <form class="theme-form theme-form-2 mega-form">
                            <div class="mb-4 row align-items-center">
                              <label class="form-label-title col-sm-3 mb-0">Product
                                Name</label>
                              <div class="col-sm-9">
                                <input class="form-control" name="prd_name" type="text" placeholder="Product Name">
                              </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                              <label class="col-sm-3 col-form-label form-label-title">Category</label>
                              <div class="col-sm-9">
                                <select class="js-example-basic-single w-100" name="category">
                                <option selected>Select Category</option>
                                <?php 
                                    include "config/dbConn.php";
                                    $user_id=$_SESSION['loginInfo']["id"];
                                    
                                    $fetchCatQuerry="SELECT id, cat_name FROM category WHERE admin_id=$user_id";
                                    $querry_result=mysqli_query($conn,$fetchCatQuerry);

                                    if($querry_result==true){
                                        $count=mysqli_num_rows($querry_result);
                                        $slNo=1;
                                        if( $count>0){
                                            while($rows=mysqli_fetch_assoc($querry_result)){
                                              $cat_id=$rows['id'];
                                              $cat_name=$rows['cat_name'];
                                                echo "<option value='$cat_id'>$cat_name</option>";
                                            } 
                                        }
                                    }
                                ?>
                                </select>
                              </div>
                            </div>
                            
                            <div class="mb-4 row align-items-center">
                              <label class="col-sm-3 form-label-title">Product Price</label>
                              <div class="col-sm-9">
                                <input class="form-control" name="prod_price" type="number" min="0" step="0.01" value="0.00">
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-body">
                          <div class="card-header-2">
                            <h5>Description</h5>
                          </div>

                          
                            <div class="row">
                              <div class="col-12">
                                <div class="row">
                                  <label class="form-label-title col-sm-3 mb-0">Product
                                    Description</label>
                                  <div class="col-sm-9" id="descSection">
                                    <div id="editor">
                                      <!-- hidden input to send descriptiion in backend -->
                                      <input class="form-control" name="prd_desc" style="display:none;" id="desc" type="text">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                         
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-body">
                          <div class="card-header-2">
                            <h5>Product Images</h5>
                          </div>

                            <div class="mb-4 row align-items-center">
                              <label class="col-sm-3 col-form-label form-label-title">Images (Multiple)</label>
                              <div class="col-sm-9">
                                <input class="form-control form-choose" onChange="handleChangeFile(event)" name="files[]" multiple="multiple" type="file" id="formFile">
                              </div>
                              <div class="col-sm-9 mt-4" id="prd_img_section">
                                <!-- <img src="" id="prd_img" style="display:none" class="img-fluid mt-1" width="100"> -->
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-body">
                          <div class="card-header-2">
                            <h5>Product Attributes</h5>
                          </div>

                          <?php 
                                include "config/dbConn.php";

                                $user_id=$_SESSION['loginInfo']["id"];
                                $fetchCatQuerry="SELECT attr_name, id FROM attribute WHERE admin_id=$user_id";
                                $querry_result=mysqli_query($conn,$fetchCatQuerry);
                                $attrOptions='<option selected>Select Attribute</option>';
                                
                                if($querry_result==true){
                                  $count=mysqli_num_rows($querry_result);
                                  $slNo=1;
                                  if( $count>0){
                                      while($rows=mysqli_fetch_assoc($querry_result)){
                                          $attr_id=$rows['id'];
                                          $attr_name=$rows['attr_name'];
                                          $attrOptions .= '<option value="'.$attr_id.'">'.$attr_name.'</option>';
                                       } 
                                  }
                                }
                                  ?>
                          <div id="allAttributes">
                            <!-- this input is given for saving the number of attributes added for a particular product -->
                            <input type="number" id="noOfAttr" name="noOfAttr" style="display:none" value=1>
                            <div id="attrChild1">
                              <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Attributes
                                  Name</label>
                                <div class="col-sm-8">
                                  <select class="js-example-basic-single w-100" id="attr1" onchange="attributeSelect('#attr-section1','attr1')" name="attr1">
                                  <?php echo $attrOptions;?>
                                 
                                  </select>
                                </div>
                                <div class="col-sm-1">
                                  <!-- delete attribute button -->
                                  <i class="ri-close-fill text-danger" onClick="deleteAttribute(this.parentElement)" style="cursor:pointer;font-weight: bolder;"></i>
                                </div>
                              </div>
                              <div class="row align-items-center" id="attr-section1"></div>
                            </div>
                          </div> 
                          

                          <span onclick="addProductAttribute()" class="add-option" style="cursor:pointer"><i class="ri-add-line me-2"></i> Add Another
                            Option
                          </span>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-body">
                          <div class="card-header-2">
                            <h5>Product Inventory</h5>
                          </div>

                            <div class="mb-4 row align-items-center">
                              <label class="form-label-title col-sm-3 mb-0">SKU</label>
                              <div class="col-sm-9">
                                <input class="form-control" name="sku" type="text">
                              </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                              <label class="col-sm-3 col-form-label form-label-title">Stock
                                Status</label>
                              <div class="col-sm-9">
                                <select class="js-example-basic-single w-100" name="status">
                                <option selected>Select Product Status</option>
                                  <option>In Stock</option>
                                  <option>Out Of Stock</option>
                                </select>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" onclick="submitEditedData()" name="addProduct" class="btn w-25 mb-3 theme-bg-color text-white">Add Product</button>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </form>
        <!-- New Product Add End -->

        <!-- //js code for this page -->
        <script>
          localStorage.removeItem("attributeValues");
          const attributeSelect=(valueSectionId,attrId)=>{
            console.log(valueSectionId,attrId);
            const attribute=document.getElementById(`${attrId}`).value;
            let prevAttr=localStorage.getItem("attributeValues");
            console.log(prevAttr);
            if(prevAttr==null){
              $.ajax({
                  url: "show-attributeValue.php",
                  method:"POST",
                  data: {attr_id:attribute,attr_name:attrId},
                  success: function(data) {
                    $(`${valueSectionId}`).html(data)
                    localStorage.setItem("attributeValues",attribute);
                  }
              });

            }
            else{
              let prevAttrArray=localStorage.getItem("attributeValues").split('@');
              let x=prevAttrArray.findIndex(attr=>attr==attribute);
              if(x==-1){
                $.ajax({
                    url: "show-attributeValue.php",
                    method:"POST",
                    data: {attr_id:attribute,attr_name:attrId},
                    success: function(data) {
                      $(`${valueSectionId}`).html(data)
                      if(prevAttr===""){
                        localStorage.setItem("attributeValues",attribute);
                      }
                      else{
                        let newAttr=prevAttr+"@"+attribute;
                        localStorage.setItem("attributeValues",newAttr);
                      }
                    }
                });

              }
              else{
                document.getElementById(`${attrId}`).value="Select Attribute";
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Attribute already added! Select another Attribute.',
                })
                $(`${valueSectionId}`).html("");
              }

            }
            
          }
          const handleChangeFile=(event)=>{
            let imgSection=document.getElementById('prd_img_section');
            imgSection.innerHTML = " ";

            const length=event.target.files.length;
            let i=0;
            for(i=0;i<length;i++){

              var preview = document.createElement("img");
              preview.className = "img-fluid mt-1";
              preview.width = "100";
              preview.style.margin = "7px";

              preview.src = URL.createObjectURL(event.target.files[i]);
              preview.onload = function() {
                  URL.revokeObjectURL(preview.src) // free memory
                }

              imgSection.appendChild(preview);
            }
            var file= document.getElementById("formFile");
            console.log("file",file);
          }

          const addProductAttribute=()=>{
            let value = parseInt(document.getElementById('noOfAttr').value, 10);
            value++;
            console.log(value);
            document.getElementById('noOfAttr').value = value;

            let parentDiv=document.getElementById('allAttributes');

            let attrChild=document.createElement('div');
            attrChild.id = `attrChild${value}`;
            attrChild.className="mt-3"

            let childHeader=document.createElement('div');
            childHeader.className = "mb-4 row align-items-center";

            let label = document.createElement("label");
            label.className = "form-label-title col-sm-3 mb-0";
            label.innerText = "Attributes Name";

            let div=document.createElement('div');
            div.className="col-sm-8";

            let crossBtn=document.createElement('div');
            crossBtn.className="col-sm-1";

            let crossIcon=document.createElement("i");
            crossIcon.className = "ri-close-fill text-danger";
            crossIcon.style.cursor="pointer";
            crossIcon.style.fontWeight="bolder";
            crossIcon.onclick = function() {
              deleteAttribute(this.parentElement);
              };
              
            crossBtn.appendChild(crossIcon);

            var select = document.createElement("select");
            select.id = `attr${value}`;
            select.className = "js-example-basic-single w-100";
            select.onchange = "attributeSelect";
            select.setAttribute("onchange", `attributeSelect('#attr-section${value}','attr${value}')`);
            select.name =`attr${value}`;
            select.innerHTML = '<?php echo $attrOptions; ?>';

            div.appendChild(select);

            childHeader.appendChild(label);
            childHeader.appendChild(div);
            childHeader.appendChild(crossBtn);

            attrChild.appendChild(childHeader);
            let adjacentDiv=document.createElement('div');
            adjacentDiv.className="row align-items-center";
            adjacentDiv.id=`attr-section${value}`
            attrChild.appendChild(adjacentDiv);

            parentDiv.appendChild(attrChild);

          }
          const submitEditedData=()=>{
            //set description to the hidden input to send it in the backend
            const editor=document.getElementById('editor');
            let descriptionPane=editor.nextSibling.childNodes[2].childNodes[0];
            const descInput=document.getElementById('desc');
            descInput.value=descriptionPane.innerHTML;
            const isExistPaneId=document.getElementById('descPane');
            console.log(descInput.value);

            //clear attributes value from local Storage
            localStorage.removeItem("attributeValues");

          }
          const deleteAttribute=(e)=>{
            let removalDIvId=e.parentElement.parentElement;
            let removalAttrNameId=e.parentElement.children[1].children[0].value;
            
            if(removalAttrNameId!="Select Attribute"){
              console.log("jiji");
              let prevAttr=localStorage.getItem("attributeValues");
              let prevAttrArray=localStorage.getItem("attributeValues").split('@');

              let newArray=prevAttrArray.filter(value=>value!=removalAttrNameId);

              let newAttrAsString="";
              let i=0;
              for(i=0;i<newArray.length-1;i++){
                newAttrAsString=newAttrAsString+newArray[i]+"@";
              }
              newAttrAsString=newAttrAsString+newArray[i];
              localStorage.setItem("attributeValues",newAttrAsString);

              console.log(removalAttrNameId,newArray,newAttrAsString);
            }

            var element=document.getElementById(removalDIvId.id);
            // console.log(removalDIvId.id,removalAttrNameId,list);
            removalDIvId.parentNode.removeChild(element);
            
          }


        </script>
        <?php include('includes/footer.php'); ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <?php include('includes/scripts.php'); ?>
</body>

</html>
