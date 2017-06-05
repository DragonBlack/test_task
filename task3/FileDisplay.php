<?php
/**
 * File FileDisplay.php
 */

/**
 * Вывод списка файлов директории
 */
class FileDisplay implements IFIleDisplay {

    /** @var  string  Директория для поиска файлов */
    protected $_dir;

    /** @var string  Петтерн для поиска файлов */
    protected $_pattern = '/^[0-9a-z]+\.ixt$/i';

    /** @var  string  Тескт последней ошибки */
    protected $_error;

    /**
     * {@inheritdoc}
     *
     * @param string $directory
     *
     * @return $this
     * @throws Exception
     */
    public function setDirectory($directory) {
        if (!is_dir($directory)) {
            throw new Exception("'$directory' не является директорией");
        }
        $this->_dir = (string)$directory;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function showFiles() {
        if (!$this->validateDir()) {
            throw new Exception($this->getError());
        }

        $list = $this->_makeList();
        if (empty($list)) {
            echo "\033[31mFiles not found\033[0m", PHP_EOL;

            return;
        }

        sort($list);
        foreach ($list as $file) {
            echo "\033[32m$file\033[0m", PHP_EOL;
        }
    }

    /**
     * Возвращает текст ошибки.
     *
     * @return string
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * Формирует список файлов.
     *
     * @return array
     */
    protected function _makeList() {
        $files = scandir($this->_dir);

        return preg_grep($this->_pattern, $files);
    }

    /**
     * Валидация пути к файлам.
     *
     * @return bool
     */
    protected function validateDir() {
        if (empty($this->_dir)) {
            $this->setError('Директория не может быть пустой');

            return false;
        }
        elseif (!is_dir($this->_dir)) {
            $this->setError("'{$this->_dir}' не является директорией");

            return false;
        }

        return true;
    }

    /**
     * Сеттер для ошибок валидации.
     *
     * @param $error
     */
    protected function setError($error) {
        $this->_error = $error;
    }
}