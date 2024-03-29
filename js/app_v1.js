window.onload = () => {
  // =====================CACHE DOM ELEMENTS=====================
  const hamburger = document.querySelector("#hamburger");
  const nav = document.querySelector(".header-menu");
  const labelTransform = document.querySelectorAll(".label-transform");

  const submitRequestForm = document.querySelectorAll(".submit-request-form");
  const submitContact = document.querySelector(".submit-contact");
  const submitNewsletterForm = document.querySelector(
    ".submit-newsletter-form"
  );
  const allFieldsRequiredMessage_p = document.querySelector(
    ".all-fields-required-message"
  );

  //FOOTER
  const upArrow = document.querySelector(".to-top-arrow");
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
    if (nav.classList.contains("show-nav")) {
      nav.classList.remove("show-nav");
      nav.style.animation = `navSlideOut 0.7s`;
      hamburger.classList.remove("toggle-burger");
    }
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

  //================AUM COUNTER ANIMATION ==========================
  const counters = document.querySelectorAll(".counter");
  const aumSection = document.querySelector("#aum-section");
  let aumSectionPosition = !!aumSection
    ? aumSection.getBoundingClientRect().top
    : 0;
  const countersSpeed = 75;

  const animateCounters = () => {
    counters.forEach((counter) => {
      let count = 0;
      const updateCount = () => {
        //added "+" to trasnform strings to numbers
        const target = +counter.getAttribute("data-target");
        const inc = target / countersSpeed;

        if (counter.innerText < target && count < target) {
          count += inc;
          counter.innerText = Math.round(count);
          setTimeout(updateCount, 10);
        } else {
          counter.innerText = target;
        }
      };
      updateCount();
    });
  };

  const startAnimateCounters = () => {
    if (
      aumSectionPosition - window.innerHeight <
      -(aumSection.offsetHeight / 2)
    ) {
      animateCounters();
    }
  };

  //Start counters on refresh if in viewport
  if (elementExists(aumSection)) {
    startAnimateCounters();
  }

  //Start counters on scroll when in viewport
  if (elementExists(aumSection)) {
    window.addEventListener("scroll", function () {
      aumSectionPosition = aumSection.getBoundingClientRect().top;
      startAnimateCounters();
    });
  }
  //  ##############################################################
  // Scroll to top arrow==================
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
    const currentForm = event.target.parentNode;
    const requiredFields = currentForm.querySelectorAll(".required-field");
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

  // ************************************************************************

  // ================== OPEN/CLOSED MODALS ======================
  const openModalBtns = document.querySelectorAll(".open-modal-btn");
  const closeModalBtns = document.querySelectorAll(".close-modal-btn");
  // open modal (get modal name from button attribute)
  const openModalOnClick = (openModalBtn) => {
    //select wich modal to open
    const modalName = openModalBtn.getAttribute("data-modal");
    const currentModal = document.querySelector(`.${modalName}`);
    console.log(currentModal);
    const modalTitle = openModalBtn.getAttribute("data-title");
    if (!!modalTitle) {
      //set modal title
      currentModal.querySelector(`.${modalName} .section-title`).innerHTML =
        modalTitle;
      //set request type
      currentModal.querySelector("#request-type").value = modalTitle;
    }
    currentModal.classList.add("show");
  };
  // open modal event listener
  if (elementExists(openModalBtns)) {
    openModalBtns.forEach((openModalBtn) => {
      openModalBtn.addEventListener("click", () =>
        openModalOnClick(openModalBtn)
      );
    });
  }
  // close modal (the modal should be direct parent to the close-button)
  const closeModalOnClick = (closeModalBtn) => {
    const currentModal = closeModalBtn.parentNode;
    currentModal.classList.remove("show");
  };

  // close modal event listeners
  if (elementExists(closeModalBtns)) {
    closeModalBtns.forEach((closeModalBtn) => {
      closeModalBtn.addEventListener("click", () =>
        closeModalOnClick(closeModalBtn)
      );
    });
  }

  // ***********************************************************

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

  //Validate become-a-member form
  if (elementExists(submitRequestForm)) {
    submitRequestForm.forEach((requestForm) => {
      requestForm.addEventListener("click", validateForm);
    });
  }
  //Validate contact form
  if (elementExists(submitContact)) {
    submitContact.addEventListener("click", validateForm);
  }
  //Validate newsletter form
  if (elementExists(submitNewsletterForm)) {
    submitNewsletterForm.addEventListener("click", validateForm);
  }
};

// ==============Newsletter=========================
const newsletterForm = document.querySelector("#newsletter-form");
const formMsg = document.querySelector(".form-msg");
const newsletterEmailInput = document.querySelector("#newsletter-email");
const newsletterCheckbox = document.querySelector(".newsletter-checkbox");
const submitNewsletterFormBtn = document.querySelector(
  ".submit-newsletter-form"
);

const newsletterSubmited = () => {
  submitNewsletterFormBtn.onclick = () => {
    let xhr = new XMLHttpRequest(); //create XML object
    xhr.open("POST", `PHP/newsletter_submit.php`, true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          formMsg.innerHTML = data;
          newsletterEmailInput.value = "";
          newsletterCheckbox.checked = false;
        }
      }
    };
    let formData = new FormData(newsletterForm);
    xhr.send(formData);
  };
};
if (submitNewsletterFormBtn) {
  newsletterSubmited();
}
