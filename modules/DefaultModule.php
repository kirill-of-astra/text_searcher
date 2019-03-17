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
            if (($column = strpos($eachLine, $query)) !== false) {
                return ['line' => ++$line, 'column' => ++$column]; // to positive numbers
            }
            $line++;
        }
        return null;
    }
}