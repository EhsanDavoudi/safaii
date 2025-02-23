<?php

namespace controllers;

use controllers\AdminController;
use models\AdminDealModel;

class AdminDealController extends AdminController
{
    private $type = 'deal';

    public function deals()
    {
        $this->listEntities($this->type);
    }

    public function dealabeUsers()
    {
        $this->listEntities('nobTokenList');
    }

    public function viewDeal()
    {
        $this->viewEntity($this->type);
    }

    public function editAdmin()
    {
        $fields = ['news_signal', 'trading_signal', 'tether_amount', 'status']; // Adjust fields as needed

        $this->editEntity($this->type, $fields);
    }

    public function deleteDeal()
    {
        $this->deleteEntity($this->type);
    }
}