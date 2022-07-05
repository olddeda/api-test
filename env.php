<?php
/**
 * Load application environment from .env file
 */
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();