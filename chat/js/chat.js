let panelItems = document.querySelectorAll(".panel-item");
const incomingImageContainer = document.querySelector(
  "#incoming-image-container"
);
const chatBox = document.querySelector("#chat-box");
const chatBoxContainer = document.querySelector("#chat-box-container");
const sendForm = document.querySelector("#send-form");
const sendInput = document.querySelector("#send-input");
const sendBtn = document.querySelector("#send-btn");

let searchTerm = "";
// Check if element exists before calling function
const elementExists = (element) => {
  return element != undefined && element != null;
};

// Logout Timer=================
const logout = () => {
  location.href = "php/logout.php?reason=timeout";
};
const inactivityTime = () => {
  let time;
  let time_to_wait = 900; // use the same value in php/members_list.php -> $time_to_wait

  //window.onmousemove = resetTimer;
  window.onload = resetTimer;
  window.onmousedown = resetTimer; // catches touchscreen presses as well
  window.ontouchstart = resetTimer; // catches touchscreen swipes as well
  window.onclick = resetTimer; // catches touchpad clicks as well
  window.onkeydown = resetTimer;
  window.addEventListener("scroll", resetTimer, true); // improved; see comments

  function resetTimer() {
    //update db expire tieme
    let xhr = new XMLHttpRequest(); //create XML object
    xhr.open("POST", "php/reset_session_timeout.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
        }
      }
    };
    xhr.send();
    clearTimeout(time);
    time = setTimeout(logout, time_to_wait * 1000); //15 min -> miliseconds
  }
};
inactivityTime();
// *****************************

//Scroll chat window to bottom
const scrollChatToBottom = () => {
  chatBoxContainer.scrollTop = chatBoxContainer.scrollHeight;
};

// ============ASYNC======================================
const chatPanelList = document.querySelector("#chat-panel-list");
const incomingIdInput = document.querySelector("#incoming-id-input");
let refreshChat = true;

//stop chat from scrolling to bottom whe the user scrolles
chatBox.onmouseenter = () => {
  refreshChat = false;
};
chatBox.onmouseleave = () => {
  refreshChat = true;
};

//Set SESSION['incoming_id'] when click on a panel item
const setCurrentIncomingId = () => {
  panelItems = document.querySelectorAll(".panel-item");
  panelItems.forEach((item) => {
    item.addEventListener("click", () => {
      const incomingId = item.getAttribute("data-id");
      let xhr = new XMLHttpRequest(); //create XML object
      xhr.open("GET", "php/set_session_incoming_id.php?id=" + incomingId, true);
      xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            getMessages(true);
            displayMembers();
          }
        }
      };
      xhr.send();
      readMessages();
      //show text window if on mobile
      showTextWindow();
    });
  });
};

//Set incoming image for the top bar
const setIncomingImage = () => {
  let xhr = new XMLHttpRequest(); //create XML object
  xhr.open("GET", "php/set_incoming_image.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        incomingImageContainer.innerHTML = data;
      }
    }
  };
  xhr.send();
};
setIncomingImage();

//populate chat panel list
const displayMembers = () => {
  let xhr = new XMLHttpRequest(); //create XML object
  xhr.open("GET", "php/display_members.php?searchTerm=" + searchTerm, true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatPanelList.innerHTML = data;
        setCurrentIncomingId();
        //set incoming image for top bar
        setIncomingImage();
      }
    }
  };
  xhr.send();
};

// ######################################################

//search members=============
const searchMembersBar = document.querySelector("#search-members");

const searchMembers = () => {
  searchMembersBar.onkeyup = () => {
    searchTerm = searchMembersBar.value;
    displayMembers();
  };
};
// cancel search members
const cancelSearchMembersBtn = document.querySelector(
  "#cancel-search-members-btn"
);
const cancelSearchMembers = () => {
  cancelSearchMembersBtn.onclick = () => {
    searchTerm = "";
    displayMembers();
  };
};
if (elementExists(searchMembersBar)) {
  searchMembers();
  cancelSearchMembers();
}
// **********************************************************
// CHAT WINDOW======================================

// get chat
function getMessages(forceScroll = false) {
  // forceScroll used to force scroll to bottom on click e.g. when switching to another member, and the chat with the revoius member is already scrolled by user
  let xhr = new XMLHttpRequest(); //create XML object
  xhr.open("POST", "php/get_chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        let notScrolledByUser =
          chatBoxContainer.scrollHeight -
            (chatBoxContainer.scrollTop + chatBoxContainer.offsetHeight) <
          300;
        if (refreshChat && (notScrolledByUser || forceScroll)) {
          scrollChatToBottom();
        }
      }
    }
  };
  let formData = new FormData(sendForm);
  xhr.send(formData);
  //Put curent panel-item on top of the list
  displayMembers();
}

// send chat
sendForm.onsubmit = (e) => {
  e.preventDefault();
};
const sendMessage = () => {
  sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest(); //create XML object
    xhr.open("POST", "php/insert_chat.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          sendInput.value = "";
          getMessages(true);
          scrollChatToBottom();
        }
      }
    };
    let formData = new FormData(sendForm);
    xhr.send(formData);
  };
};
if (elementExists(sendBtn)) {
  sendMessage();
}

//set messages as read
const readMessages = () => {
  let xhr = new XMLHttpRequest(); //create XML object
  xhr.open("GET", "php/set_msg_as_read.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
      }
    }
  };
  xhr.send();
};
// **************************************************

//   logout============================
const userIcon = document.getElementById("user-icon");
const logoutDiv = document.getElementById("logout-div");

//show logout div
if (elementExists(userIcon)) {
  userIcon.addEventListener("click", () => {
    logoutDiv.classList.remove("hidden");
  });
}

//hide logout div
if (elementExists(logoutDiv)) {
  window.addEventListener("click", function (e) {
    if (!logoutDiv.contains(e.target) && !userIcon.contains(e.target)) {
      logoutDiv.classList.add("hidden");
    }
  });
}
// #################################

// switch between chat/groups=============;
const switchTabs = document.querySelectorAll(".switch-tab");
const switchIcons = document.querySelectorAll(".switch-icon");
const sidePanels = document.querySelectorAll(".side-panel");

const switchTabsOnClick = () => {
  for (const switchTab of switchTabs) {
    switchTab.addEventListener("click", () => {
      switchTabs.forEach((tab) => {
        tab.classList.remove("bg-blue-100");
      });
      switchTab.classList.add("bg-blue-100");
      const currentTab = switchTab.getAttribute("data-switch");
      // set current icon
      switchIcons.forEach((switchIcon) => {
        switchIcon.classList.remove("opacity-100");
        switchIcon.classList.add("opacity-50");
      });
      const currentSwitchIcon = document.getElementById(`${currentTab}-icon`);
      currentSwitchIcon.classList.add("opacity-100");

      // set current panel
      sidePanels.forEach((sidePanel) => {
        sidePanel.classList.add("hidden");
      });
      const currentsidePanel = document.getElementById(
        `${currentTab}-side-panel`
      );
      currentsidePanel.classList.remove("hidden");
    });
  }
};
if (elementExists(switchTabs)) {
  switchTabsOnClick();
}

// Show-hide side panel on mobile===============
const showSidePanelArrow = document.querySelector("#show-side-panel-arrow");
const textWindow = document.querySelector("#text-window");

const hideTextWindow = () => {
  showSidePanelArrow.addEventListener("click", () => {
    chatBox.innerHTML = "";
    textWindow.classList.add("translate-x-full");
  });
};
if (elementExists(showSidePanelArrow)) {
  hideTextWindow();
}

const showTextWindow = () => {
  textWindow.classList.remove("translate-x-full");
};
//   ###############################################

//   EMOJIS PICKER===================================
const emojiPicker = new FgEmojiPicker({
  trigger: ["#emojis-btn"],
  removeOnSelection: false,
  closeButton: true,
  position: ["top", "left"],
  preFetch: true,
  insertInto: sendInput,
});

// ##################################################

// Change input type file when file is selected
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
window.onload = () => {
  displayMembers();
  setInterval(() => {
    displayMembers();
  }, 3000);

  getMessages(true);
  setInterval(() => {
    getMessages(false);
  }, 1000);
};
