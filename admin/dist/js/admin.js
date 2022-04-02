window.onload = () => {
  //HTML elements
  const sidebarLinks = document.querySelectorAll(".nav-treeview .nav-link");

  // Check if element exists before calling function
  const elementExists = (element) => {
    return element != undefined && element != null;
  };

  //Get current sideBar page==========
  const getCurrentSidebarPage = () => {
    const currentPageURL = window.location.href;

    sidebarLinks.forEach((sidebarLink) => {
      sidebarLink.classList.remove("active");
      const currentLink = sidebarLink.href;
      if (currentPageURL === currentLink) {
        //activate link
        sidebarLink.classList.add("active");
        //open sidebar dropdown
        const currentPageHeader = sidebarLink.closest(".sidebar-page-header");
        currentPageHeader.classList.add("menu-open");
        //add blue color to dropdown header
        const sidebarPageTitle = currentPageHeader.querySelector(
          ".sidebar-page-title"
        );
        sidebarPageTitle.classList.add("active");
        //set active icon
        const navIcon = sidebarLink.querySelector(".nav-icon");
        navIcon.classList.remove("fa-circle");
        navIcon.classList.add("fa-dot-circle");
      }
    });
  };

  if (elementExists(sidebarLinks)) {
    getCurrentSidebarPage();
  }
  // #################################

  // CKEditor=======================================
  const body = document.querySelector("#body");
  if (body != undefined && body != null) {
    ClassicEditor.create(body).catch((error) => {
      console.error("There was a problem initializing the editor.", error);
    });
  }

  // Blog================
  const blogPostStatusSelect = document.querySelectorAll(".post-status-select");

  const setBlogStatusColor = () => {
    for (statusSelect of blogPostStatusSelect) {
      if (statusSelect.value == "Published") {
        statusSelect.style.backgroundColor = "#28a745";
      }
    }
  };

  if (elementExists(blogPostStatusSelect)) {
    setBlogStatusColor();
  }

  // CLEAR INPUT AFTER BUTTON==================
  const clearInputAfterBtns = document.querySelectorAll(".clear-input-after");

  const clearInputAfterOnClick = () => {
    clearInputAfterBtns.forEach(function (clearInputBtn) {
      clearInputBtn.addEventListener("click", function () {
        const targetInput = clearInputBtn.parentElement.nextElementSibling;
        targetInput.value = "";
      });
    });
  };

  if (elementExists(clearInputAfterBtns)) {
    clearInputAfterOnClick();
  }
  // ##############################

  // Set select color
  const channelsColorsSelect = document.querySelector(
    "#channels-colors-select"
  );
  const randomizeSelectBtns = document.querySelectorAll(".randomize-select");

  const setOptionColor = (curentSelect) => {
    const options = curentSelect.querySelectorAll("option");
    options.forEach((item) => {
      if (item.selected == true) {
        const optionColor = item.getAttribute("data-color");
        channelsColorsSelect.style.backgroundColor = optionColor;
      }
    });
  };

  const randomizeSelectOnClick = () => {
    randomizeSelectBtns.forEach(function (selectBtn) {
      selectBtn.addEventListener("click", function () {
        const targetSelect = selectBtn.parentElement.nextElementSibling;
        const items = targetSelect.getElementsByTagName("option");
        const index = Math.floor(Math.random() * items.length);
        targetSelect.selectedIndex = index;
        setOptionColor(targetSelect);
      });
    });
  };

  //event listeners
  if (!!randomizeSelectBtns) {
    randomizeSelectOnClick();
  }
  if (!!channelsColorsSelect) {
    // set option color on load
    setOptionColor(channelsColorsSelect);
    channelsColorsSelect.addEventListener("change", () => {
      setOptionColor(channelsColorsSelect);
    });
  }
  // ===================================
  //FORMS VALIDATION
  //user forms validation
  $(function () {
    $("#user-form").validate({
      rules: {
        firstname: {
          required: true,
        },
        lastname: {
          required: true,
        },
        username: {
          required: true,
          minlength: 3,
        },
        email: {
          required: true,
          email: true,
        },
        phone: {
          required: true,
        },
        user_password: {
          required: true,
          minlength: 8,
        },
        repeat_user_password: {
          required: true,
          equalTo: "#user_password",
        },
      },
      messages: {
        username: {
          required: "Please provide a username",
          minlength: "Your username must be at least 3 characters long",
        },
        email: {
          required: "Please enter a email address",
          email: "Please enter a vaild email address",
        },
        user_password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 8 characters long",
        },
        repeat_user_password: {
          required: "Please enter the same a password",
          equalTo: "Your password must be the same",
        },
      },
      errorElement: "span",
      errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest(".form-group").append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
      },
    });
  });

  //add member forms validation
  $(function () {
    $("#add-member-form").validate({
      rules: {
        firstname: {
          required: true,
        },
        lastname: {
          required: true,
        },
        username: {
          required: true,
          minlength: 3,
        },
        email: {
          required: true,
          email: true,
        },
        m_password: {
          required: true,
          minlength: 8,
        },
        repeat_m_password: {
          required: true,
          equalTo: "#m_password",
        },
      },
      messages: {
        username: {
          required: "Please provide a username",
          minlength: "Your username must be at least 3 characters long",
        },
        email: {
          required: "Please enter a email address",
          email: "Please enter a vaild email address",
        },
        user_password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 8 characters long",
        },
        repeat_user_password: {
          required: "Please enter the same a password",
          equalTo: "Your password must be the same",
        },
      },
      errorElement: "span",
      errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest(".form-group").append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
      },
    });
  });

  $(function () {
    //Initialize Custom file input
    bsCustomFileInput.init();
    //Initialize summernote
    $("#summernote").summernote();
  });
};
