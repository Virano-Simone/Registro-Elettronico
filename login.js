"use strict"

window.onload = function () {
    $(lblErrore).hide();

    btnLogin.addEventListener("click", controllaLogin)

    // il submit deve essere eseguito anche con il solo tasto INVIO
    document.addEventListener('keydown', function (event) {
        if (event.key == "Enter")
            controllaLogin();
    });

    function controllaLogin() {
        username.classList.remove("is-invalid");
        username.previousElementSibling.classList.remove("icona-rossa");
        password.classList.remove("is-invalid");
        password.previousElementSibling.classList.remove("icona-rossa");

        $(lblErrore).hide();

        if (username.value == "") {
            username.classList.add("is-invalid");
            username.parentElement.firstElementChild.classList.add("icona-rossa");
        }
        else if (password.value == "") {
            password.classList.add("is-invalid");
            password.parentElement.firstElementChild.classList.add("icona-rossa");
        }
        else {
            let user = username.value;
            let pass = CryptoJS.MD5(password.value).toString();
            let rq = inviaRichiesta("POST", "server/login.php", { user, pass })
            rq.then(function (response) {
                window.location.href = "index.php"
            });
            rq.catch(function (err) {
                if (err.response && err.response.status == 401) {//unauthorized
                    $(lblErrore).show();
                }
                else
                    errore(err)
            });
        }
    }

    lblErrore.firstElementChild.addEventListener("click", function () {
        $(lblErrore).hide();
    })

    btnRegistrati.addEventListener("click", function () {
        location.href = "registrazione.html"
    })

    btnNewPassword.addEventListener("click", function () {
        location.href = "_passwordDimenticata.html";
    })
}