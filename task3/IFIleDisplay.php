<?php
/**
 * File IFileDisplay.php
 */

/**
 * Интерфейс класса, отображающего файлы в директории.
 */
interface IFIleDisplay {

    /**
     *Задает директорию для поиска файлов.
     *
     * @param string $directory
     *
     * @return $this
     */
    public function setDirectory($directory);

    /**
     * Выводит список найденных файлов на экран.
     */
    public function showFiles();
}