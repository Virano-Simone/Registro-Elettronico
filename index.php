<?php
// Simuliamo una sessione già avviata per lo studente
session_start();

// In un'implementazione reale, qui ci sarebbe il controllo della sessione
// e il reindirizzamento al login se necessario
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<title>Registro Elettronico</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./index.css">
	<script src="./axios@1.1.2.min.js"></script>
	<script src="./libreria.js"></script>
	<script src="./index.js"></script>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">Registro Elettronico</div>
            <div class="user-info">
                <span>Benvenuto, <strong><?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] . ' ' . $_SESSION['cognome'] : 'Studente'; ?></strong></span>
                <span>Classe: <strong><?php echo isset($_SESSION['classe']) ? $_SESSION['classe'] : ''; ?></strong></span>
                <button class="logout-btn">Logout</button>
            </div>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul class="nav-tabs">
                <li><a href="#voti" class="active">I miei voti</a></li>
                <li><a href="#assenze">Le mie assenze</a></li>
                <li><a href="#planning">Planning argomenti</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Sezione Voti -->
        <div id="voti" class="tab-content active">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">I miei voti</h2>
                </div>
                
                <div class="voti-stats">
                    <div class="stat-card">
                        <h3>Media generale</h3>
                        <div class="stat-value"><?php /* qui verrà mostrata la media generale */ ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Voti sufficienti</h3>
                        <div class="stat-value"><?php /* qui il numero di voti sufficienti */ ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Voti insufficienti</h3>
                        <div class="stat-value"><?php /* qui il numero di voti insufficienti */ ?></div>
                    </div>
                </div>
                
                <div class="controls">
                    <select id="filtro-materia">
                        <option value="">Tutte le materie</option>
                        <?php 
                        // Qui verrebbe generata la lista delle materie con PHP
                        // Esempio:
                        /*
                        $materie = ottieniMaterie();
                        foreach($materie as $materia) {
                            echo "<option value='{$materia['id']}'>{$materia['materia']}</option>";
                        }
                        */
                        ?>
                    </select>
                    <select id="filtro-periodo">
                        <option value="">Tutto l'anno</option>
                        <option value="1">Primo quadrimestre</option>
                        <option value="2">Secondo quadrimestre</option>
                    </select>
                </div>
                
                <table class="data-table" id="tabella-voti">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Materia</th>
                            <th>Voto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Qui verrebbero caricati i voti con PHP 
                        // Esempio di riga:
                        /*
                        foreach($voti as $voto) {
                            $classe_voto = $voto['voto'] >= 6 ? 'voto-sufficiente' : 'voto-insufficiente';
                            echo "<tr>
                                <td>{$voto['data']}</td>
                                <td>{$voto['materia']}</td>
                                <td class='{$classe_voto}'>{$voto['voto']}</td>
                            </tr>";
                        }
                        */
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Sezione Assenze -->
        <div id="assenze" class="tab-content">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Le mie assenze</h2>
                </div>

                <div class="assenze-status">
                    <p>Totale assenze: <strong><?php /* qui il totale assenze */ ?></strong></p>
                    <p>Da giustificare: <strong><?php /* qui il numero di assenze da giustificare */ ?></strong></p>
                </div>
                
                <table class="data-table" id="tabella-assenze">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Stato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Qui verrebbero caricate le assenze con PHP
                        // Esempio di riga:
                        /*
                        foreach($assenze as $assenza) {
                            $stato = $assenza['giustificato'] ? 
                                '<span class="status-badge giustificato">Giustificato</span>' : 
                                '<span class="status-badge non-giustificato">Non giustificato</span>';
                            echo "<tr>
                                <td>{$assenza['data']}</td>
                                <td>{$stato}</td>
                            </tr>";
                        }
                        */
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Sezione Planning -->
        <div id="planning" class="tab-content">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">Planning argomenti</h2>
                </div>
                
                <div class="filter-controls">
                    <select id="filtro-planning-materia" class="filter-control">
                        <option value="">Tutte le materie</option>
                        <?php 
                        // Qui verrebbe generata la lista delle materie con PHP
                        // Esempio:
                        /*
                        foreach($materie as $materia) {
                            echo "<option value='{$materia['id']}'>{$materia['materia']}</option>";
                        }
                        */
                        ?>
                    </select>
                    <input type="date" id="filtro-planning-data" class="filter-control">
                </div>
                
                <table class="data-table" id="tabella-planning">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Materia</th>
                            <th>Argomento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Qui verrebbero caricati gli argomenti con PHP
                        // Esempio di riga:
                        /*
                        foreach($argomenti as $argomento) {
                            echo "<tr>
                                <td>{$argomento['data']}</td>
                                <td><span class='materia-badge'>{$argomento['materia']}</span></td>
                                <td>{$argomento['argomento']}</td>
                            </tr>";
                        }
                        */
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Script per gestire i tab di navigazione
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-tabs a');
            const contents = document.querySelectorAll('.tab-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Rimuove la classe active da tutti i tab
                    tabs.forEach(t => t.classList.remove('active'));
                    
                    // Aggiunge la classe active al tab cliccato
                    this.classList.add('active');
                    
                    // Nasconde tutti i contenuti
                    contents.forEach(content => content.classList.remove('active'));
                    
                    // Mostra il contenuto corrispondente
                    const targetId = this.getAttribute('href').substring(1);
                    document.getElementById(targetId).classList.add('active');
                });
            });
            
            // Gestione filtri
            const filtroMateria = document.getElementById('filtro-materia');
            if (filtroMateria) {
                filtroMateria.addEventListener('change', function() {
                    // Qui andrebbe il codice per filtrare i voti per materia
                    // O una chiamata AJAX al server per ricaricare i dati filtrati
                });
            }
            
            const filtroPeriodo = document.getElementById('filtro-periodo');
            if (filtroPeriodo) {
                filtroPeriodo.addEventListener('change', function() {
                    // Qui andrebbe il codice per filtrare i voti per periodo
                    // O una chiamata AJAX al server per ricaricare i dati filtrati
                });
            }
            
            const filtroPlanningMateria = document.getElementById('filtro-planning-materia');
            if (filtroPlanningMateria) {
                filtroPlanningMateria.addEventListener('change', function() {
                    // Qui andrebbe il codice per filtrare il planning per materia
                    // O una chiamata AJAX al server per ricaricare i dati filtrati
                });
            }
            
            const filtroPlanningData = document.getElementById('filtro-planning-data');
            if (filtroPlanningData) {
                filtroPlanningData.addEventListener('change', function() {
                    // Qui andrebbe il codice per filtrare il planning per data
                    // O una chiamata AJAX al server per ricaricare i dati filtrati
                });
            }
            
            // Gestione logout
            const logoutBtn = document.querySelector('.logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function() {
                    // Redirect alla pagina di logout
                    window.location.href = "logout.php";
                });
            }
        });
    </script>
</body>
</html>
