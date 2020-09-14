<?php

class LicitacoesController extends MainController
{
    public function index()
    {
        if (!empty($_SESSION['download_file'])) {
            $file_id = $_SESSION['download_file'];
            if (isset($file_id)) {
                unset($_SESSION['download_file_check']);
                unset($_SESSION['download_file']);

                $query['conditions'] = 'id = ' . $file_id;
                $file = ActiveRecord::model('BiddingFile')->first($query);
                if ($file && file_exists(FISHY_PUBLIC_PATH.'/'. $file->path)) {
                    Fishy_DownloadHelper::force_download($file->title, file_get_contents(FISHY_PUBLIC_PATH.'/'. $file->path));
                }
            }
        }
        if (!empty($_SESSION['download_file_check'])) {
            $this->check = true;
            unset($_SESSION['download_file_check']);
        } else {
            $this->check = false;
        }

        $this->meta_tags(array(
            'meta_title'       => 'Licitações | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Licitações | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Licitações | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Licitações');

        $page_url = $this->site_url('licitacoes/page/');

        $this->pagination('Bidding', $page_url, 5);
    }

    public function search()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Busca | Licitações | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Busca | Licitações | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Busca | Licitações | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Licitações', $this->site_url('licitacoes'));
        $this->addBreadcrumbs('Busca');

        $page = $this->param('page', 1);
        $search = $this->param('search');

        $str_search = strtolower(utf8_decode($search));
        $page_url = $this->site_url('licitacoes/busca/page/');

        $query['conditions'] = 'status = 1 and date_published <= "' . date('Y-m-d H:i:s') . '" and (LOWER(CONVERT(CAST(CONVERT(title USING latin1) AS BINARY) USING utf8)) LIKE "%' . $str_search . '%" OR LOWER(CONVERT(CAST(CONVERT(text USING latin1) AS BINARY) USING utf8)) LIKE "%' . $str_search . '%")';
        $query['order'] = 'date_published desc';

        $limit = 5;
        $offset = ($page - 1) * $limit;

        $total = ActiveRecord::model('Bidding')->count($query);

        if ($total == 0) {
            $result_text = 'Não foi encontrado <b>nenhum registro</b> utilizando o termo <b>“' . $search . '”</b>.';
        } elseif ($total == 1) {
            $result_text = 'Foi encontrado <b>1 registro</b> utilizando o termo <b>“' . $search . '”</b>.';
        } else {
            $result_text = 'Foram encontrados <b>' . $total . ' registros</b> utilizando o termo <b>“' . $search . '”</b>.';
        }

        $total = ceil($total / $limit);
        $prev = $page > 1 ? $page - 1 : 1;
        $next = $page < $total ? $page + 1 : $total;

        $this->prev = $page_url . $prev . '?search=' . $search;
        $this->next = $page_url . $next . '?search=' . $search;
        $this->page = $page;
        $this->total = $total;

        $query['limit'] = $limit;
        $query['offset'] = $offset;

        $this->data = ActiveRecord::model('Bidding')->all($query);
        $this->result_text = $result_text;

        $this->render('index');
    }

    public function check_cpf_cnpj()
    {
        if (isset($_POST['cpf-cnpj'])) {
            $cpf_cnpj = $_POST['cpf-cnpj'];
            $cpf_cnpj = str_replace(".", "", $cpf_cnpj);
            $cpf_cnpj = str_replace("-", "", $cpf_cnpj);
            $cpf_cnpj = str_replace("/", "", $cpf_cnpj);
            $query['conditions'] = 'status = 1 AND cpf_cnpj = "' . $cpf_cnpj . '"';

            $this->register = ActiveRecord::model('Register')->first($query);
            $bf = ActiveRecord::model('BiddingFile')->find($_POST['id_download']);
            

            
            if ($this->register) {

                $bidding = $bf->bidding;
                $query = array();
                $query['select'] = 'biddings.*';
                $query['joins']='inner join bidding_registers on (bidding_registers.bidding_id = biddings.id and bidding_registers.register_id = '.$this->register->id.' and bidding_registers.bidding_id='.$bidding->id.')';
                if(!ActiveRecord::model('Bidding')->first($query)){
                   //$bidding->fill(array('registers'=>array($this->register->id)));
                   //$bidding->save();
                    $data['bidding_id'] = $bidding->id;
                    $data['register_id'] = $this->register->id;

                    $log = new BiddingRegister();
                    $log->fill($data);
                    $log->save(); 

                }
                

                $_SESSION['download_file'] = $_POST['id_download'];
                $resp = array(
                  'success' => true,
                  'redirect' => true,
                );
            } else {
                $_SESSION['download_file_register'] = $_POST['id_download'];

                $resp = array(
                  'success' => true,
                  'register' => true,
                );
            }

            die(json_encode($resp));
        }
    }

    public function register()
    {
        $this->_render_layout = false;

        foreach ($_POST as $field => $value) {
            $this->$field = $value;
        }
        $query['conditions'] = 'status=1 AND email = "' .  $this->email . '"';

        $subscription = ActiveRecord::model('Register')->first($query);

        if ($subscription) {
            $resp = array(
              'success' => false,
              'title' => 'Formulário não foi enviado.',
              'message' => "email já cadastrado"
          );
            die(json_encode($resp));
        }

        $subscription = new Register();
        $cpf = $this->cpf;
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $cpf = str_replace("/", "", $cpf);

        $subscription->cpf_cnpj = $cpf;
        $subscription->name = $this->nome;
        $subscription->email = $this->email;
        $subscription->social = $this->razao;
        $subscription->save();

        $mail = new PHPMailer;
        $mail->IsSMTP();

        $this->md5_registro = md5($this->email);
        $mail->Host = 'mail.smtp2go.com';
        $mail->Username = 'turquesa';
        $mail->Password = 'NWU2c21sbGR5cmEw';
        $mail->SMTPSecure = 'TLS';
        $mail->Port = 587;

        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Contato | Cepe';
        $mail->From = 'no-reply@cepe.com.br';
        $mail->FromName = 'Cepe';
        $content = $this->render('main', array('return' => true, 'controller' => 'mail'));

        $mail->Body = $content;

        $mail->AddAddress($subscription->email);

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

    public function ativar_registro()
    {
        $id_md5 = $this->param("id");
        $subscription = ActiveRecord::model('Register')->all();
        foreach ($subscription as $value) {
            if (md5($value->email) == $id_md5) {
                $value->status = 1;
                $value->save();
                $_SESSION['download_file_check'] = true;
            }
        }
        $this->redirect_to('licitacoes/');
    }
}
