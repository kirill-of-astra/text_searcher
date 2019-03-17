<?php

namespace kirillGru\textSearcher;

use Symfony\Component\Yaml\Yaml;

class Config
{
    public $config_path = __DIR__ . '/config.yaml';

    public $user_params = [];

    private $store = [];


    function __construct(array $user_params = [], string $file_path = '')
    {
        $this->user_params = $user_params;
        if (!empty($file_path)) {
            $this->file_path = $file_path;
        }
    }

    function readFile(string $path): array
    {
        return Yaml::parseFile($path);
    }

    public function load()
    {
        $file_params = $this->readFile($this->config_path); // todo exception?
        $default_params = $this->getDefaultParams();
        $this->store = array_merge($default_params, $file_params, $this->user_params);
    }

    public function getDefaultParams(): array
    {
        return [
            //'max_file_size' => '', // ignore
            //'file_mime_type' => '', // ignore
            'defaul_module' => 'kirillGru\\textsearcher\\modules\\DefaultModule'
        ];
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \Exception();// todo
        }
        return $this->store[$key];
    }

    public function has($key): bool
    {
        return $this->store[$key];
    }

}