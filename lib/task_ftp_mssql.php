<?php
$i=-1;
//for($i=-125;$i>-156;$i--){
    //echo date("Y_m_d")."<br />";
    $yesterday = date("Y_m_d",strtotime("$i days"));
    $yesterday_sql = date('Y-m-d',strtotime("$i days"));
    echo $yesterday;
    $ftp_host = "217.56.60.146";
    $ftp_user = "isoil";
    $ftp_password = "IsoilMid2023@1%";

    //Connect
    echo "<br />Connecting to $ftp_host via FTP...";
    $conn = ftp_connect($ftp_host,23021);
    $login = ftp_login($conn, $ftp_user, $ftp_password);

    //
    //Enable PASV ( Note: must be done after ftp_login() )
    //
    $mode = ftp_pasv($conn, TRUE);

    //Login OK ?
    if ((!$conn) || (!$login) || (!$mode)) {
        die("FTP connection has failed !");
    }
    echo "<br />Login Ok.<br />";
    //
    //Now run ftp_nlist()
    //
    $local_file = 'temp.csv';
    $row_file = 'temp.txt';

    $file_list = ftp_nlist($conn, "");

    $serverName = "192.168.0.7";
    $connectionOptions = [
        "Database"=>"ISOIL",
        "Uid"=>"sa",
        "PWD"=>"Lora2022@1%"
    ];
    $conn_sql = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn_sql){
        //echo "connected";
        $sql = "SELECT * FROM RTU";
        $stmt = sqlsrv_query( $conn_sql, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }

        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            echo "<br>".$row['ID']." - ".$row['RTU']." - ".$row['NOME']." ";
            $rtu = $row['ID'];
            foreach ($file_list as $file)
            {
                if ((strpos($file, $yesterday)&&(strpos($file, $row['ID']))&&(strpos($file, 'DATA_LOG.CSV'))) !== false) {
                    echo "<br>Nome File: $file";
                    $handle = fopen($local_file, 'w');
                    if (ftp_fget($conn, $handle, $file, FTP_ASCII, 0)) {
                        echo "<br> successfully written to $local_file\n";
                        $line = file($local_file)[0];
                        echo "<br>Dato:$line<br>";
                        if($line != ""){
                            $handle_row = fopen($row_file, "w") or die("Unable to open file!");
                            fwrite($handle_row, $line);
                            $handle_row_r = fopen($row_file, 'r');
                            $data = fgetcsv($handle_row_r, 1000, ";");
                            if ($rtu == '273172'){
                                echo "<br>$data[8]<br />\n";
                                $misurazione = $data[8];
                            }else{
                                echo "<br>$data[4]<br />\n";
                                $misurazione = $data[4];
                            }
                            $insert = "INSERT INTO MISURAZIONI (DATA,RTU_ID,MISURAZIONE) VALUES(DATEADD(day, $i, GETDATE()),$rtu,$misurazione)";
                            $stmt2 = sqlsrv_query( $conn_sql, $insert );
                            if( $stmt2 === false) {
                                die( print_r( sqlsrv_errors(), true) );
                            }
                            /*while (($data = fgetcsv($handle_row_r, 1000, ";")) !== FALSE) {
                                $num = count($data);
                                echo "<p> $num fields in line 0: <br /></p>\n";
                                for ($c=0; $c < $num; $c++) {
                                    echo $data[$c] . "<br />\n";
                                }
                            }*/
                        }
                    } else {
                        echo " There was a problem while downloading $file to $local_file\n";
                    }
                }
            }
        }
        sqlsrv_free_stmt( $stmt);
    }else{
        die(print_r(sqlsrv_errors(), true));
    }




    //close
    ftp_close($conn);
//}
?>
