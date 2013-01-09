<div class="players view">
    <h2>
        Player profile: <?php
        echo h($player['Player']['first_name']);
        if(!empty($player['Player']['nickname'])){
            echo ' "'.$player['Player']['nickname'].'"';
        }
        echo ' '.h($player['Player']['last_name']);
        ?>
    </h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($player['Player']['id']); ?>
        </dd>
        <dt><?php echo __('Department'); ?></dt>
        <dd>
            <?php echo $this->Html->link($player['Department']['name'], array('controller'=>'departments', 'action'=>'view', $player['Department']['id'])); ?>
        </dd>
        <dt>Joined</dt>
        <dd>
            <?php echo $this->Time->niceShort($player['Player']['created']); ?>
        </dd>
        <dt>Latest victory</dt>
        <dd>
            <?php
            // Has won a match
            if(!empty($last_win)){
                $against = '';
                $losing_team = Set::extract("/MatchesPlayer[result=Lost]", $last_win);
                foreach($losing_team as $p){
                    $against .= $p['MatchesPlayer']['Player']['first_name'].' '.substr($p['MatchesPlayer']['Player']['last_name'], 0, 1).' &amp; ';
                }
                $against = rtrim($against, "&amp; ");
                echo $this->Html->link("Won a <b>{$last_win['MatchType']['name']}</b> match against <b>$against</b> ".$this->Time->niceShort($last_win['Match']['created']), array('controller'=>'matches', 'action'=>'view', $last_win['Match']['id']), array('escape'=>false));
            } elseif($results['total_score'] == 0){
                // Hasn't scored any points
                echo "<p>Not played yet</p>";
            } else{
                // Has played, but not won any
                echo "<p class='winless'>Loser!</p>";
            }
            ?>
        </dd>
        <dt>Latest defeat</dt>
        <dd>
            <?php
            // Has played, but not lost any matches
            if(!empty($last_loss)){
                $against = '';
                $winning_team = Set::extract("/MatchesPlayer[result=Won]", $last_loss);
                foreach($winning_team as $p){
                    $against .= $p['MatchesPlayer']['Player']['first_name'].' '.substr($p['MatchesPlayer']['Player']['last_name'], 0, 1).' &amp; ';
                }
                $against = rtrim($against, "&amp; ");
                echo $this->Html->link("Lost a <b>{$last_loss['MatchType']['name']}</b> match against <b>$against</b> ".$this->Time->niceShort($last_loss['Match']['created']), array('controller'=>'matches', 'action'=>'view', $last_loss['Match']['id']), array('escape'=>false));
            } elseif($results['total_score'] == 0){
                // Hasn't scored any points
                echo "<p>Not played yet</p>";
            } else{
                echo "<p class='undefeated'>Undefeated!</p>";
            }
            ?>
        </dd>
        <dt>Win:Loss</dt>
        <dd>
            <?php echo $this->element('score-stats', array('stats'=>$results[0]['MatchesPlayer'][0]['MatchesPlayer'][0])); ?>
        </dd>
    </dl>

    <div class="charts">
        <div id="wins_by_time" style="width:600px;height:300px;"></div>
        <?php $this->Blocks->append('script');?>
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
                google.load("visualization", "1", {packages:["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {

                    items = [
                            ['Date','Wins','Losses'],
                        <?php
                        foreach($winsbytime as $item){
                            ?>
                            ['<?php echo $item[0]['day']?>', <?php echo $item[0]['wins']?>, <?php echo $item[0]['losses']?>],
                            <?php
                        }
                        ?>
                    ];

                    var data = google.visualization.arrayToDataTable(items);

                    var options = {
                        title: 'Matches by day'
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('wins_by_time'));
                    chart.draw(data, options);
                }
            </script>
        <?php $this->Blocks->end();?>
    </div>

</div>

