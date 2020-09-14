<?php

class ContestAttachment extends ActiveRecord
{

    public function setup()
    {
        $this->validates_presence_of('contest', 'Escolha o concurso');
        $this->validates_presence_of('title', 'Digite o título');
        $this->validates_presence_of('file', 'Escolha o arquivo');

        $this->field_as_file('file', array('public' => true));
    }

    public function before_destroy()
    {
        $dir = FISHY_PUBLIC_PATH . '/' . $this->file;

        @unlink($dir);
    }

    public function get_filename()
    {
        $file = explode('/', $this->file);
        $file = end($file);
        $pos = strpos($file, '.');
        $filename = substr($file, $pos + 1);

        return $filename;
    }

    public function get_ext()
    {
        $file = explode('.', $this->file);
        $ext = end($file);

        return '.' . $ext;
    }

    public function get_ext_image()
    {
        $file = explode('.', $this->file);
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

        return $ext;
    }

    public function get_file_size()
    {
        $bytes = filesize(FISHY_ROOT_PATH. '/public/'. $this->file);

        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }


}