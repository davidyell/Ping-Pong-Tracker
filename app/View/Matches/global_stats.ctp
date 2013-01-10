<div class="matches global_stats">
    <h2>Global statistics</h2>

    <div class="well">
        <p><b>Matches: </b><span class="badge"><?php echo $stats['stats']['total_matches']; ?></span></p>
        <p><b>Points: </b><span class="badge"><?php echo $stats['stats']['total_score']; ?></span></p>
        <p><b>Winning points: </b><span class="badge"><?php echo $stats['stats']['win_points']; ?></span></p>

        <?php
        if($stats['stats']['diff'] > 0){
            $class = 'badge-success';
        }elseif($stats['stats']['diff'] == 0){
            $class = 'badge-warning';
        }else{
            $class = 'badge-important';
        }
        ?>
        <p><b>Points difference: </b><span class="badge <?php echo $class;?>"><?php echo $stats['stats']['diff']; ?></span></p>
        <p><b>Rating: </b><span class="badge"><?php echo number_format($stats['stats']['rank'],2); ?></span></p>

    </div>

    <h3>Busiest Ping-Pong days so far</h3>
    <ol>
        <?php foreach($stats['most_played_days'] as $day):?>
            <li><?php echo $this->Time->format('l jS M Y', $day[0]['day']);?> - <?php echo $day[0]['matches'];?></li>
        <?php endforeach;?>
    </ol>

    <div class="charts">
        <h3>Matches by day</h3>
        <div id="matches_by_day"></div>
        <?php $this->Blocks->append('script');?>
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
                google.load("visualization", "1", {packages:["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {

                    items = [
                            ['Day','Matches'],
                        <?php
                        foreach($stats['matches_by_day'] as $item){
                            ?>
                            ['<?php echo $item[0]['day'];?>', <?php echo $item[0]['matches'] ?>],
                            <?php
                        }
                        ?>
                    ];

                    var data = google.visualization.arrayToDataTable(items);

                    var options = {
                        legend: {position:'none'},
                        width: 600,
                        height: 300
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('matches_by_day'));
                    chart.draw(data, options);
                }
            </script>
        <?php $this->Blocks->end();?>
    </div>

</div>