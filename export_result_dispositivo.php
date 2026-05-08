<?php
$ricerca_dispositivo = $_GET['dispositivo'];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dati rilevati per il dispositivo: <?php echo $nome_dispositivo;?></title>
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

</head>
<body>
<div>
    <table id="example" class="display nowrap" style="width:100%">
        <thead>
        <tr>
            <th>MISURAZIONE mc</th>
            <th>DATA</th>
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
<script type="text/javascript">
    // -------------------------------------------------------------------------
    // Initialize DEMO

    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel'
            ],
            info: false,
            paging: false,
        } );
    } );
</script>
</body>
</html>