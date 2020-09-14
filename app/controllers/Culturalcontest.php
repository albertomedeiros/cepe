<?php

class CulturalContestController extends MainController
{

    public $scripts = array();

    public function initialize()
    {
        parent::initialize();

        $this->news = ActiveRecord::model('ContestNews')->all(array(
            'conditions' => array(
                'status' => 1,
            ),
            'order' => 'date DESC'
        ));
    }

    public function check_cpf()
    {
        $subscription = ActiveRecord::model('ContestSubscription')->all(array(
            'conditions' => array(
                'cpf' => $_POST['cpf'],
                'genre' => $_POST['genre'],
            )
        ));

        $response = array();
        if (!empty($subscription)) {
            $response = array(
                'success' => false,
                'message' => 'Esse CPF já possui inscrição para essa modalidade.'
            );
        } else {
            $response = array(
                'success' => true,
                'message' => 'CPF ok.'
            );
        }

        die(json_encode($response));
    }

    public function step1()
    {
        $this->attachments = ActiveRecord::model('ContestAttachment')->all(array(
            'conditions' => array(
                'contest' => 'cultural_contest_2019',
                'status' => 1
            ),
            'order' => 'created_at DESC'
        ));
        $this->scripts[] = 'js/app/culturalcontest/step1.js';
    }

    public function step2()
    {

    }

    public function step2_2()
    {

    }

    public function step3()
    {
        if (Fishy_Uri::segment(3)) {
            $_SESSION['premio_cepe']['menor'] = true;
        } else {
            $_SESSION['premio_cepe']['menor'] = false;
        }
    }

    public function step4()
    {
        $this->validate_genre();
        $this->scripts[] = 'js/app/culturalcontest/step4.js';
    }

    public function step5()
    {
        $this->validate_genre();
        if ((empty($_POST) || !$_POST['terms_agreed']) && empty($_COOKIE['terms_agreed'])) {
            $this->redirect_to('premio-cepe/inscricao');
        }
        setcookie('terms_agreed', true, time()+3600);

        $this->subscription = new ContestSubscription();
        if (!empty($_POST['subscription'])) {
            $subscription = new ContestSubscription;
            $subscription->contest = 'cultural_contest_2019';
            $subscription->fill($_POST['subscription']);

            if ($subscription->is_valid()) {
                $this->cancel_subscription($_POST['subscription']['cpf'], $_POST['subscription']['genre']);

                $subscription->save();
                $this->send_subscription_email($subscription);

                $_SESSION['premio_cepe']['subscription_id'] = $subscription->id;
                $this->redirect_to('premio-cepe/sucesso');
            } else {
                $this->subscription = $subscription;
                $this->problems = $subscription->problems();
            }
        }

        if ($this->genre === 'nacional') {
            $categories = array(
                'conto' => 'Conto',
                'poesia' => 'Poesia',
                'romance' => 'Romance',
            );
        } else {
            $categories = array(
                'infantil' => 'Infantil',
                'juvenil' => 'Juvenil',
            );
        }

        $this->categories = $categories;
        $this->scripts[] = 'js/app/culturalcontest/form.js';
    }

    /**
     * Renders success page
     */
    public function step6()
    {
        if (!empty($_SESSION['premio_cepe']['subscription_id'])) {
            $subscription_id = $_SESSION['premio_cepe']['subscription_id'];
            unset($_SESSION['premio_cepe']['subscription_id']);
            $this->subscription = ActiveRecord::model('ContestSubscription')->find($subscription_id);

            switch($this->subscription->genre) {
                case 'infantojuvenil':
                    $this->title = 'Infantojuvenil';
                    break;
                case 'nacional':
                    $this->title = 'Nacional';
                    break;
            }

        } else {
            $this->redirect_to('premio-cepe/inscricao');
        }
    }

    public function check_subscription()
    {
        if(empty($_POST)) {
            return $this->redirect_to('premio-cepe/inscricao');
        }

        $this->subscription = ActiveRecord::model('ContestSubscription')->find_by_code($_POST['subscription_id']);
    }

    private function cancel_subscription($cpf, $genre)
    {
        $subscriptions = ActiveRecord::model('ContestSubscription')->all(array(
            'conditions' => array(
                'cpf' => $cpf,
                'genre' => $genre,
            )
        ));

        foreach ($subscriptions as $subscription) {
            $subscription->cancel();
        }
    }

    private function send_subscription_email($subscription)
    {
        $this->_render_layout = false;

        $this->subscription = $subscription;
        $content = $this->render_partial('subscription.mail', null, array('return' => true));

        $mail = new PHPMailer;
         $mail->IsSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'concursoliterario@cepe.com.br';
        $mail->Password = 'c3p3@intranet';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->SMTPAuth = true;

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Inscrição Concurso Cultural | Cepe';
        $mail->From = 'no-reply@cepe.com.br';
        $mail->FromName = 'Cepe';
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
    }

    private function validate_genre()
    {
        $genre = $this->param('genero');

        switch($genre) {
            case 'infantojuvenil':
                $title = 'Infantojuvenil';
                break;
            case 'nacional':
                $title = 'Nacional';
                break;
            default:
                $this->redirect_to('premio-cepe/inscricao');
                die;
        }

        $this->genre = $genre;
        $this->title = $title;
    }

}