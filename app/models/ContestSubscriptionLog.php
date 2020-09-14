<?php

class ContestSubscriptionLog extends ActiveRecord
{

    public function setup()
    {
        $this->validates_presence_of('contest_subscription_id', 'Escolha a inscrição');
        $this->validates_presence_of('title', 'Digite o texo');
    }

}