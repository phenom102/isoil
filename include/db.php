<?php
require_once __DIR__ . '/config.php';

/**
 * Connects to a SQL Server database.
 *
 * @param string $database The database name.
 * @return resource|false The connection resource or false on failure.
 */
function get_db_connection($database = DB_NAME_ISOIL) {
    $connectionOptions = [
        "Database" => $database,
        "Uid" => DB_USER,
        "PWD" => DB_PASSWORD,
        "TrustServerCertificate" => true // Often needed for local/internal connections
    ];

    $conn = sqlsrv_connect(DB_SERVER, $connectionOptions);

    if ($conn === false) {
        error_log("Database connection failed for $database: " . print_r(sqlsrv_errors(), true));
    }

    return $conn;
}

/**
 * Formats a date for SQL queries.
 *
 * @param string $date Date in DD-MM-YYYY or DD/MM/YYYY format.
 * @return string Date in YYYY-MM-DD format.
 */
function format_date_for_sql($date) {
    $date = str_replace('/', '-', $date);
    return date("Y-m-d", strtotime($date));
}
?>
