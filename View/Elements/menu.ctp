<?php foreach($menuItems as $title => $url): ?>
	<li><?php echo $this->Html->link($title, $url, array('class' => 'button'));?></li>
<?php endforeach;?>