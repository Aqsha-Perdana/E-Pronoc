<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);