window.onload = () => {
  // =====================CACHE DOM ELEMENTS=====================
  const header = document.querySelector("header");
  const body = document.querySelector("body");
  const hamburger = document.querySelector("#hamburger");
  const nav = document.querySelector(".header-menu");

  const labelTransform = document.querySelectorAll(".label-transform");
  const upArrow = document.querySelector(".to-top-arrow");

  //FOOTER
  const currentYearSpan = document.querySelector(".current-year-span");
  // =========== General Functions =================

  // Check if element exists before calling function
  const elementExists = (element) => {
    return element != undefined && element != null;
  };

  // Preloader============
  const preloader = document.querySelector(".preloader");
  if (elementExists(preloader)) {
    preloader.classList.add("hide");
  }

  // ========================HEADER============================

  //Navbar on mobile===========
  const navToggle = () => {
    nav.classList.toggle("show-nav");
    if (nav.classList.contains("show-nav")) {
      nav.style.animation = `navSlideIn 0.7s forwards`;
    } else {
      nav.style.animation = `navSlideOut 0.7s`;
    }
    hamburger.classList.toggle("toggle-burger");
  };
  const closeNav = () => {
    nav.classList.remove("show-nav");
    nav.style.animation = `navSlideOut 0.7s`;
    hamburger.classList.remove("toggle-burger");
  };

  //Scroll to selected sections from menu links
  const homePageLinks = document.querySelectorAll(".home-page-link");
  const scroollToSection = (section) => {
    const dataLink = section.getAttribute("data-link");
    const targetSection = document.querySelector(`#${dataLink}`);
    //smooth scroll if the target section is on the current page
    if (elementExists(targetSection)) {
      const targetPosition =
        targetSection.getBoundingClientRect().top + window.pageYOffset;
      const headerOffset =
        window.innerWidth <= 1024
          ? document.querySelector("header").offsetHeight
          : 0;
      const offsetPosition = targetPosition - headerOffset;
      window.scrollTo({
        top: offsetPosition,
        behavior: "smooth",
      });
    } else {
      //target section is on annother page
      location.href = `index.php#${dataLink}`;
    }
    //close nav on mobile
    closeNav();
  };

  // =============================custom dropdown=======================================

  for (const dropdown of document.querySelectorAll(".custom-select-wrapper")) {
    dropdown.addEventListener("click", function () {
      this.querySelector(".custom-select").classList.toggle("open");
    });
  }

  for (const option of document.querySelectorAll(".custom-option")) {
    option.addEventListener("click", function () {
      if (!this.classList.contains("selected")) {
        this.parentNode
          .querySelector(".custom-option.selected")
          .classList.remove("selected");
        this.classList.add("selected");
        //set input to current value
        let input = this.parentNode.querySelector(".select-value-input");
        let currentValue = this.getAttribute("data-value");
        if (input) {
          input.setAttribute("value", currentValue);
        }
        //set select header text
        this.closest(".custom-select").querySelector(
          ".custom-select__trigger span"
        ).textContent = this.textContent;
      }
    });
  }

  window.addEventListener("click", function (e) {
    for (const select of document.querySelectorAll(".custom-select")) {
      if (!select.contains(e.target)) {
        select.classList.remove("open");
      }
    }
  });

  // ***********************************************************************************
  // ==============FORMS=========================================
  // Floating labels
  const moveUp = (input) => {
    const currenLabel = input.previousElementSibling;
    input.classList.add("current-input");
    currenLabel.classList.add("moveUp");
  };

  const moveDown = (input) => {
    const currenLabel = input.previousElementSibling;
    if (input.value == "") {
      input.classList.remove("current-input");
      currenLabel.classList.remove("moveUp");
    }
  };

  //====================================================================

  // Scroll to top arrow
  const scrollToTop = () => window.scroll({ top: 0, behavior: "smooth" });
  // Show scroll up arrow
  const showItem = (item, scrollHeight) => {
    const y = window.scrollY;
    if (y >= scrollHeight) {
      item.classList.add("show");
    } else {
      item.classList.remove("show");
    }
  };

  //=========FOOTER===========
  const getCurrentYear = () => {
    let currentDate = new Date();
    return currentDate.getFullYear();
  };

  if (elementExists(currentYearSpan)) {
    currentYearSpan.innerHTML = getCurrentYear();
  }

  // ==============================Forms validation======================
  const submitContact = document.querySelector(".submit-contact");
  const allFieldsRequiredMessage_p = document.querySelector(
    ".all-fields-required-message"
  );
  function validateEmail(email) {
    var re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  const validateFormInput = (event, condition, item) => {
    //set input bg
    item.style.backgroundColor = "transparent";
    //show warning message

    if (condition) {
      event.preventDefault();
      item.style.backgroundColor = "#d9534f55";
      allFieldsRequiredMessage_p.style.display = "block";
    } else {
      allFieldsRequiredMessage_p.style.display = "none";
    }
  };

  function validateForm(event) {
    const requiredFields = document.querySelectorAll(".required-field");
    // check required inputs
    requiredFields.forEach((field) => {
      validateFormInput(event, field.value == "", field);
      field.addEventListener("input", function () {
        validateFormInput(event, field.value == "", field);
      });
      //validate required checkbox
      //has to be wrapped in a p which gets the bg color
      if (field.type.toLowerCase() == "checkbox") {
        validateFormInput(event, field.checked == false, field.parentNode);
        field.addEventListener("input", function () {
          validateFormInput(event, field.checked == false, field.parentNode);
        });
      }
      //validate email
      if (field.type.toLowerCase() == "email") {
        validateFormInput(event, validateEmail(field.value) == false, field);
        field.addEventListener("input", function () {
          validateFormInput(event, validateEmail(field.value) == false, field);
        });
      }
      //validate select
      if (field.tagName.toLowerCase() == "select") {
        validateFormInput(
          event,
          field.value == "0" || field.value == undefined,
          field
        );
      }
    });
  }
  // ************************************************************

  //=========================EVENT LISTENERS=====================
  if (elementExists(homePageLinks)) {
    homePageLinks.forEach((pageLink) => {
      pageLink.addEventListener("click", () => scroollToSection(pageLink));
    });
  }
  // show nav on hamburger tap
  hamburger.addEventListener("click", navToggle);
  //floating labels
  if (elementExists(labelTransform)) {
    // Input labels event listeners
    labelTransform.forEach((input) =>
      input.addEventListener("focus", () => moveUp(input))
    );
    labelTransform.forEach((input) =>
      input.addEventListener("focusout", () => moveDown(input))
    );
    labelTransform.forEach((input) => {
      if (input.value !== "") {
        moveUp(input);
      } else {
        moveDown(input);
      }
    });
  }

  // Scroll to top
  if (elementExists(upArrow)) {
    window.addEventListener("scroll", () => showItem(upArrow, 300));
  }
  // scroll page to top
  if (elementExists(upArrow)) {
    upArrow.addEventListener("click", scrollToTop);
  }

  //Contact form
  if (elementExists(submitContact)) {
    submitContact.addEventListener("click", validateForm);
  }
};
