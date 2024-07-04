<?php

namespace cytDiscountTable\Extensions;

use Plenty\Plugin\Templates\Extensions\Twig_Extension;
use Plenty\Plugin\Templates\Factories\TwigFactory;
use cytDiscountTable\Contracts\DiscountTableRepositoryContract;

class DiscountTableTwigExtension extends Twig_Extension
{
    private $twig;

    public function __construct(TwigFactory $twig)
    {
        $this->twig = $twig;
    }

    public function getName(): string
    {
        return "cytDiscount_Extension";
    }

    public function getFilters(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return  [
            $this->twig->createSimpleFunction('cyt_discount_table', [$this, 'getDiscountTable'])
        ];
    }

    /**
     * Expose the TwigExtension
     * @return array
     */
    public function getGlobals(): array
    {
        return [];
    }

    public function getDiscountTable()
    {
        $repo =  pluginApp(DiscountTableRepositoryContract::class);
        return $repo->getEntries();
    }
}
