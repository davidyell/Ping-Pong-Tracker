<div class="pages home">
	<h1>Uk Web Media Ping-Pong Tracker</h1>

	<div class="buttons">
		<?php echo $this->Html->link('Add new match', array('controller'=>'matches','action'=>'add'), array('class'=>'btn btn-inverse btn-large'));?>
		<?php echo $this->Html->link('View matches', array('controller'=>'matches','action'=>'index'), array('class'=>'btn btn-inverse btn-large'));?>
		<?php echo $this->Html->link('Player profiles', array('controller'=>'players','action'=>'index'), array('class'=>'btn btn-inverse btn-large'));?>
		<div class="clearfix"><!-- blank --></div>
	</div>

	<p>Track your progress against the rest of the company by <?php echo $this->Html->link('logging your matches', array('controller'=>'matches','action'=>'add'));?> and track your performance throughout the season.</p>
</div>