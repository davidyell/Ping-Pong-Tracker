<?php
if (isset($player['Player']['facebook_avatar'])) {
    echo "<span class='facebookavatar'><img src='{$player['Player']['facebook_avatar']}' alt='{$player['Player']['first_name']}'></span>";
} else {
    echo "<span class='gravatar'>".$this->Gravatar->image($player['Player']['email'], array('s'=>24,'d'=>'wavatar'))."</span>";
}
?>