<?php

namespace kirillGru\textSearcher\fileSources;

use kirillGru\textSearcher\exceptions\CannotCloseFileException;
use kirillGru\textSearcher\exceptions\CannotOpenFileException;

class LocalFile implements FileSourceInterface
{
    private $path;
    private $file = false;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Read next line from file. Returns NULL if end of file reached.
     * @return null|string
     */
    public function readLine(): ?string
    {
        $line = fgets($this->file);
        if ($line !== false) {
            return $line;
        }
        return null;
    }

    /**
     * Get full file data
     * @return string
     */
    public function getContent(): string
    {
        rewind($this->file);
        return fread($this->file, filesize($this->file));
    }

    /**
     * Detect MIME type by file contents
     * @return mixed
     */
    public function getMimeType(): string
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $this->path);
        finfo_close($finfo);
        return $mimetype;
    }

    /**
     * Get file size in bytes
     * @return int
     */
    public function getSize(): int
    {
        return filesize($this->path);
    }

    /**
     * @throws CannotOpenFileException
     */
    public function openFile()
    {
        if ($this->file !== false) {
            $this->closeFile();
        }
        $this->file = fopen($this->path, 'rb');
        if ($this->file === false) {
            throw new CannotOpenFileException("Cannot open file: $this->path");
        }

    }

    /**
     * @throws CannotCloseFileException
     */
    public function closeFile()
    {
        if ($this->file !== false and @fclose($this->file) === false) {
            throw new CannotCloseFileException("Cannot open file: $this->path");
        }
    }

    public function __destruct()
    {
        try {
            $this->closeFile();
        } catch (CannotCloseFileException $e) {
            // ignore exception
        }
    }
}