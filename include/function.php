<?php

function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
}

$urlExistsInDb = function ($url, $table, $column) use ($pdo) {
    $sql = "SELECT id, url from $table where $column = :url limit 1;";
    $stmt = $pdo->prepare($sql);
    $params = array(
        "url" => $url
    );
    $stmt->execute($params);
    $result = $stmt->fetch();
    return (empty($result)) ? false : $result;
};

function create_Short_Code($url) {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $length = strlen($alphabet);
    $shortCode = "";
    for ($i = 0; $i < 4; $i++) {
      $shortCode .= $alphabet[mt_rand(0, $length - 1)];
    }
    return $shortCode;
}

$createShortUrl = function ($url) use ($urlExistsInDb) {
    $urlInTable = $urlExistsInDb(createShortCode($url), 'short_urls', 'short_url');
    if ($urlInTable) {
        return createShortUrl($url);
    } 
    else {
        /* $sql = "insert into short_urls set short_url = $urlInTable, id_url = ". $urlExistsInDb($url, 'urls', 'url')['id'] .";"; */
        /* $stmt = $pdo->prepare($sql); */
        return $urlInTable;
    }
};

function add_Url_In_Table(PDO $pdo, $url, $table) {
    $sql = "INSERT INTO $table SET url = :url";
    $stmt = $pdo->prepare($sql);
    $params = array("url" => $url);
    $stmt->execute($params);
}

function get_val_From_Table(PDO $pdo, $field, $table, $column, $param) {
    $sql = "select $field from $table where $column = :param";
    $stmt = $pdo->prepare($sql);
    $params = array("param" => $param);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result ? array_values($result)[0] : null;
}

function add_Short_Url_In_Table(PDO $pdo, $url, $table, $shortTable) {
    $id = get_id_Url_From_Table($pdo, $url, $table);
    $sql = "insert into $shortTable set id_url = $id, short_url = :short_code"; 
    $stmt = $pdo->prepare($sql);
    try {
        $short_code = create_Short_Code($url);
        $params = array("short_code" => $short_code);
        $stmt->execute($params);
    } catch (Exception $e) {
        $short_code = create_Short_Code($url);
        $params = array("short_code" => $short_code);
        $stmt->execute($params);
    }
    return $short_code;
}


