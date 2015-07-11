<!-- File: src/Template/Articles/index.ctp (delete links added) -->

<h1>Blog articles</h1>
<p><?= $this->Html->link('Add Article', array('action' => 'add')) ?></p>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>

<!-- Here's where we loop through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= $article->id ?></td>
        <td>
            <?= $this->Html->link($article->title, array('action' => 'view', $article->id)) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $article->id),
                array('confirm' => 'Are you sure?'))
            ?>
            <?= $this->Html->link('Edit', array('action' => 'edit', $article->id)) ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>