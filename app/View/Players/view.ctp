<div class="players view">
	<h2>
		<?php
		echo $this->element('player-avatar', array('player' => $player, 'size' => 100), array('cache' => array('config' => 'twoweeks', 'key' => 'player_' . $player['Player']['id'] . '_100')));

		echo h($player['Player']['first_name']);
		if (!empty($player['Player']['nickname'])) {
			echo ' "' . $player['Player']['nickname'] . '"';
		}
		echo ' ' . h($player['Player']['last_name']);
		?>
	</h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($player['Player']['id']); ?>
		</dd>
		<dt><?php echo __('Department'); ?></dt>
		<dd>
			<?php echo $this->Html->link($player['Department']['name'], array('controller' => 'departments', 'action' => 'view', $player['Department']['id'])); ?>
		</dd>
		<dt>Joined</dt>
		<dd>
			<?php echo $this->Time->niceShort($player['Player']['created']); ?>
		</dd>
		<dt>Latest victory</dt>
		<dd>
			<?php
			// Has won a match
			if (!empty($lastWin)) {
				$against = '';
				$losingTeam = Set::extract("/MatchesPlayer[result=Lost]", $lastWin);
				foreach ($losingTeam as $p) {
					$against .= $p['MatchesPlayer']['Player']['first_name'] . ' ' . substr($p['MatchesPlayer']['Player']['last_name'], 0, 1) . ' &amp; ';
				}
				$against = rtrim($against, "&amp; ");
				echo $this->Html->link("Won a <b>{$lastWin['MatchType']['name']}</b> match against <b>$against</b> " . $this->Time->niceShort($lastWin['Match']['created']), array('controller' => 'matches', 'action' => 'view', $lastWin['Match']['id']), array('escape' => false));
			} elseif ($results[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['total_score'] == 0) {
				// Hasn't scored any points
				echo "<p>Not played yet</p>";
			} else {
				// Has played, but not won any
				echo "<p class='winless'>Winless!</p>";
			}
			?>
		</dd>
		<dt>Latest defeat</dt>
		<dd>
			<?php
			// Has played, but not lost any matches
			if (!empty($lastLoss)) {
				$against = '';
				$winningTeam = Set::extract("/MatchesPlayer[result=Won]", $lastLoss);
				foreach ($winningTeam as $p) {
					$against .= $p['MatchesPlayer']['Player']['first_name'] . ' ' . substr($p['MatchesPlayer']['Player']['last_name'], 0, 1) . ' &amp; ';
				}
				$against = rtrim($against, "&amp; ");
				echo $this->Html->link("Lost a <b>{$lastLoss['MatchType']['name']}</b> match against <b>$against</b> " . $this->Time->niceShort($lastLoss['Match']['created']), array('controller' => 'matches', 'action' => 'view', $lastLoss['Match']['id']), array('escape' => false));
			} elseif ($results[0]['MatchesPlayer'][0]['MatchesPlayer'][0]['total_score'] == 0) {
				// Hasn't scored any points
				echo "<p>Not played yet</p>";
			} else {
				echo "<p class='undefeated'>Undefeated!</p>";
			}
			?>
		</dd>
		<dt>Match history</dt>
		<dd><?php echo $this->Html->link('View match history', array('controller' => 'matches', 'action' => 'match_history', $player['Player']['id']));?></dd>
		<dt>Singles performance rating</dt>
		<dd>
			<?php echo $player['Player']['performance_rating'];?>
		</dd>
		<dt>Win:Loss</dt>
		<dd>
			<?php echo $this->element('score-stats', array('stats' => $results[0]['MatchesPlayer'][0]['MatchesPlayer'][0])); ?>
		</dd>
	</dl>

	<div class="charts">
		<div id="wins_by_time"></div>
		<div id="rating_by_time"></div>

		<?php $this->Blocks->append('script');?>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
				google.load("visualization", "1", {packages:["corechart"]});

				function drawWinsChart() {

					items = [
						['Date','Wins','Losses'],
						<?php
						foreach ($winsbytime as $item) {
							?>
							['<?php echo $item[0]['day']?>', <?php echo $item[0]['wins']?>, <?php echo $item[0]['losses']?>],
							<?php
						}
						?>
					];

					var data = google.visualization.arrayToDataTable(items);

					var options = {
						title: 'Matches by day (30 days)',
						width: 600,
						height: 300
					};

					var chart = new google.visualization.AreaChart(document.getElementById('wins_by_time'));
					chart.draw(data, options);
				}

				function drawRatingChart() {
					items = [
						['Date', 'Rating'],
						<?php
						foreach ($ratingbytime as $item) {
							?>
							['<?php echo $this->Time->format('D jS M', $item[0]['day']);?>', <?php echo $item[0]['average'];?>],
							<?php
						}
						?>
					];

					var data = google.visualization.arrayToDataTable(items);

					var options = {
						legend: {position:'none'},
						title: 'Average single PR by day (30 days)',
						width: 600,
						height: 300
					};

					var chart = new google.visualization.AreaChart(document.getElementById('rating_by_time'));
					chart.draw(data, options);
				}

				google.setOnLoadCallback(function() {
					$(function(){

					   drawWinsChart();
					   drawRatingChart();

					});
				});
			</script>
		<?php $this->Blocks->end();?>
	</div>

	<div id="match_history">
		<h3>Last 10 matches</h3>
		<?php $this->set('matches', $this->requestAction(array('controller' => 'matches', 'action' => 'match_history', $player['Player']['id'])));?>
		<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Match type</th>
					<th>Players</th>
					<th>Played</th>
					<th class="hidden-phone">Notes</th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody id="matches-tbody">
				<?php echo $this->element('matches-index-table');?>
			</tbody>
		</table>
	</div>

</div>

