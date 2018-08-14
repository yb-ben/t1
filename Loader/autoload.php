<?php

$autoloader = new Loader;

$autoloader->addClassMap(require 'autoload_class.php');
$autoloader->addNamespaceMap(require 'autoload_namespaces.php');
$autoloader->addFiles(require 'autoload_file.php');
$autoloader->register();


