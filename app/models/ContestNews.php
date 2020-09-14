<?php

class ContestNews extends ActiveRecord
{

    public function setup()
    {
        $this->validates_presence_of('title', 'Digite o título');
        $this->validates_presence_of('date_f', 'Escolha a data');

        $this->field_as_datetime('date');
    }

    public function set_date_f($date)
    {
        $date = implode('-', array_reverse(explode('/', $date)));

        $this->write_attribute('date', $date);
    }

    public function get_date_f()
    {
        $date = date('d/m/Y');

        if ($this->date) {
            $date = $this->date('d/m/Y');
        }
        return $date;
    }


}