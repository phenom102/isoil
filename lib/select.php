<?php
$stmt = $pdo->prepare("SELECT * FROM dbo.RTU");
$serverName = "U4BUO1D";
$connectionInfo = array("Database"=>"AmanfoHR", "UID"=>"userName", "PWD"=>"password");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

$tsql = "
SELECT  No_ AS empID,
        [First Name] AS fname
FROM dbo.[DATABASE"."$"."Employee];";

$stmt = sqlsrv_query( $conn, $tsql);

if( $stmt === false ) {
    echo "Error in executing query.</br>";
    die( print_r( sqlsrv_errors(), true));
}

while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo $obj['fname'];
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
