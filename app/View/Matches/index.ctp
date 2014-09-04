<div class="matches index">
	<h2>Matches played <?php echo $this->Html->link('Auto reload', '#', array('title'=>'Auto reload page','class'=>'btn btn-small', 'id'=>'reload-page'));?></h2>

	<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
		<tr>
			<th><?php echo $this->Paginator->sort('match_type_id'); ?></th>
			<th>Players</th>
			<th><?php echo $this->Paginator->sort('created', 'Played'); ?></th>
			<th class="hidden-phone"><?php echo $this->Paginator->sort('notes'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
		<tbody id="matches-tbody">
			<?php echo $this->element('matches-index-table');?>
		</tbody>
	</table>

	<p class="hidden-phone">
		<?php
		echo $this->Paginator->counter(array(
			'format'=>__('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
		));
		?>
	</p>

	<div class="paging">
		<?php
		echo $this->Paginator->prev('< '.__('previous'), array(), null, array('class'=>'prev disabled'));
		echo $this->Paginator->numbers(array('separator'=>''));
		echo $this->Paginator->next(__('next').' >', array(), null, array('class'=>'next disabled'));
		?>
	</div>

	<?php $this->Blocks->append('script');?>
		<script type="text/javascript">
			$(function(){

				function reloadPage(){
					$('#matches-tbody').load('/matches');
				}

				var timer;

				$('#reload-page').toggle(function(e){
					e.preventDefault();
					$(this).toggleClass('btn-info');

					timer = window.setInterval(reloadPage, 5000);
				}, function(e){
					e.preventDefault();
					$(this).toggleClass('btn-info');

					window.clearInterval(timer);
				});

			});
		</script>
	<?php $this->Blocks->end();?>
</div>
