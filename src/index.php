<?php
global $conn;
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

const ROOT_DIR = __DIR__ .  DIRECTORY_SEPARATOR;
const CONFIG_DIR = ROOT_DIR . 'config' . DIRECTORY_SEPARATOR;
const CONTROLLER_DIR = ROOT_DIR . 'controllers' . DIRECTORY_SEPARATOR;
const MODEL_DIR = ROOT_DIR . 'models' . DIRECTORY_SEPARATOR;
const HELPER_DIR = ROOT_DIR . 'helper' . DIRECTORY_SEPARATOR;
const VIEW_DIR = ROOT_DIR . 'views' . DIRECTORY_SEPARATOR;
const SYSTEM_DIR = ROOT_DIR . 'system' . DIRECTORY_SEPARATOR;
const ASSET_DIR = ROOT_DIR . 'assets' . DIRECTORY_SEPARATOR;

include SYSTEM_DIR . 'core.php';