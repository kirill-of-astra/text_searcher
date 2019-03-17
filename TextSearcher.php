<?php

namespace kirillGru\textSearcher;

use kirillGru\textSearcher\exceptions\ModuleNotFoundException;
use kirillGru\textSearcher\fileSources\LocalFile;
use kirillGru\textSearcher\modules\ModuleInterface;

/**
 * The TextSearcher is main class for using this library
 *
 * See usage examples in readme
 * @package kirillGru\textSearcher
 */
class TextSearcher
{
    private $config;
    private $source;
    private $module;

    /**
     * @param array $user_params
     * @throws ModuleNotFoundException
     * @throws \Exception
     */
    function __construct($user_params = [])
    {
        $this->config = new Config($user_params);
        $this->config->load();
        $this->module = $this->getSearchModule();
    }


    /**
     * open local file
     * @param $file_path
     */
    public function openFile($file_path)
    {
        $this->source = new LocalFile($file_path);
        $this->source->openFile();
    }

    public function openHTTPFile($url)
    {
        throw new \Exception('method not implemented'); // TODO
    }

    public function openFTPFile($path, array $credentials)
    {
        throw new \Exception('method not implemented'); // TODO
    }

    // TODO closeFile

    public function search(string $query)
    {
        return $this->module->search($this->source, $query);
    }

    /**
     * return configured search module
     *
     * @return ModuleInterface
     * @throws ModuleNotFoundException
     * @throws \Exception
     */
    private function getSearchModule(): ModuleInterface
    {
        $module = $this->config->get('defaul_module');
        try {
            return new $module();
        } catch (\Exception $e) {
            throw new ModuleNotFoundException("Module $module not found");
        }
    }

    public function closeFile()
    {
        $this->source->closeFile();
    }

}