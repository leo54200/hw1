const chatInput = document.querySelector("#chat-input");
const sendButton = document.querySelector("#send-button");
const chatContainer = document.querySelector(".chat-box");
const refreshButton = document.querySelector("#refresh-button");

let userText = null;
let bot_element = null;

const createChatElement = (content, className) => {
  // Create new div and apply chat, specified class and set html content of div
  const chatDiv = document.createElement("div");
  chatDiv.classList.add("chat", className);
  chatDiv.innerHTML = content;
  return chatDiv; // Return the created chat div
};

// Array globale per memorizzare i messaggi
const chatHistory = [];

function getChatResponse(incomingChatDiv, userText, model = "gpt-3.5-turbo") {
  const API_URL = "assets/open_ai.php";
  const pElement = document.createElement("p");

  // Aggiungi il messaggio dell'utente alla cronologia
  chatHistory.push({ role: "user", content: userText });
  const allMessages = [
    ...chatHistory, // Includere tutti i messaggi precedenti
  ];

  // Define the properties and data for the API request
  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      model: model,
      messages: allMessages,
    }),
  };

  return fetch(API_URL, requestOptions)
    .then(onResponse)
    .then((data) => {
      console.log("Dati ricevuti dall'API di OpenAI:", data);
      const messageContent = data.messageContent;
      const messageId = data.messageId;

      // Aggiungere il messaggio attuale alla cronologia della chat
      pElement.textContent = messageContent;

      share(pElement);
      // Rimuovi l'animazione di digitazione e aggiungi l'elemento paragrafo
      incomingChatDiv.querySelector(".typing-animation").remove();
      incomingChatDiv.querySelector(".chat-details").appendChild(pElement);

      // Associa l'ID del messaggio come attributo data-* del div
      incomingChatDiv.setAttribute("data-message-id", messageId);

      chatHistory.push({ role: "system", content: messageContent });
      return messageContent;
    })
    .catch(onError);
}

function getMessageIdFromElement(element) {
  // cerca il primo genitore con messageId
  let currElem = element;
  while (!currElem.dataset.messageId && currElem.parentNode) currElem = currElem.parentNode;
  return currElem.dataset.messageId;
}

function onResponse(response) {
  return response.json();
}

function onError(error) {
  console.error("Errore durante la richiesta all'API di OpenAI:", error);
  return "Oops! Qualcosa è andato storto.";
}

function printMessage(data) {
  console.log("questo è il return dal php", data);
}

function share(pElement) {
  bot_element = pElement.textContent;
}

// Get pElement from getChatResponse function
const pElement = bot_element;
let BoxCounter = 0;

const showTypingAnimation = () => {
  BoxCounter++;
  // Display the typing animation and call the getChatResponse function
  const template = document.getElementById("typing-template");
  const clone = template.content.cloneNode(true);

  // Convertire il clone del template (DocumentFragment) in una stringa HTML
  const tempDiv = document.createElement("div");
  tempDiv.appendChild(clone);
  const htmlContent = tempDiv.innerHTML;

  // Usa createChatElement per creare il div della chat in arrivo
  const incomingChatDiv = createChatElement(htmlContent, "incoming");
  incomingChatDiv.id = `incomingChatDiv_${BoxCounter}`;

  // Aggiungi il nuovo div al container della chat
  chatContainer.appendChild(incomingChatDiv);
  chatContainer.scrollTo(0, chatContainer.scrollHeight);

  // Esegui la funzione per ottenere la risposta della chat
  getChatResponse(incomingChatDiv, userText);
};

function getParentText(button) {
  // Trova il parent "incomingDiv" del pulsante
  const incomingDiv = button.closest(".chat-content");
  const coorectionBox = incomingDiv.querySelector(".correctionBox");
  if (coorectionBox !== null) return coorectionBox.textContent;

  if (incomingDiv) {
    // Trova l'elemento che contiene il testo del bot
    const botTextElement = incomingDiv.querySelector(".chat-details p");
    if (botTextElement) {
      return botTextElement.textContent;
    }
  }
  return "";
}

function getPastMessageText(button) {
  const incomingDiv = button.closest(".chat-content");
  if (incomingDiv) {
    // Trova l'elemento che contiene il testo del bot
    const botTextElement = incomingDiv.querySelector(".chat-details p");
    if (botTextElement) {
      return botTextElement.textContent;
    }
  }
  return "";
}

function getParentId(button) {
  // Trova il parent "incomingDiv" del pulsante
  const div = button.closest(".chat-content");
  incomingDiv = div.parentElement;
  if (incomingDiv) {
    // Ritorna l'ID dell'elemento "incomingDiv"
    return incomingDiv.id;
  }
  // Se non viene trovato l'elemento, ritorna una stringa vuota
  return "";
}

document.body.addEventListener("click", (event) => {
  if (event.target && event.target.id === "copyBtn") {
    copyResponse(event.target);
  }
});

document.body.addEventListener("click", (event) => {
  if (event.target && event.target.id === "editBtn") {
    editResponse(event.target);
  }
});

document.body.addEventListener("click", (event) => {
  if (event.target && event.target.id === "rateBtn") {
    rateResponse(event.target);
  }
});

const copyResponse = (copyBtn) => {
  // Copy the text content of the response to the clipboard
  const reponseTextElement = copyBtn.closest(".chat-content").querySelector("p");
  navigator.clipboard.writeText(reponseTextElement.textContent);
  copyBtn.textContent = "done";
  setTimeout(() => (copyBtn.textContent = "content_copy"), 1000);
};

let editBoxTemplate = null;

const editResponse = (editBtn) => {
  const chatButtons = editBtn.parentElement;
  const botText = getParentText(editBtn);
  const ID_botMessage = getParentId(editBtn);

  console.log("Bot text:", botText);

  if (editBoxTemplate === null) {
    // Clone the edit box template the first time it is needed
    const originalEditBox = document.querySelector("#editBox");
    if (originalEditBox) {
      editBoxTemplate = originalEditBox.cloneNode(true);
      originalEditBox.remove(); // Remove the original template from the DOM
    }
  }

  // Check if a edit box is already present
  if (chatButtons.querySelector(".edit-box")) {
    const existingEditBox = chatButtons.querySelector(".edit-box");
    chatButtons.removeChild(existingEditBox);
    editBtn.textContent = "edit";
    return;
  }

  // Create the edit box
  let editBox = editBoxTemplate.cloneNode(true);
  editBox.classList.remove("hidden");
  editBox.classList.add("edit-box");

  // Append the edit box to the chat-buttons element
  chatButtons.appendChild(editBox);

  // Get the textarea element inside the edit box
  const textarea = editBox.querySelector("textarea");
  const past_message = document.querySelector("#past_message");

  // Set the value of the textarea to the text content of the bot_element from getChatResponse
  textarea.value = botText;
  const pastMessage = getPastMessageText(editBtn);
  past_message.value = pastMessage;

  if (!textarea.value) {
    editBox.classList.add("hidden");
    return; // If textarea.value is empty return from here
  }

  // Submit button
  document.getElementById("submit_correction").addEventListener("click", (event) => {
    event.preventDefault();
    sendCorrectionToServer();

    chatButtons.removeChild(editBox);
    editBox.classList.add("hidden");
    editBox = null; // Reset editBox variable
    editBtn.textContent = "edit";
    editChatHistory(botText, textarea.value);

    // Trova il div dove aggiungere l'elemento div
    const container = document.getElementById(ID_botMessage);
    div = container.querySelector(".chat-details");
    const modifiedParagraph = div.querySelector(".correctionBox");

    if (modifiedParagraph !== null) {
      modifiedParagraph.textContent = textarea.value;
    } else {
      const newParagraph = document.createElement("p");

      // Imposta il contenuto di p su textarea.value
      newParagraph.textContent = textarea.value;
      newParagraph.classList.add("correctionBox");
      // Aggiungi l'elemento p al div
      div.appendChild(newParagraph);
    }
  });

  // Add event listener to the Cancel button inside the edit box
  const cancelBtn = editBox.querySelector("button");
  cancelBtn.addEventListener("click", () => {
    // Perform actions when the Cancel button is clicked
    chatButtons.removeChild(editBox);
    editBox.classList.add("hidden");
    editBox = null; // Reset editBox variable
    editBtn.textContent = "edit";
  });

  editBtn.textContent = "arrow_drop_down";
  setTimeout(() => (editBtn.textContent = "arrow_drop_up"), 300);
};

function editChatHistory(oldMessage, newMessage) {
  console.log("Cronologia attuale della chat:", chatHistory);
  console.log("Messaggio da sostituire:", oldMessage);
  const messageIndex = chatHistory.findIndex((message) => message.role === "system" && message.content === oldMessage);
  console.log(messageIndex);
  console.log(oldMessage);
  console.log(newMessage);
  if (messageIndex !== -1) {
    chatHistory[messageIndex].content = newMessage;
    console.log(chatHistory);
  } else {
    console.error("Messaggio non trovato nella cronologia.");
  }
}

function sendCorrectionToServer() {
  const form = document.querySelector("#correction_form");
  const formData = new FormData(form);
  messageId = getMessageIdFromElement(document.querySelector("#correction_form"));
  console.log("messageId: " + messageId);
  formData.append("messageId", messageId);

  // Invia richiesta con POST
  fetch("assets/update_message.php", {
    method: "POST",
    body: formData,
  })
    .then(onResponse)
    .then(printMessage);
}

let rating1 = null;
let rating2 = null;

let ratingBox = null;

const rateResponse = (rateBtn) => {
  const chatButtons = rateBtn.parentElement;

  // Check if ratingBox is already open
  if (ratingBox) {
    // If ratingBox is open, remove it
    chatButtons.removeChild(ratingBox);
    ratingBox = null; // Reset ratingBox variable
    rateBtn.textContent = "grade";
    return; // Exit the function
  }

  // Clone the rating box template each time it is needed
  const originalRatingBox = document.querySelector("#ratingBox");
  if (originalRatingBox) {
    ratingBox = originalRatingBox.cloneNode(true);
  } else {
    console.error("Rating box template not found");
    return;
  }

  // Remove 'hidden' class and add necessary classes
  ratingBox.classList.remove("hidden");
  ratingBox.classList.add("rating-box");

  // Append the rating box to the chat-buttons element
  chatButtons.appendChild(ratingBox);

  // Update references to the cloned inputs
  rating1 = ratingBox.querySelector("#rating1");
  rating2 = ratingBox.querySelector("#rating2");
  const current_message = ratingBox.querySelector("#current_message");

  // Get the current message and set its value
  const currentMessage = getPastMessageText(rateBtn);
  current_message.value = currentMessage;

  // Select all elements with the "i" tag and store them in a NodeList called "stars"
  const stars1 = ratingBox.querySelectorAll(".stars1 i");

  // Loop through the "stars" NodeList
  stars1.forEach((star, index1) => {
    // Add an event listener that runs a function when the "click" event is triggered
    star.addEventListener("click", () => {
      rating1.value = checkStarValue(star); // Estrai il numero e converti in intero
      // Loop through the "stars" NodeList Again
      stars1.forEach((star, index2) => {
        // Add the "active" class to the clicked star and any stars with a lower index
        // and remove the "active" class from any stars with a higher index
        index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
      });
    });
  });

  // Select all elements with the "i" tag and store them in a NodeList called "stars2"
  const stars2 = ratingBox.querySelectorAll(".stars2 i");

  // Loop through the "stars" NodeList
  stars2.forEach((star, index1) => {
    // Add an event listener that runs a function when the "click" event is triggered
    star.addEventListener("click", () => {
      rating2.value = checkStarValue(star); // Estrai il numero e converti in intero
      // Loop through the "stars" NodeList Again
      stars2.forEach((star, index2) => {
        // Add the "active" class to the clicked star and any stars with a lower index
        // and remove the "active" class from any stars with a higher index
        index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
      });
    });
  });

  // Add event listener to the OK button inside the rating box
  const okBtn = ratingBox.querySelector("#sumbit_rating");
  okBtn.addEventListener("click", (event) => {
    event.preventDefault();
    console.log("Rating selezionato:", rating1.value); // Output di debug
    console.log("Rating selezionato:", rating2.value); // Output di debug
    sendRatingToServer();

    // Perform actions when the OK button is clicked
    chatButtons.removeChild(ratingBox);
    ratingBox = null; // Reset ratingBox variable
    rateBtn.textContent = "grade";
  });

  rateBtn.textContent = "arrow_drop_down";
  setTimeout(() => (rateBtn.textContent = "arrow_drop_up"), 300);
};

function checkStarValue(star) {
  const starId = star.id;
  if (starId === "star1" || starId === "star6") {
    return 1;
  } else if (starId === "star2" || starId === "star7") {
    return 2;
  } else if (starId === "star3" || starId === "star8") {
    return 3;
  } else if (starId === "star4" || starId === "star9") {
    return 4;
  } else if (starId === "star5" || starId === "star10") {
    return 5;
  }
}

function sendRatingToServer() {
  const form = document.querySelector("#rating_form");
  const formData = new FormData(form);
  messageId = getMessageIdFromElement(document.querySelector("#rating_form"));
  formData.append("messageId", messageId);

  // Invia richiesta con POST
  fetch("assets/update_message.php", {
    method: "POST",
    body: formData,
  })
    .then(onResponse)
    .then(printMessage);
}

const handleOutgoingChat = () => {
  userText = chatInput.value.trim(); // Get chatInput value and remove extra spaces
  if (!userText) return; // If chatInput is empty return from here

  // Clear the input field and reset its height
  chatInput.value = "";
  chatInput.style.height = `${initialInputHeight}px`;

  // Seleziona il template e clona il suo contenuto
  const template = document.getElementById("outgoing-template");
  const clone = template.content.cloneNode(true);

  // Inserisci il testo dell'utente nel paragrafo del clone
  const pElement = clone.querySelector("p");
  pElement.textContent = userText;

  // Convertire il clone del template (DocumentFragment) in una stringa HTML
  const tempDiv = document.createElement("div");
  tempDiv.appendChild(clone);
  const htmlContent = tempDiv.innerHTML;

  // Create an outgoing chat div with user's message and append it to chat container
  const outgoingChatDiv = createChatElement(htmlContent, "outgoing");
  chatContainer.querySelector(".default-text")?.remove();
  chatContainer.appendChild(outgoingChatDiv);
  chatContainer.scrollTo(0, chatContainer.scrollHeight);
  setTimeout(showTypingAnimation, 500);
};

refreshButton.addEventListener("click", () => {
  // Remove the chats from display
  if (confirm("Sei sicuro di voler riavviare la chat?")) {
    location.reload();
  }
});

const initialInputHeight = chatInput.scrollHeight;

chatInput.addEventListener("input", () => {
  // Adjust the height of the input field dynamically based on its content
  chatInput.style.height = `${initialInputHeight}px`;
  chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
  // If the Enter key is pressed without Shift and the window width is larger
  // than 800 pixels, handle the outgoing chat
  if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 500) {
    e.preventDefault();
    handleOutgoingChat();
  }
});

sendButton.addEventListener("click", handleOutgoingChat);

function flex_item_handler(event) {
  const selected_flex_item = event.currentTarget;
  if (selected_flex_item.id === "item01" || selected_flex_item.id === "item02") {
    const item01 = document.querySelector("#item01");
    const item02 = document.querySelector("#item02");
    item01.classList.remove("selected");
    item02.classList.remove("selected");
    selected_flex_item.classList.add("selected");
    document.getElementById("id_type").value = selected_flex_item.dataset.id;
    console.log(document.getElementById("id_type").value);
    const enter = document.querySelector("#enter");
    enter.classList.remove("hidden");
  } else {
    // Rimuovi la classe "selected" da tutti gli elementi con classe "flex_item"
    const allFlexItems = document.querySelectorAll(".subject");
    allFlexItems.forEach((item) => {
      item.classList.remove("selected");
    });

    // Aggiungi la classe "selected" all'elemento cliccato
    selected_flex_item.classList.add("selected");

    // Imposta il valore del campo "subject"
    document.querySelector("#id_subject").value = selected_flex_item.dataset.id;
    console.log(document.querySelector("#id_subject").value);

    // Mostra il container2
    const container2 = document.querySelector("#container2");
    container2.classList.remove("hidden");
  }
}

document.querySelector("#types").addEventListener("submit", chat_type);

function chat_type(event) {
  event.preventDefault();
  const choice = document.querySelector("#choice");
  choice.classList.add("hidden");

  const selected_items = document.querySelector("#selected_items");
  const item = document.querySelectorAll(".selected");

  for (const it of item) {
    const textContent = it.textContent;
    let textNode = document.createTextNode(textContent + ", ");
    if (it.id === "item01" || it.id === "item02") {
      textNode = document.createTextNode(textContent);
    }
    // Aggiungere il nodo di testo all'elemento selected_items
    selected_items.appendChild(textNode);
  }
  selected_items.classList.remove("hidden");

  // Remove the disabled attribute from the textarea
  document.getElementById("chat-input").removeAttribute("disabled");
  // Leggi form
  const form = document.querySelector("#types");

  // Invia richiesta con POST
  fetch("assets/start_chat.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((response) =>
      response.json().catch(() => {
        throw new Error("Invalid JSON");
      })
    )
    .then((data) => {
      console.log(data); // Verifica l'output JSON ricevuto
      if (data.error) {
        console.error(data.error);
      } else {
        console.log(data.message);
        // Optionally handle the new chat session ID
      }
    })
    .catch((error) => console.error("Error:", error));
}

document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#types");

  fetch("assets/get_subjects.php", {
    method: "POST",
    body: new FormData(form),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        console.error(data.error);
        return;
      }
      let count = 0;
      const container = document.querySelector("#subjects_container");
      data.subjects.forEach((subject) => {
        count++;
        const div = document.createElement("div");
        div.classList.add("subject");
        div.classList.add("flex_item");
        div.setAttribute("data-id", subject.id);
        div.innerHTML = `<h4>${subject.nome}</h4>`;
        container.appendChild(div);
      });
      const flex_item = document.querySelectorAll(".flex_item");
      for (const item of flex_item) {
        item.addEventListener("click", flex_item_handler);
      }
    })
    .catch((error) => console.error("Error:", error));
});
