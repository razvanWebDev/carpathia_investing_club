//window.onload = () => {
console.log("loaded");
let panelItems = document.querySelectorAll(".panel-item");

const incomingImageContainer = document.querySelector(
  "#incoming-image-container"
);
const chatBox = document.querySelector("#chat-box");
const chatBoxContainer = document.querySelector("#chat-box-container");
const sendForm = document.querySelector("#send-form");
const sendInput = document.querySelector("#send-input");
const sendBtn = document.querySelector("#send-btn");
// Check if element exists before calling function
const elementExists = (element) => {
  return element != undefined && element != null;
};
// ============ASYNC======================================
const chatPanelList = document.querySelector("#chat-panel-list");
const incomingIdInput = document.querySelector("#incoming-id-input");
let refreshChatPanelList = true;

//stop chat from scrolling to bottom whe the user scrolles
chatBox.onmouseenter = () => {
  refreshChatPanelList = false;
};
chatBox.onmouseleave = () => {
  refreshChatPanelList = true;
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
  xhr.open("GET", "php/display_members.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (refreshChatPanelList) {
          chatPanelList.innerHTML = data;
          setCurrentIncomingId();
        }
      }
    }
  };
  xhr.send();
};
displayMembers();
setInterval(() => {
  displayMembers();
}, 3000);

// ######################################################

//search members=============
const searchMembersBar = document.querySelector("#search-members");
const searchMembers = () => {
  searchMembersBar.onkeyup = () => {
    let searchTerm = searchMembersBar.value;
    refreshChatPanelList = searchTerm == "";
    let xhr = new XMLHttpRequest(); //create XML object
    xhr.open("POST", "php/search_members.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let data = xhr.response;
          chatPanelList.innerHTML = data;
        }
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
  };
};
// cancel search members
const cancelSearchMembersBtn = document.querySelector(
  "#cancel-search-members-btn"
);
const cancelSearchMembers = () => {
  cancelSearchMembersBtn.onclick = () => {
    searchMembersBar.value = "";
    displayMembers();
    refreshChatPanelList = true;
  };
};
if (elementExists(searchMembersBar)) {
  searchMembers();
  cancelSearchMembers();
}
// **********************************************************
// CHAT WINDOW======================================

// get chat
const getMessages = () => {
  let xhr = new XMLHttpRequest(); //create XML object
  xhr.open("POST", "php/get_chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        if (refreshChatPanelList) {
          scrollChatToBottom();
        }
        //Put curent panel-item on top of the list
        displayMembers();
      }
    }
  };
  let formData = new FormData(sendForm);
  xhr.send(formData);
};
//get messages on load
getMessages();
//get messages @ interval
setInterval(() => {
  getMessages();
}, 500);

//
const scrollChatToBottom = () => {
  chatBoxContainer.scrollTo(0, chatBoxContainer.scrollHeight);
};
scrollChatToBottom();
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
          getMessages();
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

//Set SESSION['incoming_id'] when click on a panel item
const setCurrentIncomingId = () => {
  panelItems = document.querySelectorAll(".panel-item");
  panelItems.forEach((item) => {
    item.addEventListener("click", () => {
      console.log("clicksetCurrentIncomingId");
      const incomingId = item.getAttribute("data-id");
      let xhr = new XMLHttpRequest(); //create XML object
      xhr.open("GET", "php/set_session_incoming_id.php?id=" + incomingId, true);
      xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            getMessages();
            displayMembers();
          }
        }
      };
      xhr.send();
      readMessages();
      //set incoming image for top bar
      setIncomingImage();
      //show text window if on mobile
      showTextWindow();
    });
  });
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
  emit(obj, triggerElement) {
    console.log(obj, triggerElement);
  },
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
//};
