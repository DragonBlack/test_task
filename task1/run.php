<?php
/**
 * Точка входа для задания №1
 */

spl_autoload_register(function($className){
    $fileName = __DIR__.DIRECTORY_SEPARATOR.$className.'.php';
    if(file_exists($fileName)){
        require_once $fileName;
    }
});

/**
 * Вывод сообщения об ошибке и прекращение работыы скрипта
 *
 * @param string    $error
 */
function exitWithError($error){
    echo "\033[31mERROR: $error\033[0m", PHP_EOL;
    exit(0);
}


try{
    $conn = new MysqlProvider('mysql:host=localhost;dbname=testtasks', 'root', 'root');
    $init = new Init($conn);
    print_r($init->get());
}
catch (PDOException $e){
    exitWithError($e->getMessage());
}
catch(Exception $e){
    exitWithError($e->getMessage());
}
catch(Error $e){
    exitWithError($e->getMessage());
}


