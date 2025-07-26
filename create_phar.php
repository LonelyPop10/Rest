<?php
$pluginName = "FlyPlugin";
$pluginVersion = "1.0.0";
$phar = new Phar($pluginName . "_v" . $pluginVersion . ".phar");
$phar->buildFromDirectory(__DIR__ . "/FlyPlugin");
$phar->stopBuffering();
?>
