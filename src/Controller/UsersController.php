<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Bookmarks'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido eliminado'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no ha sido eliminado intente de nuevo'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('El usuario ha sido eliminado'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no ha sido eliminado intente de nuevo'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('El usuario ha sido eliminado'));
        } else {
            $this->Flash->error(__('El usuario no ha sido eliminado intente de nuevo'));
        }

        return $this->redirect(['action' => 'index']);
    }



    //se agrega la funcion del login encargado de redirigir hacia un inicio de sesion para poder acceder a todas las funciones del crud
    public function login()
{
    // Verifica si la solicitud es de tipo POST
    if ($this->request->is('post')) {
        // Intenta identificar al usuario utilizando los datos del formulario
        $user = $this->Auth->identify();
        // Si se identifica al usuario correctamente
        if ($user) {
            // Establece al usuario como autenticado
            $this->Auth->setUser($user);
            // Redirige al usuario a la URL a la que intentaba acceder
            return $this->redirect($this->Auth->redirectUrl());
        }
        // Si el usuario no puede ser identificado, muestra un mensaje de error
        $this->Flash->error('Tu usuario o contraseña es incorrecta');
    }
    }// Método de inicialización
    public function initialize(): void
    {
        parent::initialize();
    
        // Permitir acceso a las acciones logout y add sin autenticación
        $this->Auth->allow(['logout', 'add']);
    }

    // Método para cerrar sesión
    public function logout()
    {
        // Muestra un mensaje de éxito
        $this->Flash->success('Se ha cerrado sesión.');
        // Redirige al usuario a la página de inicio de sesión
        return $this->redirect($this->Auth->logout());
    }

}
