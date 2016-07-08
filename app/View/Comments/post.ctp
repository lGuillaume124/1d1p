<?php

if (!empty($comments)) {
    $array_length = count($comments);
    $i = 0;

    echo '<div id="comments-from-' . $comments[0]['Comment']['post_id'] . '">';

    foreach ($comments as $c) {

        echo '<h5>' . $c['Comment']['author'] . ' <small>' . $this->Time->format($c['Comment']['created'], '%d/%m/%Y - %H:%M') . '</small></h5>';
        echo '<p>' . $c['Comment']['content'] . '</p>';

        if ($i < $array_length - 1) {
            echo '<hr />';
        }

        $i++;

    }

    echo '</div>';
} else {
    echo '';
}