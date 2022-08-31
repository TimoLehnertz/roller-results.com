<?php
include_once "../secret/secrets.php";

$dBName = "results";

$mysqli = new mysqli($serverName, $dBUsername, $dBPwd, $dBName);

$QUERY_MAX_SIZE = -1;

/**
 * set the maximum size of the resultset returned by query
 * -1 for infinite
 */
function setMaxResultSize($size) {
    global $QUERY_MAX_SIZE;
    $QUERY_MAX_SIZE = $size;
}

function dbInsert($sql, ... $fillers) {
    global $mysqli;

    $insertTypes;
    if(sizeof($fillers) > 1) {
        $insertTypes = $fillers[0];
    }
    $insertValues = [];
    if(isset($insertTypes)){
        for ($i=1; $i < sizeof($fillers); $i++) { 
            $insertValues[] = &$fillers[$i];
        }
    }
    if(call_user_func_array("dbExecute", array_merge(array($sql), array($insertTypes), $insertValues))) {
        return $mysqli->insert_id;
    } else {
        return false;
    }
}

function dbExecute($sql, ... $fillers) {
    global $mysqli;
    $succsess = false;
    $insertTypes;
    if(sizeof($fillers) > 1){
        $insertTypes = $fillers[0];
    }
    $insertValues = [];
    if(isset($insertTypes)){
        for ($i=1; $i < sizeof($fillers); $i++) { 
            $insertValues[] = &$fillers[$i];
        }
    }
    if($stmt = $mysqli->prepare($sql)) {
        if(isset($insertTypes)) {
            if(!$stmt->bind_param($insertTypes, ...$insertValues)) {
                $stmt->close();
                printf("Error message: %s\n", $mysqli->error);
                return false;
            } else {
                // debug_print_backtrace();
                // echo "1 ";
                // echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        }
        if($stmt->execute()) {
            $succsess = true;
        } else {
            printf("Error message: %s\n", $mysqli->error);
        }
        $stmt->close();
    } else {
        printf("Error message: %s\n", $mysqli->error);
    }
    return $succsess;
}

function dbExecuteArr($sql, $insertTypes, $insertValues) {
    global $mysqli;
    $succsess = false;
    if($stmt = $mysqli->prepare($sql)) {
        if(isset($insertTypes)){
            if(!$stmt->bind_param($insertTypes, ...$insertValues)) {
                $stmt->close();
                // printf("Error message: %s\n", $mysqli->error);
                return false;
            }
        }
        if($stmt->execute()) {
            $succsess = true;
        }
        $stmt->close();
    }
    return $succsess;
}

function query($sql, ... $fillers){
    global $mysqli;
    global $QUERY_MAX_SIZE;
    $resultArray = [];
    $insertTypes;
    
    if(sizeof($fillers) > 1){
        $insertTypes = $fillers[0];
    }
    $insertValues = [];
    if(isset($insertTypes)){
        for ($i=1; $i < sizeof($fillers); $i++) {
            $insertValues[] = &$fillers[$i];
        }
    }
    if($stmt = $mysqli->prepare($sql)) {
        if(isset($insertTypes)) {
            if(!call_user_func_array(array($stmt, "bind_param"), array_merge(array($insertTypes), $insertValues))){
                $stmt->close();
                return [];
            }
        }
        if($stmt->execute()) {
            if($result = $stmt->get_result()) {
                $size = 0;
                while(($row = $result->fetch_assoc()) && $size < ($QUERY_MAX_SIZE == -1 ? 100000000 : $QUERY_MAX_SIZE)){
                    $resultArray[] = $row;
                    $size++;
                }
                $result->close();
            } else {
                printf("Error message3: %s\n", $mysqli->error);
            }
        } else {
            printf("Error message2: %s\n", $mysqli->error);
        }
        $stmt->close();
    } else {
        printf("Error message1: %s\n", $mysqli->error);
    }
    return $resultArray;
}