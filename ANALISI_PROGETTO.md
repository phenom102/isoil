# Analisi Progetto ISOIL

## 1. Introduzione
Il progetto "isoil" è un sistema di monitoraggio e visualizzazione di dati provenienti da dispositivi RTU (Remote Terminal Units), probabilmente misuratori di portata o contatori d'acqua. Il sistema raccoglie dati tramite FTP, li memorizza in un database SQL Server e li espone tramite una dashboard web.

## 2. Architettura del Sistema

### 2.1 Ingestione Dati (`lib/task_ftp_mssql.php`)
Il processo di acquisizione segue questi step:
1. Connessione a un server FTP esterno.
2. Download di file CSV (`DATA_LOG.CSV`) contenenti le letture.
3. Parsing dei file CSV per estrarre le misurazioni.
4. Inserimento dei dati nel database MSSQL (`ISOIL`).

### 2.2 Database
Vengono utilizzati due database principali su un server SQL Server (192.168.0.7):
- **ISOIL**: Contiene le tabelle `RTU` (anagrafica dispositivi) e `MISURAZIONI` (storico letture).
- **IFIX**: Contiene le tabelle `Campioni2026` e `Descrizioni`, utilizzate per il monitoraggio delle portate in tempo reale.

### 2.3 Interfaccia Web
L'interfaccia è basata su PHP ed utilizza il template "PixelAdmin". Le funzionalità principali includono:
- **Dashboard Principale (`index.php`)**: Visualizza lo stato delle letture ricevute rispetto a quelle attese per il giorno precedente.
- **Ricerca Storica (`ricerca.php`, `result.php`)**: Consente di consultare i dati per data o per singolo dispositivo.
- **Dettaglio Dispositivo (`result_dispositivo.php`)**: Mostra lo storico delle letture di un'unità, calcolando i consumi giornalieri e la portata media in l/s.
- **Monitoraggio Portate (`portate.php`, `portate_map.php`)**: Fornisce una vista tabellare e cartografica (tramite Leaflet) delle portate attuali.

## 3. Tecnologie Utilizzate
- **Linguaggio**: PHP 7.x
- **Database**: Microsoft SQL Server (estensione `sqlsrv`)
- **Frontend**:
    - Bootstrap & PixelAdmin (UI)
    - jQuery (Interattività)
    - DataTables (Tabelle dinamiche ed export Excel/CSV)
    - Leaflet (Mappe interattive)
- **Integrazione**: FTP (per acquisizione dati)

## 4. Analisi Critica e Suggerimenti

### 4.1 Sicurezza
- **Credenziali Hardcoded**: Le password del database e dell'FTP sono presenti in chiaro in diversi file (es. `index.php`, `lib/task_ftp_mssql.php`). Si consiglia di spostarle in un file di configurazione protetto (`.env` o simile) e non incluso nel versionamento.
- **SQL Injection**: Molte query utilizzano parametri passati via GET senza adeguata sanitizzazione (es. `$ricerca_dispositivo` in `result_dispositivo.php`). È fortemente consigliato l'uso di **prepared statements**.

### 4.2 Ottimizzazione
- **Ridondanza Connessioni**: Molti file aprono connessioni al database individualmente. Sarebbe preferibile centralizzare la gestione della connessione (es. tramite un file `db.php` incluso).
- **Calcolo Portate**: Il calcolo del differenziale tra letture in `result_dispositivo.php` viene effettuato a livello applicativo. Per dataset grandi, potrebbe essere più efficiente eseguirlo via SQL.

### 4.3 Manutenzione
- **Codice Hardcoded**: Riferimenti ad anni specifici (es. `Campioni2026`) potrebbero richiedere modifiche manuali future. Si consiglia di rendere dinamico il riferimento alle tabelle o di utilizzare una struttura più generica.

## 5. Conclusione
Il progetto è funzionale e ben strutturato per lo scopo prefissato (monitoraggio industriale/idrico). Tuttavia, necessita di interventi prioritari sulla sicurezza e sulla gestione delle configurazioni per essere considerato "production-ready" secondo gli standard moderni.
