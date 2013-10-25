    <?php
     
    class CommentsController extends AppController {
    	//ここから
    	public function isAuthorized($user) {
    // 登録済ユーザーは投稿できる
    if ($this->action === 'add') {
        return true;
    }

    // 投稿のオーナーは編集や削除ができる
    if (in_array($this->action, array('edit', 'delete'))) {
        $postId = $this->request->params['pass'][0];
        if ($this->Comment->isOwnedBy($postId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
}
//ここまで認証解除するためにcontrollerに挿入
    public $helpers = array('Html', 'Form');
    public function add() {
	if ($this->request->is('post')) {
		$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
		$this->request->data['Comment']['commenter'] = $this->Auth->user('username');
		if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash('Success!');
				$this->redirect(array('controller'=>'posts','action'=>'view',$this->data['Comment']['post_id']));
			} else {
				$this->Session->setFlash('failed!');
		}
		$this->Session->setFlash('failed!');
	}
}
   public function delete($id) {
    if ($this->request->is('get')) {
    throw new MethodNotAllowedException();
    }
    if ($this->request->is('post')) {       
        if ($this->Comment->delete($id)) {
        $this->Session->setFlash('Deleted!');
    /*$this->autoRender = false;
    $this->autoLayout = false;
    $response = array('id' => $id);
    $this->header('Content-Type: application/json');
    echo json_encode($response);
    exit();*/
        }
    }
    $this->redirect(array('controller'=>'posts', 'action'=>'index'));
    }
}
    