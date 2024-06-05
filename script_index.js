let counter = 0;

function button_left_handler() {
  counter -= 1;
  if (counter < 0) counter = 2;
  button_handler();
}

function button_right_handler() {
  counter += 1;
  if (counter > 2) counter = 0;
  button_handler();
}

function button_handler() {
  const mathematics_image = document.querySelector("#mathematics_image");
  const physics_image = document.querySelector("#physics_image");
  const technology_image = document.querySelector("#technology_image");
  const text = document.querySelector("#classroom_title");
  if (counter == 0) {
    mathematics_image.classList.remove("hidden");
    physics_image.classList.add("hidden");
    technology_image.classList.add("hidden");
    text.textContent = "Matematica";
  } else if (counter == 1) {
    mathematics_image.classList.add("hidden");
    physics_image.classList.add("hidden");
    technology_image.classList.remove("hidden");
    text.textContent = "Informatica";
  } else {
    mathematics_image.classList.add("hidden");
    physics_image.classList.remove("hidden");
    technology_image.classList.add("hidden");
    text.textContent = "Fisica";
  }
}
function hideDiv(div) {
  div.classList.add("hidden");
}
function not_available_handler() {
  const not_available_div = document.querySelector("#not_available_div");
  not_available_div.classList.remove("hidden");
  not_available_div.textContent = "Non disponibile, prima devi fare l'autenticazione!";
  setTimeout(() => hideDiv(not_available_div), 5000);
}
//Bottoni per andare avanti e indietro tra le immagini della home page
const button_left = document.querySelector("#left");
button_left.addEventListener("click", button_left_handler);
const button_right = document.querySelector("#right");
button_right.addEventListener("click", button_right_handler);
const not_available = document.querySelector("#not_available");
not_available.addEventListener("click", not_available_handler);
