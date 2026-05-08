<?php
session_start();
date_default_timezone_set('Europe/Rome');
include "assets/config/db_config.php";
// Create connection
$conn = new mysqli($hostname, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
IF((ISSET($_SESSION['id']))&&($_SESSION['id']==1)){
//echo "<script language=\"javascript\">alert(\"OK ".$_SESSION['name']." \");</script>";
    ?>
    <!DOCTYPE html>

    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <title>Ordini - Eurek@!MLM</title>

        <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
        <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <!-- DEMO ONLY: Function for the proper stylesheet loading according to the demo settings -->
        <script>function _pxDemo_loadStylesheet(a,b,c){var c=c||decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-theme")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"candy-blue"),d="rtl"===document.getElementsByTagName("html")[0].getAttribute("dir");document.write(a.replace(/^(.*?)((?:\.min)?\.css)$/,'<link href="$1'+(c.indexOf("dark")!==-1&&a.indexOf("/css/")!==-1&&a.indexOf("/themes/")===-1?"-dark":"")+(!d||0!==a.indexOf("assets/css")&&0!==a.indexOf("assets/demo")?"":".rtl")+'$2" rel="stylesheet" type="text/css"'+(b?'class="'+b+'"':"")+">"))}</script>

        <!-- DEMO ONLY: Set RTL direction -->
        <script>"ltr"!==document.getElementsByTagName("html")[0].getAttribute("dir")&&"1"===decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-rtl")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"0")&&document.getElementsByTagName("html")[0].setAttribute("dir","rtl");</script>

        <!-- DEMO ONLY: Load PixelAdmin core stylesheets -->
        <script>
            _pxDemo_loadStylesheet('assets/css/bootstrap.min.css', 'px-demo-stylesheet-bs');
            _pxDemo_loadStylesheet('assets/css/pixeladmin.min.css', 'px-demo-stylesheet-core');
            _pxDemo_loadStylesheet('assets/css/widgets.min.css', 'px-demo-stylesheet-widgets');
        </script>

        <!-- DEMO ONLY: Load theme -->
        <script>
            function _pxDemo_loadTheme(a){var b=decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-theme")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"candy-blue");_pxDemo_loadStylesheet(a+b+".min.css","px-demo-stylesheet-theme",b)}
            _pxDemo_loadTheme('assets/css/themes/');
        </script>

        <!-- Demo assets -->
        <script>_pxDemo_loadStylesheet('assets/demo/demo.css');</script>
        <!-- / Demo assets -->

        <!-- holder.js -->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/holder/2.9.0/holder.js"></script>

        <!-- Pace.js -->
        <script src="assets/pace/pace.min.js"></script>

        <script type="text/javascript" src="assets/js/function.js"></script>
    </head>
    <body>
    <?php
    $day_now = date("Y-m-d");
    $data_now = new DateTime('now');
    ?>

     <nav class="px-nav px-nav-left">
        <button type="button" class="px-nav-toggle" data-toggle="px-nav">
            <span class="px-nav-toggle-arrow"></span>
            <span class="navbar-toggle-icon"></span>
            <span class="px-nav-toggle-label font-size-11">NASCONDI MENU</span>
        </button>

        <ul class="px-nav-content">
            <li class="px-nav-box p-a-3 b-b-1" id="demo-px-nav-box">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <img src="assets/demo/avatars/1.jpg" alt="" class="pull-xs-left m-r-2 border-round"
                     style="width: 54px; height: 54px;">
                <div class="font-size-16"><span class="font-weight-light">Ciao, </span><strong><?php echo $_SESSION['nome'];?></strong></div>
                <div class="btn-group" style="margin-top: 4px;">
                    <a href="logout.php" class="btn btn-xs btn-danger btn-outline" title="Logout"><i class="fa fa-power-off"></i></a>
                </div>
            </li>

            <!-- MENU ADMIN/USER -->
            <?php
            if($_SESSION['id'] == 1){
                ?>

                <li class="px-nav-item">
                    <a href="index.php"><i class="px-nav-icon fa fa-pie-chart"></i><span class="px-nav-label">Dashboard<span
                                    class="label label-danger"></span></span></a>
                </li>
                <li class="px-nav-item">
                    <a href="carriera.php"><i class="px-nav-icon fa fa-sitemap"></i><span class="px-nav-label">Carriera<span
                                    class="label label-danger"></span></span></a>
                </li>
                <li class="px-nav-item">
                    <a href="result_fattura_compensi_user.php"><i class="px-nav-icon fa fa-money"></i><span class="px-nav-label">Compensi<span
                                    class="label label-danger"></span></span></a>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-user-o"></i><span class="px-nav-label">Collaboratori</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="utenti.php"><span class="px-nav-label">Elenco</span></a></li>
                        <li class="px-nav-item"><a href="crea_utente.php"><span class="px-nav-label">Nuovo</span></a></li>
                        <li class="px-nav-item"><a href="crea_fattura_compensi.php"><span class="px-nav-label">Fatture-Compensi</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-shopping-cart"></i><span class="px-nav-label">Ordini</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="ordini.php"><span class="px-nav-label">Elenco</span></a></li>
                        <li class="px-nav-item"><a href="crea_ordine.php"><span class="px-nav-label">Nuovo</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-th-large"></i><span class="px-nav-label">Prodotti</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="prodotti.php"><span class="px-nav-label">Elenco</span></a></li>
                        <li class="px-nav-item"><a href="crea_prodotto.php"><span class="px-nav-label">Nuovo</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-group"></i><span class="px-nav-label">Fornitori</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="fornitori.php"><span class="px-nav-label">Elenco fornitori</span></a></li>
                        <li class="px-nav-item"><a href="crea_fornitore.php"><span class="px-nav-label">Nuovo fornitore</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-bank"></i><span class="px-nav-label">Banche</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="banche.php"><span class="px-nav-label">Elenco</span></a></li>
                        <li class="px-nav-item"><a href="crea_banca.php"><span class="px-nav-label">Nuova Banca</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-upload"></i><span class="px-nav-label">Fatture Emesse</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="fatture_out.php"><span class="px-nav-label">Elenco</span></a></li>
                        <li class="px-nav-item"><a href="crea_fattura_out.php"><span class="px-nav-label">Nuova</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-download"></i><span class="px-nav-label">Fatture Ricevute</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="fatture_in.php"><span class="px-nav-label">Elenco</span></a></li>
                        <li class="px-nav-item"><a href="crea_fattura_in.php"><span class="px-nav-label">Nuova</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item px-nav-dropdown">
                    <a href="#"><i class="px-nav-icon fa fa-money"></i><span class="px-nav-label">Incassi/Pagamenti</span></a>
                    <ul class="px-nav-dropdown-menu">
                        <li class="px-nav-item"><a href="pagamenti_out.php"><span class="px-nav-label">Elenco incassi</span></a></li>
                        <li class="px-nav-item"><a href="reg_pagamento_out.php"><span class="px-nav-label">Registra incasso</span></a></li>
                        <li class="px-nav-item"><a href="pagamenti_in.php"><span class="px-nav-label">Elenco pagamenti</span></a></li>
                        <li class="px-nav-item"><a href="reg_pagamento_in.php"><span class="px-nav-label">Registra pagamento</span></a></li>
                    </ul>
                </li>
                <li class="px-nav-item">
                    <a href="modulistica.php"><i class="px-nav-icon fa fa-file-text"></i><span class="px-nav-label">Modulistica<span
                                    class="label label-danger"></span></span></a>
                </li>

                <?php
            }else{
                ?>

                <li class="px-nav-item">
                    <a href="index.php"><i class="px-nav-icon fa fa-pie-chart"></i><span class="px-nav-label">Dashboard<span
                                    class="label label-danger"></span></span></a>
                </li>
                <li class="px-nav-item">
                    <a href="carriera_user.php"><i class="px-nav-icon fa fa-sitemap"></i><span class="px-nav-label">Carriera<span
                                    class="label label-danger"></span></span></a>
                </li>
                <li class="px-nav-item">
                    <a href="ordini_famiglia_user.php"><i class="px-nav-icon fa fa-shopping-cart"></i><span class="px-nav-label">Ordini<span
                                    class="label label-danger"></span></span></a>
                </li>
                <li class="px-nav-item">
                    <a href="modulistica.php"><i class="px-nav-icon fa fa-file-text"></i><span class="px-nav-label">Modulistica<span
                                    class="label label-danger"></span></span></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>

    <nav class="navbar px-navbar">
        <!-- Header -->
        <div class="navbar-header">
            <a class="navbar-brand px-demo-brand" href="index.php"><span class="px-demo-logo bg-primary"><span
                        class="px-demo-logo-1"></span><span class="px-demo-logo-2"></span><span
                        class="px-demo-logo-3"></span><span class="px-demo-logo-4"></span><span
                        class="px-demo-logo-5"></span><span class="px-demo-logo-6"></span><span
                        class="px-demo-logo-7"></span><span class="px-demo-logo-8"></span><span
                        class="px-demo-logo-9"></span></span>Eurek@!MLM</a>
        </div>

        <!-- Navbar togglers -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#px-demo-navbar-collapse"
                aria-expanded="false"><i class="navbar-toggle-icon"></i></button>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="px-demo-navbar-collapse">
            <ul class="nav navbar-nav">

            </ul>

            <ul class="nav navbar-nav navbar-right">


                <li>

                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <img src="assets/demo/avatars/1.jpg" alt="" class="px-navbar-image">
                        <span class="hidden-md"><?php echo $_SESSION['nome'];?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <div class="px-content">
        <div class="page-header">
            <h1><span class="text-muted font-weight-light"><i class="page-header-icon ion-android-checkbox-outline"></i>Registra ordine</span>
        </div>

        <div class="panel">

            <div class="panel-heading">
                <span class="panel-title"></span>
            </div>

            <div class="wizard panel-wizard" id="wizard-validation">

                <div class="wizard-wrapper">
                    <ul class="wizard-steps">
                        <li data-target="#wizard-fornitore" class="active">
                            <span class="wizard-step-number">1</span>
                            <span class="wizard-step-complete"><i class="fa fa-check"></i></span>
                            <span class="wizard-step-caption">
                    Seleziona cliente
                  </span>
                        </li>
                        <li data-target="#wizard-fattura-out">
                            <span class="wizard-step-number">2</span>
                            <span class="wizard-step-complete"><i class="fa fa-check"></i></span>
                            <span class="wizard-step-caption">
                    Registrazione
                  </span>
                        </li>
                        <li data-target="#wizard-riepilogo">
                            <span class="wizard-step-number">3</span>
                            <span class="wizard-step-complete"><i class="fa fa-check"></i></span>
                            <span class="wizard-step-caption">
                    Riepilogo
                    <span class="wizard-step-description"></span>
                  </span>
                        </li>
                        <li data-target="#wizard-finish">
                            <span class="wizard-step-number">4</span>
                            <span class="wizard-step-complete"><i class="fa fa-check"></i></span>
                            <span class="wizard-step-caption">
                    Conferma
                  </span>
                        </li>
                    </ul>
                </div>

                <div class="wizard-content">

                    <div id="result">
                    </div>

                    <form class="wizard-pane active" id="wizard-fornitore">
                        <div class="row">
                            <div class="form-group">
                                <label for="wizard-fornitore-select" class="col-sm-3 control-label"><label>
                                        <input type="radio" onfocus="cliente_esistente()" id="radio_esistente" name="fornitore_radio" value="esistente" >
                                    </label> Usa un cliente già esistente</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="wizard-fornitore-select" id="fornitore_select" disabled>
                                        <option selected ></option>
                                        <?php
                                        $sql = "SELECT * FROM users";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option name='denominazione' value=\"".$row["id"]."\">".$row["riferimento"].$row["livello"]."-".$row["id"]." - ".$row["nome"]." ".$row["cognome"]." - ".$row["cf"]."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <fieldset class="form-group">
                            <label>
                                <input onfocus="cliente_new()" type="radio" id="radio_nuovo" name="fornitore_radio" value="nuovo">
                            </label>
                            <label >Crea un nuovo cliente</label>
                        </fieldset>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="fornitore_denominazione">Nome/Denominazione</label>
                                <fieldset class="form-group">
                                    <input type="text" name="wizard-fornitore-denominazione" class="form-control" id="fornitore_denominazione" placeholder="Richiesto" disabled>
                                </fieldset>
                            </div>
                            <div class="col-sm-3">
                                <label for="fornitore_cognome">Cognome</label>
                                <fieldset class="form-group">
                                    <input type="text" name="wizard-fornitore-cognome" class="form-control" id="fornitore_cognome" placeholder="Richiesto" disabled>
                                </fieldset>
                            </div>
                            <div class="col-sm-3">
                                <label for="fornitore_cf">Codice fiscale</label>
                                <fieldset class="form-group">
                                    <input type="text" class="form-control" id="fornitore_cf" name="wizard-fornitore-cf" placeholder="Richiesto" disabled>
                                </fieldset>
                            </div>
                            <div class="col-sm-3">
                                <label for="fornitore_piva">Partita IVA</label>
                                <fieldset class="form-group">
                                    <input type="text" class="form-control" id="fornitore_piva" name="wizard-fornitore-piva" placeholder="Richiesto" disabled>
                                </fieldset>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="fornitore-indirizzo">Indirizzo</label>
                                <fieldset class="form-group">
                                    <input type="text" class="form-control" id="fornitore_indirizzo" name="wizard-fornitore-indirizzo" placeholder="Richiesto" disabled>
                                </fieldset>
                            </div>
                            <div class="col-sm-1">
                                <label for="fornitore_cap">CAP</label>
                                <fieldset class="form-group">
                                    <input onchange="fornitore_citta_provincia()" type="text" class="form-control" id="fornitore_cap" name="wizard-fornitore-cap" placeholder="Richiesto" disabled>
                                </fieldset>
                            </div>
                            <div id="change_prov">
                                <div class="col-sm-5" id="citta_forn">
                                    <label for="fornitore_citta">Città</label>
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" id="fornitore_citta" name="wizard-fornitore-citta" placeholder="Richiesto" disabled>
                                    </fieldset>
                                </div>
                                <div class="col-sm-1">
                                    <label for="fornitore_provincia">Provincia</label>
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" id="fornitore_provincia" name="wizard-fornitore-provincia" placeholder="Richiesto" disabled>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <br>
                        <fieldset class="form-group">
                            <div class="panel-wide-block p-x-3 p-t-3 b-t-1 bg-white text-xs-right">
                                <button type="button" class="btn btn-primary" data-wizard-action="next" id="fornitore_avanti" >Avanti</button>
                            </div>
                        </fieldset>
                    </form>

                    <form class="wizard-pane" id="wizard-fattura-out">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="wizard-fattura-out-denominazione">Denominazione</label>
                                <fieldset class="form-group">
                                    <input type="text" class="form-control" id="fattura_out_denominazione" name="wizard-fattura-out-denominazione" placeholder="Richiesto">
                                </fieldset>
                            </div>
                            <div class="col-sm-2">
                                <label for="wizard-fattura-out-data">Data</label>
                                <fieldset class="form-group">
                                    <input type="text" name="wizard-fattura-out-data" id="daterange-3" value="" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-sm-4">
                                <label for="wizard-fattura-out-cantiere">Venditore</label>
                                <fieldset class="form-group">
                                    <select class="form-control" id="fattura_out_cantiere" name="wizard-fattura-out-cantiere">
                                        <option value="">Seleziona...</option>
                                        <?php
                                        $sql = "SELECT * FROM users";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                $cliente = $row['nome']." ".$row['cognome']." - ".$row['cf'];
                                                echo "<option name='cantiere_id' value=\"".$row["id"]."\">".$row["riferimento"].$row["livello"]."-".$row["id"]." - ".$row["nome"]." - ".$cliente."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="wizard-fattura-in-imponibile">Imponibile</label>
                                    <fieldset class="form-group">
                                        <input onchange="importo_totale()" type="text" class="form-control" id="fattura_in_imponibile" name="wizard-fattura-in-imponibile" placeholder="Richiesto" >
                                    </fieldset>
                                </div>
                                <div class="col-sm-2">
                                    <label for="wizard-fattura-in-iva">Perc. IVA</label>
                                    <fieldset class="form-group">
                                        <select onchange="importo_totale()" class="form-control" id="fattura_in_iva" name="wizard-fattura-in-iva">
                                            <option value="">Seleziona...</option>
                                            <option value="0">RC</option>
                                            <option value="4">4%</option>
                                            <option value="10">10%</option>
                                            <option value="22">22%</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-2">
                                    <label for="wizard-fattura-in-sconto">Sconto</label>
                                    <fieldset class="form-group">
                                        <select onchange="sconto_imponibile()" class="form-control" id="fattura_in_sconto" name="wizard-fattura-in-sconto">
                                            <option value="">Seleziona...</option>
                                            <option value="50">50%</option>
                                            <option value="65">65%</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-2">
                                    <label for="wizard-fattura-in-tot-iva">IVA</label>
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" id="fattura_in_tot_iva" name="wizard-fattura-in-tot-iva" placeholder="" readonly>
                                    </fieldset>
                                </div>
                                <div class="col-sm-2">
                                    <label for="wizard-fattura-in-tot">TOTALE</label>
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" id="fattura_in_tot" name="wizard-fattura-in-tot" placeholder="" readonly>
                                    </fieldset>
                                </div>
                                <div class="col-sm-2">
                                    <label for="wizard-fattura-in-pagare">NETTO A PAGARE</label>
                                    <fieldset class="form-group">
                                        <input type="text" class="form-control" id="fattura_in_pagare" name="wizard-fattura-in-pagare" placeholder="" readonly>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="wizard-fattura-out-prodotto">Prodotto</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="fattura_out_prodotto" name="wizard-fattura-out-prodotto">
                                            <option value="">Seleziona...</option>
                                            <?php
                                            $sql = "SELECT * FROM prodotti";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $prodotto = $row['descrizione'];
                                                    echo "<option name='prodotto_id' value=\"".$row["id"]."\">".$prodotto."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-3">
                                    <label for="wizard-fattura-out-installatore">Installatore</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="fattura_out_installatore" name="wizard-fattura-out-installatore">
                                            <option value="">Seleziona...</option>
                                            <?php
                                            $sql = "SELECT * FROM fornitori WHERE installatore = 1";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $installatore = $row['denominazione']." - ".$row['cf'];
                                                    echo "<option name='installatore_id' value=\"".$row["id"]."\">".$installatore."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6">
                                    <label for="wizard-fattura-out-note">Note:</label>
                                    <fieldset class="form-group">
                                        <textarea class="form-control" name="wizard-fattura-out-note" id="fattura_out_note"></textarea>
                                    </fieldset>
                                </div>
                            </div>

                        </div>
                        <div class="panel-wide-block p-x-3 p-t-3 b-t-1 bg-white text-xs-right">
                            <button type="button" class="btn" data-wizard-action="prev">Indietro</button>&nbsp;&nbsp;
                            <button onclick="riepilogo_ordine()" type="button" class="btn btn-primary" data-wizard-action="next">Avanti</button>
                        </div>
                    </form>

                    <form class="wizard-pane" id="wizard-riepilogo">
                        <div class="row">
                            <h2>CLIENTE:<h2>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="r_fornitore_denominazione">Nome/Denominazione</label>
                                <input type="text" class="form-control" id="r_fornitore_denominazione" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label id="l_fornitore_cognome" for="r_fornitore_cognome">Cognome</label>
                                <input type="text" class="form-control" id="r_fornitore_cognome" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label id="l_fornitore_cf" for="r_fornitore_cf">Codice Fiscale</label>
                                <input type="text" class="form-control" id="r_fornitore_cf" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label id="l_fornitore_piva" for="r_fornitore_piva">Partita IVA</label>
                                <input type="text" class="form-control" id="r_fornitore_piva" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <label id="l_fornitore_indirizzo" for="r_fornitore_indirizzo">Indirizzo</label>
                                <input type="text" class="form-control" id="r_fornitore_indirizzo" readonly>
                            </div>
                            <div class="col-sm-1">
                                <label id="l_fornitore_cap" for="r_fornitore_cap">CAP</label>
                                <input type="text" class="form-control" id="r_fornitore_cap" readonly>
                            </div>
                            <div class="col-sm-5">
                                <label id="l_fornitore_citta" for="r_fornitore_citta">Città</label>
                                <input type="text" class="form-control" id="r_fornitore_citta" readonly>
                            </div>
                            <div class="col-sm-1">
                                <label id="l_fornitore_provincia" for="r_fornitore_provincia">Provincia</label>
                                <input type="text" class="form-control" id="r_fornitore_provincia" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <h2>ORDINE:<h2>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="r_fattura_out_denominazione">Denominazione</label>
                                <input type="text" class="form-control" id="r_fattura_out_denominazione" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="r_fattura_out_data">Data</label>
                                <input type="text" class="form-control" id="r_fattura_out_data" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="r_fattura_out_cantiere">Venditore</label>
                                <input type="text" class="form-control" id="r_fattura_out_cantiere" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="r_fattura_out_imponibile">Imponibile</label>
                                <input type="text" class="form-control" id="r_fattura_out_imponibile" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="r_fattura_out_iva">% IVA</label>
                                <input type="text" class="form-control" id="r_fattura_out_iva" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="r_fattura_out_sconto">% SCONTO</label>
                                <input type="text" class="form-control" id="r_fattura_out_sconto" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="r_fattura_out_tot_iva">IVA</label>
                                <input type="text" class="form-control" id="r_fattura_out_tot_iva" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="r_fattura_out_tot">Totale</label>
                                <input type="text" class="form-control" id="r_fattura_out_tot" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label for="r_fattura_out_pagare">Netto a pagare</label>
                                <input type="text" class="form-control" id="r_fattura_out_pagare" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="r_fattura_out_prodotto">Prodotto</label>
                                <input type="text" class="form-control" id="r_fattura_out_prodotto" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label for="r_fattura_out_installatore">Installatore</label>
                                <input type="text" class="form-control" id="r_fattura_out_installatore" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="r_fattura_out_note">Note</label>
                                <input type="text" class="form-control" id="r_fattura_out_note" readonly>
                            </div>
                        </div>
                        <div class="panel-wide-block p-x-3 p-t-3 b-t-1 bg-white text-xs-right">
                            <button type="button" class="btn" data-wizard-action="prev">Indietro</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary" data-wizard-action="next">Avanti</button>
                        </div>
                    </form>

                    <div class="wizard-pane" id="wizard-finish">
                        <div class="text-xs-center m-y-4">
                            <form method="post">
                                <i class="ion-android-warning text-warning font-size-52 line-height-1"></i>
                                <h4 class="font-weight-semibold font-size-20 m-x-0 m-t-1 m-b-0">Vuoi confermare?</h4>
                                <button type="button" class="btn btn-secondary m-t-4" data-wizard-action="prev">No</button>&nbsp;&nbsp;
                                <button onclick="inserisciOrdine()" type="button" class="btn btn-primary m-t-4" name="button1" data-wizard-action="finish">Si</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <footer class="px-footer px-footer-bottom p-t-0">
        <hr class="page-wide-block">
        <span class="text-muted">Copyright © 2021 Eurek@!MLM. All rights reserved. Powered by <a href="//www.eurekasmartsolution.it">EurekaSmartSolution</a> </span>
    </footer>

    <!-- ==============================================================================
    |
    |  SCRIPTS
    |
    =============================================================================== -->

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/pixeladmin.min.js"></script>

    <script type="text/javascript">
        // -------------------------------------------------------------------------
        // Initialize DEMO

        $(function() {
            var file = String(document.location).split('/').pop();

            // Remove unnecessary file parts
            file = file.replace(/(\.html).*/i, '$1');

            if (!/.html$/i.test(file)) {
                file = 'index.html';
            }

            // Activate current nav item
            $('body > .px-nav')
                .find('.px-nav-item > a[href="' + file + '"]')
                .parent()
                .addClass('active');

            $('body > .px-nav').pxNav();
            $('body > .px-footer').pxFooter();

            $('#navbar-notifications').perfectScrollbar();
            $('#navbar-messages').perfectScrollbar();
        });
    </script>

    <script>
        // -------------------------------------------------------------------------
        // Initialize balance chart

        $(function() {
            if (pxUtil.default) { pxUtil = pxUtil.default; }

            var chartColor = pxDemo.getRandomColors(1)[0];
            var data = [pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), pxDemo.getRandomData(40000, 20000), 31600];

            $("#balance-chart").pxSparkline(data, {
                type: 'line',
                width: '100%',
                height: '60px',
                fillColor: pxUtil.hexToRgba(chartColor, 0.3),
                lineColor: chartColor,
                lineWidth: 1,
                spotColor: null,
                minSpotColor: null,
                maxSpotColor: null,
                highlightSpotColor: chartColor,
                highlightLineColor: chartColor,
                spotRadius: 3,
            });
        });

        // -------------------------------------------------------------------------
        // Initialize revenue chart

        $(function() {
            if (pxUtil.default) { pxUtil = pxUtil.default; }

            var chartColor = pxDemo.getRandomColors(1)[0];
            var data = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label:           'Revenue, $',
                    data:            [pxDemo.getRandomData(5000, 2000), pxDemo.getRandomData(5000, 2000), pxDemo.getRandomData(5000, 2000), pxDemo.getRandomData(5000, 2000), pxDemo.getRandomData(5000, 2000), pxDemo.getRandomData(5000, 2000), 3239],
                    borderWidth:     1,
                    backgroundColor: pxUtil.hexToRgba(chartColor, 0.3),
                    borderColor:     chartColor,
                }],
            };

            new Chart(document.getElementById('revenue-chart').getContext("2d"), {
                type: 'line',
                data: data,
                options: {
                    legend: { display: false },
                },
            });
        });

        // -------------------------------------------------------------------------
        // Initialize expenses chart

        $(function() {
            var chartColor = pxDemo.getRandomColors(1)[0];
            var data = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label:           'Expenses, $',
                    data:            [pxDemo.getRandomData(3000, 900), pxDemo.getRandomData(3000, 900), pxDemo.getRandomData(3000, 900), pxDemo.getRandomData(3000, 900), pxDemo.getRandomData(3000, 900), pxDemo.getRandomData(3000, 900), 1273],
                    borderWidth:     1,
                    backgroundColor: pxUtil.hexToRgba(chartColor, 0.3),
                    borderColor:     chartColor,
                }],
            };

            new Chart(document.getElementById('expenses-chart').getContext("2d"), {
                type: 'bar',
                data: data,
                options: {
                    legend: { display: false },
                },
            });
        });
    </script>
    <script type="text/javascript">
        // -------------------------------------------------------------------------
        // Initialize DEMO

        $(function() {
            var file = String(document.location).split('/').pop();

            // Remove unnecessary file parts
            file = file.replace(/(\.html).*/i, '$1');

            if (!/.html$/i.test(file)) {
                file = 'index.html';
            }

            // Activate current nav item
            $('body > .px-nav')
                .find('.px-nav-item > a[href="' + file + '"]')
                .parent()
                .addClass('active');

            $('body > .px-nav').pxNav();
            $('body > .px-footer').pxFooter();

            $('#navbar-notifications').perfectScrollbar();
            $('#navbar-messages').perfectScrollbar();
        });
    </script>

    <script>
        // -------------------------------------------------------------------------
        // Initialize validation example

        $(function() {
            // Initialize Select2 select box
            $('#fornitore_select').select2({
                allowClear:  true,
                placeholder: 'Seleziona un cliente...',
            }).change(function() {
                $(this).valid();
            });

            $('#fattura_out_cantiere').select2({
                allowClear:  true,
                placeholder: 'Seleziona un venditore...',
            }).change(function() {
                $(this).valid();
            });

            // Initialize Select2 multiselect box
            $('#validation-select2-multi').select2({
                placeholder: 'Select gear...',
            }).change(function() {
                $(this).valid();
            });

            // Initialize custom file input
            $('#validation-file-custom-label').pxFile();

            // Add phone validator
            $.validator.addMethod(
                'phone_format',
                function(value, element) {
                    return this.optional(element) || /^\(\d{3}\)[ ]\d{3}\-\d{4}$/.test(value);
                },
                'Invalid phone number.'
            );

            // Initialize validator
            $('#validation-form').pxValidate({
                ignore: '.ignore, .select2-input',
                focusInvalid: false,
                rules: {
                    'validation-email': {
                        required: true,
                        email: true
                    },
                    'validation-password': {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    'validation-password-confirmation': {
                        required: true,
                        minlength: 6,
                        equalTo: '#validation-password'
                    },
                    'validation-required': {
                        required: true
                    },
                    'validation-url': {
                        required: true,
                        url: true
                    },
                    'validation-phone': {
                        required: true,
                        phone_format: true
                    },
                    'validation-select': {
                        required: true
                    },
                    'validation-multiselect': {
                        required: true,
                        minlength: 2
                    },
                    'validation-select2': {
                        required: true
                    },
                    'validation-select2-multi': {
                        required: true,
                        minlength: 2
                    },
                    'validation-text': {
                        required: true
                    },
                    'validation-message-light': {
                        required: true
                    },
                    'validation-message-dark': {
                        required: true
                    },
                    'validation-file': {
                        required: true
                    },
                    'validation-file-custom': {
                        required: true
                    },
                    'validation-switcher': {
                        required: true
                    },
                    'validation-radios': {
                        required: true
                    },
                    'validation-radios-custom': {
                        required: true
                    },
                    'validation-checkbox': {
                        required: true
                    },
                    'validation-checkbox-custom': {
                        required: true
                    },

                    // Checkbox groups
                    //

                    'validation-checkbox-group-1': {
                        require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                    },
                    'validation-checkbox-group-2': {
                        require_from_group: [1, 'input[name="validation-checkbox-group-1"], input[name="validation-checkbox-group-2"]']
                    },

                    'validation-checkbox-custom-group-1': {
                        require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                    },
                    'validation-checkbox-custom-group-2': {
                        require_from_group: [1, 'input[name="validation-checkbox-custom-group-1"], input[name="validation-checkbox-custom-group-2"]']
                    },
                },
            });
        });

        // -------------------------------------------------------------------------
        // Initialize wizard validation example

        $(function() {
            var $wizard = $('#wizard-validation');

            $wizard.pxWizard();

            // Init plugins
            $('#wizard-country').select2({
                placeholder: 'Select your country...'
            }).change(function() { $(this).valid(); });
            $('#wizard-postal-code').mask("999999");
            $('#wizard-credit-card-number').mask("9999 9999 9999 9999");
            $('#wizard-csv').mask("999");
            $('[data-toggle="tooltip"]').tooltip();

            // Rules
            $('#wizard-fornitore').pxValidate({
                ignore: '.ignore',
                focusInvalid: false,
                rules: {
                    'fornitore_radio': {
                        required: true,
                    },
                    'wizard-fornitore-select': {
                        required: true,
                    },
                    'wizard-fornitore-denominazione': {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                    },
                    'wizard-fornitore-indirizzo': {
                        required: true,
                        minlength: 5,
                        maxlength: 30,
                    },
                    'wizard-fornitore-cap': {
                        required: true,
                        digits: true,
                        rangelength: [5, 5],
                    },
                    'wizard-fornitore-cf': {
                        required: true,
                        rangelength: [9, 16],
                    },
                    'wizard-fornitore-piva': {
                        rangelength: [9, 9],
                    },
                    'wizard-fornitore-iban': {
                        required: true,
                        rangelength: [27, 27],
                    },
                },
            });

            $('#wizard-fattura-out').pxValidate({
                ignore: '.ignore',
                focusInvalid: false,
                rules: {
                    'wizard-fattura-out-denominazione': {
                        required: true,
                        minlength: 3,
                    },
                    'wizard-fattura-out-num': {
                        required: true,
                    },
                    'wizard-fattura-out-imponibile': {
                        required: true,
                    },
                    'wizard-fattura-out-iva': {
                        required: true,
                    },
                    'wizard-fattura-out-tot-iva': {
                        required: true,
                    },
                    'wizard-fattura-out-tot': {
                        required: true,
                    },
                    'wizard-fattura-out-cantiere': {
                        required: true,
                    },
                },
            });





            // Validate

            $wizard.on('stepchange.px.wizard', function(e, data) {
                // Validate only if jump to the forward step

                if (data.nextStepIndex < data.activeStepIndex) { return; }

                var $form = $wizard.pxWizard('getActivePane');

                if (!$form.valid()) {
                    e.preventDefault();
                }
            });

            // Finish

            $wizard.on('finished.px.wizard', function() {
                //
                // Collect and send data...
                //

                $('#wizard-finish').find('.ion-android-warning').removeClass('ion-android-warning text-warning').addClass('ion-checkmark-circled text-primary');
                $('#wizard-finish').find('h4').text('Completato!');
                $('#wizard-finish').find('button').remove();
            });

        });
    </script>

    <script>
        // -------------------------------------------------------------------------
        // Initialize Date Range Picker

        $(function() {
            $('#daterange-1').daterangepicker();

            $('#daterange-2').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY h:mm A'
                }
            });

            $('#daterange-3').daterangepicker({
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    maxDate: moment().endOf("day"),
                    singleDatePicker: true,
                    showDropdowns: true
                },
                function() {
                    //var years = moment().diff(start, 'years');
                    //alert("You are " + years + " years old.");
                });

            (function() {
                var startDate = moment().subtract(29, 'days');
                var endDate = moment();

                function cb(start, end) {
                    $('#daterange-4').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }

                $('#daterange-4').daterangepicker({
                    startDate: startDate,
                    endDate: endDate,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);

                cb(startDate, endDate);
            })();
        });

        // -------------------------------------------------------------------------
        // Initialize Datepicker

        $(function() {
            $('#datepicker-features').datepicker({
                calendarWeeks:         true,
                todayBtn:              'linked',
                daysOfWeekDisabled:    '1',
                clearBtn:              true,
                todayHighlight:        true,
                multidate:             true,
                daysOfWeekHighlighted: '1,2',
                orientation:           'auto right',

                beforeShowMonth: function(date) {
                    if (date.getMonth() === 8) {
                        return false;
                    }
                },

                beforeShowYear: function(date){
                    if (date.getFullYear() === 2014) {
                        return false;
                    }
                }
            });
            $('#datepicker-range').datepicker();
            $('#datepicker-inline').datepicker();
        });

        // -------------------------------------------------------------------------
        // Initialize Timepicker

        $(function() {
            $('#timepicker-base').timepicker();
            $('#timepicker-features').timepicker();
            $('#timepicker-addon').timepicker();
            $('#timepicker-modal').timepicker();
        });

        // -------------------------------------------------------------------------
        // Initialize Minicolors

        $(function() {
            $('#minicolors-hue').minicolors({
                control:  'hue',
                position: 'bottom left',
            });

            $('#minicolors-saturation').minicolors({
                control:  'saturation',
                position: 'bottom right',
            });

            $('#minicolors-wheel').minicolors({
                control:  'wheel',
                position: 'top right',
            });

            $('#minicolors-opacity').minicolors({
                control: 'wheel',
                opacity: true,
            });

            $('#minicolors-brightness').minicolors({
                control:  'brightness',
                position: 'top left',
            });

            $('#minicolors-hidden').minicolors();

            $('#minicolors-sm-left').minicolors({
                opacity: true,
            });

            $('#minicolors-sm-right').minicolors({
                opacity:  true,
                position: 'top right',
            });

            $('#minicolors-sm-hidden').minicolors();

            $('#minicolors-lg-left').minicolors({
                opacity: true,
            });

            $('#minicolors-lg-right').minicolors({
                opacity:  true,
                position: 'top right',
            });

            $('#minicolors-lg-hidden').minicolors();
        });

        // -------------------------------------------------------------------------
        // Initialize Toastr

        $(function() {
            var curMsgIndex = -1;

            function getMessage() {
                var msgs = [
                    'My name is Inigo Montoya. You killed my father. Prepare to die!',
                    '<div><input class="form-control input-sm" value="textbox"/>&nbsp;<a href="//johnpapa.net" target="_blank">This is a hyperlink</a></div><div><button type="button" id="okBtn" class="btn btn-primary">Close me</button><button type="button" id="surpriseBtn" class="btn" style="margin: 0 8px 0 8px">Surprise me</button></div>',
                    'Are you the six fingered man?',
                    'Inconceivable!',
                    'I do not think that means what you think it means.',
                    'Have fun storming the castle!',
                ];

                curMsgIndex++;

                if (curMsgIndex === msgs.length) { curMsgIndex = 0; }

                return msgs[curMsgIndex];
            };

            $('#toastr-show').click(function() {
                var msg   = $('#toastr-message').val() || getMessage();
                var title = $('#toastr-title').val() || '';
                var type  = $('#toastr-type').val();

                toastr[type](msg, title, {
                    positionClass:     $('input[name="toastr-position"]:checked').val(),
                    closeButton:       $('#toastr-close-button').prop('checked'),
                    progressBar:       $('#toastr-progress-bar').prop('checked'),
                    preventDuplicates: $('#toastr-prevent-duplicates').prop('checked'),
                    newestOnTop:       $('#toastr-newest-on-top').prop('checked'),
                });
            });

            $('#toastr-clear').on('click', function() {
                toastr.clear();
            });
        });

        $(function() {
            $('#dropzonejs').dropzone({
                parallelUploads: 2,
                maxFilesize:     50,
                filesizeBase:    1000,

                resize: function(file) {
                    return {
                        srcX:      0,
                        srcY:      0,
                        srcWidth:  file.width,
                        srcHeight: file.height,
                        trgWidth:  file.width,
                        trgHeight: file.height,
                    };
                },
            });

            // Mock the file upload progress (only for the demo)
            //
            Dropzone.prototype.uploadFiles = function(files) {
                var minSteps         = 6;
                var maxSteps         = 60;
                var timeBetweenSteps = 100;
                var bytesPerStep     = 100000;
                var isUploadSuccess  = Math.round(Math.random());

                var self = this;

                for (var i = 0; i < files.length; i++) {

                    var file = files[i];
                    var totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

                    for (var step = 0; step < totalSteps; step++) {
                        var duration = timeBetweenSteps * (step + 1);

                        setTimeout(function(file, totalSteps, step) {
                            return function() {
                                file.upload = {
                                    progress: 100 * (step + 1) / totalSteps,
                                    total: file.size,
                                    bytesSent: (step + 1) * file.size / totalSteps
                                };

                                self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                                if (file.upload.progress == 100) {

                                    if (isUploadSuccess) {
                                        file.status =  Dropzone.SUCCESS;
                                        self.emit('success', file, 'success', null);
                                    } else {
                                        file.status =  Dropzone.ERROR;
                                        self.emit('error', file, 'Some upload error', null);
                                    }

                                    self.emit('complete', file);
                                    self.processQueue();
                                }
                            };
                        }(file, totalSteps, step), duration);
                    }
                }
            };
        });

    </script>
    </body>
    </html>
    <?php
}else{
    echo "<script language=\"javascript\">;document.location.href='login.php';</script>";
}
?>