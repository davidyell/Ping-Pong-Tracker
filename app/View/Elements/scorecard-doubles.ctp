<table summary="scores" class="result-table">
    <tbody>
        <tr>
            <td>
                <?php
                echo $match['MatchesPlayer'][0]['Player']['first_name'];
                if(!empty($match['MatchesPlayer'][0]['Player']['nickname'])){
                    echo ' "'.$match['MatchesPlayer'][0]['Player']['nickname'].'" ';
                }
                echo ' '.$match['MatchesPlayer'][0]['Player']['last_name'];
                ?>

                <br>&amp;</br>

                <?php
                echo $match['MatchesPlayer'][2]['Player']['first_name'];
                if(!empty($match['MatchesPlayer'][2]['Player']['nickname'])){
                    echo ' "'.$match['MatchesPlayer'][2]['Player']['nickname'].'" ';
                }
                echo ' '.$match['MatchesPlayer'][2]['Player']['last_name'];
                ?>
            </td>
            <td rowspan="2">&nbsp;VS&nbsp;</td>
            <td>
                <?php
                echo $match['MatchesPlayer'][1]['Player']['first_name'];
                if(!empty($match['MatchesPlayer'][1]['Player']['nickname'])){
                    echo ' "'.$match['MatchesPlayer'][1]['Player']['nickname'].'" ';
                }
                echo ' '.$match['MatchesPlayer'][1]['Player']['last_name'];
                ?>

                <br>&amp;</br>

                <?php
                echo $match['MatchesPlayer'][3]['Player']['first_name'];
                if(!empty($match['MatchesPlayer'][3]['Player']['nickname'])){
                    echo ' "'.$match['MatchesPlayer'][3]['Player']['nickname'].'" ';
                }
                echo ' '.$match['MatchesPlayer'][3]['Player']['last_name'];
                ?>
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