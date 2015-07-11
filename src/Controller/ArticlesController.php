<?php

namespace App\Controller;

class ArticlesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Flash'); // Include the FlashComponent
    }

public function isAuthorized($user)
{
    // All registered users can add articles
    if ($this->request->action === 'add') {
        return true;
    }

    // The owner of an article can edit and delete it
    if (in_array($this->request->action, array('edit', 'delete'))) {
        $articleId = (int)$this->request->params['pass'][0];
        if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
}

    public function index()
    {
        $this->set('articles', $this->Articles->find('all'));
    }

    public function view($id)
    {
        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }

public function add()
{
    $article = $this->Articles->newEntity();
    if ($this->request->is('post')) {
        $article = $this->Articles->patchEntity($article, $this->request->data);
        // Added this line
        $article->user_id = $this->Auth->user('id');
        // You could also do the following
        //$newData = ['user_id' => $this->Auth->user('id')];
        //$article = $this->Articles->patchEntity($article, $newData);
        if ($this->Articles->save($article)) {
            $this->Flash->success(__('Your article has been saved.'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Unable to add your article.'));
    }
    $this->set('article', $article);
}

    public function edit($id = null)
	{
    $article = $this->Articles->get($id);
    if ($this->request->is(array('post', 'put'))) {
        $this->Articles->patchEntity($article, $this->request->data);
        if ($this->Articles->save($article)) {
            $this->Flash->success(__('Your article has been updated.'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('Unable to update your article.'));
    }

    $this->set('article', $article);
}

public function delete($id)
{
    $this->request->allowMethod(array('post', 'delete'));

    $article = $this->Articles->get($id);
    if ($this->Articles->delete($article)) {
        $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
        return $this->redirect(array('action' => 'index'));
    }
}

}

?>