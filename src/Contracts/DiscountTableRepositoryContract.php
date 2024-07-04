<?php

namespace cytDiscountTable\Contracts;

use cytDiscountTable\Models\DiscountTable;

/**
 * Class DiscountTableRepositoryContract
 * @package cytDiscountTable\Contracts
 */
interface DiscountTableRepositoryContract
{
    /**
     * Add a new Entry to the To Do list
     *
     * @param array $data
     * @return DiscountTable
     */
    public function createEntry(array $data): DiscountTable;

    /**
     * List all Entries of the DiscountTable
     *
     * @return DiscountTable[]
     */
    public function getEntries(): array;

    /**
     * Update the status of the Entry
     *
     * @param int $id
     * @return DiscountTable
     */
    public function updateEntry($id): DiscountTable;

    /**
     * Delete a Entry from the To Do list
     *
     * @param int $id
     * @return DiscountTable
     */
    public function deleteEntry($id): DiscountTable;

    /**
     * Delete all Entries from the To Do list
     *
     *  * @return array
    */
    public function deleteAllEntries(): array;
} 
