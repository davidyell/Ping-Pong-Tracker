<?php
if (!empty($player['Player']['facebook_id'])) {
    $response = @file_get_contents("https://graph.facebook.com/{$player['Player']['facebook_id']}?fields=id,name,picture.width({$size})");
    if ($response !== false) {
        $data = json_decode($response);
        $player['Player']['facebook_avatar'] = $data->picture->data->url;
    }
}

if (isset($player['Player']['facebook_avatar'])) {
	echo "<span class='facebookavatar'><img src='{$player['Player']['facebook_avatar']}' alt='{$player['Player']['first_name']}'></span>";
} else {
	echo "<span class='gravatar'>" . $this->Gravatar->image($player['Player']['email'], array('s' => $size, 'd' => 'wavatar')) . "</span>";
}