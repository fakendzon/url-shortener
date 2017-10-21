<?php

include 'include/db.inc.php';
include 'include/function.php';

/* echo "index.php \n"; */
/* print_r($_GET); */
/* echo $uri_data[1]; */
/* echo $_SERVER['HTTP_HOST']; */
/* echo $_SERVER['REQUEST_URI']; */
/* echo $_SERVER['PHP_SELF']; */
/* var_dump($_SERVER); */

/* include $_SERVER['DOCUMENT_ROOT'] . '/htdocs/songs/url-shortener/include/index.html'; */
//если короткий то переводить
/* print_r($_SERVER); */
/* print_r($_SERVER['REQUEST_URI']); */
/* print_r($_SERVER["REDIRECT_QUERY"]); */
/* print_r($_GET); */

//получаем 
$arReq = explode('/', $_SERVER['REQUEST_URI']);
$req = end($arReq);
if ($req) {
}
echo "-------------------------------------".$req;
/* print_r(get_val_From_Table($pdo, 'id', 'short_urls', 'short_url', $req)); */
/* echo 'test'; */
$id_short_url_in_table = get_val_From_Table($pdo, 'id', 'short_urls', 'short_url', $req);
if ($id_short_url_in_table) {
    $id_url_in_short_urls = get_val_From_Table($pdo, 'id_url', 'short_urls', 'id', $id_short_url_in_table);
    $real_url = get_val_From_Table($pdo, 'url', 'urls', 'id', $id_url_in_short_urls);
    header("Location: ". $real_url);
    exit();
} else {
    include 'include/index.html';
}
