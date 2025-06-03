window.onload = function () {
	const btnInvia = document.querySelector("#btnInvia")
	const alertError = document.querySelector("#alertError")
	const alertSuccess = document.querySelector("#alertSuccess")
	const errorMessage = document.querySelector("#errorMessage")
	const tipoUtenteSelect = document.querySelector("#lstTipoUtente")
	const classeGroup = document.querySelector("#classeGroup")
	const classeSelect = document.querySelector("#lstClasse")
	const imageInput = document.querySelector("#imageInput")
	const imagePreview = document.querySelector("#imagePreview")
	const previewImg = document.querySelector("#previewImg")
	const removeImageBtn = document.querySelector("#removeImage")

	tipoUtenteSelect.addEventListener("change", function () {
		if (this.value == "0") {
			classeGroup.style.display = "block"
			classeSelect.setAttribute("required", "required")
		} else {
			classeGroup.style.display = "none"
			classeSelect.removeAttribute("required")
			classeSelect.value = ""
		}
	})

	imageInput.addEventListener("change", function () {
		const nomeImmagine = imageInput.files[0] ? imageInput.files[0].name : "user.jpg"
		document.querySelector(".upload-text").textContent = nomeImmagine
	});

	btnInvia.addEventListener("click", function () {
		alertError.style.display = "none"
		alertSuccess.style.display = "none"

		const Nome = document.querySelector("[name='txtNome']").value.trim()
		const Cognome = document.querySelector("[name='txtCognome']").value.trim()
		const Mail = document.querySelector("[name='txtMail']").value.trim()
		const Pwd = document.querySelector("[name='txtPassword']").value
		const Pwd2 = document.querySelector("[name='txtConfPassword']").value
		const Residenza = document.querySelector("[name='txtResidenza']").value
		const Indirizzo = document.querySelector("[name='txtIndirizzo']").value.trim()
		const TipoUtente = document.querySelector("[name='txtTipoUtente']").value
		const Classe = document.querySelector("[name='txtClasse']").value

		if (!Nome || !Cognome || !Mail || !Pwd || !Residenza || !TipoUtente || !Indirizzo) {
			errorMessage.textContent = "Tutti i campi obbligatori devono essere compilati"
			alertError.style.display = "block"
			return
		}

		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
		if (!emailRegex.test(Mail)) {
			errorMessage.textContent = "Formato email non valido"
			alertError.style.display = "block"
			return
		}

		if (TipoUtente == "0" && !Classe) {
			errorMessage.textContent = "La classe è obbligatoria per gli studenti"
			alertError.style.display = "block"
			return
		}

		if (Pwd != Pwd2) {
			errorMessage.textContent = "Le password non coincidono"
			alertError.style.display = "block"
			return
		}

		if (Pwd.length < 6) {
			errorMessage.textContent = "La password deve essere di almeno 6 caratteri"
			alertError.style.display = "block"
			return
		}

		const PwdMD5 = CryptoJS.MD5(Pwd).toString()

		btnInvia.disabled = true
		btnInvia.innerHTML = '<i class="fas fa-spinner fa-spin"></i> REGISTRAZIONE...'

		const nomeImmagine = imageInput.files[0] ? imageInput.files[0].name : "user.jpg"
		document.querySelector(".upload-text").textContent = nomeImmagine

		const params = {
			Nome: Nome,
			Cognome: Cognome,
			Mail: Mail,
			Pwd: PwdMD5,
			Residenza: Residenza,
			TipoUtente: TipoUtente,
			Indirizzo: Indirizzo,
			Classe: Classe,
			Immagine: nomeImmagine
		}

		const rq = inviaRichiesta("POST", "server/nuovoUtente.php", params)

		rq.then(function (response) {
			alertSuccess.style.display = "block"

			document.querySelector("#registrationForm").reset()
			classeGroup.style.display = "none"
			classeSelect.removeAttribute("required")

			setTimeout(function () {
				window.location.href = "login.html"
			}, 2000)

			btnInvia.disabled = false
			btnInvia.innerHTML = '<i class="fas fa-user-plus"></i> REGISTRATI'
		})

		rq.catch(function (err) {
			errore(err)
			errorMessage.textContent = "Errore durante la registrazione"
			alertError.style.display = "block"
			btnInvia.disabled = false
			btnInvia.innerHTML = '<i class="fas fa-user-plus"></i> REGISTRATI'
		})
	})

	document.getElementById("btnLogin").addEventListener("click", function () {
		window.location.href = "login.html"
	})
}