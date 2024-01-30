const handleChangeFile = (event) => {
  let preview = document.getElementById("prd_img");

  console.log(event.target.files[0]);
  preview.src = URL.createObjectURL(event.target.files[0]);
  preview.onload = function () {
    URL.revokeObjectURL(preview.src); // free memory
  };
};
const desc = (p) => {
  console.log("description");
};

const submitEditedData = () => {
  //set description to the hidden input to send it in the backend
  const editor = document.getElementById("editor");
  let descriptionPane = editor.nextSibling.childNodes[2].childNodes[0];
  const descInput = document.getElementById("desc");
  descInput.value = descriptionPane.innerHTML;
  const isExistPaneId = document.getElementById("descPane");
  console.log(descInput.value);

  //clear attributes value from local Storage
  localStorage.removeItem("attributeValues");
};

const checkProdImg = () => {
  const imgTag = document.getElementById("formFile");
  console.log(imgTag, imgTag.value, imgTag.files);
  let i = 0;
  for (i = 0; i < imgTag.files.length; i++) {
    console.log(imgTag.files[i]);
  }
};

const handleRemoveImg = (e, imgType) => {
  const removalImgSrc = e.parentElement.children[0].currentSrc;
  console.log("ASAS", removalImgSrc, e.parentElement.children);
  var files = document.getElementById("formFile").files;
  console.log(files);
  var fileName = $(e).parent().find("img");
  console.log(e.target, fileName, files[0]);
  for (var i = 0; i < files.length; i++) {
    if (files[i].name == fileName) {
      console.log("ji");
      files[i] = null;
      break;
    } else if (i == 0) {
      files[i] = null;
      break;
    }
  }
  $(e).parent().remove();
};
