<?php
use Essentio\Core\Application;

require_once __DIR__ . "/../vendor/autoload.php";
Application::http(__DIR__ . "/..");
require_once base_path("bootstrap.php");

get("", [Action\Home::class, "view"]);
post("", [Action\Home::class, "nameAction"]);
get(":name", [Action\Home::class, "nameView"]);

Application::run();
