<!DOCTYPE html>
<html lang="it">

<head>
    <title>Registro Elettronico</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <script src="librerie/axios@1.1.2.min.js"></script>
    <script src="librerie/libreria.js"></script>
    <script src="index.js"></script>

</head>

<body style="display: none;">
    <?php session_start(); ?>
    <!-- Modern Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>Registro Elettronico</span>
            </div>
            <div class="user-section">
                <div class="user-info">
                    <div class="user-name" id="userName">
                        <?php
                        echo isset($_SESSION['nome']) ? $_SESSION['nome'] . ' ' . $_SESSION['cognome'] : 'Studente'; ?>
                    </div>
                    <div class="user-class" id="userClass">
                        <?php echo isset($_SESSION['classe']) ? $_SESSION['classe'] : ''; ?>
                    </div>
                </div>
                <button class="logout-btn" id="btnLogout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </div>
        </div>
    </header>

    <!-- Modern Navigation -->
    <nav class="navigation">
        <div class="nav-container">
            <ul class="nav-tabs">
                <li class="nav-tab">
                    <a href="#voti" class="nav-link active">
                        <i class="fas fa-chart-line"></i>
                        I miei voti
                    </a>
                </li>
                <li class="nav-tab">
                    <a href="#assenze" class="nav-link">
                        <i class="fas fa-calendar-times"></i>
                        Le mie assenze
                    </a>
                </li>
                <li class="nav-tab">
                    <a href="#planning" class="nav-link">
                        <i class="fas fa-book-open"></i>
                        Planning argomenti
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Sezione Voti -->
        <div id="voti" class="tab-content active">
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-chart-line"></i>
                        I miei voti
                    </h2>
                </div>
                <div class="section-content">
                    <!-- Stats Cards -->
                    <div class="stats-grid">
                        <div class="stat-card media">
                            <div class="stat-header">
                                <div class="stat-title">Media Generale</div>
                                <div class="stat-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                            </div>
                            <div class="stat-value" id="mediaGenerale">--</div>
                            <div class="stat-subtitle">Su tutti i voti</div>
                        </div>
                        <div class="stat-card sufficienti">
                            <div class="stat-header">
                                <div class="stat-title">Voti Sufficienti</div>
                                <div class="stat-icon">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                            </div>
                            <div class="stat-value" id="votiSufficienti">--</div>
                            <div class="stat-subtitle">Voti >= 6</div>
                        </div>
                        <div class="stat-card insufficienti">
                            <div class="stat-header">
                                <div class="stat-title">Voti Insufficienti</div>
                                <div class="stat-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="stat-value" id="votiInsufficenti">--</div>
                            <div class="stat-subtitle">Voti < 6</div>
                            </div>
                        </div>

                        <!-- Filtri -->
                        <div class="controls">
                            <div class="control-group">
                                <label class="control-label">Materia</label>
                                <select id="filtro-materia" class="form-control">
                                    <option value="">Tutte le materie</option>
                                </select>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Periodo</label>
                                <select id="filtro-periodo" class="form-control">
                                    <option value="">Tutto l'anno</option>
                                    <option value="1">Primo quadrimestre</option>
                                    <option value="2">Secondo quadrimestre</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tabella Voti -->
                        <div class="table-container">
                            <table class="data-table" id="tabella-voti">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar"></i> Data</th>
                                        <th><i class="fas fa-book"></i> Materia</th>
                                        <th><i class="fas fa-star"></i> Voto</th>
                                        <th><i class="fas fa-comment"></i> Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <div class="loading">
                                                <div class="loading-spinner"></div>
                                                <div class="loading-text">Caricamento voti...</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sezione Assenze -->
            <div id="assenze" class="tab-content">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-calendar-times"></i>
                            Le mie assenze
                        </h2>
                    </div>
                    <div class="section-content">
                        <!-- Stats Assenze -->
                        <div class="stats-grid">
                            <div class="stat-card media">
                                <div class="stat-header">
                                    <div class="stat-title">Totale Assenze</div>
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                </div>
                                <div class="stat-value" id="totaleAssenze">--</div>
                                <div class="stat-subtitle">Giorni di assenza</div>
                            </div>
                            <div class="stat-card insufficienti">
                                <div class="stat-header">
                                    <div class="stat-title">Da Giustificare</div>
                                    <div class="stat-icon">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </div>
                                </div>
                                <div class="stat-value" id="daGiustificare">--</div>
                                <div class="stat-subtitle">Assenze non giustificate</div>
                            </div>
                        </div>

                        <!-- Tabella Assenze -->
                        <div class="table-container">
                            <table class="data-table" id="tabella-assenze">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar"></i> Data</th>
                                        <th><i class="fas fa-info-circle"></i> Tipo</th>
                                        <th><i class="fas fa-check-circle"></i> Stato</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <div class="loading">
                                                <div class="loading-spinner"></div>
                                                <div class="loading-text">Caricamento assenze...</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sezione Planning -->
            <div id="planning" class="tab-content">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-book-open"></i>
                            Planning argomenti
                        </h2>
                    </div>
                    <div class="section-content">
                        <!-- Filtri Planning -->
                        <div class="controls">
                            <div class="control-group">
                                <label class="control-label">Materia</label>
                                <select id="filtro-planning-materia" class="form-control">
                                    <option value="">Tutte le materie</option>
                                </select>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Data</label>
                                <input type="date" id="filtro-planning-data" class="form-control">
                            </div>
                        </div>

                        <!-- Tabella Planning -->
                        <div class="table-container">
                            <table class="data-table" id="tabella-planning">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar"></i> Data</th>
                                        <th><i class="fas fa-book"></i> Materia</th>
                                        <th><i class="fas fa-list"></i> Argomento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <div class="loading">
                                                <div class="loading-spinner"></div>
                                                <div class="loading-text">Caricamento argomenti...</div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    </script>
</body>

</html>