<?php
class Comment extends AppModel {
	public $belongsTo = array('Post','User');
	public function isOwnedBy($post, $user) {
		return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
	}
}