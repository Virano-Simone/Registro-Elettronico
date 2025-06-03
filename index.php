<!DOCTYPE html>
<html lang="it">

<head>
    <title>Registro Elettronico</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">

    <script src="librerie/axios@1.1.2.min.js"></script>
    <script src="librerie/libreria.js"></script>
    <script src="index.js"></script>
</head>

<body style="display: none;">
    <?php session_start(); ?>

    <nav class="navbar navbar-dark bg-primary sticky-top shadow-lg">
        <div class="container-fluid">
            <div class="navbar-brand d-flex align-items-center">
                <i class="fas fa-graduation-cap me-2 fs-4"></i>
                <span class="d-none d-sm-inline">Registro Elettronico</span>
                <span class="d-sm-none">Registro</span>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown d-block d-md-none me-3">
                    <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item nav-link-mobile" href="#voti"><i
                                    class="fas fa-chart-line me-2"></i>I miei voti</a></li>
                        <li><a class="dropdown-item nav-link-mobile" href="#assenze"><i
                                    class="fas fa-calendar-times me-2"></i>Le mie assenze</a></li>
                        <li><a class="dropdown-item nav-link-mobile" href="#planning"><i
                                    class="fas fa-book-open me-2"></i>Planning argomenti</a></li>
                    </ul>
                </div>

                <div class="d-flex align-items-center text-white me-3">
                    <img id="userImage" src="./img/<?php echo ($_SESSION['immagine']) ?>" alt="Avatar utente"
                        class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                    <div class="d-none d-lg-block">
                        <div class="fw-bold"><?php echo ($_SESSION['nome'] . ' ' . $_SESSION['cognome']) ?></div>
                        <small class="opacity-75"><?php echo ($_SESSION['classe']); ?></small>
                    </div>
                </div>

                <button class="btn btn-outline-light btn-sm" id="btnLogout">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                </button>
            </div>
        </div>
    </nav>

    <nav class="bg-white border-bottom sticky-top d-none d-md-block" style="top: 56px;">
        <div class="container-fluid">
            <ul class="nav nav-tabs border-0" id="mainTabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#voti">
                        <i class="fas fa-chart-line me-2"></i>I miei voti
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#assenze">
                        <i class="fas fa-calendar-times me-2"></i>Le mie assenze
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#planning">
                        <i class="fas fa-book-open me-2"></i>Planning argomenti
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid py-3 py-md-4">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="voti">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h2 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>I miei voti
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calculator fs-1 mb-2"></i>
                                        <h3 class="card-title">Media Generale</h3>
                                        <h2 class="display-4 fw-bold" id="mediaGenerale">--</h2>
                                        <small>Su tutti i voti</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-thumbs-up fs-1 mb-2"></i>
                                        <h3 class="card-title">Voti Sufficienti</h3>
                                        <h2 class="display-4 fw-bold" id="votiSufficienti">--</h2>
                                        <small>Voti >= 6</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-exclamation-triangle fs-1 mb-2"></i>
                                        <h3 class="card-title">Voti Insufficienti</h3>
                                        <h2 class="display-4 fw-bold" id="votiInsufficienti">--</h2>
                                        <small>Voti < 6</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Materia</label>
                                        <select id="filtro-materia" class="form-select">
                                            <option value="">Tutte le materie</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Periodo</label>
                                        <select id="filtro-periodo" class="form-select">
                                            <option value="">Tutto l'anno</option>
                                            <option value="1">Primo quadrimestre</option>
                                            <option value="2">Secondo quadrimestre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tabella-voti">
                                <thead class="table-primary">
                                    <tr>
                                        <th><i class="fas fa-calendar me-1"></i><span
                                                class="d-none d-sm-inline">Data</span></th>
                                        <th><i class="fas fa-book me-1"></i><span
                                                class="d-none d-sm-inline">Materia</span></th>
                                        <th><i class="fas fa-star me-1"></i><span class="d-none d-sm-inline">Voto</span>
                                        </th>
                                        <th class="d-none d-md-table-cell"><i class="fas fa-comment me-1"></i>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="spinner-border text-primary me-2" role="status"></div>
                                            <span>Caricamento voti...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="assenze">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h2 class="card-title mb-0">
                            <i class="fas fa-calendar-times me-2"></i>Le mie assenze
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar-times fs-1 mb-2"></i>
                                        <h3 class="card-title">Totale Assenze</h3>
                                        <h2 class="display-4 fw-bold" id="totaleAssenze">--</h2>
                                        <small>Giorni di assenza</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-danger text-white h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-exclamation-circle fs-1 mb-2"></i>
                                        <h3 class="card-title">Da Giustificare</h3>
                                        <h2 class="display-4 fw-bold" id="daGiustificare">--</h2>
                                        <small>Assenze non giustificate</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tabella-assenze">
                                <thead class="table-primary">
                                    <tr>
                                        <th><i class="fas fa-calendar me-1"></i><span
                                                class="d-none d-sm-inline">Data</span></th>
                                        <th><i class="fas fa-info-circle me-1"></i><span
                                                class="d-none d-sm-inline">Tipo</span></th>
                                        <th><i class="fas fa-check-circle me-1"></i><span
                                                class="d-none d-sm-inline">Stato</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="spinner-border text-primary me-2" role="status"></div>
                                            <span>Caricamento assenze...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="planning">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h2 class="card-title mb-0">
                            <i class="fas fa-book-open me-2"></i>Planning argomenti
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Materia</label>
                                        <select id="filtro-planning-materia" class="form-select">
                                            <option value="">Tutte le materie</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Data</label>
                                        <input type="date" id="filtro-planning-data" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="tabella-planning">
                                <thead class="table-primary">
                                    <tr>
                                        <th><i class="fas fa-calendar me-1"></i><span
                                                class="d-none d-sm-inline">Data</span></th>
                                        <th><i class="fas fa-book me-1"></i><span
                                                class="d-none d-sm-inline">Materia</span></th>
                                        <th><i class="fas fa-list me-1"></i><span
                                                class="d-none d-sm-inline">Argomento</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="spinner-border text-primary me-2" role="status"></div>
                                            <span>Caricamento argomenti...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>