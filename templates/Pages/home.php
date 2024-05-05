<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        $connection = ConnectionManager::get($name);
        $connected = $connection->connect();
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
        if ($name === 'debug_kit') {
            $error = 'Try adding your current <b>top level domain</b> to the
                <a href="https://book.cakephp.org/debugkit/4/en/index.html#configuration" target="_blank">DebugKit.safeTld</a>
            config and reload.';
            if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
                $error .= '<br />You need to install the PHP extension <code>pdo_sqlite</code> so DebugKit can work properly.';
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;



?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        CakePHP: the rapid development PHP framework:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'home']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Cake</span>PHP</a>
        </div>
        <div id="header">
        <!--Pasos para la modificacion del Home.php para poder agregar botones o accesos a otras rutas del proyecto-->
        <?php if ($this->getRequest()->getSession()->check('Auth.User')): ?>
            <!-- Verificar si el usuario está autenticado -->
            Bienvenido, <?php echo $this->getRequest()->getSession()->read('Auth.User.email'); ?> |
            <!-- Mostrar saludo y enlace de deslogueo -->
            <?php echo $this->Html->link('Cerrar Sesion', ['controller' => 'Users', 'action' => 'logout']); ?>
        <?php else: ?>
            <!-- Si el usuario no está autenticado -->
            <?php echo $this->Html->link('Ingresar', ['controller' => 'Users', 'action' => 'login']); ?> |
            
        <?php endif; ?>
        </div>

    <div id="content">
        <?php echo $this->fetch('content'); ?>
    </div>
        <div class="top-nav-links">
            <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/">Documentation</a>
            <a target="_blank" rel="noopener" href="https://api.cakephp.org/">API</a>
        </div>
    </nav>
    <header>
        
    </header>
    <main class="main">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="column">

                    <!--Se agrego los botones con las rutas, en este caso solo redigira a bookmars ya que aun no tiene permisos para las otras rutas mas que esa
                1- tomar en cuenta que solo podran visualizar los bookmars creados por el usuario que ingrese,
                 si no tiene ningun bookmark creado no se visualizara nada -->
                    <nav id="menu" style="text-align: center; background-color: #ffffff; padding: 10px 0;">
                        <ul style="display: inline-block; padding-left: 0; margin: 0;">
                            <li style="display: inline-block; margin-right: 10px;">
                                <a href="http://localhost:8765/" style="text-decoration: none; color: #28a745; padding: 10px 20px; border-radius: 5px; background-color: #ffffff; border: 1px solid #28a745;">Inicio</a>
                            </li>
                            <li style="display: inline-block; margin-right: 10px;">
                                <a href="http://localhost:8765/users/" style="text-decoration: none; color: #28a745; padding: 10px 20px; border-radius: 5px; background-color: #ffffff; border: 1px solid #28a745;">Usuarios</a>
                            </li>
                            <li style="display: inline-block; margin-right: 10px;">
                                <a href="http://localhost:8765/tags/" style="text-decoration: none; color: #28a745; padding: 10px 20px; border-radius: 5px; background-color: #ffffff; border: 1px solid #28a745;">Tags</a>
                            </li>
                            <li style="display: inline-block;">
                                <a href="http://localhost:8765/bookmarks/" style="text-decoration: none; color: #28a745; padding: 10px 20px; border-radius: 5px; background-color: #ffffff; border: 1px solid #28a745;">Bookmarks</a>
                            </li>
                        </ul>
                    </nav>



                    <div class="container text-center">
                        <a href="https://cakephp.org/" target="_blank" rel="noopener">
                            <img alt="CakePHP" src="https://cakephp.org/v2/img/logos/CakePHP_Logo.svg" width="350" />
                        </a>
                        <h1>
                            Welcome to CakePHP <?= h(Configure::version()) ?> Strawberry (🍓)
                        </h1>
                     </div>


                     
                        <div class="message default text-center">
                            <small>Please be aware that this page will not be shown if you turn off debug mode unless you replace templates/Pages/home.php with your own version.</small>
                        </div>
                        <div id="url-rewriting-warning" style="padding: 1rem; background: #fcebea; color: #cc1f1a; border-color: #ef5753;">
                            <ul>
                                <li class="bullet problem">
                                    URL rewriting is not properly configured on your server.<br />
                                    1) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/installation.html#url-rewriting">Help me configure it</a><br />
                                    2) <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/development/configuration.html#general-configuration">I don't / can't use URL rewriting</a>
                                </li>
                            </ul>
                        </div>
                        <?php Debugger::checkSecurityKeys(); ?>
                    </div>
                </div>




                <div class="row">
                    <div class="column">
                        <h4>Entorno</h4>
                        <ul>
                            <?php if (version_compare(PHP_VERSION, '7.4.0', '>=')) : ?>
                                <li class="bullet success">Tu versión de PHP es 7.4.0 o superior (detectada <?= PHP_VERSION ?>).</li>
                            <?php else : ?>
                                <li class="bullet problem">Tu versión de PHP es demasiado baja. Necesitas PHP 7.4.0 o superior para usar CakePHP (detectada <?= PHP_VERSION ?>).</li>
                            <?php endif; ?>

                            <?php if (extension_loaded('mbstring')) : ?>
                                <li class="bullet success">Tu versión de PHP tiene cargada la extensión mbstring.</li>
                            <?php else : ?>
                                <li class="bullet problem">Tu versión de PHP NO tiene cargada la extensión mbstring.</li>
                            <?php endif; ?>

                            <?php if (extension_loaded('openssl')) : ?>
                                <li class="bullet success">Tu versión de PHP tiene cargada la extensión openssl.</li>
                            <?php elseif (extension_loaded('mcrypt')) : ?>
                                <li class="bullet success">Tu versión de PHP tiene cargada la extensión mcrypt.</li>
                            <?php else : ?>
                                <li class="bullet problem">Tu versión de PHP NO tiene cargadas las extensiones openssl o mcrypt.</li>
                            <?php endif; ?>

                            <?php if (extension_loaded('intl')) : ?>
                                <li class="bullet success">Tu versión de PHP tiene cargada la extensión intl.</li>
                            <?php else : ?>
                                <li class="bullet problem">Tu versión de PHP NO tiene cargada la extensión intl.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="column">
                    <h4>Sistema de archivos</h4>
                    <ul>
                        <?php if (is_writable(TMP)) : ?>
                            <li class="bullet success">Tu directorio tmp es escribible.</li>
                        <?php else : ?>
                            <li class="bullet problem">Tu directorio tmp NO es escribible.</li>
                        <?php endif; ?>

                        <?php if (is_writable(LOGS)) : ?>
                            <li class="bullet success">Tu directorio de logs es escribible.</li>
                        <?php else : ?>
                            <li class="bullet problem">Tu directorio de logs NO es escribible.</li>
                        <?php endif; ?>

                        <?php $settings = Cache::getConfig('_cake_core_'); ?>
                        <?php if (!empty($settings)) : ?>
                            <li class="bullet success">Se está utilizando <em><?= h($settings['className']) ?></em> para el almacenamiento en caché central. Para cambiar la configuración, edita config/app.php</li>
                        <?php else : ?>
                            <li class="bullet problem">Tu caché NO está funcionando. Por favor, verifica la configuración en config/app.php</li>
                        <?php endif; ?>
                    </ul>
                </div>


                </div>
                <hr>
                <div class="row">
                    <div class="column">
                        <h4>Database</h4>
                        <?php
                        $result = $checkConnection('default');
                        ?>
                        <ul>
                        <?php if ($result['connected']) : ?>
                            <li class="bullet success">CakePHP is able to connect to the database.</li>
                        <?php else : ?>
                            <li class="bullet problem">CakePHP is NOT able to connect to the database.<br /><?= h($result['error']) ?></li>
                        <?php endif; ?>
                        </ul>
                    </div>
                    <div class="column">
                        <h4>DebugKit</h4>
                        <ul>
                        <?php if (Plugin::isLoaded('DebugKit')) : ?>
                            <li class="bullet success">DebugKit is loaded.</li>
                            <?php
                            $result = $checkConnection('debug_kit');
                            ?>
                            <?php if ($result['connected']) : ?>
                                <li class="bullet success">DebugKit can connect to the database.</li>
                            <?php else : ?>
                                <li class="bullet problem">There are configuration problems present which need to be fixed:<br /><?= $result['error'] ?></li>
                            <?php endif; ?>
                        <?php else : ?>
                            <li class="bullet problem">DebugKit is <strong>not</strong> loaded.</li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="column links">
                        <h3>Getting Started</h3>
                        <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/">CakePHP Documentation</a>
                        <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/tutorials-and-examples/cms/installation.html">The 20 min CMS Tutorial</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="column links">
                        <h3>Help and Bug Reports</h3>
                        <a target="_blank" rel="noopener" href="irc://irc.freenode.net/cakephp">irc.freenode.net #cakephp</a>
                        <a target="_blank" rel="noopener" href="https://slack-invite.cakephp.org/">Slack</a>
                        <a target="_blank" rel="noopener" href="https://github.com/cakephp/cakephp/issues">CakePHP Issues</a>
                        <a target="_blank" rel="noopener" href="https://discourse.cakephp.org/">CakePHP Forum</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="column links">
                        <h3>Docs and Downloads</h3>
                        <a target="_blank" rel="noopener" href="https://api.cakephp.org/">CakePHP API</a>
                        <a target="_blank" rel="noopener" href="https://bakery.cakephp.org">The Bakery</a>
                        <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/en/">CakePHP Documentation</a>
                        <a target="_blank" rel="noopener" href="https://plugins.cakephp.org">CakePHP plugins repo</a>
                        <a target="_blank" rel="noopener" href="https://github.com/cakephp/">CakePHP Code</a>
                        <a target="_blank" rel="noopener" href="https://github.com/FriendsOfCake/awesome-cakephp">CakePHP Awesome List</a>
                        <a target="_blank" rel="noopener" href="https://www.cakephp.org">CakePHP</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="column links">
                        <h3>Training and Certification</h3>
                        <a target="_blank" rel="noopener" href="https://cakefoundation.org/">Cake Software Foundation</a>
                        <a target="_blank" rel="noopener" href="https://training.cakephp.org/">CakePHP Training</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>