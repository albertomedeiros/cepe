<?php

include_once "app/controllers/Application.php";

class MainController extends ApplicationController
{
    private static $load_diaries;

    protected function initialize()
    {
        parent::initialize();

        
        $this->meta_tags(array(
            'meta_title'       => 'Cepe - Companhia Editora de Pernambuco',
            'meta_description' => '',
            'meta_keywords'    => '',
            'meta_author'      => 'Fishy - Agência Digital',
            'tt_creator'       => 'Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Cepe - Companhia Editora de Pernambuco',
            'tt_description'   => '',
            'og_description'   => '',
            'og_image_width'   => '500',
            'og_image_height'  => '500',
            'og_locale'        => 'pt-BR',
            'og_url'           => '',
            'og_site_name'     => 'Cepe - Companhia Editora de Pernambuco',
        ));

        $this->_layout = 'main';
        $this->calendar_home = true;

        $query['conditions'] = 'status = 1 and date_published <= "' . date('Y-m-d H:i:s') . '"';
        $query['order'] = 'date_published desc';
        
        $this->tenders = ActiveRecord::model('Tender')->all($query);
        $this->categories = ActiveRecord::model('Category')->all();

        

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ); 


        
        self::$load_diaries = str_replace('per', '', file_get_contents('https://www.cepe.com.br/diarios.txt',false, stream_context_create($arrContextOptions)));

        $this->weekdays = array(
            1 => 'Segunda',
            2 => 'Terça',
            3 => 'Quarta',
            4 => 'Quinta',
            5 => 'Sexta',
            6 => 'Sábado',
            7 => 'Domingo'
        );
    }

    public function get_diaries()
    {
        $this->_render_layout = false;
        echo self::$load_diaries;
    }

    public function index()
    {
        $this->months = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        $this->diaries = explode('&', self::$load_diaries);
    }

    public function get_calendar()
    {
        $this->_render_layout = false;

        $data['year'] = $this->param('year');
        $data['month'] = $this->param('month');

        $this->diaries = explode('&', self::$load_diaries);
        echo $this->render_partial('calendar', $data);
    }

    public function a_cepe()
    {
        $this->meta_tags(array(
            'meta_title'       => 'A cepe | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'A cepe | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'A cepe | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('A Cepe');

        $this->render('a-cepe');
    }

    public function formularios_lai()
    {

        $this->meta_tags(array(
            'meta_title'       => 'Formulários LAI | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Formulários LAI | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Formulários LAI | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Formulários LAI');

        $this->render('formularios-lai');

    }

    public function cepe_doc()
    {

        $this->meta_tags(array(
            'meta_title'       => 'Cepe DOC | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Cepe DOC | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Cepe DOC | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Cepe DOC');

        $this->render('cepe-doc');


    }

    public function cepe_grafica()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Cepe Gráfica | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Cepe Gráfica | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Cepe Gráfica | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Cepe Gráfica');

        $this->render('cepe-grafica');
    }

    public function ouvidoria()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Ouvidoria | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Ouvidoria | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Ouvidoria | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Ouvidoria');

        $this->render('ouvidoria');
    }

    public function certificacao()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Cepe Digital | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Cepe Digital | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Cepe Digital | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Cepe Digital');

        $this->render('certificacao');
    }

    public function acervo_cepe()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Acervo Cepe | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Acervo Cepe | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Acervo Cepe | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Acervo Cepe');

        $this->render('acervo-cepe');
    }

    public function acervo_cepe_interna()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Acervo Cepe | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Acervo Cepe | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Acervo Cepe | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Acervo Cepe Interna');

        $this->render('acervo-cepe-interna');
    }

    public function certificado_digital()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Certificado Digital | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Certificado Digital | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Certificado Digital | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Certificado Digital');
        $this->calendar_cert = true;

        $this->render('certificado-digital');
    }

    public function faq()
    {
        $this->meta_tags(array(
            'meta_title'       => 'FAQ | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'FAQ | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'FAQ | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('FAQ');

        $this->render('faq');
    }

    public function regulamento()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Regulamento | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Regulamento | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Regulamento | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Regulamento');

        $this->render('regulamento');
    }

    public function termos()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Termos e Condições | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Termos e Condições | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Termos e Condições | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Termos e Condições');

        $this->render('termos-e-condicoes');
    }

    public function politica_privacidade()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Política de Privaicdade | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Política de Privaicdade | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Política de Privaicdade | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Política de Privaicdade');

        $this->render('politica-de-privacidade');
    }

    public function estrutura_administrativa()
    {
        $categories = ActiveRecord::model('Category')->all(array('order' => 'title'));
        $categoriesAno = array();
        // Verificando se as categorias são numéricas
        foreach($categories as $intChave => $arrValor){
            $intAno = (int) $arrValor->title;
            // Caso seja númerico
            if($intAno > 0){
                $categoriesAno[] = $arrValor;
            } 
        }
        $this->categories = array_reverse($categoriesAno);

        $this->meta_tags(array(
            'meta_title'       => 'Estrutura Administrativa | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Estrutura Administrativa | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Estrutura Administrativa | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Estrutura Administrativa');
        
        // Caso exista post
        if(!empty($_POST) && !empty($_POST["categoria"])){
            $idCategoria = (int) $_POST["categoria"];
            $query["joins"] = " inner join estrutura_categories on (estrutura_categories.estrutura_id = estruturas.id and category_id = $idCategoria)";
        }
        
        $query['select'] = 'estruturas.*';
        $query['conditions'] = 'status = 1 and date_published <= "' . date('Y-m-d H:i:s') . '"';
        $query['order'] = 'date_published desc';
        
        
        $this->data = ActiveRecord::model('Estrutura')->all($query);


        //echo '<pre>';
        //print_r($this->data);
        //die;
        //app/views/main/estrutura-administrativa.php

        $this->render('estrutura-administrativa');
    }

    public function governanca_corporativa()
    {
        $categories = ActiveRecord::model('Category')->all(array('order' => 'title'));
        $categoriesAno = array();
        // Verificando se as categorias são numéricas
        foreach($categories as $intChave => $arrValor){
            $intAno = (int) $arrValor->title;
            // Caso seja númerico
            if($intAno > 0){
                $categoriesAno[] = $arrValor;
            } 
        }
        $this->categories = array_reverse($categoriesAno);

        $this->meta_tags(array(
            'meta_title'       => 'Governança Corporativa | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Governança Corporativa | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Governança Corporativa | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Governança Corporativa');
        
        // Caso exista post
        if(!empty($_POST) && !empty($_POST["categoria"])){
            $idCategoria = (int) $_POST["categoria"];
            $query["joins"] = " inner join governance_categories on (governance_categories.governance_id = governances.id and category_id = $idCategoria)";
        }
        
        $query['select'] = 'governances.*';
        $query['conditions'] = 'status = 1 and date_published <= "' . date('Y-m-d H:i:s') . '"';
        $query['order'] = 'date_published desc';

        $this->data = ActiveRecord::model('Governance')->all($query);

        //echo '<pre>';
        //print_r($this->data);
        //die;
        

        $this->render('governanca-corporativa');
    }

    public function identidade()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Identidade Visual | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Identidade Visual | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Identidade Visual | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Identidade Visual');

        $this->render('identidade-visual');
    }

    public function fale_conosco()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Fale Conosco | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Fale Conosco | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Fale Conosco | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Fale Conosco');

        $this->render('fale-conosco');
    }

    public function diario_oficial()
    {
        $this->months = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        $this->diaries = explode('&', self::$load_diaries);

        $this->meta_tags(array(
            'meta_title'       => 'Diário Oficial | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Diário Oficial | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Diário Oficial | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Diário Oficial');

        $this->render('diario-oficial');
    }

    protected function pagination($model, $page_url, $limit)
    {
        $page = $this->param('page', 1);

        $query['conditions'] = 'status = 1 and date_published <= "' . date('Y-m-d H:i:s') . '"';
        $query['order'] = 'date_published desc';

        $limit = $limit;
        $offset = ($page - 1) * $limit;

        $total = ActiveRecord::model($model)->count($query);

        $total = ceil($total / $limit);
        $prev = $page > 1 ? $page - 1 : 1;
        $next = $page < $total ? $page + 1 : $total;

        $this->prev = $page_url . $prev;
        $this->next = $page_url . $next;
        $this->page = $page;
        $this->total = $total;

        $query['limit'] = $limit;
        $query['offset'] = $offset;

        $this->data = ActiveRecord::model($model)->all($query);
    }

    public function send_contact()
    {
        $this->_render_layout = false;

        foreach ($_POST as $field => $value) {
            $this->$field = $value;
        }

        $content = $this->render_partial('template.contact.mail', null, array('return' => true));

        $mail = new PHPMailer;

    
        $mail->IsSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'concursoliterario@cepe.com.br';
        $mail->Password = 'c3p3@intranet';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        //$mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Contato | Cepe';
        $mail->From = 'concursoliterario@cepe.com.br';
        $mail->AddReplyTo($this->email, $this->name);
        $mail->FromName = 'Cepe';
        $mail->Body = $content;

        $mail->AddAddress('faleconosco@cepe.com.br');

        if ($mail->Send()) {
            $resp = array(
                'success' => true,
                'title' => 'Formulário enviado com sucesso.',
                'message' => 'Clique para continuar'
            );
        } else {
            $resp = array(
                'success' => false,
                'title' => 'Formulário não foi enviado.',
                'message' => $mail->ErrorInfo
            );
        }

        die(json_encode($resp));
    }
}
