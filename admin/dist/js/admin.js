window.onload = () => {
  //HTML elements
  const sidebarPageTitles = document.querySelectorAll(".sidebar-page-header");
  const sidebarLinks = document.querySelectorAll(".nav-treeview .nav-link");

  // Check if element exists before calling function
  const elementExists = (element) => {
    return element != undefined && element != null;
  };

  //Get current URL page name
  const getCurrentPageName = () => {
    const currentPath = window.location.href;
    //var sPage = sPath.substring(sPath.lastIndexOf('\\') + 1);
    const currentPage = currentPath.substring(currentPath.lastIndexOf("/") + 1);
    console.log("currentPage", currentPage);

    //TODO file extension
    // let lastDotIndex = currentPage.lastIndexOf(".");
    // lastDotIndex =
    //   elementExists(lastDotIndex) && lastDotIndex !== -1
    //     ? lastDotIndex
    //     : currentPage.length;
    // const currentPageName = currentPage.substring(0, lastDotIndex);
    // return currentPageName;

    return currentPage;
  };

  //Get current sideBar page
  const getCurrentSidebarPage = () => {
    //get current page name from URL
    const currentPageName = getCurrentPageName();

    sidebarLinks.forEach((sidebarLink) => {
      sidebarLink.classList.remove("active");
      const dataPageHeader = sidebarLink.getAttribute("data-page-header");
      const dataPage = sidebarLink.getAttribute("data-page");
      if (currentPageName === dataPage) {
        console.log("dataPage", dataPage);
        //activate link
        sidebarLink.classList.add("active");
        //open sidebar dropdown
        const currentPageHeader = document.getElementById(dataPageHeader);
        currentPageHeader.classList.add("menu-open");
        //add blue color to dropdown header
        const sidebarPageTitle = currentPageHeader.querySelector(
          ".sidebar-page-title"
        );
        sidebarPageTitle.classList.add("active");
        //set active icon
        const navIcon = sidebarLink.querySelector(".nav-icon");
        console.log("navIcon", navIcon);
        navIcon.classList.remove("fa-circle");
        navIcon.classList.add("fa-dot-circle");
      }
    });
  };

  getCurrentSidebarPage();

  //FORMS VALIDATION
  //Add user form validation
  $(function () {
    $("#add-user-form").validate({
      rules: {
        firstname: {
          required: true,
        },
        lastname: {
          required: true,
        },
        username: {
          required: true,
          minlength: 6,
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
          minlength: "Your username must be at least 6 characters long",
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
    $("#edit-user-form").validate({
      rules: {
        firstname: {
          required: true,
        },
        lastname: {
          required: true,
        },
        username: {
          required: true,
          minlength: 6,
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
          minlength: "Your username must be at least 6 characters long",
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

  //Initialize Custom file input
  $(function () {
    bsCustomFileInput.init();
  });
};
