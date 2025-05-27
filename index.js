window.onload = function () {


    let request = inviaRichiesta("GET", "server/controllaSessione.php");
    request.catch(errore)
    request.then(function (responseHTTP) {
       document.querySelector("body").style.display = "block";
    })

    btnLogout.addEventListener("click", function () {
        let request = inviaRichiesta("GET", "server/logout.php")
        request.catch(errore);
        request.then(function (responseHTTP) {
            alert("Uscito correttamente");
            window.location.href = "login.html"
        })
    })
}