<?php

namespace cytDiscountTable\Migrations;

use cytDiscountTable\Models\DiscountTable;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

/**
 * Class CreateDiscountTable
 */
class CreateDiscountTable
{
    /**
     * @param Migrate 
     */
    public function run(Migrate $migrate)
    {
        $migrate->createTable(DiscountTable::class);
    }
}
