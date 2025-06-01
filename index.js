window.onload = function () {


    let request = inviaRichiesta("GET", "server/controllaSessione.php");
    request.then(function (responseHTTP) {
        document.querySelector("body").style.display = "block";
        inizializzaApp();
    })
    request.catch(errore)

    btnLogout.addEventListener("click", function () {
        let request = inviaRichiesta("GET", "server/logout.php")
        request.catch(errore);
        request.then(function (responseHTTP) {
            alert("Uscito correttamente");
            window.location.href = "login.html";
        })
    })
}

let votiData = [];
let materieData = [];

function inizializzaApp() {
    inizializzaNavigazione();

    caricaVoti();
    caricaMaterie();
}

function inizializzaNavigazione() {
    const navLinks = document.querySelectorAll('.nav-link');
    const tabContents = document.querySelectorAll('.tab-content');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            navLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(t => t.classList.remove('active'));

            this.classList.add('active');

            const targetTab = this.getAttribute('href').substring(1);
            document.getElementById(targetTab).classList.add('active');
        });
    });
}

function caricaVoti() {
    let request = inviaRichiesta("GET", "server/getVoti.php");
    request.then(function (response) {
        votiData = response.data;
        aggiornaStatistiche(votiData);
        aggiornaTabellaVoti(votiData);
        inizializzaFiltriVoti();
    }).catch(errore);
}

function caricaMaterie() {
    let request = inviaRichiesta("GET", "server/getMaterie.php");
    request.then(function (response) {
        materieData = response.data;
        popolaSelectMaterie();
    }).catch(errore);
}

function aggiornaStatistiche(voti) {
    const totalVoti = voti.length;

    if (totalVoti == 0) {
        document.getElementById('mediaGenerale').textContent = '--';
        document.getElementById('votiSufficienti').textContent = '0';
        document.getElementById('votiInsufficenti').textContent = '0';
        return;
    }

    const somma = voti.reduce((acc, voto) => acc + parseFloat(voto.voto), 0);
    const media = (somma / totalVoti).toFixed(2);

    const sufficienti = voti.filter(voto => parseFloat(voto.voto) >= 6).length;
    const insufficienti = voti.filter(voto => parseFloat(voto.voto) < 6).length;

    document.querySelector('#mediaGenerale').textContent = media;
    document.querySelector('#votiSufficienti').textContent = sufficienti;
    document.querySelector('#votiInsufficienti').textContent = insufficienti;
}

function aggiornaTabellaVoti(voti) {
    const tbody = document.querySelector('#tabella-voti tbody');

    if (voti.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px;">Nessun voto disponibile</td></tr>';
        return;
    }

    let html = '';
    voti.forEach(voto => {
        const dataFormattata = formatDate(voto.data);
        const votoClass = parseFloat(voto.voto) >= 6 ? 'voto-sufficiente' : 'voto-insufficiente';

        html += `
            <tr>
                <td>${dataFormattata}</td>
                <td>${voto.materia_nome}</td>
                <td><span class="voto ${votoClass}">${voto.voto}</span></td>
                <td>${voto.note || ''}</td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

function popolaSelectMaterie() {
    const selectMateria = document.getElementById('filtro-materia');
    const selectPlanningMateria = document.getElementById('filtro-planning-materia');

    selectMateria.innerHTML = '<option value="">Tutte le materie</option>';
    if (selectPlanningMateria) {
        selectPlanningMateria.innerHTML = '<option value="">Tutte le materie</option>';
    }

    materieData.forEach(materia => {
        const option = `<option value="${materia.id}">${materia.materia}</option>`;
        selectMateria.innerHTML += option;
        if (selectPlanningMateria) {
            selectPlanningMateria.innerHTML += option;
        }
    });
}

function inizializzaFiltriVoti() {
    const filtroMateria = document.getElementById('filtro-materia');
    const filtroPeriodo = document.getElementById('filtro-periodo');

    filtroMateria.addEventListener('change', applicaFiltriVoti);
    filtroPeriodo.addEventListener('change', applicaFiltriVoti);
}

function applicaFiltriVoti() {
    const materiaSelezionata = document.getElementById('filtro-materia').value;
    const periodoSelezionato = document.getElementById('filtro-periodo').value;

    let votiFiltrati = [...votiData];

    if (materiaSelezionata) {
        votiFiltrati = votiFiltrati.filter(voto => voto.materia_id == materiaSelezionata);
    }

    if (periodoSelezionato) {
        const anno = new Date().getFullYear();
        votiFiltrati = votiFiltrati.filter(voto => {
            const dataVoto = new Date(voto.data);
            if (periodoSelezionato === '1') {
                return (dataVoto.getMonth() >= 8) || (dataVoto.getMonth() === 0 && dataVoto.getDate() <= 31);
            } else if (periodoSelezionato === '2') {
                return dataVoto.getMonth() >= 1 && dataVoto.getMonth() <= 5;
            }
        });
    }

    aggiornaStatistiche(votiFiltrati);
    aggiornaTabellaVoti(votiFiltrati);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('it-IT', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function mostraErroreTabella(tabellaId, messaggio) {
    const tbody = document.querySelector(`#${tabellaId} tbody`);
    const colonne = tbody.querySelector('tr').children.length;
    tbody.innerHTML = `<tr><td colspan="${colonne}" style="text-align: center; padding: 20px; color: #e74c3c;">${messaggio}</td></tr>`;
}