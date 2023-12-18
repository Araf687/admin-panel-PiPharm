<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php'); ?>

<body>
<?php
      
      if(isset($_SESSION['status']))
      {
        // echo "<script>console.log(\"".$_SESSION['status']."\")</script>";

        if($_SESSION['status']=="added"){
          echo "<script>Swal.fire(
              'Great!',
              'User Added Successfully!',
              'success'
          );
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

      <!-- Page Sidebar Start -->
      <div class="page-body">
        <!-- New User start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-sm-8 m-auto">
                  <form action="querryCode/userCode.php" method="POST" class="theme-form theme-form-2 mega-form">
                    <div class="card">
                      <div class="card-body">
                        <div class="title-header option-title">
                          <h5>Add New User</h5>
                        </div>
                        
                          <div class="card-header-1">
                            <h5>User Information</h5>
                          </div>
                          <div class="row">
                            <div class="mb-4 row align-items-center">
                              <label class="form-label-title col-lg-3 col-md-3 mb-0">First
                                Name</label>
                              <div class="col-md-9 col-lg-9">
                                <input name="firstName" class="form-control" type="text">
                              </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                              <label class="form-label-title col-lg-3 col-md-3 mb-0">Last
                                Name</label>
                              <div class="col-md-9 col-lg-9">
                                <input name="lastName"  class="form-control" type="text">
                              </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                              <label class="col-lg-3 col-md-3 col-form-label form-label-title">Email
                                Address</label>
                              <div class="col-md-9 col-lg-9">
                                <input name="emailAddr" onChange="isEmailValid(event)" class="form-control" type="email">
                              </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                              <label class="col-lg-3 col-md-3 col-form-label form-label-title">Phone</label>
                              <div class="col-md-9 col-lg-9">
                                <input name="phone" class="form-control" type="text">
                              </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                              <label class="col-lg-3 col-md-3 col-form-label form-label-title">Password</label>
                              <div class="col-md-9 col-lg-9">
                                <input name="pass" id="pass" onChange="checkPass(event)" class="form-control" type="password">
                              </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                              <label class="col-lg-3 col-md-3 col-form-label form-label-title">Confirm
                                Password</label>
                              <div class="col-md-9 col-lg-9">
                                <input class="form-control" name="confirm_pass" id="confirmPass" onChange="isPassMatched(event)" type="password">
                                <p id="notifyMatchPass" class="text-danger"></p>
                              </div>
                            </div>
                          </div>                           
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <div class="title-header option-title">
                          <h5>User Address</h5>
                        </div>
                        <!-- //hidden input to send number of address data in the backend -->
                        <input type="number" value="1" style="display:none;" id="addresses" name="noOfAddress">
                        <div id="allAddresses">
                              <div class="mb-5 row align-items-center" id="address1">
                                  <label class="form-label-title col-lg-2 col-md-3 mb-0">Address</label>
                                  <div class="col-md-9 col-lg-9">
                                    <div class="mb-3">
                                      <label></label>
                                      <input name="addr1_main" class="form-control" type="text">
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6 col-lg-6 mb-2">
                                        <label>City</label>
                                        <input name="addr1_city" class="form-control" type="text">
                                      </div>
                                      <div class="col-md-6 col-lg-6 mb-2">
                                        <label>State</label>
                                        <input name="addr1_state" class="form-control" type="text">
                                      </div>
                                      <div class="col-md-6 col-lg-6 mb-2">
                                        <label>Country</label>
                                        <input name="addr1_country" class="form-control" type="text">
                                      </div>
                                      <div class="col-md-6 col-lg-6 mb-2">
                                        <label>Zip Code</label>
                                        <input name="addr1_zip" class="form-control" type="text">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-1">
                                      <i class="ri-close-fill text-danger cancelIcon" onclick="deleteAddress(this.parentElement)" style="cursor:pointer;font-weight: bolder;"></i>
                                  </div>
                              </div>
                              
                        </div>
                        
                        <span onclick="addAddress()" class="add-option" style="cursor:pointer"><i class="ri-add-line me-2"></i> Add Another Address</span>
                      </div>
                    </div>
                    <button name="addUser" type="submit" class="btn ms-auto theme-bg-color my-2 text-white" style="margin-right:20px;">Add User</button>
                  </form> 
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- New User End -->
        <script>
          const isEmailValid=(e)=>{
            console.log(e.target.value);
          }
          const isPassMatched=(e)=>{
            const pass=document.getElementById("pass").value;
            const confirmPass=e.target.value;
            if(pass!==confirmPass){
              document.getElementById("notifyMatchPass").innerText="Password does not match";
            }
          }
          const checkPass=(e)=>{
            const pass=e.target.value;
            const confirmPass=document.getElementById("confirmPass").value;

            const notifier=document.getElementById("notifyMatchPass").innerText;
            if(notifier!==""){
              if(pass==confirmPass){
                document.getElementById("notifyMatchPass").innerText="";
              } 
            }
            
          }

          const addAddress=()=>{
            let noOfAddress=document.getElementById("addresses").value;
            noOfAddress++;
            document.getElementById("addresses").value=noOfAddress;
            console.log(noOfAddress);

            const mainSection=document.getElementById("allAddresses");

            let div1=document.createElement('div');
            div1.id=`address${noOfAddress}`;
            div1.className="mb-5 row align-items-center";

            let label1 = document.createElement("label");
            label1.className ="form-label-title col-lg-2 col-md-3 mb-0";
            label1.innerText = "Address";

            div1.appendChild(label1);

            let div2=document.createElement('div');
            div2.className="col-md-9 col-lg-9";

            let div3=document.createElement('div');
            div3.className="mb-3";

            let label2= document.createElement("label");
            label2.innerText = "";

            var inputElement = document.createElement('input');
            inputElement.className="form-control"
            inputElement.setAttribute('type', 'text');
            inputElement.setAttribute('name', `addr${noOfAddress}_main`);
            inputElement.setAttribute('placeholder', 'Enter Address');

            div3.appendChild(label2);
            div3.appendChild(inputElement);


            let div4=document.createElement('div');
            div4.className="row";


            let i=0;
            for(i=0;i<4;i++){
              let labelText=i===0?"City":i===1?"State":i==2?"Country":"Zip Code";
              let inputName=i===0?`addr${noOfAddress}_city`:i===1?`addr${noOfAddress}_state`:i==2?`addr${noOfAddress}_country`:`addr${noOfAddress}_zip`;

              console.log(labelText,inputName);

              let div=document.createElement('div');
              div.className="col-md-6 col-lg-6 mb-2";

              let label= document.createElement("label");
              label.innerText = labelText;

              var inputElement = document.createElement('input');
              inputElement.className="form-control"
              inputElement.setAttribute('type', 'text');
              inputElement.setAttribute('name', inputName);

              div.appendChild(label);
              div.appendChild(inputElement);

              div4.appendChild(div);

            }

            div2.appendChild(div3);
            div2.appendChild(div4);

            div1.appendChild(div2);


            let crossBtn=document.createElement('div');
            crossBtn.className="col-sm-1";

            let crossIcon=document.createElement("i");
            crossIcon.className = "ri-close-fill text-danger cancelIcon";
            crossIcon.style.cursor="pointer";
            crossIcon.style.fontWeight="bolder";
            crossIcon.onclick = function() {
              deleteAddress(this.parentElement);
              };
              
            crossBtn.appendChild(crossIcon);

            div1.appendChild(crossBtn);

            mainSection.appendChild(div1);
            
            
          }


          const deleteAddress=(e)=>{
            let removalDIvId=e.parentElement.id;
            const parentDiv=document.getElementById('allAddresses');
            const removalElement=document.getElementById(removalDIvId);
            parentDiv.removeChild(removalElement);
            
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
