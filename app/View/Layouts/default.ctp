<?php echo $this->Html->doctype(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array('../bootstrap/css/bootstrap.min', '../bootstrap/css/bootstrap-responsive.min', 'NiceAdmin.pagination',  'style'));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=0.9">
    </head>
    <body>
        <div class="container-fluid">
            <header class="row-fluid">
                <div class="span12">
                    <?php echo $this->Html->link("<h1>UKWM Ping-Pong</h1>", '/', array('class'=>'logo', 'escape'=>false)); ?>
                    <?php echo $this->element('navigation');?>
                </div>
            </header>
            <div class="row-fluid">
                <div class="span12">
                    <div class="content">
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->fetch('content'); ?>
                    </div>
                </div>
            </div>
            <footer class="row-fluid">
                <div class="span12">

                </div>
            </footer>
        </div>

        <?php
        echo $this->Html->script(array('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', 'common'));
        echo $this->fetch('script');
        ?>
    </body>
</html>
