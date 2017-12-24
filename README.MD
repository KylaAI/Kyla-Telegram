# Kyla Telegram
Kyla telegram is framework for bot in Telegram.

## Installation
First time you must run this command in your terminal.

```bash
composer install
```

This code will install all requirement in this framework. After all done you must setting config framework in Config folder.

**Telegram.php**
```php
<?php
return [
    'hooks'=>'URL to root',
    'apikey'=>'Telegram API',
    'urltel'=>'https://api.telegram.org/bot',
    'username'=>'@botusername'
];
```
Hooks is for telegram send data to your server. You can get API key in Bot Father (@botfather) and create your bot. Bot Father will give you API Key.

**Database.php***
```php
<?php
return [
    'host'=>'HOST',
    'user'=>'USERNAME',
    'pass'=>'PASSWORD',
    'dbname'=>'DATABASE'
];
```
You must configure this file for connection to database.

After all done, you must give telegram hooks for telegram give post data.
Open it in your browser. 

```bash
URL/setHooks
```

You will get messages from telegram server if your config is correct.
