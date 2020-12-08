## Crear proyecto de Symfony
1. Preparo mi PC
    * Instalo Xampp para correr apache en local
    * [Instalo PHP](https://www.php.net/manual/es/install.php) (en mi caso web platform installer de windows)
    * [Instalo composer](https://getcomposer.org/)

2. Creo mi proyecto de symfony dentro de C:\xampp\htdocs\symfony-project
    ```shell script
   composer create-project symfony/website-skeleton my-symfony-app-name
    ```
3. Instalo un paquete que me permite usar symfony en un servidor apache
     ```shell script
       cd my-symfony-app-name
       composer require symfony/apache-pack
      ```