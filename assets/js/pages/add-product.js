
const handleChangeFile = (event) => {
  let imgSection = document.getElementById('prd_img_section');
  imgSection.innerHTML = " ";

  const length = event.target.files.length;
  let i = 0;
  for (i = 0; i < length; i++) {

    var preview = document.createElement("img");
    preview.className = "img-fluid mt-1";
    preview.width = "100";
    preview.style.margin = "7px";

    preview.src = URL.createObjectURL(event.target.files[i]);
    preview.onload = function () {
      URL.revokeObjectURL(preview.src) // free memory
    }

    imgSection.appendChild(preview);
  }
  var file = document.getElementById("formFile");
  console.log("file", file);
}


const submitEditedData = () => {
  //set description to the hidden input to send it in the backend
  const editor = document.getElementById('editor');
  let descriptionPane = editor.nextSibling.childNodes[2].childNodes[0];
  const descInput = document.getElementById('desc');
  descInput.value = descriptionPane.innerHTML;
  const isExistPaneId = document.getElementById('descPane');
  console.log(descInput.value);

  //clear attributes value from local Storage
  localStorage.removeItem("attributeValues");

}


