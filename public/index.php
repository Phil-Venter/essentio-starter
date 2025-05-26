<?php

require_once __DIR__ . "/../vendor/autoload.php";
Essentio\Core\Application::web(__DIR__ . "/..");
require_once base("bootstrap.php");

get("", [Action\Home::class, "view"]);
post("", [Action\Home::class, "nameAction"]);
get(":name", [Action\Home::class, "nameView"]);

Essentio\Core\Application::run();
