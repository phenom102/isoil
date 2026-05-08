<?php
$yesterday = date("d-m-Y",strtotime("-1 days"));
$yesterday_sql = date("Y-m-d",strtotime("-1 days"));
$serverName = "192.168.0.7";
$connectionOptions = [
    "Database"=>"ISOIL",
    "Uid"=>"sa",
    "PWD"=>"Lora2022@1%"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);
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

    <li class="px-nav-item">
      <a href="index.php"><i class="px-nav-icon ion-ios-pulse-strong"></i><span class="px-nav-label">Dashboard</span></a>
    </li>
    <li class="px-nav-box b-t-1 p-a-2">
      <a href="ricerca.php" class="btn btn-primary btn-block btn-outline"><i class="px-nav-icon ion-ios-search"></i>Ricerca</a>
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
      <div class="panel-title">Dati rilevati il <?php echo $yesterday;?></div>
      <div align="right"><a target="_blank" href="export_index.php" class="btn btn-primary">Esporta</a></div>
    </div>
    <div class="panel-body">

      <div class="table-primary">
        <table class="table table-striped table-bordered" id="datatables">
          <thead>
          <tr>
            <th>ID</th>
            <th>POD</th>
            <th>MATRICOLA</th>
            <th>RTU</th>
            <th>NOME</th>
            <th>MISURAZIONE mc</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if ($conn){
            //echo "connected";
            $sql = "SELECT * FROM MISURAZIONI WHERE DATA = '$yesterday_sql'";
            $stmt = sqlsrv_query( $conn, $sql );
            if( $stmt === false) {
              die( print_r( sqlsrv_errors(), true) );
            }

            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              $id_temp_rtu = $row['RTU_ID'];

              $sql2 = "SELECT * FROM RTU WHERE id = $id_temp_rtu ORDER BY NOME ASC ";
              $stmt2 = sqlsrv_query( $conn, $sql2 );
              if( $stmt2 === false) {
                die( print_r( sqlsrv_errors(), true) );
              }
              while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                echo "<tr class='odd gradeX'>
                            <td>".$row2['ID']."</td>
                            <td>".$row2['POD']."</td>
                            <td>".$row2['MATRICOLA']."</td>
                            <td>".$row2['RTU']."</td>
                            <td>".$row2['NOME']."</td>
                            <td>".number_format($row['MISURAZIONE'], 0, '', '')."</td>
                           </tr>";
              }
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

  <span class="text-muted">Copyright © 2024 CED Asis Salernitana reti ed impianti. Tutti i diritti riservati.</span>
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
