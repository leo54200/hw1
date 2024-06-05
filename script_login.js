// Funzione per l'accessp di un utente
function sign_in_form_handler() {
  const sign_in_div = document.querySelector("#sign_in_div");
  const blur = document.querySelector("#blur");
  sign_in_div.classList.remove("hidden");
  blur.classList.add("blur");
}

function close_form_handler() {
  const sign_in_div = document.querySelector("#sign_in_div");
  const blur = document.querySelector("#blur");
  sign_in_div.classList.add("hidden");
  blur.classList.remove("blur");
}

//Bottone accedi per far apparire il form di accesso
const sign_in = document.querySelector(".sign_in");
sign_in.addEventListener("click", sign_in_form_handler);

//Bottone x per far scomparire il form di accesso
const close_form = document.querySelector("#close_form");
close_form.addEventListener("click", close_form_handler);

document.getElementById("id_submit").addEventListener("click", function (event) {
  event.preventDefault(); // Prevenire il comportamento di submit predefinito

  const username = document.getElementById("txtusername").value;
  const password = document.getElementById("txtpassword").value;

  fetch("assets/login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      username: username,
      password: password,
    }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text(); // Assumendo che il server ritorni il tipo di utente come testo
    })
    .then((responseText) => {
      switch (
        responseText.trim() // Aggiunta di .trim() per rimuovere eventuali spazi bianchi
      ) {
        case "Studente":
          window.location.href = "home.php";
          break;
        case "Professore":
          window.location.href = "chatbot_teacher.php";
          break;
        case "Admin":
          window.location.href = "admin.php";
          break;
        default:
          document.getElementById("idError").textContent = responseText;
          break;
      }
    })
    .catch((error) => {
      console.error("Errore:", error);
      document.getElementById("idError").textContent = "Errore nella richiesta al server";
    });
});
