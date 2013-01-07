<p><b>Matches won: </b><span class="badge badge-success"><?php echo $wins; ?></span></p>
<p><b>Matches lost: </b><span class="badge badge-important"><?php echo $losses; ?></span></p>

<?php
if($wins > 0 && $losses > 0){
    $percent = ($wins / ($wins + $losses)) * 100;
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

<p><b>Win%: </b><span class="badge <?php echo $class; ?>"><?php echo number_format($percent) ?></span></p>
<p><b>Points: </b><span class="badge"><?php echo $total_points; ?></span></p>