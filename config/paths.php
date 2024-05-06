<?php
/**
 * CakePHP(tm) : Framework de Desarrollo Rápido (https://cakephp.org)
 * Derechos de Autor (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licenciado bajo la Licencia MIT
 * Las redistribuciones de archivos deben conservar el aviso de derechos de autor anterior.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org Proyecto CakePHP(tm)
 * @since         3.0.0
 * @license       Licencia MIT (https://opensource.org/licenses/mit-license.php)
 */

/*
 * Usa DS para separar los directorios en otros defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/*
 * Estos defines solo deben editarse si tiene CakePHP instalado en
 * un diseño de directorio diferente al que se distribuye.
 * Cuando utilice configuraciones personalizadas, asegúrese de usar DS y no agregar DS al final.
 */

/*
 * La ruta completa al directorio que contiene "src", SIN un DS al final.
 */
define('ROOT', dirname(__DIR__));

/*
 * El nombre de directorio real para el directorio de la aplicación. Normalmente
 * llamado 'src'.
 */
define('APP_DIR', 'src');

/*
 * Ruta al directorio de la aplicación.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/*
 * Ruta al directorio de configuración.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/*
 * Ruta de acceso al directorio webroot.
 *
 * Para derivar su webroot de su servidor web, cambie esto a:
 *
 * `define('WWW_ROOT', rtrim($_SERVER['DOCUMENT_ROOT'], DS) . DS);`
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/*
 * Ruta al directorio de pruebas.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/*
 * Ruta al directorio de archivos temporales.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/*
 * Ruta al directorio de registros.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/*
 * Ruta al directorio de archivos de caché. Puede compartirse entre hosts en una configuración de múltiples servidores.
 */
define('CACHE', TMP . 'cache' . DS);

/*
 * Ruta al directorio de recursos.
 */
define('RESOURCES', ROOT . DS . 'resources' . DS);

/*
 * La ruta absoluta al directorio "cake", SIN un DS al final.
 *
 * CakePHP siempre debe instalarse con composer, así que busque allí.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/*
 * Ruta al directorio de cake.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

/*
 * Agregue la ruta al directorio de traducciones en español
 */
define('LOCALES', RESOURCES . 'locales' . DS . 'es' . DS);

