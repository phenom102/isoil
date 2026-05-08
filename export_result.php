<?php
require_once 'include/db.php';

$ricerca_data = $_GET['ricerca-data'] ?? date("d-m-Y", strtotime("-1 days"));
$ricerca_data = str_replace('/', '-', $ricerca_data);

$yesterday = date("d-m-Y",strtotime($ricerca_data));
$yesterday_sql = date("Y-m-d",strtotime($ricerca_data));

$conn = get_db_connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dati rilevati il <?php echo $yesterday;?> alle ore 00.05</title>
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
        $i = 0;
        $j = 0;
        if ($conn){
            //echo "connected";
            $sql = "SELECT * FROM MISURAZIONI WHERE DATA = ?";
            $params = array($yesterday_sql);
            $stmt = sqlsrv_query( $conn, $sql, $params );
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
            }

            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                $id_temp_rtu = $row['RTU_ID'];
                $array_rtu[$i] = $id_temp_rtu;
                $i++;
                $sql2 = "SELECT * FROM RTU WHERE id = ? ORDER BY NOME ASC ";
                $params2 = array($id_temp_rtu);
                $stmt2 = sqlsrv_query( $conn, $sql2, $params2 );
                if( $stmt2 === false) {
                    die( print_r( sqlsrv_errors(), true) );
                }
                while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                    $sql5 = "SELECT TOP 1 * FROM MISURAZIONI WHERE RTU_ID = ? ORDER BY DATA desc ";
                    $params5 = array($row2['ID']);
                    $stmt5 = sqlsrv_query( $conn, $sql5, $params5 );
                    if( $stmt5 === false) {
                        die( print_r( sqlsrv_errors(), true) );
                    }
                    while( $row5 = sqlsrv_fetch_array( $stmt5, SQLSRV_FETCH_ASSOC) ) {
                        $data_ultima_mis_ok = date_format($row5['DATA'] ,"d-m-Y");
                    }
                    sqlsrv_free_stmt( $stmt5);

                    echo "<tr class='odd gradeX'>
                            <td><a href='result_dispositivo.php?dispositivo=$row2[ID]'><span class='badge badge-success'>".$row2['ID']."</span></a></td>
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
        if (isset($array_rtu) && count($array_rtu) > 0) {
            $placeholders = implode(',', array_fill(0, count($array_rtu), '?'));
            $sql3 = "SELECT * FROM RTU WHERE id NOT IN ($placeholders)";
            $params3 = $array_rtu;
        } else {
            $sql3 = "SELECT * FROM RTU";
            $params3 = array();
        }
        $stmt3 = sqlsrv_query( $conn, $sql3, $params3 );
        if( $stmt3 === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
        while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
            $array_rtu_result[$j] = $row3['ID'];
            $j++;
            $sql6 = "SELECT TOP 1 * FROM MISURAZIONI WHERE RTU_ID = ? ORDER BY DATA desc ";
            $params6 = array($row3['ID']);
            $stmt6 = sqlsrv_query( $conn, $sql6, $params6 );
            if( $stmt6 === false) {
                die( print_r( sqlsrv_errors(), true) );
            }
            while( $row6 = sqlsrv_fetch_array( $stmt6, SQLSRV_FETCH_ASSOC) ) {
                $data_ultima_mis_no = date_format($row6['DATA'] ,"d-m-Y");
            }
            sqlsrv_free_stmt( $stmt6);

            echo "<tr class='odd gradeX'>
                        <td><a href='result_dispositivo.php?dispositivo=$row3[ID]'><span class='badge badge-danger'>".$row3['ID']."</span></a></td>
                        <td><span class='badge badge-danger'>".$row3['POD']."</span></td>
                        <td><span class='badge badge-danger'>".$row3['MATRICOLA']."</span></td>
                        <td><span class='badge badge-danger'>".$row3['RTU']."</span></td>
                        <td><span class='badge badge-danger'>".$row3['NOME']."</span></td>
                        <td><span class='badge badge-danger'>NESSUNA MISURAZIONE RICEVUTA</span></td>
                       </tr>";

        }
        //print_r($array_rtu_result);
        $rtu_ok_count = isset($array_rtu) ? count($array_rtu) : 0;
        $rtu_no_count = isset($array_rtu_result) ? count($array_rtu_result) : 0;
        echo "<span class='badge badge-success'>Misurazioni ricevute &nbsp;".$rtu_ok_count."</span>&nbsp; &nbsp;";
        echo "<span class='badge badge-danger'>Misurazioni non ricevute &nbsp;".$rtu_no_count."</span><br><br>";
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