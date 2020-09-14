<?php

class UserRouter extends Fishy_Router
{
    public function setup()
    {
        $this->gwmRoutes();
        $this->culturalContestRoutes();

        //site routes
        $this->map_connect('image/view/:model/:field/:id/:f', array("controller" => "image", "action" => "view"));
        $this->map_connect('image/view/:model/:field/:id', array("controller" => "image", "action" => "view"));

        $this->map_connect('concursos/page/:page', array("controller" => "concursos", "action" => "index"));
        $this->map_connect('concursos/:slug', array("controller" => "concursos", "action" => "view"));
        $this->map_connect('concursos', array("controller" => "concursos", "action" => "index"));

        $this->map_connect('licitacoes/busca/page/:page', array("controller" => "licitacoes", "action" => "search"));
        $this->map_connect('licitacoes/busca', array("controller" => "licitacoes", "action" => "search"));
        $this->map_connect('licitacoes/email', array("controller" => "licitacoes", "action" => "send_email"));
        $this->map_connect('licitacoes/check-cpf-cnpj', array("controller" => "licitacoes", "action" => "check_cpf_cnpj"));
        $this->map_connect('licitacoes/registrar', array("controller" => "licitacoes", "action" => "register"));

        $this->map_connect('licitacoes/page/:page', array("controller" => "licitacoes", "action" => "index"));
        $this->map_connect('licitacoes', array("controller" => "licitacoes", "action" => "index"));
        $this->map_connect('licitacoes/ativar/:id', array("controller" => "licitacoes", "action" => "ativar_registro"));

        $this->map_connect('noticias/page/:page', array("controller" => "noticias", "action" => "index"));
        $this->map_connect('noticias/:slug', array("controller" => "noticias", "action" => "view"));
        $this->map_connect('noticias', array("controller" => "noticias", "action" => "index"));
        $this->map_connect('categoria/:slug/page/:page', array("controller" => "noticias", "action" => "categoria"));
        $this->map_connect('categoria/:slug', array("controller" => "noticias", "action" => "categoria"));

        $this->map_connect('sobre', array("controller" => "main", "action" => "a_cepe"));
        $this->map_connect('formularios-lai', array("controller" => "main", "action" => "formularios_lai"));
        $this->map_connect('cepe-doc', array("controller" => "main", "action" => "cepe_doc"));
        $this->map_connect('ouvidoria', array("controller" => "main", "action" => "ouvidoria"));
        $this->map_connect('cepe-digital', array("controller" => "main", "action" => "certificacao"));
        $this->map_connect('acervo-cepe', array("controller" => "main", "action" => "acervo_cepe"));
        $this->map_connect('acervo-cepe-interna', array("controller" => "main", "action" => "acervo_cepe_interna"));
        $this->map_connect('faq', array("controller" => "main", "action" => "faq"));
        $this->map_connect('cepe-grafica', array("controller" => "main", "action" => "cepe_grafica"));
        $this->map_connect('certificado-digital', array("controller" => "main", "action" => "certificado_digital"));
        $this->map_connect('regulamento', array("controller" => "main", "action" => "regulamento"));
        $this->map_connect('termos-e-condicoes', array("controller" => "main", "action" => "termos"));
        $this->map_connect('politica-de-privacidade', array("controller" => "main", "action" => "politica_privacidade"));
        $this->map_connect('identidade-visual', array("controller" => "main", "action" => "identidade_visual"));
        $this->map_connect('governanca-corporativa', array("controller" => "main", "action" => "governanca_corporativa"));
        $this->map_connect('fale-conosco', array("controller" => "main", "action" => "fale_conosco"));
        $this->map_connect('diario-oficial', array("controller" => "main", "action" => "diario_oficial"));
        $this->map_connect('estrutura-administrativa', array("controller" => "main", "action" => "estrutura_administrativa"));


        $this->devRoutes();
        $this->fallBackRoutes();
    }

        public function culturalContestRoutes()
    {
//        $this->map_connect('premio-cepe/inscricao', array("controller" => "culturalcontest", "action" => "preform"));
        $this->map_connect('premio-cepe/escolher-categoria', array("controller" => "culturalcontest", "action" => "genre_selector"));
        $this->map_connect('premio-cepe/termo-de-concordancia', array("controller" => "culturalcontest", "action" => "agreement"));
        $this->map_connect('premio-cepe/inscricao', array("controller" => "culturalcontest", "action" => "step1"));
        $this->map_connect('premio-cepe/inscricao/1', array("controller" => "culturalcontest", "action" => "step1"));
        $this->map_connect('premio-cepe/inscricao/2', array("controller" => "culturalcontest", "action" => "step2"));
        $this->map_connect('premio-cepe/inscricao/2/menor', array("controller" => "culturalcontest", "action" => "step2_2"));
        $this->map_connect('premio-cepe/inscricao/3', array("controller" => "culturalcontest", "action" => "step3"));
        $this->map_connect('premio-cepe/inscricao/3/menor', array("controller" => "culturalcontest", "action" => "step3"));
        $this->map_connect('premio-cepe/inscricao/4/:genero', array("controller" => "culturalcontest", "action" => "step4"));
        $this->map_connect('premio-cepe/inscricao/5/:genero', array("controller" => "culturalcontest", "action" => "step5"));
        $this->map_connect('premio-cepe/inscricao/cadastrar', array("controller" => "culturalcontest", "action" => "save_subscription"));
        $this->map_connect('premio-cepe/sucesso', array("controller" => "culturalcontest", "action" => "step6"));
        $this->map_connect('premio-cepe/acompanhar-inscricao', array("controller" => "culturalcontest", "action" => "check_subscription"));
        $this->map_connect('premio-cepe/cpf', array("controller" => "culturalcontest", "action" => "check_cpf"));
        $this->map_connect('premio-cepe', array("controller" => "culturalcontest", "action" => "step1"));

    }

    public function gwmRoutes()
    {
        $this->map_gwm_change_password('gwm/change_password', array("controller" => "gwm_personal", "action" => "changepassword"));
        $this->map_gwm_login('gwm/login', array("controller" => "gwm_main", "action" => "login"));
        $this->map_gwm_logout('gwm/logout', array("controller" => "gwm_main", "action" => "logout"));
        $this->map_gwm_change_language('gwm/change_language/:language', array("controller" => "gwm_main", "action" => "changelanguage"));

        $this->map_connect("gwm/tender/remove_file/:tender_id/:id", array("controller" => "gwm_tender", "action" => "remove_file"));
        $this->map_connect("gwm/bidding/remove_file/:bidding_id/:id", array("controller" => "gwm_bidding", "action" => "remove_file"));
        $this->map_connect("gwm/news/remove_file/:news_id/:id", array("controller" => "gwm_news", "action" => "remove_file"));
        $this->map_connect("gwm/governance/remove_file/:governance_id/:id", array("controller" => "gwm_governance", "action" => "remove_file"));
        
        $this->map_namespace('gwm_contest');
        $this->map_namespace('gwm');
        $this->map_connect('gwm', array("controller" => "gwm_main"));
    }

    public function devRoutes()
    {
        $this->map_connect('dev', array('controller'=>'dev'));
        $this->map_connect('dev/:action', array('controller'=>'dev'));
    }

    public function fallBackRoutes()
    {
        $this->map_connect(':controller/:action/:id');
        $this->map_connect(':controller/:action/:id.:format');
        $this->map_connect(':controller/:action');
        $this->map_connect(':controller/:action.:format');
        $this->map_connect(':action', array("controller" => "main"));
        $this->map_connect('', array("controller" => "main"));
    }

    public function map_namespace($namespace)
    {
        $path_form = str_replace('_', '/', $namespace);

        $this->map_connect("$path_form/:controller/all/:page", array("namespace" => "$namespace", "action" => "all"));
        $this->map_connect("$path_form/:controller/:action/:id", array("namespace" => "$namespace"));
        $this->map_connect("$path_form/:controller/:action", array("namespace" => "$namespace"));
        $this->map_connect("$path_form/:controller", array("namespace" => "$namespace"));
    }
}
