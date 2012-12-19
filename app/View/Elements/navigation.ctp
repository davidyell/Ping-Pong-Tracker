<ul class="nav nav-tabs">
    <li <?php echo ($this->request->controller == 'matches' && $this->request->action == 'add')? 'class="active"' : '';?>>
        <?php echo $this->Html->link('Add match', array('controller'=>'matches','action'=>'add'));?>
    </li>
</ul>