<?php

namespace cytDiscountTable\Migrations;

use cytDiscountTable\Models\DiscountTable;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

/**
 * Class CreateDiscountTable
 */
class DeleteDiscountTable
{
    /**
     * @param Migrate $migrate
     */
    public function delete(Migrate $migrate)
    {
        $migrate->deleteTable(DiscountTable::class);
    }
}
