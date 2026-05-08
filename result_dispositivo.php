<?php
$ricerca_dispositivo = $_GET['dispositivo'];
/*$ricerca_data = str_replace('/', '-', $ricerca_data);
//$yesterday = date("d-m-Y",strtotime("-1 days"));
$yesterday = date("d-m-Y",strtotime($ricerca_data));
//$yesterday_sql = date("Y-m-d",strtotime("-1 days"));
$yesterday_sql = date("Y-m-d",strtotime($ricerca_data));*/
$serverName = "192.168.0.7";
$connectionOptions = [
    "Database"=>"ISOIL",
    "Uid"=>"sa",
    "PWD"=>"Lora2022@1%"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);
$sql2 = "SELECT * FROM RTU WHERE id = $ricerca_dispositivo ";
$stmt2 = sqlsrv_query( $conn, $sql2 );
if( $stmt2 === false) {
    die( print_r( sqlsrv_errors(), true) );
}
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


    <!-- Custom styling -->
    <style>
        .page-header-form .input-group-addon,
        .page-header-form .form-control {
            background: rgba(0,0,0,.05);
        }
    </style>
    <!-- / Custom styling -->
</head>
<body>
<nav class="px-nav px-nav-left">
    <button type="button" class="px-nav-toggle" data-toggle="px-nav">
        <span class="px-nav-toggle-arrow"></span>
        <span class="navbar-toggle-icon"></span>
        <span class="px-nav-toggle-label font-size-11">HIDE MENU</span>
    </button>

    <ul class="px-nav-content">
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="index.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon ion-ios-pulse-strong"></i>Dashboard ISOIL</a>
        </li>
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="ricerca.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon ion-ios-search"></i>Ricerca ISOIL</a>
        </li>
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="portate.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon fa fa-tint"></i>Portate Telecontrollo</a>
        </li>
        <li class="px-nav-box b-t-1 p-a-2">
            <a href="portate_map.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon fa fa-map"></i>Portate Tel. Mappa</a>
        </li>
    </ul>
</nav>

<nav class="navbar px-navbar">
    <!-- Header -->
    <div class="navbar-header">
        <a class="navbar-brand px-demo-brand" href="index.php"><span class="px-demo-logo bg-primary"><span class="px-demo-logo-1"></span><span class="px-demo-logo-2"></span><span class="px-demo-logo-3"></span><span class="px-demo-logo-4"></span><span class="px-demo-logo-5"></span><span class="px-demo-logo-6"></span><span class="px-demo-logo-7"></span><span class="px-demo-logo-8"></span><span class="px-demo-logo-9"></span></span>ISOIL</a>
    </div>
</nav>

<div class="px-content">
    <div class="page-header">
        <div class="row">
            <div class="col-md-4 text-xs-center text-md-left text-nowrap">
                <h1><i class="page-header-icon ion-ios-pulse-strong"></i>Dashboard</h1>
            </div>

            <hr class="page-wide-block visible-xs visible-sm">

            <!-- Spacer -->
            <div class="m-b-2 visible-xs visible-sm clearfix"></div>

        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Dati rilevati per il dispositivo: <?php echo $nome_dispositivo;?></div>
            <div align="right"><a target="_blank" href="export_result_dispositivo.php?dispositivo=<?php echo $ricerca_dispositivo;?>" class="btn btn-primary">Esporta</a></div>
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
                        $sql = "SELECT * FROM MISURAZIONI WHERE RTU_ID = $ricerca_dispositivo ORDER BY DATA asc ";
                        $stmt = sqlsrv_query( $conn, $sql );
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

    <span class="text-muted">Copyright © 2026 CED Asis Salernitana reti ed impianti. Tutti i diritti riservati.</span>
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
        $('#datatables_wrapper .table-caption').text('Uploads');
        $('#datatables_wrapper .dataTables_filter input').attr('placeholder', 'Cerca...');
    });
</script>


</body>
</html>
