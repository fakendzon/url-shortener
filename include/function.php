<?php

function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
}
/**
 * Возвращает случайную полследовательность из четырех символов
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
 * @param PDO $pdo 
 * @param string $field 
 * @param string $table 
 * @param string $column 
 * @param string $param 
 * @return string
 */
function get_val_From_Table(PDO $pdo, $field, $table, $column, $param) {
    $sql = "select $field from $table where $column = :param";
    $stmt = $pdo->prepare($sql);
    $params = array("param" => $param);
    $stmt->execute($params);
    $result = $stmt->fetch();
    // $result - это ассоциативный массив, необходимо значение первого элемента
    return $result ? array_values($result)[0] : null;
}

/**
 * Добавить короткий код в таблицу
 * 
 * Алгоритм работы:
 * - получить id, введенного url
 * - подготовить запрос в базу, который вставит полученный id и короткий код в таблицу коротких url
 * - создаем короткий код, отправляем его в sql запрос, если такой код уже был в таблице, получаем exception (так как поле уникальное)
 *   будем получать exception до тех пор пока код не станет уникальным
 *
 *
 * @param PDO $pdo 
 * @param string $url 
 * @param string $table 
 * @param string $shortTable 
 * @return string
 */
function add_Short_Url_In_Table(PDO $pdo, $url, $table, $shortTable) {
    $id = get_val_From_Table($pdo, 'id', $table, 'url', $url);
    $sql = "insert into $shortTable set id_url = $id, short_url = :short_code"; 
    $stmt = $pdo->prepare($sql);
    $i = 0;
    while ($i == 0) {
        try {
            $short_code = create_Short_Code();
            $params = array("short_code" => $short_code);
            $stmt->execute($params);
            $i++;
        } catch (Exception $e) {}
    }
    return $short_code;
}


