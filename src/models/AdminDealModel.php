<?php

namespace models;

use models\AdminModel;

class AdminDealModel extends AdminModel
{
    private $table = 'deals';

    public function getDeals($start_limit, $results_per_page)
    {
        return $this->get($this->table, $start_limit, $results_per_page);
    }

    public function getTotalDeals()
    {
        return $this->getTotal($this->table);
    }

    public function createDeal()
    {
        
    }
    
    public function dealInfo()
    {
        if (isset($_GET['id'])) {
            $dealID = $this->conn->real_escape_string($_GET['id']);

            $dealInfo = $this->read($this->table, $dealID);

            if ($dealInfo) {
                return $dealInfo;
            } else {
                return "<h4>No Such User Found</h4>";
            }
        } else {
            return "<h4>No User ID Provided</h4>";

        }
    }

    public function editDeal($id, $newsSignal = null, $tradingSignal = null, $tetherAmount = null, $status = null)
    {
        $fieldsToUpdate = [
            'news_signal' => $newsSignal,
            'trading_signal' => $tradingSignal,
            'tether_amount' => $tetherAmount,
            'status' => $status,
        ];

        return $this->edit($this->table, $id, $fieldsToUpdate);
    }

    public function deleteDeal($id)
    {
        return $this->delete($this->table, $id);
    }

    public function nobTokenList()
    {
        $validUserIds = [];

        $nobTokenLissQuery = "SELECT * FROM users WHERE nobitex_token IS NOT NULL AND nobitex_token != ''";

        $result = $this->conn->query($nobTokenLissQuery);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function nobTokenCheck($nobitexToken)
    {
        $state = new NobitexApi($nobitexToken);
        $isCheck = $state->profile();
        $data = json_decode($isCheck, true);
        $check = $data['status'] ?? null;
        if (!$check) {
            return false;
        } else return true;
    }
}