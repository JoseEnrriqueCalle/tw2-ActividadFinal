<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookmark $bookmark
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Acciones') ?></h4>
            <?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $bookmark->id],
                ['confirm' => __('¿Estás seguro de que deseas eliminar # {0}?', $bookmark->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Listar Marcadores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bookmarks form content">
            <?= $this->Form->create($bookmark) ?>
            <fieldset>
                <legend><?= __('Editar Marcador') ?></legend>
                <?php
                echo $this->Form->control('usuario', ['options' => $users]);

                    echo $this->Form->control('title', ['label' => __('Título')]);
                    echo $this->Form->control('description', ['label' => __('Descripción')]);
                    echo $this->Form->control('url', ['label' => __('URL')]);

                    // Se agrega esta línea
                    echo $this->Form->control('tags._ids', ['options' => $tags, 'label' => 'Etiquetas']);


                  
                ?>

            </fieldset>
            <?= $this->Form->button(__('Enviar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
