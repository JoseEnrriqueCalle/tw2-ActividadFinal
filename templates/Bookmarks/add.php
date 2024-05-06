<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bookmark $bookmark
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Acciones') ?></h4>
            <?= $this->Html->link(__('Listar Marcadores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bookmarks form content">
            <?= $this->Form->create($bookmark) ?>
            <fieldset>
                <legend><?= __('Agregar Marcador') ?></legend>
                <?php
                    echo $this->Form->control('user', ['options' => $users, 'label' => 'Usuario']);
                    echo $this->Form->control('title', ['label' => 'Título']);
                    echo $this->Form->control('description', ['label' => 'Descripción']);
                    echo $this->Form->control('url', ['label' => 'URL']);
                    echo $this->Form->control('tags._ids', ['options' => $tags, 'label' => 'Etiquetas']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Enviar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
