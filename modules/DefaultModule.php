<?php

namespace kirillGru\textSearcher\modules;

use kirillGru\textSearcher\fileSources\FileSourceInterface;

class DefaultModule implements ModuleInterface
{


    public function search(FileSourceInterface $source, string $query): bool
    {
        // TODO: Implement search() method.
    }
}