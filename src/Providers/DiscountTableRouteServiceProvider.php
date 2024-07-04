<?php

namespace cytDiscountTable\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;
 
class DiscountTableRouteServiceProvider extends RouteServiceProvider
{
	public function map(Router $router)
	{
        $router->get('/cytDiscountTable/version','cytDiscountTable\Controllers\ContentController@version');

        $router->get('/cytDiscountTable/logUrl', 'cytDiscountTable\Controllers\ContentController@getLogUrl');
        $router->get('/cytDiscountTable/deleteLog', 'cytDiscountTable\Controllers\ContentController@deleteLog');

        $router->get('/cytDiscountTable/deleteTable', 'cytDiscountTable\Migrations\DeleteDiscountTable@delete');
		$router->get('/cytDiscountTable/createTable', 'cytDiscountTable\Migrations\CreateDiscountTable@run');

        $router->get('cytDiscountTable', 'cytDiscountTable\Controllers\ContentController@index');
        $router->post('cytDiscountTable', 'cytDiscountTable\Controllers\ContentController@create');
        $router->put('cytDiscountTable/{id}', 'cytDiscountTable\Controllers\ContentController@update')->where('id', '\d+');
		$router->delete('cytDiscountTable/{id}', 'cytDiscountTable\Controllers\ContentController@delete')->where('id', '\d+');
 	}
}
