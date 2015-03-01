Skeleton API
=============

API RESTFull

Instalação
==========

É necessário o PHP 5.5.x

## Extensões necessárias
- curl
- pdo
- reflection
- json
- xdebug (opcional)

## Instalação
Baixe o [Composer](https://getcomposer.org/)

```
./vendor/bin/phing install
```

## O arquivo config.yml
Se tudo ocorreu bem, foi criado um arquivo chamado *config.yml* na pasta *config* do projeto, edite-o e preencha corretamente
todos os dados solicitados. Eles são imprescindíveis para o correto funcionamento da aplicação.

*Todos os parâmetros são obrigatórios.*

## Rodando localmente
Você pode utilizar o [servidor web embutido](http://php.net/manual/pt_BR/features.commandline.webserver.php) no [PHP](http://www.php.net)
para rodar localmente a API. Ou se preferir, configurar seu servidor web preferido apontando para a pasta *public*.
```
composer.phar run
```

## Rodando em modo desenvolvimento
Rodar a API em modo de desenvolvimento, você deve definir a variável de ambiente *APPLICATION_ENV* com o valor *development*.
Caso a variável não esteja definida, o valor padrão é *production*.
Em modo de desenvolvimento, a aplicação irá mostrar todas as mensagens de erro e também de irá logar as mensagens de 
debug.
```
export APPLICATION_ENV="development"
composer.phar run
```

## Testando
### ATENÇÃO: a base é totalmente limpa e são carregadas as fixtures antes dos testes, então, *NÃO EXECUTE EM PRODUÇÃO*.

```
./vendor/bin/phing test
```

## Rotas
- Home
  - Url: /
  - Método: GET

- User
  - Url: /user/[1-10]
  - Método: GET

- User
  - Url: /user/
  - Método: POST

- User
  - Url: /user/[1-10]
  - Método: DELETE

- User
  - Url: /user/[1-10]
  - Método: PUT
