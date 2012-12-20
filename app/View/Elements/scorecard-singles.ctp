<table summary="scores" class="result-table">
    <tbody>
        <tr>
            <td>
                <?php echo $match['MatchesPlayer'][0]['Player']['first_name']; ?>
                "<?php echo $match['MatchesPlayer'][0]['Player']['nickname']; ?>"
                <?php echo $match['MatchesPlayer'][0]['Player']['last_name']; ?>
            </td>
            <td rowspan="2">&nbsp;VS&nbsp;</td>
            <td>
                <?php echo $match['MatchesPlayer'][1]['Player']['first_name']; ?>
                "<?php echo $match['MatchesPlayer'][1]['Player']['nickname']; ?>"
                <?php echo $match['MatchesPlayer'][1]['Player']['last_name']; ?>
            </td>
        </tr>
        <tr class="scores">
            <td>
                <?php echo $match['MatchesPlayer'][0]['score']; ?>
            </td>
            <td>
                <?php echo $match['MatchesPlayer'][1]['score']; ?>
            </td>
        </tr>
    </tbody>
</table>