<?php

function getApplicationEnvironment(): string
{
    return $_ENV['APP_ENVIRONMENT'] ?? 'development';
}
