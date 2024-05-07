<?php
/**
 * Página web sobre libros con inicio de sesión
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
   <style>
    body {
        background-color: #f8f9fa;
        color: #333;
    }

    .top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 112rem;
        padding: 2rem;
        margin: 0 auto 2rem;
        background-color: #3ca0e5;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .top-nav-title a {
        font-size: 2.4rem;
        color: #fff;
        text-decoration: none;
    }

    .top-nav-title span {
        color: #f0f0f0;
    }

    
.top-nav-links a {
    margin: 0 0.5rem;
    color: #fff; /* Cambiar color de enlaces a blanco */
    text-decoration: none; /* Quitar subrayado */
    font-weight: bold;
}

    

    .side-nav-item {
        display: block;
        padding: 0.5rem 0;
    }

    .navbar {
        background-color: #3ca0e5 !important;
        
    }

    .navbar-brand, .nav-link {
        color: #fff !important;
    }

    .navbar-brand img {
        max-height: 60px;
    }

    .hero {
        background-color: #f0f0f0;
        padding: 100px 0;
    }

    .hero h1, .hero p {
        color: #333;
    }

    .btn-primary {
        background-color: #3ca0e5;
        border-color: #3ca0e5;
        border-radius: 20px;
    }

    .btn-primary:hover {
        background-color: #297aa0;
        border-color: #297aa0;
    }

    .about, .categories {
        padding: 50px 0;
    }

    .footer {
        background-color: #343a40;
        color: #fff;
        padding: 20px 0;
    }

    .footer p {
        margin-bottom: 0;
    }
</style>

</head>
<body>

<!-- Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="<?= $this->Url->webroot('img/icono.png') ?>" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8765/tags/">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8765/bookmarks/">Marcadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:8765/users/">Usuarios</a>
                    </li>
                </ul>
                <!-- Inicio de sesión / Cierre de sesión -->
                <div class="top-nav-links">
        <div class="navbar-login">
                    <?php if ($this->getRequest()->getSession()->check('Auth.User')): ?>
                        <!-- Verificar si el usuario está autenticado -->
                        Bienvenido, <?= $this->getRequest()->getSession()->read('Auth.User.email'); ?> |
                        <!-- Mostrar saludo y enlace de deslogueo -->
                        <?= $this->Html->link('Cerrar Sesión', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-outline-light']); ?>
                    <?php else: ?>
                        <!-- Si el usuario no está autenticado -->
                        <?= $this->Html->link('Ingresar', ['controller' => 'Users', 'action' => 'login'], ['class' => 'btn btn-outline-light']); ?>
                      
                    <?php endif; ?>
                </div>
        </div>
            </div>
        </div>
    </nav>
</header>
<!-- About Section -->
<section class="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="container text-center">
                    <h2>Acerca de nuestra biblioteca</h2>
                    <p>En nuestra biblioteca virtual, nos dedicamos a promover la lectura y el conocimiento a través de una amplia colección de libros en línea.</p>
                    <p>Explora nuestras categorías y descubre nuevas historias que te cautivarán.</p>
                    <a href="#" class="btn btn-primary">Conoce más</a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="<?= $this->Url->webroot('img/libro2.jpg') ?>" alt="libro2" class="img-fluid" style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="container text-center">
                    <h1>Bienvenido a nuestra Biblioteca Virtual</h1>
                    <p>Descubre una amplia selección de libros de diversos géneros y autores.</p>
                    <a href="#" class="btn btn-primary">Explorar libros</a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="<?= $this->Url->webroot('img/libro.jpg') ?>" alt="hero" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories">
    <div class="container">
        <div class="container text-center">
            <h1>Categorías Populares</h1>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= $this->Url->webroot('img/fiction.jpg') ?>" class="card-img-top" alt="Fiction">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ficción</strong></h5>
                        <p class="card-text">Sumérgete en mundos imaginarios y vive aventuras inolvidables con nuestra selección de libros de ficción.</p>
                        <a href="#" class="btn btn-primary">Ver libros de Ficción</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= $this->Url->webroot('img/non-fiction.jpg') ?>" class="card-img-top" alt="Non-fiction">
                    <div class="card-body">
                        <h5 class="card-title"><strong>No Ficción</strong></h5>
                        <p class="card-text">Descubre libros informativos y educativos que te ayudarán a ampliar tus conocimientos en diversos temas.</p>
                        <a href="#" class="btn btn-primary">Ver libros de No Ficción</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= $this->Url->webroot('img/science-fiction.jpg') ?>" class="card-img-top" alt="Science Fiction">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ciencia Ficción</strong></h5>
                        <p class="card-text">Explora futuros alternativos y tecnologías asombrosas en nuestra colección de ciencia ficción.</p>
                        <a href="#" class="btn btn-primary">Ver libros de Ciencia Ficción</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center">
        <p>&copy; 2024 Biblioteca Virtual. Todos los derechos reservados.</p>
    </div>
</footer>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
