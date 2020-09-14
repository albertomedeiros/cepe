<?php

class EstruturaFile extends ActiveRecord
{
    public function setup()
    {
        $this->field_as_file('path', array('public' => true));
    }

    public function before_destroy()
    {
        $dir = FISHY_PUBLIC_PATH . '/' . $this->path;

        @unlink($dir);
    }

    public function get_filename()
    {
        if ($this->url) {
            $filename = 'URL';
        } else {
            $file = explode('/', $this->path);
            $file = end($file);
            $pos = strpos($file, '.');
            $filename = substr($file, $pos + 1);
        }

        return $filename;
    }

    public function get_ext()
    {
        $file = explode('.', $this->path);
        $ext = end($file);

        return '.' . $ext;
    }

    public function get_ext_file()
    {
        $file = explode('.', $this->path);
        $ext = strtolower(end($file));

        if ($ext == 'pptx') {
            $ext = 'ppt';
        }

        if ($ext == 'docx') {
            $ext = 'doc';
        }

        if ($ext == 'xlsx') {
            $ext = 'xls';
        }

        $ext = in_array($ext, array('doc', 'pdf', 'ppt', 'rtf', 'swf', 'txt', 'xls', 'zip')) ? $ext : 'attachment';

        return $ext;
    }
}
