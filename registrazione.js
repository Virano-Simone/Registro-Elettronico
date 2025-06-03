"use strict";

window.onload = function () {
	const btnInvia = document.querySelector("#btnInvia");
	const alertError = document.querySelector("#alertError");
	const alertSuccess = document.querySelector("#alertSuccess");
	const errorMessage = document.querySelector("#errorMessage");
	
	btnInvia.addEventListener("click", function () {
		alertError.style.display = "none";
		alertSuccess.style.display = "none";

		let NomeCognome = document.querySelector("[name='txtNome']").value + " " + document.querySelector("[name='txtCognome']").value;
		let cComune = document.querySelector("#lstComuni").value;
		let Telefono = document.querySelector("[name='txtTelefono']").value;
		let Mail = document.querySelector("[name='txtMail']").value;
		let Pwd = document.querySelector("[name='txtPassword']").value;
		let Pwd2 = document.querySelector("[name='txtConfPassword']").value;

		if (!document.querySelector("[name='txtNome']").value.trim() ||
			!document.querySelector("[name='txtCognome']").value.trim() ||
			!cComune || !Telefono.trim() || !Mail.trim() || !Pwd) {
			errorMessage.textContent = "Tutti i campi obbligatori devono essere compilati";
			alertError.style.display = "block";
			return;
		}

		if (Pwd == Pwd2) {
			btnInvia.disabled = true;
			btnInvia.innerHTML = '<i class="fas fa-spinner fa-spin"></i> REGISTRAZIONE...';

			let user = { NomeCognome, cComune, Telefono, Mail, Pwd };
			let rq = inviaRichiesta("POST", "server/newUser.php", user);

			rq.catch(function (errore) {
				errorMessage.textContent = errore;
				alertError.style.display = "block";
				btnInvia.disabled = false;
				btnInvia.innerHTML = '<i class="fas fa-user-plus"></i> REGISTRATI';
			});

			rq.then(function (response) {
				console.log(response.data);
				alertSuccess.style.display = "block";

				document.getElementById("registrationForm").reset();

				setTimeout(() => {
					window.location.href = "login.html";
				}, 2000);

				btnInvia.disabled = false;
				btnInvia.innerHTML = '<i class="fas fa-user-plus"></i> REGISTRATI';
			});
		} else {
			errorMessage.textContent = "Le password non coincidono";
			alertError.style.display = "block";
		}
	});

	document.getElementById("btnLogin").addEventListener("click", function () {
		window.location.href = "login.html";
	});
};