<?php

/* include $_SERVER['DOCUMENT_ROOT'] . '/htdocs/songs/url-shortener/include/db.inc.php'; */
/* include $_SERVER['DOCUMENT_ROOT'] . '/htdocs/songs/url-shortener/include/function.php'; */
include '../include/db.inc.php';
include '../include/function.php';

$url = $_REQUEST["q"];

/* if ($url == 'a') { */
/*     header("HTTP/1.1 301 Moved Permanently"); */
    /* header("Location: " . $_SERVER['HTTP_HOST']); */
    /* exit(); */
/* } */

if (empty($url)) {
    throw new \Exception("No URL was supplied.");
}

if (validateUrl($url) == false) {
    throw new \Exception("URL does not have a valid format.");
}
/* print_r($createShortUrl($url)); */

try {
    add_Url_In_Table($pdo, $url, 'urls');
} catch (Exception $e) {}
echo "\n";
/* echo get_id_Url_From_Table($pdo, $url, 'urls', 'url'); */

/* print_r($_SERVER['HTTP_REFERER'] . add_Short_Url_In_Table($pdo, $url, 'urls', 'short_urls')); */

//Написать функцию для выбоки универсальную

//Игнорировать ошибку:
//пхп на функцию или пдо 
//может отключить вообще все ошибки для пользователя
//ввод url
//выборка из базы его id
//вставка во вторую таблицу
//с проверкой существования короткого кода, может быть через функуцию лучше, так как делается всего один запрос
//а первое что должно происходить при переходе на сайт - перевод пользователя по url, если такой есть
//Функции запросов писать конкрентые на каждый случай, если писать общие то получается уже моя API
//не показывать index.php
