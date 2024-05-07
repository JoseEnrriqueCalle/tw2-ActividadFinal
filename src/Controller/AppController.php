<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Phinx\Db\Table\Index;

class AppController extends Controller
{
    // Función initialize para configurar el controlador
    public function initialize(): void
    {
        // Cargar el componente Flash para mostrar mensajes flash
        $this->loadComponent('Flash');

        // Cargar el componente Auth para la autenticación de usuarios
        $this->loadComponent('Auth', [
            // Configuración de la autorización y autenticación
            'authorize'=> 'Controller', // Autorizar mediante el método isAuthorized del controlador
            'authenticate' => [
                'Form' => [ // Utilizar autenticación mediante formulario
                    'fields' => [
                        'username' => 'email', // Nombre del campo de correo electrónico en el formulario
                        'password' => 'password' // Nombre del campo de contraseña en el formulario
                    ]
                ]
            ],
            'loginAction' => [ // Redirigir a esta acción si se solicita iniciar sesión
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer() // Redirigir a la página de referencia si el usuario no está autorizado
        ]);
    
        // Permitir la acción de visualización para que nuestro controlador de páginas
        // continúe funcionando.
        $this->Auth->allow();


       // [
       //     'display',
        //    'index',
        //    'view']
    }

    // Función isAuthorized para determinar si un usuario está autorizado para realizar una acción
    public function isAuthorized($user)
    {
        return false; // Por defecto, no se autoriza a ningún usuario
    }
}
