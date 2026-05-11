<?php
require_once 'include/db.php';

$ricerca_dispositivo = $_GET['dispositivo'] ?? 0;
$conn = get_db_connection();

// Secure query with parameters for RTU
$sql2 = "SELECT * FROM RTU WHERE id = ? ";
$params2 = array($ricerca_dispositivo);
$stmt2 = sqlsrv_query( $conn, $sql2, $params2 );
if( $stmt2 === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$nome_dispositivo = "Sconosciuto";
while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
    $nome_dispositivo = $row2['NOME'];
}
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
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//datatables.net/download/build/nightly/jquery.dataTables.js"></script>
    <script type="text/javascript" src="data_order.js"></script>

    <!-- Pace.js -->
    <script src="assets/pace/pace.min.js"></script>

    <script src="assets/demo/demo.js"></script>


    <?php include 'include/style_modern.php'; ?>
</head>
<body>
<?php include 'include/nav.php'; ?>

<div class="px-content">
    <div class="page-header">
        <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Dettaglio Dispositivo</h1>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-title">Dispositivo: <?php echo $nome_dispositivo;?></div>
                </div>
                <div class="col-md-4 text-md-right">
                    <a target="_blank" href="export_result_dispositivo.php?dispositivo=<?php echo $ricerca_dispositivo;?>" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Esporta</a>
                </div>
            </div>
        </div>
        <div class="panel-body">

            <div class="table-primary">
                <table class="table table-striped table-bordered" id="datatables">
                    <thead>
                    <tr>
                        <th>MISURAZIONE mc</th>
                        <th>DATA - ora 00.05</th>
                        <th>mc giornalieri</th>
                        <th>l/s</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    if ($conn){
                        //echo "connected";
                        $sql = "SELECT * FROM MISURAZIONI WHERE RTU_ID = ? ORDER BY DATA asc ";
                        $params = array($ricerca_dispositivo);
                        $stmt = sqlsrv_query( $conn, $sql, $params );
                        if( $stmt === false) {
                            die( print_r( sqlsrv_errors(), true) );
                        }

                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $mis_tmp = 0;
                            $j= $i-1;
                            $data1 = '01-01-1970';
                            $data2 = '01-01-1970';
                            $diff_gg = 0;
                            $misurazioni[$i] = $row['MISURAZIONE'];
                            $date[$i] = $row['DATA'];
                            echo "<tr class='odd gradeX'>
                            <td>".number_format($row['MISURAZIONE'], 0, '', '')."</td>
                            <td>".date_format($row['DATA'] ,"d-m-Y")."</td>";
                            if(isset($date[$i],$date[$j])){
                                $data1 = date_format($date[$i] ,"Y/m/d");
                                $data2 = date_format($date[$j] ,"Y/m/d");
                                //$date_tmp = $data1->diff($data2);
                                $diff_gg = floor((strtotime($data1) - strtotime($data2)) / 86400);
                            }
                            if(isset($misurazioni[$i],$misurazioni[$j])){
                                if($diff_gg!=0){
                                    $mis_tmp = ($misurazioni[$i] - $misurazioni[$j])/$diff_gg;
                                }else{
                                    $mis_tmp = null;
                                }
                            }
                            $l_s = $mis_tmp/86.4;
                            echo "<td>".number_format($mis_tmp, 0, '', '')."</td>";
                            echo "<td>".number_format($l_s, 2, ',', '')."</td>
                           </tr>";
                            $i++;
                        }

                        sqlsrv_free_stmt( $stmt);
                    }else{
                        die(print_r(sqlsrv_errors(), true));
                    }
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
        $('#datatables').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
            },
            "pageLength": 10
        });
        $('#datatables_wrapper .table-caption').text('Storico Misurazioni');
        $('#datatables_wrapper .dataTables_filter input').attr('placeholder', 'Cerca...');
    });
</script>


</body>
</html>
