# Symfony

1. [Crear proyecto de Symfony](#id1)

2. [Estructura proyecto Symfony](#id2)

3. [Controladores y Rutas](#id3)

3.1. [Crear Controladores](#id3.1)

3.2. [Rutas y acciones](#id3.2)

3.2. [Listar rutas en la consola](#id3.2n)

3.3. [Pasar parámetros opcionales con la url](#id3.3)

3.4. [Redirecciones](#id3.4)

4. [Vistas, Plantillas y Twig](#id4)

4.2. [Arrays](#id4.2)

4.3. [Estructuras de control](#id4.3)

4.4. [Funciones Predefinidas](#id4.4)

4.5. [Includes](#id4.5)

4.6. [Filtros | Pipes](#id4.6)

4.7. [Crear nuestro propio filtro](#id4.7)

5. [Bases de datos y Doctrine](#id5)

5.1. [Convertir mis Tablas a Entidades y Clases utilizables en Symfony](#id5.1.)



## 1. Crear proyecto de Symfony <a name="id1"></a>
1. Preparo mi PC
    * Instalo Xampp para correr apache en local
    * [Instalo PHP](https://www.php.net/manual/es/install.php) (en mi caso web platform installer de windows)
    * [Instalo composer](https://getcomposer.org/)

2. Creo mi proyecto de symfony al que llamo symfony-podcast dentro de C:\xampp\htdocs\symfony-project
    ```shell script
   composer create-project symfony/website-skeleton symfony-podcast
    ```
3. Instalo un paquete que me permite usar symfony en un servidor apache
     ```shell script
       cd my-symfony-app-name
       composer require symfony/apache-pack
      ```
4. Con xampp funcionando con Apache y SQL compruebo que funciona
 * http://localhost/symfony-project/symfony-podcast/public/
 
## 2. Estructura proyecto Symfony <a name="id2"></a>

* Carpeta bin
    * programas ejecutables de consola
        * pruebas unitarias
        * consola de symfony
        
* Carpeta config
    * configuraciones en general
    * packges: configuración de diferentes paquetes
    * routes: configuración de rutas del pryecto
    * bundle: si tienes que instalar un bundle de terceros se añade ahí
    * rputes.yaml: me permite establecer rutas
    * services: permite configurar diferentes eervicios
 
 * Public: carpeta de entrada al pruecto
 * src: la parte del código que vamos a estar tocando
    * controller: controladores
    * entity: carpeta para nuestros modelos
    * migrations: migraciones
    * repository: clases de tipo repositorio de consulta, vinculaadas al modelo, para programar ordenado
    
 * templates
    * Es donde tengo las vistas
    
 * test: test unitarios
 
 * translations
 
 * var: donde se guarda la caché y los logs
 
 * vendor: donde se instalan paquetes y dependencias
    * composer.json
        * donde se especifican las versiones de los paquetes
        
 
        
## 3. Controladores y Rutas <a name="id3"></a>

### 3.1. Crear Controladores <a name="id3.1"></a>
 
* Puedo ver los comandos disponibles usando: 
    ```shell script
    php bin/console help
    
    php bin/console list
    ```
* Los controladores se crean crean en src/controller
* Creo mi controlador HomeController: 
    ```shell script
    php bin/console make:controller HomeController
    ```
* Ahora podemos acceder a la ruta [http://localhost/symfony-project/symfony-podcast/public/home](http://localhost/symfony-project/symfony-podcast/public/home)
* la vista está en [templates/home/index.html.twig](symfony-podcast/templates/home/index.html.twig)
* por el [controlador](symfony-podcast/src/Controller/HomeController.php) puedo pasar código a la vista como hemos hecho con {{ helloWorld}}

### 3.2. Rutas y acciones <a name="id3.2"></a>

Vamos a generar las rutas en un fichero .yaml en lugar de hacerlo con los comentarios del controlador que dejan más sucio el código como:
```php
/**
     * @Route("/home", name="home")
     */
```
edito [config/routes.yaml](symfony-podcast/config/routes.yaml) que orginalmente aparece así
```yaml
#index:
#    path: /
#    controller: App\Controller\DefaultController::index
```
y lo dejamos así
```yaml
index:
    path: /inicio
    controller: App\Controller\HomeController::index
```
Ahora podemos usar la ruta [http://localhost/symfony-project/symfony-podcast/public/inicio](http://localhost/symfony-project/symfony-podcast/public/inicio)

Me creo una nueva función en mi [home controller](symfony-podcast/src/Controller/HomeController.php), una nueva vista [templates/home/animales.html.twig/](symfony-podcast/templates/home/animales.html.twig) y una nueva ruta animales en config/routes.yaml:
```yaml
index:
    path: /inicio
    controller: App\Controller\HomeController::index

animales:
    path: /animales
    controller: App\Controller\HomeController::animales
```
Ahora podemos acceder a través de:

[http://localhost/symfony-project/symfony-podcast/public/animales](http://localhost/symfony-project/symfony-podcast/public/animales)


####3.2. Listar rutas en la consola <a name="id3.2n"></a>
php bin/console debug:router

### 3.3. Pasar parámetros opcionales con la url: <a name="id3.3"></a>

En la ruta podemos dejar establecidos que parámetros opcionales como {nombre} podemos pasar por la barra del navegador:

Modifico la función de [HomeController](symfony-podcast/src/Controller/HomeController.php) para pasar como parámetro el nombre de un animal, también añado este parámetro a la vista [templates/home/animales.html.twig/](symfony-podcast/templates/home/animales.html.twig)
config/routes.yaml
```yaml
animales:
  path: /animales/{nombre?}/{apellidos} #la interrogación hace que el parámetro no sea obligatorio
  controller: App\Controller\HomeController::animales
  defaults: { nombre: 'Centauro', apellidos: 'Animal mitológico' } #nombre por defecto para cuando no pongo parámetro, ya no hace falta poner la interrogación
  methods: [ GET, POST ] #Puedo indicar lo métodos que acepta la ruta
  requirements:
    nombre: '[a-zA-z]+'
    apellidos: '[0-9]+' #de esta manera el apellido tiene que ser numérico
```

[http://localhost/symfony-project/symfony-podcast/public/animales/perrete](http://localhost/symfony-project/symfony-podcast/public/animales/perrete)


### 3.4. Redirecciones <a name="id3.4"></a>

* creo método redirigir en HomeController, creo ruta redirigir en routes.yaml:

routes.yaml
```yaml
redirigir1:
  path: /redirigir1
  controller: App\Controller\HomeController::redirigir1

redirigir2:
  path: /redirigir2
  controller: App\Controller\HomeController::redirigir2

redirigir3:
  path: /redirigir3
  controller: App\Controller\HomeController::redirigir3
```
HomeController.php
```php
    public function redirigir1(){
        return $this->redirectToRoute('index');
    }
    #http://localhost/symfony-project/symfony-podcast/public/redirigir1

    public function redirigir2(){
        return $this->redirectToRoute('animales', [ #esto me sirve para redirigir a animales pasándole parámetros)
            'nombre' => 'Minotauro',
            'apellidos' => '22'
        ]);
    }
    #http://localhost/symfony-project/symfony-podcast/public/redirigir2

    public function redirigir3(){
        return $this->redirect('http://www.angeldeveloper.es');
    }
    #http://localhost/symfony-project/symfony-podcast/public/redirigir3
```

## 4. Vistas, Plantillas y Twig <a name="id4"></a>

* Twig: motor de pantillas y de vistas predefinido de Symfony

* Platillas/Layouts: base.html.twig es una platilla predefinida de Symfony

* Dentro de templates me creo mi carpeta para plantillas, 'layouts'

templates/layouts/plantillaBase.html
```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>
        {% block titulo %} Angel Developer {% endblock %}- www.AngelDeveloper.es <!-- el contenido dentro de block lo puedo modificar, y pongo un contenido por defecto Angel Developer-->
    </title>
</head>
<body>
<div id="header">
    {%  block cabecera %}
        <h1> Cabecera de la plantilla </h1> <!-- contenido por defecto-->
    {% endblock %}
</div>

<section id="content">
    {% block contenido %}
        <p> Contenido por defecto</p>
    {% endblock %}
</section>

<footer>
    www.AngelDeveloper.es
</footer>
</body>
</html>
```


Para usar la plantilla en una de mis vistas uso extends:

animales.html.twig
```twig
{% extends 'layouts/plantillaBase.html.twig' %}
{# así hago que mi página herede la estructura de la plantilla #}

{% block titulo %}
    ANIMALES
{% endblock %}

{% block cabecera %}
    {{ parent() }} {# Parent hace que se vea el contenido predefinido que tenía en mi plantilla #}
    <h1>Animales</h1>
{% endblock %}

{% block contenido %}
    <h1>{{ title }}</h1>
    <h2> El nombre del animal es {{ nombre }} - {{ apellidos }}</h2>
    <hr>

    {# Podemos crear variables en dentro de la vista Twig #}

    {% set perro = 'Pastor Aleman' %}

    <h3> El nombre del animal es {{ perro }}</h3>


{% endblock %}
```

### 4.2. Arrays <a name="id4.2"></a>

HomeController.php
```php
    public  function animales($nombre, $apellidos){

        $title = 'Bienvenido a la página de Animales';
        $animales = array ('gallifante','comadreja','tortuga ninja','palomo cojo');
        $aves = array (
            'tipo' => 'periquito',
            'color' => 'verde',
            'edad' => 2,
            'raza' => 'agaporni');

        return $this->render('home/animales.html.twig',[ /*Le pasamos las variables a la vista*/
            'title' => $title,
            'nombre' => $nombre, //se lo pasamos a la vista,
            'apellidos' => $apellidos,
            'animales' => $animales,
            'aves' => $aves
        ]);
```


animales.html.twig
```twig
{% block contenido %}
    {# ... #}
    {# Trabajar con Arrays #}

    {{ dump(animales) }} {# veo el contenido de mi Array #}
    {{ animales[2] }}

    {# Arrays Asociativos #}

    {{ dump(aves) }}
    {{  aves.tipo ~ ' - ' ~ aves.raza}}
{% endblock %}
```

### 4.3. Estructuras de control <a name="id4.3"></a>

animales.html.twig
```twig
{% block contenido %}
 {# Condicionales #}

    {% if aves.tipo == 'periquito' %}
    <h3> Cuidado Periquito a la vista </h3>
    {%  else %}
    <h2> No hay periquitos a la vista </h2>
    {% endif %}

    {# Bucles #}
    {% if animales|length >= 0 %}
    <ul>
        {% for animal in animales%}
        <li>{{ animal }}</li>
        {% endfor %}
    </ul>
    {% endif %}

    {# Bucles - de un número a otro #}
    {% for i in 0..10 %}
        {{ i }}<br/>
    {% endfor %}

    {# Bucles - Starts Ends#}
    {% if aves.color starts with "ve" %}
      <h4>El color del ave empieza por "VE"</h4>
    {% endif %}

    {% if aves.color ends with "e" %}
        <h4> El color del ave acaba en "E"</h4>
    {% endif %}



{% endblock %}
```

### 4.4. Funciones Predefinidas <a name="id4.4"></a>

animales.html.twig
```twig
{% block contenido %}
     {# Funciones Predefinidas #}
     <hr>
     <h2>Funciones Predefinidas</h2>
     <p>El min de mis números es {{ min([9,1,3,4,123,-2]) }}</p>
     <p>El número random de mis números es {{ random([9,1,3,4,123,-2]) }}</p>
     <p>El número max de mis números es {{ max([9,1,3,4,123,-2]) }}</p>
     {% set misNumeros = [9,1,3,4,123,-2] %}
     <p>El dump de misNumeros es {{ dump(misNumeros) }}</p>
 
 
     {% for i in range(-10,0, 2) %} {# El tercer parametro me indica los numeros que se salta en cada iteración #}
         {{ i }} <br/>
     {% endfor %}
{% endblock %}
```

### 4.5. Includes <a name="id4.5"></a>

* Cuando queremos tener un trozo de código que vamos a reutilizar en varios sitios
* me creo templates/partials para meter las partes de código que he creado previamente en archivos independientes usando includes


templates/partials/includeEjemplo.html.twig
```twig
<hr>
<h1> Este es mi archivo includeEjemplo.html.twig y lo estoy mostrando usando include</h1>
<h2> {{ miParametro }} es un parámetro que he elegido yo </h2>
```
animales.html.twig
```twig
{% block contenido %}
 {# Include #}

    {{ include ("partials/includeEjemplo.html.twig", {'miParametro':'www.AngelDeveloper.es'}) }}

{% endblock %}
```
### 4.6. Filtros | Pipes <a name="id4.6"></a>

[Documentación Twig](https://twig.symfony.com/doc/3.x/filters/index.html)


animales.html.twig
```twig
    {# Filtros | Pipes #}
    <a href="https://twig.symfony.com/doc/3.x/filters/index.html"><h2>Filtros | Pipes</h2></a>
    <ul>
        <li> animales|length es {{ animales|length }}</li>
        <li> animales|first es {{ animales|first }}</li>
        <li> animales|last es {{ animales|last }}</li>
        <li> animales|join es {{ animales|join }}</li>
        <li> animales|json_encode es {{ animales|json_encode }}</li>

    </ul>

    <h3>trim y upper</h3>
    {% set email = '    info@angeldeveloper.es  ' %}

    <p> dump(email)</p>
    {{ dump(email) }}
    <p> vs dump(email|trim|upper)</p>
    {{ dump(email|trim|upper) }}
```

### 4.7. Crear nuestro propio filtro <a name="id4.7"></a>

* Creamos carpeta src/twig
* Creamos nuestro filtro a través de la consola de comandos en la carpeta de nuestra app:
```shell script
php bin/console make:twig-extension MiFiltro
```
* Me crea src/Twig/MiFiltroExtension.php
    * genera las funciones getFilters(), getFunctions y doSomething
    
* Transformo la función doSomething() en multiplicar() y pongo código para mostrar la tabla de multiplicar
* Tengo que llevarme esta función a mis servicios para poder usarla:
    config/services.yaml --> introducimos el siguiente código
    ```yaml
      App\Twig\:
          resource: '../src/Twig/'
          tags: [ 'twig.extension' ]
    ```
 animales.html.twig
 ```twig
     {# Filtros Personalizados #}
         <h2>Extensiones personalizadas</h2>
         {{ multiplicar(2) | raw }} {# aplico el filtro raw para que me salga el html formateado#}
         <hr>
         {{ multiplicar(23) | raw }} {# aplico el filtro raw para que me salga el html formateado#}
         <hr>
 ```

## 5. Bases de datos y Doctrine <a name="id5"></a>

* Doctrine es un ORM de Symfony ( un modelo de programación que permite mapear las estructuras de una base de datos relacional)
    * Genera diferentes clases que representan a cada uno de los registros de las tablas de las bases de datas.

* Las bases de datos se configuran en el fichero .env de la raiz del proyecto.
    * Aquí se configura Doctrine

.env --> configuración inicial que viene cuando instalamos Symfony en el apartado doctrine:
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```

* Cambiamos el usuario db_user por root
* Cambiamos db_password (la eliminamos porque no tiene password)
* Cambiamos el nombre de la base de datos por aprendiendo symfony
* finalmente me queda la siguiente linea de código:

```
DATABASE_URL="mysql://root@127.0.0.1:3306/aprendiendo-symfony?serverVersion=5.7"
```
* Instalamos [MySQL](https://dev.mysql.com/downloads/mysql/)
* Creamos la base de datos mencionada en [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/) con XAMPP, Apache y MySQL funcionando así como la primera tabla (podcast).
![phpMyAdmin](img/Captura%20de%20pantalla%202020-12-09%20190120.png)
* También lo podemos hacer por consola con el comando 
```
php bin/console doctrine:database:create
```

## 5.1. Convertir mis Tablas a Entidades y Clases utilizables en Symfony
```
php bin/console doctrine:mapping:convert --from-database yml ./src/Entity
```