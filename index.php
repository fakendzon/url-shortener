<?php

include 'include/db.inc.php';
include 'include/function.php';

// Получаем последнюю часть после "/" запршиваемой страницы
$arReq = explode('/', $_SERVER['REQUEST_URI']);
$req = end($arReq);


if ($req) {

    //Проверка полученного значения на соответсвие формату короткого кода
    if (preg_match('/^[a-zA-Z0-9]{4}$/', $req)) {
        //Проверка наличия значения в таблице коротких url
        $id_short_url_in_table = get_val_From_Table($pdo, 'id', 'short_urls', 'short_url', $req);
        if ($id_short_url_in_table) {
            //Получаем id реального url из таблицы коротких url
            $id_url_in_short_urls = get_val_From_Table($pdo, 'id_url', 'short_urls', 'id', $id_short_url_in_table);
            //Получаем реальный url по id и переходим на эту сраницу
            $real_url = get_val_From_Table($pdo, 'url', 'urls', 'id', $id_url_in_short_urls);
            header("Location: ". $real_url);
            exit();
        }
    }
}
include 'include/index.html';
