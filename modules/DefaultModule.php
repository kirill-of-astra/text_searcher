<?php

namespace kirillGru\textSearcher\modules;

use kirillGru\textSearcher\fileSources\FileSourceInterface;

class DefaultModule implements ModuleInterface
{
    public function search(FileSourceInterface $source, string $query): ?array
    {
        $line = 0;
        $column = 0;
        while ($eachLine = $source->readLine()) {
            $eachLine = mb_convert_encoding($eachLine, 'UTF-8', ['UTF-8','CP1251']);
            if (($column = mb_stripos($eachLine, $query)) !== false) {
                return ['line' => ++$line, 'column' => ++$column]; // to positive numbers
            }
            $line++;
        }
        return null;
    }
}