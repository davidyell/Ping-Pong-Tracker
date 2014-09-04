<p><b>Matches won: </b><span class="badge badge-success"><?php echo $stats['wins']; ?></span></p>
<p><b>Matches lost: </b><span class="badge badge-important"><?php echo $stats['losses']; ?></span></p>
<p><b>Total matches: </b><span class="badge"><?php echo $stats['total_matches']; ?></span></p>

<?php
if($stats['wins'] > 0 && $stats['losses'] > 0){
	$percent = ($stats['wins'] / ($stats['wins'] + $stats['losses'])) * 100;
}else{
	$percent = 0;
}

if($percent > 0 && $percent < 20){
	$class = "badge-important";
} elseif($percent > 20 && $percent < 40){
	$class = "badge-warning";
} elseif($percent > 40 && $percent < 60){
	$class = "";
} elseif($percent > 60 && $percent < 80){
	$class = "badge-info";
} else{
	$class = "badge-success";
}
?>

<p><b>Win%: </b><span class="badge <?php echo $class; ?>"><?php echo $this->Number->precision($percent, 2) ?></span></p>
<p><b>Total points: </b><span class="badge"><?php echo $stats['total_score']; ?></span></p>
<p><b>Winning points: </b><span class="badge"><?php echo $stats['win_points']; ?></span></p>
<p><b>Points difference: </b><span class="badge"><?php echo $stats['diff']; ?></span></p>
<p><b>Rating: </b><span class="badge"><?php echo $this->Number->precision($stats['rank'],2); ?></span></p>