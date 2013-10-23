<?php
class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('ユーザー名かパスワードが違います。try again'));
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function view($id = null) {
		$this->user->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('ユーザーが違います'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('ユーザーはずびーんセーブ'));
				$this->redirect(array('controller' => 'posts', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('くどぅノットびーセーブ'));
			}
		}
	}

	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('ユーザー違います'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('セーブしました'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('セーブできません'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data{'User'}['password']);
		}
	}

	public function delete($id = null) {
		if(!$this->request->is('post')) {
			throw new MethodNotAllowException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('ユーザー違います'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('ユーザー削除しました。'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('削除できませんでした。'));
		$this->redirect(array('action' => 'index'));;
	}
}