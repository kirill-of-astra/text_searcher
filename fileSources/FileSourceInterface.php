<?php

namespace kirillGru\textSearcher\fileSources;

interface FileSourceInterface
{
    public function readLine(): string;
    public function getContent(): string;

}