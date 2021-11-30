let panelItems = document.querySelectorAll(".panel-item");
let currentActivePanel = "chat";
let refreshChat = false;
const activePanelTitle = document.querySelector("#active-panel-title");
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

//Set SESSION['incoming_id'] when click on a panel item
const setCurrentIncomingId = () => {
  panelItems = document.querySelectorAll(".panel-item");
  panelItems.forEach((item) => {
    item.addEventListener("click", () => {
      refreshChat = true;
      const incomingId = item.getAttribute("data-id");
      let xhr = new XMLHttpRequest(); //create XML object
      xhr.open("GET", "php/set_session_incoming_id.php?id=" + incomingId, true);
      xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            getMessages(true);
            displayPanelItems();
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
const displayPanelItems = () => {
  let xhr = new XMLHttpRequest(); //create XML object
  xhr.open(
    "GET",
    `php/display_${currentActivePanel}_items.php?searchTerm=${searchTerm}`,
    true
  );
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
    displayPanelItems();
  };
};
// cancel search members
const cancelSearchMembersBtn = document.querySelector(
  "#cancel-search-members-btn"
);
const cancelSearchMembers = () => {
  cancelSearchMembersBtn.onclick = () => {
    searchMembersBar.value = "";
    searchTerm = "";
    displayPanelItems();
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
  if (refreshChat) {
    let xhr = new XMLHttpRequest(); //create XML object
    xhr.open("POST", `php/get_${currentActivePanel}_messages.php`, true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          chatBox.innerHTML = data;
          let notScrolledByUser =
            chatBoxContainer.scrollHeight -
              (chatBoxContainer.scrollTop + chatBoxContainer.offsetHeight) <
            150;
          if (notScrolledByUser || forceScroll) {
            scrollChatToBottom();
          }
        }
      }
    };
    let formData = new FormData(sendForm);
    xhr.send(formData);
    //Put curent panel-item on top of the list
    displayPanelItems();
  }
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
          textAreaAdjust(sendInput);
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
  xhr.open("GET", `php/set_${currentActivePanel}_msg_as_read.php`, true);
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

const setFirstItemAsActive = () => {
  const panelItem = document.querySelector(".panel-item");
  console.log(panelItem);
};

// switch between chat/channels=============;
const switchTabs = document.querySelectorAll(".switch-tab");
const switchIcons = document.querySelectorAll(".switch-icon");
const sidePanels = document.querySelectorAll(".side-panel");

const switchTabsOnClick = () => {
  for (const switchTab of switchTabs) {
    switchTab.addEventListener("click", () => {
      refreshChat = false;
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

      activePanelTitle.innerHTML =
        currentTab.charAt(0).toUpperCase() + currentTab.slice(1);
      chatBox.innerHTML = "";
      currentActivePanel = currentTab;
      displayPanelItems();
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
//Grow send input with content
const textAreaAdjust = (element) => {
  if (element.scrollHeight < 150) {
    element.style.overflowY = "hidden";
    element.style.height = "auto";
    element.style.height = 2 + element.scrollHeight + "px";
  } else {
    element.style.overflowY = "scroll";
  }
};
if (sendInput) {
  sendInput.addEventListener("keyup", () => {
    textAreaAdjust(sendInput);
  });
}
// #####################################################

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
  displayPanelItems();

  setInterval(() => {
    displayPanelItems();
  }, 3000);

  getMessages(true);
  setInterval(() => {
    getMessages(false);
  }, 1000);
};
