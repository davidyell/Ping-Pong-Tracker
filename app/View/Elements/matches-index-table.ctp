<?php foreach ($matches as $match): ?>
	<tr>
		<td><?php echo h($match['MatchType']['name']); ?>&nbsp;</td>
		<td class="result">
			<?php
			$names = '';
			foreach ($match['MatchesPlayer'] as $player) {
				if ($player['result'] == 'Won') {
					$names .= "<span class='label label-success'>";
				} else {
					$names .= "<span class='label label-important'>";
				}
				$names .= $this->Html->link($player['Player']['first_name'] . ' ' . substr($player['Player']['last_name'], 0, 1), array('controller' => 'players', 'action' => 'view', $player['Player']['id']));
				$names .= "&nbsp;";
				$names .= $player['score'];
				$names .= "</span>";
				$names .= "&nbsp;v&nbsp;";
			}
			echo rtrim($names, "&nbsp;v&nbsp;");
			?>
		</td>
		<td><?php echo $this->Time->niceShort($match['Match']['created']); ?>&nbsp;</td>
		<td class="hidden-phone"><?php echo h($match['Match']['notes']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Actions->actions($match['Match']['id'], array('v'), 'matches'); ?>
		</td>
	</tr>
<?php endforeach;