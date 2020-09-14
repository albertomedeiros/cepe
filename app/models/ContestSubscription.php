<?php

class ContestSubscription extends ActiveRecord
{

    public function setup()
    {
//        $this->validates_presence_of('contest', 'Escolha o concurso');
//        $this->validates_presence_of('code', 'Digite o código da inscrição');
        $this->validates_presence_of('name', 'Digite o nome');
        $this->validates_presence_of('pseudonym', 'Digite o pseudônimo');
        $this->validates_presence_of('work_title', 'Digite o título da obra');
        $this->validates_presence_of('cpf', 'Digite o CPF');
        $this->validates_presence_of('rg', 'Digite o RG');
        $this->validates_presence_of('civil_status', 'Digite o estado civil');
        $this->validates_presence_of('profession', 'Digite a profissão');
        $this->validates_presence_of('address', 'Digite o endereço');
//        $this->validates_presence_of('complement', 'Digite o complemento');
        $this->validates_presence_of('zipcode', 'Digite o CEP');
//        $this->validates_presence_of('neighborhood', 'Digite o bairro');
//        $this->validates_presence_of('city', 'Digite a cidade');
//        $this->validates_presence_of('state', 'Escolha o estado');
        $this->validates_presence_of('country', 'Digite o país');
        $this->validates_presence_of('nationality', 'Escolha a nacionalidade');
        $this->validates_presence_of('email', 'Digite o e-mail');
        $this->validates_presence_of('category', 'Escolha a categoria');
        $this->validates_presence_of('rg_file', 'O envio do RG é obrigatório');
        $this->validates_presence_of('composition_file', 'O envio da Obra é obrigatório');
//        $this->validates_presence_of('cpf_file', 'O envio do CPF é obrigatório');
//        $this->validates_presence_of('proof_of_address_file', 'O envio do Comprovante de Residência é obrigatório');
//        $this->validates_presence_of('agreement_file', 'O envio do Termo de Concordância é obrigatório');

        $this->field_as_file('rg_file', array('public' => true));
        $this->field_as_file('cpf_file', array('public' => true));
        $this->field_as_file('proof_of_address_file', array('public' => true));
        $this->field_as_file('composition_file', array('public' => true));
        $this->field_as_file('agreement_file', array('public' => true));

        $this->has_many('ContestSubscriptionLog as logs');
    }

    public function after_create()
    {
        $suffix = '';
        switch ($this->genre) {
            case 'nacional';
                $preffix = 'CN';
                break;
            case 'infantojuvenil';
                $preffix = 'IF';
                break;
        }
        switch ($this->category) {
            case 'infantil':
                $suffix = 'INF';
                break;
            case 'juvenil':
                $suffix = 'JUV';
                break;
            case 'romance':
                $suffix = 'ROM';
                break;
            case 'conto':
                $suffix = 'CON';
                break;
            case 'poesia':
                $suffix = 'POE';
                break;
        }
        $this->code = sprintf('CN%s_%s', str_pad($this->id, 4, '0', STR_PAD_LEFT), $suffix);
        $this->save();

        $log = new ContestSubscriptionLog;
        $log->contest_subscription_id = $this->id;
        $log->title = 'Inscrição realizada com sucesso';
        $log->success = true;
        $log->save();
    }

    public function cancel()
    {
        if (!$this->cancelled_at) {
            $this->cancelled_at = date('Y-m-d H:i:s');
            $this->approved = 2;
            $this->save();

            $log = new ContestSubscriptionLog;
            $log->contest_subscription_id = $this->id;
            $log->title = 'Inscrição cancelada devido a submissão de novo cadastro.';
            $log->success = 2;
            $log->save();
        }
    }

    public function before_destroy()
    {
        $rg_file = FISHY_PUBLIC_PATH . '/' . $this->rg_file;
        $cpf_file = FISHY_PUBLIC_PATH . '/' . $this->cpf_file;
        $proof_of_address_file = FISHY_PUBLIC_PATH . '/' . $this->proof_of_address_file;
        $composition_file = FISHY_PUBLIC_PATH . '/' . $this->composition_file;
        $agreement_file = FISHY_PUBLIC_PATH . '/' . $this->agreement_file;

        @unlink($rg_file);
        @unlink($cpf_file);
        @unlink($proof_of_address_file);
        @unlink($composition_file);
        @unlink($agreement_file);
    }

    public function get_composition_filename()
    {
        $file = explode('/', $this->composition_file);
        $composition_file = end($composition_file);
        $pos = strpos($composition_file, '.');
        $filename = substr($composition_file, $pos + 1);

        return $filename;
    }

    public function get_composition_ext()
    {
        $composition_file = explode('.', $this->composition_file);
        $ext = end($composition_file);

        return '.' . $ext;
    }

    public function get_composition_ext_image()
    {
        $composition_file = explode('.', $this->composition_file);
        $ext = strtolower(end($composition_file));

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

    public function get_composition_file_size()
    {
        $bytes = filesize(FISHY_ROOT_PATH. '/public/'. $this->composition_file);

        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    
}