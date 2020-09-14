<?php

class Tender extends ActiveRecord
{
    public function setup()
    {
        $this->validates_presence_of('title', 'Digite o título');
        $this->validates_presence_of('text', 'Digite o texto');
        $this->validates_presence_of('date_published_f', 'Digite a data de publicação');

        $this->field_as_datetime('date_published');

        $this->has_many('TenderFile as files');
    }

    public function before_save()
    {
        $slug = Fishy_StringHelper::create_slug($this->title);
        
        if ($this->slug != $slug) {
            $count = ActiveRecord::model('Tender')->count(array('conditions' => 'slug like "' . $slug . '%"'));
            $this->slug = $count > 0 ? $slug . "-" . $count : $slug;
        }

        if (is_null($this->status)) {
            $this->status = 0;
        }
    }

    public function before_destroy()
    {
        foreach ($this->files as $file) {
            $file->destroy();
        }
    }

    public function set_date_published_f($datetime)
    {
        list($date, $time) = explode(' ', $datetime);
        $datetime = implode('-', array_reverse(explode('/', $date))) . ' ' . $time;

        $this->write_attribute('date_published', $datetime);
    }

    public function get_date_published_f()
    {
        $datetime = date('d/m/Y H:i');

        if ($this->date_published) {
            $datetime = $this->date_published('d/m/Y H:i');
        }

        return $datetime;
    }

    public function get_status_text()
    {
        $status = $this->status ? 'Publicado' : 'Pronto';
        return $this->date_published > date('Y-m-d H:i:s') ? 'Agendado' : $status;
    }
}
