<?php
// Common functions to set up and interact with the database

// debugging
if (isset($debug) && $debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$curDir = realpath(__DIR__);

function print_error($errorStr, $showBackButton=true) {
    echo '<p class="error">ERROR: ' . htmlspecialchars($errorStr) . '</p>';
    if ($showBackButton) {
        echo '<button onclick="window.history.back();">Go back</button>';
    }
}

function print_success($str, $showHomeButton=true) {
    echo '<p class="success">' . htmlspecialchars($str) . '</p>';
    if ($showHomeButton) {
        echo '<a href="index.php"><button>Go home</button></a>';
    }
}

if (!include($curDir . "/../config/config.php")) {
    die(htmlspecialchars("Missing config file!"));
    return;
}

$conn = NULL;

function sql_connect() {
    global $conn, $dbHost, $dbLogin, $dbPassword, $dbName;
    try {
        $conn = new mysqli($dbHost, $dbLogin, $dbPassword, $dbName);
    } catch (ErrorException $e) {
        die(htmlspecialchars("Error initializing mysqli: " . $e->getMessage()));
    }
    if ($conn->connect_errno) {
        die(htmlspecialchars("Error connecting to Database server: " . mysqli_connect_error()));
    }
}

sql_connect();

function executePlainSQL($cmdstr) {
    global $conn;
    $result = $conn->query($cmdstr);
    if (!$result) {
        print_error("Error in SQL query: " . $conn->error);
    }
    $conn->commit();
    return $result;
}

function executeBoundSQL($template, ...$args) {
    global $conn;
    $stmt = $conn->prepare($template);
    if (!$stmt) {
        print_error("Error preparing SQL statement: " . $conn->error);
        return false;
    }
    $stmt->bind_param(...$args);
    if (!$stmt->execute()) {
        print_error("Error executing: " . $conn->error);
        return false;
    };
    $conn->commit();

    // get_result returns false for successful queries that don't return output,
    // but we want a truthy value in these cases
    $result = $stmt->get_result();
    if ($result) {
        return $result;
    } else {
        return $stmt->affected_rows;
    };
}

// Helper to print SQL query results as an HTML table
function print_result_table($result) {
    echo '<table><tr>';
    foreach ($result->fetch_fields() as $field) {
        echo '<th>' . $field->name . '</th>';
    }
    echo '</tr>';
    while ($row = $result->fetch_row()) {
        echo '<tr>';
        foreach ($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

// default vars for pagehead.php
$hideLoginInfo = false;
?>
