<?php

namespace cytDiscountTable\Repositories;

use Plenty\Exceptions\ValidationException;
use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use cytDiscountTable\Contracts\DiscountTableRepositoryContract;
use cytDiscountTable\Models\DiscountTable;
use cytDiscountTable\Validators\DiscountTableValidator;
use Plenty\Modules\Frontend\Services\AccountService;
//use cytDiscountTable\Helper\PaginatedResultBuilder;


class DiscountTableRepository implements DiscountTableRepositoryContract
{
    private $accountService;

    /**
     * UserSession constructor.
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Add a new item to the To Do list
    */
    public function createEntry(array $data): DiscountTable
    {
        try {
            DiscountTableValidator::validateOrFail($data);
        } catch (ValidationException $e) {
            throw $e;
        }

        $database = pluginApp(DataBase::class);
        $res = pluginApp(DiscountTable::class);

        $res->clientClass = $data['clientClass'];
        $res->prefix = $data['prefix'];
        $res->WMR = $data['wmr'];
        $res->KWR = $data['kwr'];
        $res->WKZ = $data['wkz'];
        $res->PR = $data['pr'];
        $res->createdAt = time();
        //$res->userId = $this->getCurrentContactId();
        
        $database->save($res);

        return $res;
    }

    /**
     * List all items of the To Do list
     */
    public function getEntries(): array
    {
        $database = pluginApp(DataBase::class);
        $res = $database->query(DiscountTable::class)->get();
        return $res;
    }

    /**
     * Update the status of the item
     */
    public function updateEntry($id): DiscountTable
    {
        $database = pluginApp(DataBase::class);
        $stats = $database->query(DiscountTable::class)
            ->where('id', '=', $id)
            ->get();

        $res = $stats[0];
        $database->save($res);

        return $res;
    }

    /**
     * Delete an item from the To Do list
     */
    public function deleteEntry($id): DiscountTable
    {
        $database = pluginApp(DataBase::class);

        $stats = $database->query(DiscountTable::class)
            ->where('id', '=', $id)
            ->get();

        $res = $stats[0];
        $database->delete($res);

        return $res;
    }

     /**
     * Delete all items from the To Do list
     */
    public function deleteAllEntries(): array
    {
        $database = pluginApp(DataBase::class);

        $stats = $database->query(DiscountTable::class)
            ->get();

        foreach ($stats as $stat) {
            $database->delete($stat);
        }
        return $stats;
    }
}
