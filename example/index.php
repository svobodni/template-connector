<?php

include __DIR__ . '/../Svobodni/loader.php';

$connector = new Svobodni\TemplateConnector;
// $connector->setCacheDir(__DIR__ . '/cache');
$connector->setParameter('title', 'Testovací titulek');
$connector->setParameter('content', 'Tady bude obsah');
$connector->render();
