<?php
namespace Kiku\Components;

function the_alert(string $alert_kind, string $text) {
    echo "<div class='alert $alert_kind'>";
    echo $text;
    echo '</div>';
}
