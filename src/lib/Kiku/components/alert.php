<?php
namespace Kiku\Components;

function the_alert(string $alert_kind, string $text, string $domain) {
    echo "<div class='alert $alert_kind'>";
    _e($text, $domain);
    echo '</div>';
}
