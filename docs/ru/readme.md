# SymfonyApi

SymfonyApi сборка для создания REST API с авторской конфигурацией. 

Документация (EN) [здесь][doc].

## Настройка

SymfonyApi это сборка [symfony/skeleton][symfonySkeleton], с подключенными бандлами 
[api-platform][apiPlatform], [gedmo][gedmo] и [jwt-authentication-bundle][jwt].

[Полный список бандлов](#bundles) 

### Установка

Создание приложения с помощью [Composer][composer]
```bash
composer create-project ftm-pm/symfony-api my-project
```

### Конфигурация

Указываем переменные окружения для приложения.

Запускаем команду для создания базы. 
```bash
php bin/console d:s:u --force
```

В приложении по умолчанию реализована авторизация пользователя с помощью JWT. Документация по бандлу реализующему 
 JWT [здесь][jwt]. 
Для создания пользователя можете использовать любой REST client, отправив post запрос 
на http://my-project/api/register с данными:
```json
{
  "username": "johndoe",
  "password": "test",
  "email": "johndoe@example.com"
}
```

или используя curl
```bash
curl -X POST http://my-project/api/register -d username=johndoe -d password=test -d email=johndoe@example.com
```
После подтверждения email, получаем токен отправляя запрос http://my-project/api/token/get:
```json
{
  "username": "johndoe",
  "password": "test"
}
```

или используя curl
```bash
curl -X POST http://my-project/api/token/get -d username=johndoe -d password=test
```

SymfonyApi вернет 2 текстовых поля: 
```json
{
  "token": "...",
  "refresh_token": "..."
}
```

## Использование

Для авторизации в приложении отправляем заголовок: Authorization: Bearer your_token.

REST API в SymfonyApi реализовано с помощью бандла api-platform. Подробную документацию по 
использованию данного бандла можно посмотреть [здесь][apiPlatformDoc]. 
В частности часто встречающиеся задачи:
* Настройка авторизации
* Нормализация/Денормализация
* Получения разных проекций (набора возвращаемых полей)
* Создание слушателей, событий, помощников и обработчиков

### Особенности SymfonyApi

SymfonyApi включает в себя следующие особенности:
* Контроллер авторизации, регистрации
* Предоставляет мультиязычность
* Интегрирован с проектом [media-server][mediaServer]

#### Пользователь и авторизация

Для организации пользователей на сайте не используется [FOSUserBundle][fosUser]. Портирована лишь самая необходимая часть 
связанная с авторизацией, и пропущены все части, связанные с событиями, личными кабинетами, и прочей
ненужной информацией.

Если необходимо использовать FOSUserBundle, можно удалить все файлы связанные с пользователем, и 
подключить FOSUserBundle и не забыть сконфигурировать security.yaml.

Для авторизации используется модель JWT, используемая в api-platform.

#### Мультиязычность

[Gedmo Translatable][gedmoTtranslatable] реализует мультиязычностьв проекте. Для того, чтобы
api-platform возвращала ``translations`` - поле c переводами, необходимо, чтобы класс сущности
имплементировал интерфейс Gedmo\Translatable\Translatable.  Поле перевода будет иметь вид:
```json
{
  "translations": {
     "ru": {
        "field1": "value1",
        "field2": "value2"
     },
     "en": {
         "field1": "value1"
     }
  }
}
``` 

Аналогично, для того, чтобы обработать и сохранить переводы, достаточно при запросе добавить
параметр ``translations``.

Стоит отметить, что Gedmo Translatable, не дублирует данные переводов. Если по-умолчанию в приложении
установлен английский язык, то в ``translations`` английского языка не будет (будет установлен в значении полей)
```json
{
  "name": "English Name",
  "translations": {
     "ru": {
        "name": "Russian Wonderful Name"
     }
  }
}
``` 
Это можно исправить, заставив явно дублировать данные в App\Handler\TranslationHandler в SymfonyApi. 

<a name="bundles"><h2>Что включено</h2></a>
* api-platform/core
* doctrine/annotations
* gedmo/doctrine-extensions
* gesdinet/jwt-refresh-token-bundle
* gfreeau/get-jwt-bundle
* guzzlehttp/guzzle
* lexik/jwt-authentication-bundle
* nelmio/cors-bundle
* symfony/asset
* symfony/console
* symfony/expression-language
* symfony/flex
* symfony/framework-bundle
* symfony/lts
* symfony/maker-bundle,
* symfony/orm-pack
* symfony/swiftmailer-bundle
* symfony/twig-bundleч
* symfony/validator
* symfony/yaml
         
## Обратная связь
 
* Создать issue в проекте
* Задать вопрос на [сайте](https://ftm.pm).
* Написать на почту fafnur@yandex.ru

Лицензия [MIT][license].

[symfonySkeleton]: https://github.com/symfony/skeleton
[apiPlatform]: https://github.com/api-platform/api-platform
[apiPlatformDoc]: https://api-platform.com/docs/core
[doc]: https://github.com/ftm-pm/symfony-api/blob/master/README.md
[gedmo]: https://github.com/Atlantic18/DoctrineExtensions
[gedmoTtranslatable]: https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/translatable.md
[jwt]: https://github.com/lexik/LexikJWTAuthenticationBundle
[composer]: https://getcomposer.org/
[license]: https://github.com/ftm-pm/media-server/blob/master/LICENSE.txt
[mediaServer]: https://github.com/ftm-pm/media-server
[fosUser]: https://github.com/FriendsOfSymfony/FOSUserBundle
