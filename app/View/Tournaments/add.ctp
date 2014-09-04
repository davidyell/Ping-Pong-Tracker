<div class="tournament add">
	<h2>Add tournament</h2>

	<?php
	echo $this->Form->create();
	echo $this->Form->input('name');

	echo $this->Form->input('players', array('type' => 'select', 'multiple' => true, 'div' => array('class' => 'input select players')));

	echo "<div class='buttons'>";
		echo $this->Form->button('<i class="icon-arrow-right"></i>', array('type' => 'button', 'class' => 'add')) . "<br>";
		echo $this->Form->button('<i class="icon-arrow-left"></i>', array('type' => 'button', 'class' => 'remove'));
	echo "</div>";

	echo $this->Form->input('selected_players', array('type' => 'select', 'multiple' => true, 'div' => array('class' => 'input select selected_players')));

	echo "<div class='clearfix'><!--blank--></div>";

	echo $this->Html->link('Do bracket draw', '#bracketdraw', array('class' => 'btn', 'id' => 'dodraw'));
	?>

	<div id="draw"></div>

	<?php
	echo $this->Form->button('Save tournament & start playing!', array('class' => 'btn btn-large btn-primary', 'id' => 'save_tournament', 'style' => 'display:none'));

	echo $this->Form->end();
	?>

</div>