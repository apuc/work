## Installation

php init

composer install

//TODO make dev mode

php yii minify - enter every time scripts or styles change

### Settings

import database

migrations for comments extension:
https://github.com/yii2mod/yii2-comments

In **frontend/web/vue/.env.local**
change your app url

```js
VUE_APP_API_URL=YOUR_APP_URL
```

In **frontend/config/params-local.php**
```php
<?php
return [
'Cors_origin'=>['http://localhost:8080', 'http://localhost', 'localhost:8080', 'localhost', '*']
];
```

Change database connection in DATABASE_URL in **common/config/main-local.php**

cd frontend/web/vue

npm install

sh build.sh - билдится личный кабинет

### Tests

тестов нет но вы держитесь
