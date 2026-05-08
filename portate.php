<?php
require_once 'include/db.php';

$yesterday = date("d-m-Y",strtotime("-1 days"));
$yesterday_sql = date("Y-m-d",strtotime("-1 days"));
$conn = get_db_connection(DB_NAME_IFIX);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>Dashboard - Portate</title>

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- DEMO ONLY: Function for the proper stylesheet loading according to the demo settings -->
    <script>function _pxDemo_loadStylesheet(a,b,c){var c=c||decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-theme")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"clean"),d="rtl"===document.getElementsByTagName("html")[0].getAttribute("dir");document.write(a.replace(/^(.*?)((?:\.min)?\.css)$/,'<link href="$1'+(c.indexOf("dark")!==-1&&a.indexOf("/css/")!==-1&&a.indexOf("/themes/")===-1?"-dark":"")+(!d||0!==a.indexOf("assets/css")&&0!==a.indexOf("assets/demo")?"":".rtl")+'$2" rel="stylesheet" type="text/css"'+(b?'class="'+b+'"':"")+">"))}</script>

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
        function _pxDemo_loadTheme(a){var b=decodeURIComponent((new RegExp(";\\s*"+encodeURIComponent("px-demo-theme")+"\\s*=\\s*([^;]+)\\s*;","g").exec(";"+document.cookie+";")||[])[1]||"clean");_pxDemo_loadStylesheet(a+b+".min.css","px-demo-stylesheet-theme",b)}
        _pxDemo_loadTheme('assets/css/themes/');
    </script>

    <!-- Demo assets -->
    <script>_pxDemo_loadStylesheet('assets/demo/demo.css');</script>
    <!-- / Demo assets -->

    <!-- holder.js -->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/holder/2.9.0/holder.js"></script>

    <!-- Pace.js -->
    <script src="assets/pace/pace.min.js"></script>

    <script src="assets/demo/demo.js"></script>

    <?php include 'include/style_modern.php'; ?>
</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="px-content">
    <div class="page-header">
        <div class="row">
            <div class="col-md-4 text-xs-center text-md-left text-nowrap">
                <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Dashboard Portate Ingressi Serbatoi</h1>
            </div>

            <hr class="page-wide-block visible-xs visible-sm">

            <!-- Spacer -->
            <div class="m-b-2 visible-xs visible-sm clearfix"></div>

        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            <div class="table-primary">
                <table class="table table-striped table-bordered" id="datatables">
                    <thead>
                    <tr>
                        <th>TAG</th>
                        <th>NOME</th>
                        <th>ULTIMA TRASMISSIONE</th>
                        <th>MISURAZIONE l/s</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($conn){
                        // Query ottimizzata: recupera l'ultimo inserimento (indice MAX) per ogni Tag
                        $sql = "SELECT c.Tag, c.Data, c.Ora, c.Valore, d.Descrizione 
            FROM Campioni2026 c
            INNER JOIN Descrizioni d ON c.Tag = d.Tag
            WHERE d.UMI = 'l/s' AND c.indice IN (
                SELECT MAX(indice) 
                FROM Campioni2026 
                GROUP BY Tag
            )
            ORDER BY d.Descrizione ASC";

                        $stmt = sqlsrv_query( $conn, $sql );

                        if( $stmt === false) {
                            die( print_r( sqlsrv_errors(), true) );
                        }

                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            // Gestione corretta dell'oggetto DateTime di SQLSRV
                            $data_ultima_mis_ok = "";
                            if (isset($row['Data']) && isset($row['Ora'])) {
                                $data_part = $row['Data']->format('d-m-Y');
                                $ora_part = $row['Ora']->format('H:i:s');
                                $data_ultima_mis_ok = $data_part . " " . $ora_part;
                            }

                            // Il valore è già in l/s, applichiamo solo la formattazione numerica
                            $portata_ls = number_format($row['Valore'], 2, ',', '.');

                            echo "<tr class='odd gradeX'>
                <td>".$row['Tag']."</td>
                <td>".$row['Descrizione']."</td>
                <td>".$data_ultima_mis_ok."</td>
                <td>".$portata_ls."</td>
              </tr>";
                        }
                        sqlsrv_free_stmt($stmt);
                    }
                    sqlsrv_close($conn);
                    ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

<footer class="px-footer px-footer-bottom p-t-0">
    <hr class="page-wide-block">
    <span class="text-muted"><?php echo APP_COPYRIGHT; ?></span>
</footer>

<!-- ==============================================================================
|
|  SCRIPTS
|
=============================================================================== -->

<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/pixeladmin.min.js"></script>
<script>
    // -------------------------------------------------------------------------
    // Initialize DataTables

    $(function() {
        $('#datatables').dataTable();
        $('#datatables_wrapper .table-caption').text('Letture real-time');
        $('#datatables_wrapper .dataTables_filter input').attr('placeholder', 'Cerca...');

    });
</script>

<script>
    // -------------------------------------------------------------------------
    // Initialize DataTables

    $(function() {
        $('#datatables2').dataTable();
        $('#datatables2_wrapper .table-caption').text('Errore');
        $('#datatables2_wrapper .dataTables_filter input').attr('placeholder', 'Cerca...');

    });
</script>


</body>
</html>
