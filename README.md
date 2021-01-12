### Выполнение тестовой задачи ###
#### Для запуска необходимо: ####
<ol>
<li> создать файл '.env' и заполнить поля по '.env.example'</li>
<li> в терминале выполнить команду `composer install`</li>
<li> в терминале выполнить команду `php yii migrate` и выполнить миграцию </li>
<li> в терминале выполнить команду `php yii serve` для запуска dev сервера</li>
<li> проверить работоспособность API :) </li>
</ol>

#### Коллекция в Postman ####
https://www.getpostman.com/collections/56f20f21b08b6c1325b5

#### Спецификация методов API ####

<ol>
<li>
    **GET** /catalogs <br>
    Response: <br>
    [
      {"id": <number>, "title": <string>, "depth": <number>},
      {...},
      {...}
    ]
</li>
<li>
    **POST** /catalogs <br>
    Request body (Raw JSON): <br>
    `{
        "parent_id": <int> (required),
        "title": <string> (required)
    }`
</li>
<li>
    **DELETE** /catalogs/{id} <br>
</li>
<li>
    **PATCH** /catalogs/{id} <br>
    Request body (Raw JSON): <br>
        `{
            "parent_id": <int>,
            "title": <string>
        }`
</li>
</ol>
