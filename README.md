# SymfonyApi

The SymfonyApi is configured bundles for creating a REST API.

Russian documentation [here][doc].

## Setup

The SymfonyApi is a [symfony/skeleton][symfonySkeleton] application with bundles: 

* [api-platform][apiPlatform]
* [gedmo][gedmo]
* [jwt-authentication-bundle][jwt].
* [All bundles](#bundles) 

### Installation

Run the Composer command to create a new project
```bash
composer create-project ftm-pm/symfony-api my-project
```

### Configuration

After installing, you need to set environment variables. You can see variables in the .env file. 

Next step, run command to update database.
```bash
php bin/console d:s:u --force
```

In SymfonyApi, authorization was developed using JWT. You can see documentation [here][jwt].

For create a new user, you can use any REST client. You should send a new request to 
http://my-project/api/register with parameters:
```json
{
  "username": "johndoe",
  "password": "test",
  "email": "johndoe@example.com"
}
```

or using curl
```bash
curl -X POST http://my-project/api/register -d username=johndoe -d password=test -d email=johndoe@example.com
```
After the confirmation email, get token. Send a new request to `http://my-project/api/token`:
```json
{
  "username": "johndoe",
  "password": "test"
}
```

or using curl
```bash
curl -X POST http://my-project/api/token -d username=johndoe -d password=test
```

The SymfonyApi returns two fields: 
```json
{
  "token": "...",
  "id": "...",
  "refresh_token": "..."
}
```

For authorization, you must send header for any request: Authorization: Bearer your_token.

## Use

REST API on SymfonyApi developed with use api-platform bundle. You can see full documentation 
[here][apiPlatformDoc].

For example:
* The Serialization Process
* The Event System
* Data Providers
* Security
* and other

### Features SymfonyApi

SymfonyApi included:
* Authentication (login, register, getToken, refreshToken)
* Localization logic
* Integrated with [media-server][mediaServer] project

#### Authentication

For the organization of users on the application is not used [FOSUserBundle][fosUser]. 
The necessary part related to the user has been ported, and all parts related to events,
 personal accounts, and other unnecessary information have been skipped.

If you want to use FOSUserBundle, you can delete all files associated with the user 
 and include FOSUserBundle and configure security.yaml.

JWT is used for authentication. You can see documentation [here][apiPlatformDoc].

#### Localization

[Gedmo Translatable][gedmoTtranslatable] realizes localization on SymfonyApi. 
In order to the api-platform to return translations, the entity class must implement the 
Gedmo\Translatable\Translatable Interface.
  
The translation field will look like:
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

Similarly, to save translations, you must add the ``translations`` parameter to the query.

It should be noted that the Gedmo Translatable does not duplicate translations. 
If the application is set to English as the main language, the field `translations` 
English will not. For example:
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
This can be fixed by duplicate data into the App\Handler\Translation.

<a name="bundles"><h2>What's included</h2></a>
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
* symfony/twig-bundle
* symfony/validator
* symfony/yaml
         
## Feedback
 
* Create a new issue
* Ask a question on [сайте](https://ftm.pm).
* Send a message to fafnur@yandex.ru

License [MIT][license].

[symfonySkeleton]: https://github.com/symfony/skeleton
[apiPlatform]: https://github.com/api-platform/api-platform
[apiPlatformDoc]: https://api-platform.com/docs/core
[doc]: https://github.com/ftm-pm/symfony-api/blob/master/docs/ru/readme.md
[gedmo]: https://github.com/Atlantic18/DoctrineExtensions
[gedmoTtranslatable]: https://github.com/Atlantic18/DoctrineExtensions/blob/v2.4.x/doc/translatable.md
[jwt]: https://github.com/lexik/LexikJWTAuthenticationBundle
[composer]: https://getcomposer.org/
[license]: https://github.com/ftm-pm/media-server/blob/master/LICENSE.txt
[mediaServer]: https://github.com/ftm-pm/media-server
[fosUser]: https://github.com/FriendsOfSymfony/FOSUserBundle
