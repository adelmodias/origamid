Recuperar o token de um usuário:
http://wordpressapi.local/wp-json/jwt-auth/v1/token - POST
`
{
    "username": "jose@outlook.com",
    "password": "123"
}
`

Recuperar as informações de um usuário
http://wordpressapi.local/wp-json/api/user - GET
Authorization: jwt-token

Criar um novo usuário
http://wordpressapi.local/wp-json/api/user - POST
`
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
`