<?php

class Category extends ActiveRecord
{
    

    public function setup()
    {
        $this->validates_presence_of('title', 'Digite o título');
       
        $this->has_many('news', array('through' => 'news_categories', 'local_field' => 'category_id'));
    }

    public function before_destroy()
    {
        
    }

    public function before_save()
    {
        $slug = Fishy_StringHelper::create_slug($this->title);
        
        if ($this->slug != $slug) {
            $count = ActiveRecord::model('Category')->count(array('conditions' => 'slug like "' . $slug . '%"'));
            $this->slug = $count > 0 ? $slug . "-" . $count : $slug;
        }

        if (is_null($this->status)) {
            $this->status = 0;
        }
    }

    
   

    

    
}
