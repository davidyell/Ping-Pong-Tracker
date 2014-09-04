<div class="players head_to_head">
	<h2>Head to head</h2>

	<?php
	echo $this->Form->create();
		echo $this->Form->input('player1', array('type' => 'select', 'options' => $playerList, 'div' => array('class' => 'input select player1'), 'after' => '&nbsp;vs&nbsp;'));
		echo $this->Form->input('player2', array('type' => 'select', 'options' => $playerList, 'div' => array('class' => 'input select player2')));
		?><div class="clearfix"><!-- blank --></div><?php
	echo $this->Form->end('Compare');
	?>

	<?php if (isset($players)):?>
		<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped comparison">
			<tr>
				<th scope="col">&nbsp;</th>
				<td>
					<h4>
					<?php

					echo "<span class='gravatar'>" . $this->Gravatar->image($players[0]['Player']['email'], array('s' => 32, 'd' => 'wavatar')) . "</span>";

					$name = h($players[0]['Player']['first_name']);
					if (!empty($players[0]['Player']['nickname'])) {
						$name .= ' "' . $players[0]['Player']['nickname'] . '"';
					}
					$name .= ' ' . h($players[0]['Player']['last_name']);

					echo $this->Html->link($name, array('controller' => 'players', 'action' => 'view', $players[0]['Player']['id']));

					if ($players[0][0]['wins'] > $players[1][0]['wins']) {
						echo $this->Html->image('gold_star_medal_32.png', array('title' => 'Winner', 'alt' => 'Gold star medal')) . " ";
					}
					?>
					</h4>
				</td>
				<td>
					<h4>
					<?php
					echo "<span class='gravatar'>" . $this->Gravatar->image($players[1]['Player']['email'], array('s' => 32, 'd' => 'wavatar')) . "</span>";

					$name = h($players[1]['Player']['first_name']);
					if (!empty($players[1]['Player']['nickname'])) {
						$name .= ' "' . $players[1]['Player']['nickname'] . '"';
					}
					$name .= ' ' . h($players[1]['Player']['last_name']);

					echo $this->Html->link($name, array('controller' => 'players', 'action' => 'view', $players[1]['Player']['id']));

					if ($players[1][0]['wins'] > $players[0][0]['wins']) {
						echo $this->Html->image('gold_star_medal_32.png', array('title' => 'Winner', 'alt' => 'Gold star medal')) . " ";
					}
					?>
					</h4>
				</td>
			</tr>
			<tr>
				<th scope="col">Wins</th>
				<td><?php echo $players[0][0]['wins']; ?></td>
				<td><?php echo $players[1][0]['wins']; ?></td>
			</tr>
			<tr>
				<th scope="col">Losses</th>
				<td><?php echo $players[0][0]['losses']; ?></td>
				<td><?php echo $players[1][0]['losses']; ?></td>
			</tr>
			<tr>
				<th scope="col">Points difference</th>
				<td><?php echo $players[0][0]['diff']; ?></td>
				<td><?php echo $players[1][0]['diff']; ?></td>
			</tr>
			<tr>
				<th scope="col">Matches played</th>
				<td><?php echo $players[0][0]['total_matches']; ?></td>
				<td><?php echo $players[1][0]['total_matches']; ?></td>
			</tr>
			<tr>
				<th scope="col">Total points</th>
				<td><?php echo $players[0][0]['total_score']; ?></td>
				<td><?php echo $players[1][0]['total_score']; ?></td>
			</tr>
			<tr>
				<th scope="col">Winning points</th>
				<td><?php echo $players[0][0]['win_points']; ?></td>
				<td><?php echo $players[1][0]['win_points']; ?></td>
			</tr>
			<tr>
				<th scope="col">Win percent</th>
				<td><?php echo $this->Number->precision($players[0][0]['win_percent'], 0); ?>%</td>
				<td><?php echo $this->Number->precision($players[1][0]['win_percent'], 0); ?>%</td>
			</tr>
			<tr>
				<th scope="col">Rating</th>
				<td><?php echo $this->Number->precision($players[0][0]['rank'], 2); ?></td>
				<td><?php echo $this->Number->precision($players[1][0]['rank'], 2); ?></td>
			</tr>
		</table>
	<?php endif;?>

	<div class="clearfix"><!-- blank --></div>
</div>