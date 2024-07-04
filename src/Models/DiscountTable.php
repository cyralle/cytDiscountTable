<?php

namespace cytDiscountTable\Models;

use Plenty\Modules\Plugin\DataBase\Contracts\Model;

class DiscountTable extends Model
{
    public $id              = 0;
    public $clientClass     = '';
    public $prefix          = '';
    public $WMR        = 0;
    public $KWR       = 0;
    public $WKZ       = 0;
    public $PR       = 0;

    public function getTableName(): string
    {
        return 'cytDiscountTable::DiscountTable';
    }
}

