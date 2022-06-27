# DDD Patterns - PHP

## Sobre o projeto

DDD Patterns - PHP é uma aplicação backend criada para estar desenvolvendo os conhecimentos adquiridos sobre DDD e também para ganhar experiência quanto a aplicação e usabilidade do Doctrine ORM.

## Como executar o projeto

```bash
    # Clonar o repositório com uma das opções abaixo
    git clone https://github.com/williamtrevisan/ddd-patterns-php.git
    git clone git@github.com:williamtrevisan/ddd-patterns-php.git
    
    # Entrar na pasta do projeto
    cd ddd-patterns-php
    
    # Subir o container do projeto
    docker-compose up -d
    
    # Acessar o container app
    docker-compose exec app bash
    
    # Instalar as dependências do projeto
    composer install
    
    # Para executar os testes
    ./vendor/bin/phpunit
```

## Tecnologias utilizadas

- PHP
- Doctrine ORM
- PHPUnit
- Mockery
- Docker

# Autor

William Trevisan

https://www.linkedin.com/in/william-trevisan/
