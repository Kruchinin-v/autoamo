
<?php

function getUser() {

    require('../../tokens/access_token.php');


    $subdomain = 'korolevadarya'; #Наш аккаунт - поддомен

    /* Формируем ссылку для запроса */
//    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/users?USER_LOGIN=karnavalnn@mail.ru&USER_HASH=a6952b1cb4dae7dcbaf37cf2b49903c999488691';
    $link = 'https://' . $subdomain . '.amocrm.ru/api/v4/users';

    $headers = [
        'Authorization: Bearer ' . $access_token
    ];

    $curl = curl_init();
    /* Устанавливаем необходимые опции для сеанса cURL */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    /* Вы также можете передать дополнительный HTTP-заголовок IF-MODIFIED-SINCE, в котором указывается дата в формате D, d M Y
    H:i:s. При
    передаче этого заголовка будут возвращены сделки, изменённые позже этой даты. */
//curl_setopt($curl, CURLOPT_HTTPHEADER, array('IF-MODIFIED-SINCE: Mon, 01 Aug 2013 07:07:23'));
    /* Выполняем запрос к серверу. */
    $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */

    $code = (int) $code;
    $errors = array(
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    );
    try
    {
        /* Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке */
        if ($code != 200 && $code != 204) {
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        }
    } catch (Exception $E) {
        die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
    }
    /*
    Данные получаем в формате JSON, поэтому, для получения читаемых данных,
    нам придётся перевести ответ в формат, понятный PHP
    */
    $Response = json_decode($out, true);
    $Response = $Response['_embedded']['users'];//[0]['main_contact']['_links']['self']['href'];

   /* # получить гет строку с id контакта
    $id_contact = $Response[0]['main_contact']['_links']['self']['href'];
    # получить id ответственного
    $id_user = $Response[0]["responsible_user_id"];

    $id_contact =  explode('=',$id_contact);  # получение id контакта из get строки
    $id_contact = trim($id_contact[1],"'"); # Удаление лишней ' в конце*/

//    var_dump($Response);
//    echo $Response;

    $str = [];
    for ( $i = 0; $i < count($Response); $i++ ) {
        $str[] = $Response[$i]['id'] . " => " . $Response[$i]['name'];
    }

    return $str;
}
//$file = '/var/www/html/ovod-krv.ru/amo/users.json';
$b = getUser();
$a = var_export($b,true);
echo "<pre>$a</pre>";
//file_put_contents($file, $a);

//echo $a . " id \n";
