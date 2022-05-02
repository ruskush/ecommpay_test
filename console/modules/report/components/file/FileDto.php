<?php

namespace console\modules\report\components\file;

class FileDto {
    public $name;
    public $type;
    public $path;
    public $filename;
    public $extension;
    public $timestamp;
    public $mimetype;
    public $size;
    public $dirname;
    public $basename;

    public function __construct(array $params) {
        $this->name = $params['name'] ?? null;
        $this->type = $params['type'] ?? null;
        $this->path = $params['path'] ?? null;
        $this->filename = $params['filename'] ?? null;
        $this->extension = $params['extension'] ?? null;
        $this->timestamp = $params['timestamp'] ?? null;
        $this->mimetype = $params['mimetype'] ?? null;
        $this->size = $params['size'] ?? null;
        $this->dirname = $params['dirname'] ?? null;
        $this->basename = $params['basename'] ?? null;
    }
}