<?php
/**
 * Configuración de rutas.
 *
 * En este archivo, configuras rutas a tus controladores y sus acciones.
 * Las rutas son un mecanismo muy importante que te permite conectar libremente
 * diferentes URLs a controladores seleccionados y sus acciones (funciones).
 *
 * Se carga dentro del contexto del método `Application::routes()` que
 * recibe una instancia de `RouteBuilder` `$routes` como argumento del método.
 *
 * CakePHP(tm) : Framework de Desarrollo Rápido (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licenciado bajo The MIT License
 * Para obtener información completa sobre derechos de autor y licencia, consulta LICENSE.txt
 * Las redistribuciones de archivos deben conservar el aviso de derechos de autor anterior.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org Proyecto CakePHP(tm)
 * @license       https://opensource.org/licenses/mit-license.php Licencia MIT
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

$routes->setRouteClass(DashedRoute::class);

// Nueva ruta que estamos agregando para nuestra acción etiquetada.
// El `*` al final indica a CakePHP que esta acción tiene
// parámetros pasados.

$routes->scope(
    '/bookmarks',
    ['controller' => 'Bookmarks'],
    function ($routes) {
        $routes->connect('/tagged/*', ['action' => 'tags']);
    }
);

$routes->scope('/', function ($routes) {
    // Connect the default home and /pages/* routes.
    $routes->connect('/', [
        'controller' => 'Pages',
        'action' => 'display', 'home'
    ]);
    $routes->connect('/pages/*', [
        'controller' => 'Pages',
        'action' => 'display'
    ]);

    // Connect the conventions based default routes.
    $routes->fallbacks();
});

/*
 * Este archivo se carga en el contexto de la clase `Application`.
 * Entonces puedes usar `$this` para hacer referencia a la instancia de la clase de la aplicación
 * si es necesario.
 */
return function (RouteBuilder $routes): void {
   /*
     * La clase predeterminada para usar en todas las rutas
     *
     * Las siguientes clases de ruta se suministran con CakePHP y son apropiadas
     * para establecer como predeterminadas:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * Si no se hace ninguna llamada a `Router::defaultRouteClass()`, la clase utilizada es
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Ten en cuenta que `Route` no realiza ninguna inflexión en las URL, lo que resultará en
     * URLs con mayúsculas y minúsculas de manera inconsistente cuando se usen con los marcadores `{plugin}`, `{controller}` y
     * `{action}`.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
