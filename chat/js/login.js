window.onload = () => {
  // Check if element exists before calling function
  const elementExists = (element) => {
    return element != undefined && element != null;
  };

  // Change input type file when file is selected===============================
  const fileInputs = document.querySelectorAll(".chose-image-input");

  const changeFileInputs = () => {
    fileInputs.forEach((input) => {
      input.addEventListener("change", () => {
        const spanToBeRenamed =
          input.parentNode.querySelector(".select-image-span");
        if (input.files.length > 0) {
          spanToBeRenamed.innerHTML = input.files[0].name;
          input.parentElement.classList.add("bg-green-200");
        } else {
          spanToBeRenamed.innerHTML = "Select Image";
          input.parentElement.classList.remove("bg-green-200");
        }
      });
    });
  };
  if (elementExists(fileInputs)) {
    changeFileInputs();
  }
  // *********************************************
};
