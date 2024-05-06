<?php
declare(strict_types=1);

namespace App\Controller;

class BookmarksController extends AppController
{
    // Mostrar una lista de marcadores del usuario actual
    public function index()
    {
        // Configuración de la paginación para mostrar los marcadores del usuario actual
        $this->paginate = [
            'conditions' => [
                'Bookmarks.user_id' => $this->Auth->user('id'),
            ]
        ];
        // Obtener y establecer los marcadores paginados
        $this->set('bookmarks', $this->paginate($this->Bookmarks));
        // Configurar la serialización para devolver datos en formato JSON
        $this->viewBuilder()->setOption('serialize', ['bookmarks']);
    }

    // Ver detalles de un marcador específico
    public function view($id = null)
    {
        // Obtener el marcador y sus asociaciones (usuarios y etiquetas)
        $bookmark = $this->Bookmarks->get($id, [
            'contain' => ['Users', 'Tags'],
        ]);
        // Pasar el marcador a la vista
        $this->set(compact('bookmark'));
    }

    // Agregar un nuevo marcador
    public function add()
    {
        // Crear una nueva entidad de marcador con los datos de la solicitud
        $bookmark = $this->Bookmarks->newEntity($this->request->getData());
        // Establecer el ID de usuario para el nuevo marcador
        $bookmark->user_id = $this->Auth->user('id');
        // Guardar el marcador si la solicitud es de tipo POST
        if ($this->request->is('post')) {
            if ($this->Bookmarks->save($bookmark)) {
                $this->Flash->success('El marcador ha sido guardado.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('El Marcador no pudo ser guardado intente de nuevo');
        }
        // Obtener la lista de etiquetas y usuarios para el formulario
        $tags = $this->Bookmarks->Tags->find('list')->all();
        $users = $this->Bookmarks->Users->find('list')->all();
        // Pasar las variables a la vista
        $this->set(compact('bookmark', 'tags', 'users'));
        // Configurar la serialización para devolver datos en formato JSON
        $this->viewBuilder()->setOption('serialize', ['bookmark']);
    }

    // Editar un marcador existente
    public function edit($id = null)
    {
        // Obtener el marcador y sus etiquetas asociadas
        $bookmark = $this->Bookmarks->get($id, [
            'contain' => ['Tags']
        ]);
        // Actualizar el marcador con los datos de la solicitud si es de tipo PATCH, POST o PUT
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bookmark = $this->Bookmarks->patchEntity($bookmark, $this->request->getData());
            $bookmark->user_id = $this->Auth->user('id');
            if ($this->Bookmarks->save($bookmark)) {
                $this->Flash->success('El marcador ha sido guardado.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('El Marcador no pudo ser guardado intente de nuevo');
        }
        // Obtener la lista de etiquetas y usuarios para el formulario
        $tags = $this->Bookmarks->Tags->find('list')->all();
        $users = $this->Bookmarks->Users->find('list')->all();
        // Pasar las variables a la vista
        $this->set(compact('bookmark', 'tags', 'users'));
        // Configurar la serialización para devolver datos en formato JSON
        $this->viewBuilder()->setOption('serialize', ['bookmark']);
    }

    // Eliminar un marcador existente
    public function delete($id = null)
    {
        // Permitir solo el método POST o DELETE
        $this->request->allowMethod(['post', 'delete']);
        // Obtener el marcador y eliminarlo
        $bookmark = $this->Bookmarks->get($id);
        if ($this->Bookmarks->delete($bookmark)) {
            $this->Flash->success(__('El Marcador ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El Marcador no pudo ser eliminado, intente de nuevo.'));
        }
        // Redirigir al índice de marcadores
        return $this->redirect(['action' => 'index']);
    }

    // Ver marcadores etiquetados con etiquetas específicas
    public function tags()
    {
        // Obtener las etiquetas de la URL
        $tags = $this->request->getParam('pass');

        // Encontrar los marcadores etiquetados con las etiquetas especificadas
        $bookmarks = $this->Bookmarks->find('tagged', [
            'tags' => $tags
        ])->all();

        // Pasar variables a la vista
        $this->set([
            'bookmarks' => $bookmarks,
            'tags' => $tags
        ]);
    }

    // Determinar si un usuario está autorizado para realizar una acción
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        // Permitir siempre las acciones de añadir, index y tags
        if (in_array($action, ['index', 'add', 'tags'])) {
            return true;
        }
        // Requerir un ID para todas las demás acciones
        if (!$this->request->getParam('pass.0')) {
            return false;
        }

        // Verificar que el marcador pertenece al usuario actual
        $id = $this->request->getParam('pass.0');
        $bookmark = $this->Bookmarks->get($id);
        if ($bookmark->user_id == $user['id']) {
            return true;
        }
        // Si no se cumple ninguna condición, utilizar la lógica de autorización predeterminada
        return parent::isAuthorized($user);
    }
}
