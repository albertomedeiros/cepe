<?php

class Governance extends ActiveRecord
{
    public function setup()
    {
        $this->validates_presence_of('title', 'Digite o título');
        $this->validates_presence_of('text', 'Digite o texto');
        $this->validates_presence_of('date_published_f', 'Digite a data de publicação');

        $this->field_as_datetime('date_published');

        $this->has_many('categories', array('through' => 'governance_categories', 'local_field' => 'governance_id'));
        
        $this->has_many('GovernanceFile as files');
    }

    public function before_save()
    {
        $slug = Fishy_StringHelper::create_slug($this->title);
        
        if ($this->slug != $slug) {
            $count = ActiveRecord::model('Governance')->count(array('conditions' => 'slug like "' . $slug . '%"'));
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


    public function individual_categories()
    {
        $categories = array();
        
        foreach ($this->categories as $category) {
            $categories[] = (int) $category->id;
        }

        return $categories;
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

    public function get_month()
    {
        $months = array('','Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        return $months[(int)$this->date_published('m')];
    }

    public function get_weekday()
    {
        $weekdays = array('', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo');
        return $weekdays[(int)$this->date_published('N')];
    }

    public function get_date()
    {
        return sprintf('%s, %s %s %s %s', $this->weekday, $this->date_published('d'), $this->month, $this->date_published('Y'), $this->date_published('H:i'));
    }
}
