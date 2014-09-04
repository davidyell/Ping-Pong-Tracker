<div class="matches view">
<h2><?php  echo __('Match'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($match['Match']['id']); ?>
			&nbsp;
		</dd>
				<dt>Match type</dt>
				<dd>
					<?php echo $match['MatchType']['name'];?>
				</dd>
		<dt>Played</dt>
		<dd>
			<?php echo $this->Time->niceShort($match['Match']['created']); ?>
			&nbsp;
		</dd>
				<?php if(!empty($match['Match']['notes'])):?>
					<dt><?php echo __('Notes'); ?></dt>
					<dd class="well">
							<?php echo h($match['Match']['notes']); ?>
							&nbsp;
					</dd>
				<?php endif;?>
				<dt>Players</dt>
				<dd>
					<div id="scorecard">
						<?php
						if($match['MatchType']['id'] == 1){
							echo $this->element('scorecard-singles');
						}else{
							echo $this->element('scorecard-doubles');
						}
						?>
					</div>
				</dd>
	</dl>
</div>

