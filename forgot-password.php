<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/images/favicon/medicine.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/favicon/medicine.png" type="image/x-icon">
  <title>PiPharma Admin Panel</title>

  <!-- Google font-->
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Fontawesome css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/font-awesome.css">

  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">

  <!-- Feather icon css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/feather-icon.css">

  <!-- Bootstrap css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">

  <!-- App css -->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

  <!-- forgot password start -->
  <section class="log-in-section section-b-space">
    <a href="" class="logo-login"><img src="assets/images/logo/piPharm.png" style="border-radius:5px"
        class="img-fluid"></a>
    <div class="container w-100">
      <div class="row">

        <div class="col-xl-5 col-lg-6 me-auto">
          <div class="log-in-box">
            <div class="log-in-title">
              <h3>Welcome To Order</h3>
              <h4>Forgot Password</h4>
            </div>

            <div class="input-box">
              <form id="reset-password-form" class="row g-4">
                <div class="col-12">
                  <div>
                    <label class="form-check-label" for="inlineRadio1">Select Your Account
                      Type</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="loginType" id="inlineRadio1" value="authority"
                      checked>
                    <label class="form-check-label" for="inlineRadio1">Authority Admin</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="loginType" id="inlineRadio2" value="pharmacy">
                    <label class="form-check-label" for="inlineRadio2">Pharmacy</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating theme-form-floating log-in-form">
                    <input type="text" class="form-control" id="user-name" name="user-name" placeholder="Email Address">
                    <label for="email">Enter User Name</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating theme-form-floating log-in-form">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                    <label for="email">Enter Email Address</label>
                  </div>
                </div>



                <div class="col-12">
                  <button class="btn btn-animation w-100 justify-content-center" type="submit">Send</button>
                </div>

                <div class="col-12">
                  <div>
                    <!-- Button trigger modal -->
                    <!-- <button type="button" id="modalOpenBTN" class="btn btn-primary" data-toggle="modal"
                      data-target="#exampleModalToggle">
                      Launch demo modal
                    </button> -->
                  

                    <!-- Modal -->
                    <!-- <div class="modal fade" id="exampleModal_resetPass1" tabindex="-1" role="dialog"
                      aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content p-5 ">

                          <div class="modal-body d-flex justify-content-center align-items-center">
                            <img src="assets/images/mail/sendMail.gif" alt="" srcset="" height="150px">
                          </div>
                          <p class="text-center">Sending new password to your email..</p>

                          <button type="button" id="modalCloseBTN" class="btn btn-secondary d-none"
                            data-dismiss="modal">Close</button>


                        </div>
                      </div> -->

                  </div>
                </div>
            </div>


            </form>
          </div>

        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- forgot password end -->

  <!-- <div class="modal fade theme-modal remove-coupon" id="exampleModal_resetPass1" aria-hidden="true" tabindex="-1">
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

      </div>
    </div>
  </div> -->


  <!-- latest jquery-->
  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap js-->
  <script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>

  <!-- Theme js-->
  <script src="assets/js/script.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {

      let request;

      $("#reset-password-form").submit(function (event) {
        document.getElementById('modalOpenBTN').click()

        event.preventDefault();
        if (request) {
          request.abort();
        }
        var $form = $(this);
        var serializedData = $form.serialize();

        request = $.ajax({
          url: "querryCode/reset/send-password-to-user-email.php",
          type: "post",
          data: serializedData,
        });

        request.done(function (response, textStatus, jqXHR) {
          console.log(response);
          // console.log($.parseJSON(response));
          const jsonData = $.parseJSON(response);

          if (jsonData?.isSuccess) {
            document.getElementById('modalCloseBTN').click();
            Swal.fire({
              title: "Good job!",
              text: "You clicked the button!",
              icon: "success"
            });
          } else {
            document.getElementById('modalCloseBTN').click();
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to send mail",
            });
          }
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
          document.getElementById('modalCloseBTN').click();
          console.error("The following error occurred: " + textStatus, errorThrown);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        });
        request.always(function () { });
      });
    })
  </script>
</body>

</html>