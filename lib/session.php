<?php

session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => '.done.local',
    'httponly' => true
]);

session_start();
