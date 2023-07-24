<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
        $router = new RouteList;
        $router[] = $module = new RouteList('Admin');
        $module->addRoute('admin/<presenter>/<action>', 'Dashboard:default');

        $router[] = $module = new RouteList('Front');
        $module->addRoute('kontakt', 'Contact:default');
        $module->addRoute('clanek/<id>', 'Article:detail');
        $module->addRoute('<url>', 'Article:default');
        $module->addRoute('<presenter>/<action>', 'Homepage:default');
        $module->addRoute('<presenter>/<url>', 'Cms:default');
        return $router;
	}
}
