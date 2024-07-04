<?php

namespace cytDiscountTable\Containers;

use Plenty\Plugin\Templates\Twig;
use cytDiscountTable\Contracts\DiscountTableRepositoryContract;

class DiscountContainer
{
    public function call(Twig $twig):string
    {
        return $twig->render('cytDiscountTable::content.DiscountTable', ['discountTable' => $this->getDiscountTable()]);
    }

    public function getDiscountTable()
    {
        $repo =  pluginApp(DiscountTableRepositoryContract::class);
        return $repo->getEntries();
    }
}