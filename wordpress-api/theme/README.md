Recuperar o token de um usuário:

```
URL: http://wordpressapi.local/wp-json/jwt-auth/v1/token
METHOD: POST
BODY:
{
    "username": "jose@outlook.com",
    "password": "123"
}
```

Recuperar as informações de um usuário
```
URL: http://wordpressapi.local/wp-json/api/user
METHOD: GET
AUTH: Bearer jwt-token
```

Criar um novo usuário

```
URL: http://wordpressapi.local/wp-json/api/user
METHOD: POST
BODY:
{
    "name": "",
    "email": "",
    "senha": "",
    "rua": "",
    "cep": "",
    "numero": "",
    "bairro": "",
    "cidade": "",
    "estado": ""
}
```

Editar informações de um usuário

```
URL: http://wordpressapi.local/wp-json/api/user
METHOD: PUT
AUTH: Bearer jwt-token
BODY:
{
    "name": "",
    "email": "",
    "senha": "",
    "rua": "",
    "cep": "",
    "numero": "",
    "bairro": "",
    "cidade": "",
    "estado": ""
}
```
