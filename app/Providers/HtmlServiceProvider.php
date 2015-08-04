<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 05/07/2015
 * Time: 03:23 PM
 */

namespace AccountHon\Providers;


use AccountHon\Components\HtmlBuilder;
use Collective\Html\HtmlServiceProvider as CollectiveHtmlServiceProvider;

class HtmlServiceProvider extends CollectiveHtmlServiceProvider
{
    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->bindShared('html', function($app)
        {
            return new HtmlBuilder($app['url']);
        });
    }
}