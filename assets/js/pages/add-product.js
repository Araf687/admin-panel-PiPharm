
const handleChangeFile = (event) => {
  let preview = document.getElementById("prd_img");

  console.log(event.target.files[0]);
  preview.src = URL.createObjectURL(event.target.files[0]);
  preview.onload = function () {
    URL.revokeObjectURL(preview.src); // free memory
  };
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


