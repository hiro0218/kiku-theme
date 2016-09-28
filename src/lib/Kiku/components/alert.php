<?php
namespace Kiku\Components;

function the_alert($alert_kind, $text, $domain) {
    echo "<div class='alert $alert_kind'>";
    _e($text, $domain);
    echo '</div>';
}
