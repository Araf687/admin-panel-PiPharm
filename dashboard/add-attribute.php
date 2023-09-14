<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php'); 
?>

<body>
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
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-xxl-8 col-lg-10 m-auto">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-header-2">
                        <h5>Add Attribute</h5>
                      </div>
                      <!-- //deleting previous unedited data from localStorage, if they are exist. -->
                      <script>localStorage.removeItem("attributeValues");</script>

                      <form action="querryCode/attributeCode.php" method="POST" class="theme-form theme-form-2 mega-form">
                        <div class="mb-4 row align-items-center">
                          <label class="form-label-title col-sm-3 mb-0">Attribute
                            Name</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="text" name="attribute_name" placeholder="Attribute Name">
                          </div>
                        </div>

                        <div class="mb-4 row align-items-start">
                          <label class="col-sm-3 col-form-label form-label-title">Attribute
                            Value</label>
                          <div class="col-sm-9">
                            <div class="row g-sm-4 g-3">
                              <div class="col-sm-10 col-9">
                                <input class="form-control" type="text" id="attribute_input" placeholder="Attribute Value">
                              </div>

                              <div class="col-sm-2 col-3">
                                <span onClick="handleAddValue()" class="btn text-white theme-bg-color w-25">Add</span>
                              </div>
                              <div id="attribute-value-sec" class="col-sm-12">
                              <!-- hidden input to send all attribute value to backend via form -->
                              <input type="text" style="display:none" id="allAttributes" name="all_attributes">
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <button name="addAttribute" type="submit" onclick="clearStorage()" class="btn ms-auto theme-bg-color text-white">Add Attribute</button>

                      </form>

                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- New Product Add End -->
        <script>
          const handleAddValue=()=>{
            const attributeValue=document.getElementById("attribute_input").value;

            if(attributeValue!==""){
              const attributeSection=document.getElementById("attribute-value-sec");
              const prevAttr=localStorage.getItem('attributeValues');

              const spanElement=document.createElement("SPAN");
              spanElement.innerText=attributeValue;
              spanElement.classList.add('p-1', 'm-1', 'bg-primary', 'rounded');
              let i = document.createElement("i");
              i.className = "ri-close-circle-line attrRemoveIcon";
              i.onclick = function() {
                handleRemoveValue(spanElement.innerText);
              };
              spanElement.appendChild(i);
              attributeSection.appendChild(spanElement);
              
              console.log(attributeValue); 

              let newValue="";
              if (prevAttr !== null) {
                  newValue=localStorage.getItem('attributeValues')+", "+attributeValue;
                  localStorage.setItem("attributeValues",newValue);
              } else {
                newValue=attributeValue;
                localStorage.setItem("attributeValues",newValue);
              }
              document.getElementById("allAttributes").value=newValue;
              console.log(newValue);
              document.getElementById("attribute_input").value = "";
            }
            else{
              alert("empty attribute input");
            }

            
          }
          const handleRemoveValue=(removalValue)=>{
            const attributeValue=removalValue;
            const attributeSection=document.getElementById("attribute-value-sec");
            const allChildrens = attributeSection.childNodes;
            
            
              let index=-1;
              // iterate over all child nodes
              allChildrens.forEach(child => {
                if(child.innerText==attributeValue){
                  index=Array.prototype.indexOf.call(attributeSection.children, child);
                }
                
              });
              if(index==-1){
                alert("value not matched");
              }
              else{
                console.log("hiiii");
                attributeSection.removeChild(attributeSection.children[index]);
                let storageValues=localStorage.getItem('attributeValues').split(", ");
                if(storageValues!==null){
                  const newValues=storageValues.filter(value=>value!=attributeValue);
                  let valueAsString="",v=0;

                  if(newValues.length){
                    for(v=0;v<newValues.length-1;v++){
                      valueAsString=valueAsString+newValues[v]+", ";
                    }
                    valueAsString=valueAsString+newValues[v];
                  }
                  console.log(valueAsString);
                  localStorage.setItem("attributeValues",valueAsString);
                  document.getElementById("allAttributes").value=valueAsString;
                }
                else{
                  alert("no attribute values exist");
                }
                
              }
          }

          const clearStorage=()=>{
            let attrVal=document.getElementById("allAttributes").value;
            localStorage.removeItem("attributeValues");
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