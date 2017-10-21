<?php

function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
}
/**
 * Возвращает случайную полследовательность четырех из символов
 * 
 * @return string
 */
function create_Short_Code() {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $length = strlen($alphabet);
    $shortCode = "";
    for ($i = 0; $i < 4; $i++) {
      $shortCode .= $alphabet[mt_rand(0, $length - 1)];
    }
    return $shortCode;
}

/**
 * Добавить url в таблицу
 * 
 * @param PDO $pdo 
 * @param string $url 
 * @param string $table Наименование таблицы
 */
function add_Url_In_Table(PDO $pdo, $url, $table) {
    $sql = "INSERT INTO $table SET url = :url";
    $stmt = $pdo->prepare($sql);
    $params = array("url" => $url);
    $stmt->execute($params);
}

/**
 * Получить значение из таблицы
 * 
 * Формируется sql запрос
 *
 * @param PDO $pdo 
 * @param string $field 
 * @param string $table 
 * @param string $column 
 * @param string $param 
 * @param string $url Параметр параметр функции
 * @return string
 */
function get_val_From_Table(PDO $pdo, $field, $table, $column, $param) {
    $sql = "select $field from $table where $column = :param";
    $stmt = $pdo->prepare($sql);
    $params = array("param" => $param);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result ? array_values($result)[0] : null;
}

/**
 * Краткое описание функции
 * 
 * Подробное описание функции, если необходимо 
 *
 * @param string $url Параметр параметр функции
 * @return string
 */
function add_Short_Url_In_Table(PDO $pdo, $url, $table, $shortTable) {
    $id = get_val_From_Table($pdo, 'id', $table, 'url', $url);
    $sql = "insert into $shortTable set id_url = $id, short_url = :short_code"; 
    $stmt = $pdo->prepare($sql);
    try {
        $short_code = create_Short_Code();
        $params = array("short_code" => $short_code);
        $stmt->execute($params);
    } catch (Exception $e) {
        $short_code = create_Short_Code();
        $params = array("short_code" => $short_code);
        $stmt->execute($params);
    }
    return $short_code;
}


