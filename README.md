Skeleton API
=============
[![Build Status](https://travis-ci.org/mrprompt/silex-api-skel.svg)](https://travis-ci.org/mrprompt/silex-api-skel)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b337e834-dd26-46fd-ad35-82e2afbc5f7d/mini.png)](https://insight.sensiolabs.com/projects/b337e834-dd26-46fd-ad35-82e2afbc5f7d)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/3bfa93fd578d476ca60ece30655df9a8)](https://www.codacy.com/app/mrprompt/silex-api-skel)

API REST Skeleton

Instalação
==========
É necessário o PHP 7.0.x

## Extensões necessárias
- curl
- pdo
- reflection
- json
- xdebug (opcional)

## Instalação
Baixe o [Composer](https://getcomposer.org/)

```
composer.phar install --prefer-dist -o
```

## Rodando localmente
Você pode utilizar o [servidor web embutido](http://php.net/manual/pt_BR/features.commandline.webserver.php) no [PHP](http://www.php.net)
para rodar localmente a API. Ou se preferir, configurar seu servidor web preferido apontando para a pasta *public*.
```
php -S localhost:8080 -t public
```

## Rodando em modo desenvolvimento
Rodar a API em modo de desenvolvimento, você deve definir a variável de ambiente *APPLICATION_ENV* com o valor *development*.
Caso a variável não esteja definida, o valor padrão é *production*.
Em modo de desenvolvimento, a aplicação irá mostrar todas as mensagens de erro e também de irá logar as mensagens de 
debug.
```
APPLICATION_ENV="development" php -S localhost:8080 -t public
```

## Testando
```
./vendor/bin/phpunit
```

## Rotas
- User
  - Url: /user/[1-10]
  - Método: GET

- User
  - Url: /user/
  - Método: GET
