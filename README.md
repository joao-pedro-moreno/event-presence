# Event Presence

O Event Presence é uma aplicação Web para registrar, gerenciar e anunciar eventos. O projeto foi desenvolvido inicialmente como um trabalho para a matéria ***Desenvolvimento Web***, na qual era necessário desenvolver um CRUD.

[Projeto Online](https://devs.nexusnx.com/moreno/event-presence)

## Tecnologias

Esse projeto foi desenvolvido com as seguintes tecnologias: 

- HTML 5
- CSS 3
- Javascript e jQuery
- PHP
- MySQL

## Instalação Local

- Instale o Apache, PHP e SQL ao seu modo (XAMPP, WampServer ou individual), instale o Git;

- No seu servidor privado baixe o projeto usando:

```bash
    git clone https://github.com/joao-pedro-moreno/event-presence.git
    cd event-presence
```

- Instale `event_presence.sql` no PHPMyAdmin;

- Crie um arquivo `config.php` dentro da pasta `php` e cole o código abaixo:

```php
    <?php
        define('DB_HOST', 'Host');
        define('DB_USER', 'Usuário');
        define('DB_PASSWORD', 'Senha');
        define('DB_NAME', 'Nome');
    ?>
```

- Caso tenha algum problema para configurar, renomeie o arquivo `configExample.php` para `config.php` e preencha com os dados necessários;