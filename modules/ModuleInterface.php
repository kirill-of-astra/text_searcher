<?php

namespace kirillGru\textSearcher\modules;

use kirillGru\textSearcher\fileSources\FileSourceInterface;

interface ModuleInterface
{
    public function search(FileSourceInterface $source, string $query): bool;
}