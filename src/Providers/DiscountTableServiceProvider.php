<?php

namespace cytDiscountTable\Providers;


use Ceres\Helper\LayoutContainer;

use Plenty\Plugin\ServiceProvider;
use cytDiscountTable\Providers\DiscountTableRouteServiceProvider;

use cytDiscountTable\Contracts\DiscountTableRepositoryContract;
use cytDiscountTable\Repositories\DiscountTableRepository;

use cytDiscountTable\Extensions\DiscountTableTwigExtension;

use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\ResourceContainer;

use IO\Extensions\Functions\Partial;
use IO\Helper\TemplateContainer;
use IO\Helper\ComponentContainer;

use cytDiscountTable\Traits\LoggingTrait;

class DiscountTableServiceProvider extends ServiceProvider
{
	use LoggingTrait;
	const PRIORITY = 0;

	public function register()
	{
        $this->getApplication()->register(DiscountTableRouteServiceProvider::class);
        $this->getApplication()->bind(DiscountTableRepositoryContract::class, DiscountTableRepository::class);
 	}
	
	/** https://developers.plentymarkets.com/en-gb/developers/main/plentyshop-plugins/theme-plugins.html */
	 public function boot(Twig $twig, Dispatcher $eventDispatcher)
	 {
		//$twig->addExtension(DiscountTableTwigExtension::class);
		
		$eventDispatcher->listen("Ceres.LayoutContainer.Script.AfterScriptsLoaded", 
			function (LayoutContainer $container) use ($twig) {
            	//$container->addContent($twig->render('cytDiscountTable::Scripts'));
        	}
		);
		
		$eventDispatcher->listen('IO.Resources.Import',
			function (ResourceContainer $container) {
				//$container->addScriptTemplate('cytDiscountTable::Components.ItemPrice');
			}
		);	

		//$this->overrideTemplate("Ceres::PageDesign.PageDesign", "cytDiscountTable::PageDesign.PageDesign");
		
	 /**
     * Boot a template for the footer that will be displayed in the template plugin instead of the original footer.
	 * Available partials are: head, header, footer and page-design. 
	 * You can also add your own partials by using the set('your-partial', 'Plugin::PartialTemplate') 
	 * method to extend the original page design
     */
	/* Changing the page design */

	 
		$eventDispatcher->listen('IO.init.templates', function(Partial $partial)
        {
           $partial->set('footer', 'cytDiscountTable::content.ThemeFooter');
        }, self::PRIORITY);
		return false;
		/*
		* The priority of the template. Original plentyShop LTS templates have a priority of 100. 
		* Any number less than 100 will indicate a higher priority. 
		* We use the return false statement to interrupt the chain of events.
		*/
		/** Changing the template of a page */
/*       
		$eventDispatcher->listen('IO.tpl.basket', function(TemplateContainer $container, $templateData)
        {
            //$container->setTemplate('cytDiscountTable::content.ThemeBasket');
            return false;
        }, self::PRIORITY);
*/
   	 }

}


