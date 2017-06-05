<?php
/**
 * Точка входа для задания №3
 */

spl_autoload_register(function($className){
    $fileName = __DIR__.DIRECTORY_SEPARATOR.$className.'.php';
    if(file_exists($fileName)){
        require_once $fileName;
    }
});

$display = new FileDisplay();

try{
    $display->setDirectory(__DIR__.DIRECTORY_SEPARATOR.'datafiles')
        ->showFiles();
}
catch (Exception $e){
    echo "\033[31mERROR: {$e->getMessage()}\033[0m", PHP_EOL;
}