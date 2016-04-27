<?php
error_reporting(-1);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

define('SRC_PATH', realpath(dirname(__FILE__) . '/src/'));
define('TESTS_PATH', realpath(dirname(__FILE__) . '/tests/'));

require_once SRC_PATH . '/Llama/Loader/Autoloader.php';

set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            get_include_path(),
            TESTS_PATH,
            'C:\\Users\\Brendan\\Desktop\\Wamp\\bin\\php\\php5.3.5\\PEAR'
        )
    )
);

$autoloader = Llama\Loader\Autoloader::getInstance();
$autoloader->addNamespace('Llama', SRC_PATH);
$autoloader->register();

require_once 'PHPUnit/Framework/TestCase.php';

