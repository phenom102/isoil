<?php
require_once 'include/db.php';

$ricerca_data = $_GET['ricerca-data'] ?? date("d-m-Y", strtotime("-1 days"));
$ricerca_data = str_replace('/', '-', $ricerca_data);

$yesterday = date("d-m-Y",strtotime($ricerca_data));
$yesterday_sql = date("Y-m-d",strtotime($ricerca_data));

$conn = get_db_connection();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>Dashboard - ISOIL</title>

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

<?php
$rows_received = [];
$rows_missing = [];
$array_rtu = [];
$array_rtu_result = [];

if ($conn) {
    // 1. Fetch received measurements
    $sql = "SELECT m.*, r.POD, r.MATRICOLA, r.RTU, r.NOME, r.ID as RTU_ID_REAL
            FROM MISURAZIONI m
            INNER JOIN RTU r ON m.RTU_ID = r.id
            WHERE m.DATA = ?";
    $params = array($yesterday_sql);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) die(print_r(sqlsrv_errors(), true));

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $rtu_id = $row['RTU_ID_REAL'];
        $array_rtu[] = $rtu_id;

        $sql5 = "SELECT TOP 1 DATA FROM MISURAZIONI WHERE RTU_ID = ? ORDER BY DATA desc";
        $stmt5 = sqlsrv_query($conn, $sql5, array($rtu_id));
        $last_trans = "N/D";
        if ($r5 = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)) {
            $last_trans = date_format($r5['DATA'], "d-m-Y");
        }
        sqlsrv_free_stmt($stmt5);

        $row['last_transmission'] = $last_trans;
        $rows_received[] = $row;
    }
    sqlsrv_free_stmt($stmt);

    // 2. Fetch missing units
    if (count($array_rtu) > 0) {
        $placeholders = implode(',', array_fill(0, count($array_rtu), '?'));
        $sql3 = "SELECT * FROM RTU WHERE id NOT IN ($placeholders)";
        $params3 = $array_rtu;
    } else {
        $sql3 = "SELECT * FROM RTU";
        $params3 = array();
    }
    $stmt3 = sqlsrv_query($conn, $sql3, $params3);
    if ($stmt3 === false) die(print_r(sqlsrv_errors(), true));

    while ($row3 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
        $array_rtu_result[] = $row3['ID'];

        $sql6 = "SELECT TOP 1 DATA FROM MISURAZIONI WHERE RTU_ID = ? ORDER BY DATA desc";
        $stmt6 = sqlsrv_query($conn, $sql6, array($row3['ID']));
        $last_trans = "MAI";
        if ($r6 = sqlsrv_fetch_array($stmt6, SQLSRV_FETCH_ASSOC)) {
            $last_trans = date_format($r6['DATA'], "d-m-Y");
        }
        sqlsrv_free_stmt($stmt6);

        $row3['last_transmission'] = $last_trans;
        $rows_missing[] = $row3;
    }
    sqlsrv_free_stmt($stmt3);
}

$rtu_ok_count = count($array_rtu);
$rtu_no_count = count($array_rtu_result);
?>

<div class="px-content">
    <div class="page-header">
        <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Dashboard Ricerca</h1>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-title">Dati rilevati il <?php echo $yesterday;?> alle ore 00.05</div>
                </div>
                <div class="col-md-4 text-md-right">
                    <a target="_blank" href="export_result.php?ricerca-data=<?php echo $yesterday;?>" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Esporta</a>
                </div>
            </div>
        </div>
        <div class="panel-body">

            <div class="filter-section">
                <span class="text-muted m-r-2"><i class="fa fa-filter"></i> Filtra per stato:</span>
                <a href="javascript:void(0)" id="filter-received" class="btn btn-success btn-outline btn-rounded btn-sm">
                    <i class="fa fa-check-circle"></i> Ricevute <span class="badge badge-success"><?php echo $rtu_ok_count; ?></span>
                </a>
                <a href="javascript:void(0)" id="filter-missing" class="btn btn-danger btn-outline btn-rounded btn-sm">
                    <i class="fa fa-times-circle"></i> Non ricevute <span class="badge badge-danger"><?php echo $rtu_no_count; ?></span>
                </a>
                <a href="javascript:void(0)" id="filter-reset" class="btn btn-default btn-outline btn-rounded btn-sm">
                    <i class="fa fa-refresh"></i> Reset
                </a>
            </div>

            <div class="table-primary">
                <table class="table table-striped table-bordered" id="datatables">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>POD</th>
                        <th>MATRICOLA</th>
                        <th>RTU</th>
                        <th>NOME</th>
                        <th>ULTIMA TRASMISSIONE</th>
                        <th>MISURAZIONE (mc)</th>
                        <th>STATO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows_received as $row): ?>
                        <tr class='odd gradeX'>
                            <td><a href='result_dispositivo.php?dispositivo=<?php echo $row['RTU_ID_REAL']; ?>'><span class='badge badge-success'><?php echo $row['RTU_ID_REAL']; ?></span></a></td>
                            <td><?php echo $row['POD']; ?></td>
                            <td><?php echo $row['MATRICOLA']; ?></td>
                            <td><?php echo $row['RTU']; ?></td>
                            <td><?php echo $row['NOME']; ?></td>
                            <td><?php echo $row['last_transmission']; ?></td>
                            <td><?php echo number_format($row['MISURAZIONE'], 0, '', ''); ?></td>
                            <td class='text-center'><span class='label label-success'>RICEVUTA</span></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php foreach ($rows_missing as $row3): ?>
                        <tr class='odd gradeX'>
                            <td><a href='result_dispositivo.php?dispositivo=<?php echo $row3['ID']; ?>'><span class='badge badge-danger'><?php echo $row3['ID']; ?></span></a></td>
                            <td><span class='text-danger'><?php echo $row3['POD']; ?></span></td>
                            <td><span class='text-danger'><?php echo $row3['MATRICOLA']; ?></span></td>
                            <td><span class='text-danger'><?php echo $row3['RTU']; ?></span></td>
                            <td><span class='text-danger'><?php echo $row3['NOME']; ?></span></td>
                            <td><span class='text-danger'><?php echo $row3['last_transmission']; ?></span></td>
                            <td><span class='text-danger'>ASSENTE</span></td>
                            <td class='text-center'><span class='label label-danger'>NON RICEVUTA</span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

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
        var table = $('#datatables').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
            },
            "pageLength": 10,
            "order": [[ 4, "asc" ]], // Ordina per Nome
            "columnDefs": [
                { "orderable": false, "targets": [7] } // Disabilita ordinamento su colonna Stato
            ]
        });

        $('#datatables_wrapper .table-caption').text('Elenco Dispositivi e Misurazioni');
        $('#datatables_wrapper .dataTables_filter input').attr('placeholder', 'Cerca...');

        // Filtri personalizzati
        $('#filter-received').on('click', function() {
            table.column(7).search('^RICEVUTA$', true, false).draw();
        });

        $('#filter-missing').on('click', function() {
            table.column(7).search('^NON RICEVUTA$', true, false).draw();
        });

        $('#filter-reset').on('click', function() {
            table.column(7).search('').draw();
        });

        // Add active class to sidebar
        $('#nav-ricerca').addClass('active');
    });
</script>


</body>
</html>
