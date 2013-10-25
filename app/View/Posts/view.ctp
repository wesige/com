<!-- File: /app/View/Posts/view.ctp -->

<h1><?php echo h($post['Post']['title']); ?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>

<ul>
<?php foreach ($post['Comment'] as $comment): ?>
<li><?php echo h($comment['body']) ?> by <?php echo h($comment['commenter']); ?>
	    <?php if ($auth) : ?>
<?php
if ($comment['user_id'] == $user['id']){
echo $this->Form->postLink('さくじょ', array('controller' => 'comments', 'action'=>'delete', $comment['id']), array('confirm'=>'sure?'));
}
?>
    <?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
<h2>Add Comment</h2>
 <div>
    <?php if ($auth) : ?>
    <?php
echo $this->Form->create('Comment', array('action'=>'add'));
echo '投稿者: ';
echo $user['username'];
echo $this->Form->input('body', array('rows'=>3));
echo $this->Form->input('Comment.post_id', array('type'=>'hidden', 'value'=>$post['Post']['id']));
echo $this->Form->end('post comment');
	?>
    <?php else: ?>
    <P>ログインするとコメントできます</p>
    <?php endif; ?>
</div>
