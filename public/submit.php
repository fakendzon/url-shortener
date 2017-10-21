<?php

include '../include/db.inc.php';
include '../include/function.php';

//Введенный пользоывателем url
$url = $_REQUEST["q"];

if (empty($url)) {
    throw new \Exception("No URL was supplied.");
}

if (validateUrl($url) == false) {
    throw new \Exception("URL does not have a valid format.");
}

//Добавить url в таблицу urls, если в таблице уже есть такой url, то получим exception
try {
    add_Url_In_Table($pdo, $url, 'urls');
} catch (Exception $e) {}

//Выводим короткий url, созадав о нем запись в таблице коротких url 
print_r($_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] .'/'. add_Short_Url_In_Table($pdo, $url, 'urls', 'short_urls'));
