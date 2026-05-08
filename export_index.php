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
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Misurazione al <?php echo $yesterday." alle 00.05";?></title>
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
                <th>DATA ULTIMA TRASMISSIONE</th>
                <th>MISURAZIONE mc</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            $j = 0;
            if ($conn){
                //echo "connected";
                $sql = "SELECT * FROM MISURAZIONI WHERE DATA = '$yesterday_sql'";
                $stmt = sqlsrv_query( $conn, $sql );
                if( $stmt === false) {
                    die( print_r( sqlsrv_errors(), true) );
                }

                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    $id_temp_rtu = $row['RTU_ID'];
                    $array_rtu[$i] = $id_temp_rtu;
                    $i++;
                    $sql2 = "SELECT * FROM RTU WHERE id = $id_temp_rtu ORDER BY NOME ASC ";
                    $stmt2 = sqlsrv_query( $conn, $sql2 );
                    if( $stmt2 === false) {
                        die( print_r( sqlsrv_errors(), true) );
                    }
                    while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
                        $sql5 = "SELECT TOP 1 * FROM MISURAZIONI WHERE RTU_ID = $row2[ID] ORDER BY DATA desc ";
                        $stmt5 = sqlsrv_query( $conn, $sql5 );
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
                            <td>".$data_ultima_mis_ok."</td>
                            <td>".number_format($row['MISURAZIONE'], 0, '', '')."</td>
                           </tr>";
                    }
                }
                sqlsrv_free_stmt( $stmt);
            }else{
                die(print_r(sqlsrv_errors(), true));
            }
            $valoriArray = implode(",",$array_rtu);
            $sql3 = "SELECT * FROM RTU WHERE id NOT IN ($valoriArray)";
            $stmt3 = sqlsrv_query( $conn, $sql3 );
            if( $stmt3 === false) {
                die( print_r( sqlsrv_errors(), true) );
            }
            while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
                $array_rtu_result[$j] = $row3['ID'];
                $j++;
                $sql6 = "SELECT TOP 1 * FROM MISURAZIONI WHERE RTU_ID = $row3[ID] ORDER BY DATA desc ";
                $stmt6 = sqlsrv_query( $conn, $sql6 );
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
                        <td><span class='badge badge-danger'>".$data_ultima_mis_no."</span></td>
                        <td><span class='badge badge-danger'>NESSUNA MISURAZIONE RICEVUTA</span></td>
                       </tr>";

            }
            //print_r($array_rtu_result);
            $rtu_ok_count = count($array_rtu);
            $rtu_no_count = count($array_rtu_result);
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