<?php
    $serverName = "192.168.0.7";
    $connectionOptions = [
        "Database"=>"ISOIL",
        "Uid"=>"sa",
        "PWD"=>"Lora2022@1%"
    ];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn){
        //echo "connected";
        $sql = "SELECT * FROM ISOIL_H_00";
        $stmt = sqlsrv_query( $conn, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }

        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            echo $row['Nr_Riga']." - ".$row['Nome_File']." - ".$row['Misura']."<br />";
        }

        sqlsrv_free_stmt( $stmt);
    }else{
        die(print_r(sqlsrv_errors(), true));
    }

    ?>
