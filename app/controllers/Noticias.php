<?php

class NoticiasController extends MainController
{
    public function index()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Notícias | A Cepe | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Notícias | A Cepe | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Notícias | A Cepe | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('A Cepe', $this->site_url('a-cepe'));
        $this->addBreadcrumbs('Notícias');

        $page_url = $this->site_url('noticias/page/');
        $this->pagination('News', $page_url, 8);
    }


     public function categoria()
    {
        $slug = $this->param('slug');

        $category = ActiveRecord::model('Category')->find_by_slug($slug);

        if($category){ 
            $news = $category->news;

            $this->meta_tags(array(
                'meta_title'       => 'Categoria | '.$category->title.' | Cepe - Companhia Editora de Pernambuco',
                'tt_title'         => 'Categoria | '.$category->title.' | Cepe - Companhia Editora de Pernambuco',
                'og_title'         => 'Categoria | '.$category->title.' | Cepe - Companhia Editora de Pernambuco',
            ));

            $this->addBreadcrumbs('A Cepe', $this->site_url('a-cepe'));
            $this->addBreadcrumbs('Notícias', $this->site_url('noticias'));
            $this->addBreadcrumbs('Categoria - '.$category->title);

            $page_url = $this->site_url('categoria/'.$slug.'/page/');
            $this->category  = $category;
            $this->paginationCategory($category, $page_url, 8);
        }
    }

        protected function paginationCategory($obj, $page_url, $limit)
    {
        $page = $this->param('page', 1);
        $query['joins']='inner join news_categories on (news_categories.news_id = news.id and category_id = '.$obj->id.')';
        $query['conditions'] = 'status = 1 and date_published <= "' . date('Y-m-d H:i:s') . '"';
        $query['order'] = 'date_published desc';

        $limit = $limit;
        $offset = ($page - 1) * $limit;

        $total = ActiveRecord::model('News')->count($query);

        $total = ceil($total / $limit);
        $prev = $page > 1 ? $page - 1 : 1;
        $next = $page < $total ? $page + 1 : $total;

        $this->prev = $page_url . $prev;
        $this->next = $page_url . $next;
        $this->page = $page;
        $this->total = $total;

        $query['limit'] = $limit;
        $query['offset'] = $offset;

        $this->data = ActiveRecord::model('News')->all($query);
    }

    public function view()
    {
        $slug = $this->param('slug');

        $news = ActiveRecord::model('News')->find_by_slug($slug);

        if (!$news) {
            $this->page_not_found();
        }

        $this->meta_tags(array(
            'meta_title'       => $news->title . ' | Notícias | A Cepe | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => $news->title . ' | Notícias | A Cepe | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => $news->title . ' | Notícias | A Cepe | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('A Cepe', $this->site_url('a-cepe'));
        $this->addBreadcrumbs('Notícias', $this->site_url('noticias'));
        $this->addBreadcrumbs($news->title);

        $this->news = $news;
    }
}
