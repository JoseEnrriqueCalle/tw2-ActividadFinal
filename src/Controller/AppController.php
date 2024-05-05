<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Framework de Desarrollo Rápido (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licenciado bajo la Licencia MIT
 * Para obtener información completa sobre derechos de autor y licencia, consulte LICENSE.txt
 * Los redistribuciones de archivos deben conservar el aviso de derechos de autor anterior.
 *
 * @copyright Derechos de Autor (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org Proyecto CakePHP(tm)
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php Licencia MIT
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Controlador de Aplicación
 *
 * Agregue sus métodos de aplicación en toda la clase a continuación, sus controladores
 * los heredarán.
 *
 * @link https://book.cakephp.org/4/es/controllers.html#el-controlador-de-aplicacion
 */
class AppController extends Controller
{
    /**
     * Método de gancho de inicialización.
     *
     * Utilice este método para agregar código de inicialización común como cargar componentes.
     *
     * por ejemplo, `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
       

        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize'=> 'Controller', // agregué esta línea
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);
    
        // Permitir la acción de visualización para que nuestro controlador de páginas
        // continúe funcionando.
        $this->Auth->allow(['display']);


        
    }

    public function isAuthorized($user)
    {
        return false;
    }
}
