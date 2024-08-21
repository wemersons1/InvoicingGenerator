<?php

namespace App\Services\Contract;

use App\Models\Contract;

class CreateContractService {

    public function execute()
    {
        return Contract::create();
    }
}
