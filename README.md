## Projeto SoftExpert

<div align="center" style="margin-bottom: 20px;">
</div>

<div align="center" style="margin: 20px;">

<p align="center" >
  <a href="#star-introduction"> :star: Introdução</a> |
  <a href="#rocket-technologies"> :rocket: Tecnologias</a> |
  <a href="#hammer-application-deploy"> :hammer: Implantação de aplicativo</a> |
  <a href="#computer-how-to-use"> :computer: Como usar </a> |
</p>

</div>

## :star: Introduction

Aplicativo para venda e cadastro de produtos
com modulo de imposto para controle de tarifas.

## :rocket: Technologies

Este projeto foi desenvolvido para teste técnico da empresa SoftExpert com as seguintes tecnologias:

- [PHP 8.1](https://www.php.net/)
- [Twig](https://twig.symfony.com/)
- [Dotenv PHP](https://github.com/vlucas/phpdotenv)
- [JWT](https://jwt.io/)
- [PHPUnit](https://phpunit.de/)
{...}

## :hammer: Implantação de aplicativo
{...}

## :computer: Como usar

#### Clonando o projeto
```sh
$ git clone https://github.com/dihgo01/mega_store.git
$ cd Mega_store
```
#### Iniciando a API
```sh
$ cd backend

# No projeto foi utilizado o PHP 8.1 recomendado utilizar a mesma versão

$ composer install  
# Crie um arquivo .env copie as infromaçoes do arquivo de exemplo(env.exemple) e cole no mesmo 

$ php -S localhost:8000 -t src

```

<a href="https://insomnia.rest/run/?label=gobarber-jvictorfarias&uri=https%3A%2F%2Fgithub.com%2Fjvictorfarias%2FGoBarber%2Fblob%2Fmaster%2Fapi%2Finsomnia.json" target="_blank"><img src="https://insomnia.rest/images/run.svg" alt="Run in Insomnia"></a>

#### Iniciando Front-end
```sh
$ cd frontend
$ composer install 
$ $ php -S localhost:8080
```

Feito com ♥ by Diego Candido :wave: [Get in touch!](https://www.linkedin.com/in/diego-c-c-s/)

[vc]: https://code.visualstudio.com/
[vceditconfig]: https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig
[vceslint]: https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint
