# silex_app

Core montado en Silex, permite autenticación con Jira Desk Service mediante OAuth

Intrucciones:

Antes que todo es necesario utilizar el comando composer install (si es que esta instalado composer) o php composer.phar install (.phar)

1.- Crear Certificados para conexion con JIRA
    
    Para crear un certificado es necesario utilizar openssl

        openssl req -x509 -nodes -days 365 -newkey rsa:1024 -sha1 -subj '/C=US/ST=CA/L=Mountain View/CN=www.example.com' -keyout ~/myrsakey.pem -out ~/myrsacert.pem

    multiple linea

        openssl genrsa -out jira_privatekey.pem 1024
        openssl req -newkey rsa:1024 -x509 -key jira_privatekey.pem -out jira_publickey.cer -days 365
        openssl pkcs8 -topk8 -nocrypt -in jira_privatekey.pem -out jira_privatekey.pcks8
        openssl x509 -pubkey -noout -in jira_publickey.cer  > jira_publickey.pem

2.-Cambio proyecto Jira Desk Service

        Cada instancia de Jira Service Desk cuenta con una URL definida. Para realiazar el cambio para este caso hay que modificar algunas lineas dentro de web/index.php

        $oauth = new Atlassian\OAuthWrapper('https://test.atlassian.net/');
        $oauth->setPrivateKey('jira_privatekey.pem')
            ->setConsumerKey('KeyPass')

        KeyPass es la clave de conexión creada dentro de Jira Service Desk.