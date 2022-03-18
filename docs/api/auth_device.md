# Аутентификация
___
## Первый логин
<table>
    <tr>
        <th> Method </th>
        <th> URL </th>
    </tr>
    <tr>
        <td> POST </td>
        <td> /api/v1/TODO </td>
    </tr>
</table>

**Тело запроса**
```json
{    
  "login": "Логин/майл для входа",
  "password": "Пароль",
  "device_id": "Имя устройства"
}
```

**Ответ**
```json
{
  "access_token": "Токен доступа, строка",
  "access_token_expiration_time": "Время истечения токена, int->timestamp",
  "refresh_token": "Токен обновления, строка",
  "refresh_token_expiration_time": "Время истечения токена, int->timestamp"
}
```
___
## Последующие запросы
В заголовке запроса передаётся Bearer токен
<table>
<caption>Пример</caption>
    <tr>
        <th> KEY </th>
        <th> VALUE </th>
    </tr>
    <tr>
        <td> Authorization </td>
        <td> Bearer eyJ0eXAiOiJKV1QiLC... </td>
    </tr>
</table>

По истечению срока действия токена, ответ: TODO <br>
**status:** 401
```json
{
  "message": "access_token expired, please refresh it"
}
```
___
## Обновление токена
<table>
    <tr>
        <th> Method </th>
        <th> URL </th>
    </tr>
    <tr>
        <td> POST </td>
        <td> /api/v1/TODO </td>
    </tr>
</table>

**Тело запроса**
```json
{    
  "refresh_token": "Токен обновления, строка"
}
```
**Ответ: успех**
```json
{
  "access_token": "Токен доступа, строка",
  "access_token_expiration_time": "Время истечения токена, int->timestamp"
}
```
**Ответ: неудача**
**status: 401**
```json
{
  "message": "refresh_token expired, please login again"
}
```
