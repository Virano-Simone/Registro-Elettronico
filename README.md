# Registro Elettronico - Virano Simone

Applicazione web per la gestione del registro elettronico scolastico con interfaccia moderna e responsive.

## Funzionalità

### 📊 Voti
- Visualizzazione di tutti i voti con statistiche automatiche
- Media generale, voti sufficienti e insufficienti
- Filtri per materia e periodo (quadrimestri)
- Tabella dettagliata con data, materia, voto e note

### 📅 Assenze  
- Panoramica delle assenze totali
- Evidenziazione delle assenze da giustificare
- Stato visuale (giustificata/non giustificata)

### 📚 Planning Argomenti
- Calendario degli argomenti programmati
- Filtri per materia e data
- Organizzazione per materia e argomento

## Tecnologie

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP con gestione sessioni
- **Librerie**: Axios per chiamate AJAX, Font Awesome per icone
- **Design**: Completamente responsive per desktop e mobile

## Caratteristiche Tecniche

- Single Page Application con navigazione a tabs
- Caricamento asincrono dei dati
- Filtri real-time senza ricaricamento pagina
- Interfaccia responsive con menu hamburger su mobile
- Controllo automatico delle sessioni utente

## Struttura File

```
├── index.php          # Pagina principale
├── index.js           # Logica JavaScript
├── index.css          # Stili personalizzati
├── librerie/          # Librerie JavaScript
└── server/            # Endpoint PHP backend
    ├── getVoti.php
    ├── getAssenze.php
    ├── getPlanning.php
    └── ...
```

## API Endpoints

- `GET /server/getVoti.php` - Recupera voti
- `GET /server/getAssenze.php` - Recupera assenze  
- `GET /server/getPlanning.php` - Recupera planning
- `GET /server/getMaterie.php` - Recupera materie
- `GET /server/logout.php` - Logout utente
- `GET /server/login.php` - Login utente
- `GET /server/nuovoUtente.php` - Aggiunta nuovo utente
- `GET /server/mysqli.php` - Libreria che gestisce connessioni al server SQL e dati

## Installazione

1. Configurare server web con supporto PHP
2. Caricare i file nella directory web
3. Configurare gli endpoint del database
4. Testare l'applicazione

## Interfaccia

- **Desktop**: Navigazione orizzontale con tabs
- **Mobile**: Menu dropdown responsive
- Cards colorate per statistiche principali
- Tabelle responsive con scroll orizzontale
- Stati di caricamento durante il fetch dei dati