// Funzione per la registrazione di un nuovo utente
document.getElementById("submit_signup").addEventListener("click", function (event) {
  event.preventDefault(); // Prevenire il comportamento di submit predefinito

  const username = document.getElementById("txtusername").value;
  const password = document.getElementById("txtpassword").value;
  const nome = document.getElementById("txtnome").value;
  const cognome = document.getElementById("txtcognome").value;
  const id_ruolo = document.getElementById("id_ruolo").value;

  fetch("assets/signup.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      nome: nome,
      cognome: cognome,
      username: username,
      password: password,
      id_ruolo: id_ruolo,
    }),
  })
    .then((response) => response.json()) // Converti la risposta in JSON
    .then((data) => {
      if (data.success) {
        // Se la registrazione è avvenuta con successo, svuota i campi del modulo
        document.getElementById("txtusername").value = "";
        document.getElementById("txtpassword").value = "";
        document.getElementById("txtnome").value = "";
        document.getElementById("txtcognome").value = "";
        document.getElementById("id_ruolo").value = "";
      }
      // Mostra il messaggio di errore o successo sulla base della risposta dal server
      document.getElementById("idError").textContent = data.message;
    })
    .catch((error) => {
      console.error("Errore:", error);
    });
});
