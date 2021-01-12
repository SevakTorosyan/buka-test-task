### Выполнение тестовой задачи ###
#### Для запуска необходимо: ####
<ol>
<li> создать файл '.env' и заполнить поля по '.env.example'</li>
<li> в терминале выполнить команду `composer install`</li>
<li> в терминале выполнить команду `php yii migrate` и выполнить миграцию </li>
<li> в терминале выполнить команду `php yii serve` для запуска dev сервера</li>
<li> проверить работоспособность API :) </li>
</ol>

<a href='https://www.getpostman.com/collections/56f20f21b08b6c1325b5'>Коллекция в Postman</a>


#### Спецификация методов API ####

<ol>
<li>
    <b>GET</b> /catalogs <br>
    Response: <br>
    <code>
    [<br>
      &nbsp;&nbsp;&nbsp;&nbsp;{"id": int, "title": string, "depth": int},<br>
      &nbsp;&nbsp;&nbsp;&nbsp;{...},<br>
      &nbsp;&nbsp;&nbsp;&nbsp;{...}<br>
    ]
    </code>
</li>
<li>
    <b>POST</b> /catalogs <br>
    Request body (Raw JSON): <br>
    <code>
    {<br>
        &nbsp;&nbsp;&nbsp;&nbsp;"parent_id": <int> (required),<br>
        &nbsp;&nbsp;&nbsp;&nbsp;"title": <string> (required)<br>
    }
    </code>
</li>
<li>
    <b>DELETE</b> /catalogs/{id} <br>
</li>
<li>
    <b>PATCH</b> /catalogs/{id} <br>
    Request body (Raw JSON): <br>
        <code>
        {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;"parent_id": "int",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;"title": "string"<br>
        }
        </code>
</li>
</ol>
