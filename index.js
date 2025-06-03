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
let assenzeData = [];
let planningData = [];

function inizializzaApp() {
    inizializzaNavigazione();

    caricaVoti();
    caricaMaterie();
    caricaAssenze();
    caricaPlanning();
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

function aggiornaStatistiche(voti) {
    const totalVoti = voti.length;

    if (totalVoti == 0) {
        document.querySelector('#mediaGenerale').textContent = '--';
        document.querySelector('#votiSufficienti').textContent = '0';
        document.querySelector('#votiInsufficienti').textContent = '0';
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

    if (voti.length == 0) {
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

function inizializzaFiltriVoti() {
    const filtroMateria = document.getElementById('filtro-materia');
    const filtroPeriodo = document.getElementById('filtro-periodo');

    filtroMateria.addEventListener('change', applicaFiltriVoti);
    filtroPeriodo.addEventListener('change', applicaFiltriVoti);
}

function applicaFiltriVoti() {
    const materiaSelezionata = document.getElementById('filtro-materia').value;
    const periodoSelezionato = document.getElementById('filtro-periodo').value;

    let votiFiltrati = votiData.slice();

    if (materiaSelezionata) {
        votiFiltrati = votiFiltrati.filter(voto => voto.materia_id == materiaSelezionata);
    }

    if (periodoSelezionato) {
        votiFiltrati = votiFiltrati.filter(voto => {
            const dataVoto = new Date(voto.data);
            if (periodoSelezionato == '1') {
                return (dataVoto.getMonth() >= 8) || (dataVoto.getMonth() == 0 && dataVoto.getDate() <= 31);
            } else if (periodoSelezionato == '2') {
                return dataVoto.getMonth() >= 1 && dataVoto.getMonth() <= 5;
            }
        });
    }

    aggiornaStatistiche(votiFiltrati);
    aggiornaTabellaVoti(votiFiltrati);
}

function caricaAssenze() {
    let request = inviaRichiesta("GET", "server/getAssenze.php");
    request.then(function (response) {
        assenzeData = response.data;
        aggiornaStatisticheAssenze(assenzeData);
        aggiornaTabellaAssenze(assenzeData);
    }).catch(errore);
}

function aggiornaStatisticheAssenze(assenze) {
    const totaleAssenze = assenze.length;
    const daGiustificare = assenze.filter(assenza => assenza.giustificato == 0).length;

    document.querySelector('#totaleAssenze').textContent = totaleAssenze;
    document.querySelector('#daGiustificare').textContent = daGiustificare;
}

function aggiornaTabellaAssenze(assenze) {
    const tbody = document.querySelector('#tabella-assenze tbody');

    if (assenze.length == 0) {
        tbody.innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 20px;">Nessuna assenza registrata</td></tr>';
        return;
    }

    let html = '';
    assenze.forEach(assenza => {
        const dataFormattata = formatDate(assenza.data);
        const statoClass = assenza.giustificato == 1 ? 'giustificata' : 'non-giustificata';
        const statoTesto = assenza.giustificato == 1 ? 'Giustificata' : 'Da giustificare';
        const tipoIcon = assenza.giustificato == 1 ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

        html += `
            <tr>
                <td>${dataFormattata}</td>
                <td>Assenza</td>
                <td>
                    <span class="stato-assenza ${statoClass}">
                        <i class="${tipoIcon}"></i>
                        ${statoTesto}
                    </span>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

function caricaPlanning() {
    let request = inviaRichiesta("GET", "server/getPlanning.php");
    request.then(function (response) {
        planningData = response.data;
        aggiornaTabellaPlanning(planningData);
        inizializzaFiltriPlanning();
    }).catch(errore);
}

function aggiornaTabellaPlanning(planning) {
    const tbody = document.querySelector('#tabella-planning tbody');

    if (planning.length == 0) {
        tbody.innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 20px;">Nessun argomento programmato</td></tr>';
        return;
    }

    let html = '';
    planning.forEach(item => {
        const dataFormattata = formatDate(item.data);

        html += `
            <tr>
                <td>${dataFormattata}</td>
                <td>${item.materia_nome}</td>
                <td>${item.argomento}</td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

function inizializzaFiltriPlanning() {
    const filtroMateria = document.querySelector('#filtro-planning-materia');
    const filtroData = document.querySelector('#filtro-planning-data');

    if (filtroMateria) {
        filtroMateria.addEventListener('change', applicaFiltriPlanning);
    }
    if (filtroData) {
        filtroData.addEventListener('change', applicaFiltriPlanning);
    }
}

function applicaFiltriPlanning() {
    const materiaSelezionata = document.querySelector('#filtro-planning-materia').value;
    const dataSelezionata = document.querySelector('#filtro-planning-data').value;

    let planningFiltrato = planningData.slice();

    if (materiaSelezionata) {
        planningFiltrato = planningFiltrato.filter(item => item.materia_id == materiaSelezionata);
    }

    if (dataSelezionata) {
        planningFiltrato = planningFiltrato.filter(item => {
            const dataItem = new Date(item.data).toISOString().split('T')[0];
            return dataItem === dataSelezionata;
        });
    }

    aggiornaTabellaPlanning(planningFiltrato);
}

function caricaMaterie() {
    let request = inviaRichiesta("GET", "server/getMaterie.php");
    request.then(function (response) {
        materieData = response.data;
        popolaSelectMaterie();
    }).catch(errore);
}

function popolaSelectMaterie() {
    const selectMateria = document.querySelector('#filtro-materia');
    const selectPlanningMateria = document.querySelector('#filtro-planning-materia');

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