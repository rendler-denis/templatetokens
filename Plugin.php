<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 05/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens;

use Config,
    Backend,
    Event;

use Cms\Classes\Controller as CmsController;

use System\Classes\PluginBase;

use KoderHut\TemplateTokens\Classes\TokensManager,
    KoderHut\TemplateTokens\Classes\TokensService,
    KoderHut\TemplateTokens\Classes\Support\Facades\Tokens as TokensFacade;


/**
 * Webvars Plugin Information And Install Class
 */
class Plugin
    extends PluginBase
{

    /**
     * Plug-in namespace
     */
    const KODERHUT_TEMPLATETOKENS_NS = 'KoderHut\TemplateTokens';

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'koderhut.templatetokens::lang.plugin.name',
            'description' => 'koderhut.templatetokens::lang.plugin.description',
            'author'      => 'Denis-Florin Rendler',
            'icon'        => 'icon-quote-left',
            'homepage'    => 'https://github.com/rendler-denis/templatetokens',
        ];
    }

    /**
     * Set up a few things during plug-in boot
     */
    public function boot()
    {
        $this->app->bind(TokensManager::FACADE_ACCESSOR, function ($app)
        {
            return new TokensManager();
        });

        $this->app->bind(TokensService::FACADE_ACCESSOR, function ($app)
        {
            return new TokensService($app);
        });
    }

    /**
     * Register our event listener where we inject the variables
     * and our main classes
     */
    public function register()
    {
        /**
         * Register a listener to inject the tokens before the
         * page and layout are rendered
         */
        Event::listen('cms.page.init', function(CmsController $controller = null)
        {
            if (null === $controller) {
                return;
            }

            TokensFacade::initScopeTokens($controller);
        });
    }

    /**
     * Register the plug-in settings
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'token_config' => [
                'label'       => 'koderhut.templatetokens::lang.plugin.config.label',
                'description' => 'koderhut.templatetokens::lang.plugin.config.description',
                'category'    => 'KoderHut',
                'icon'        => 'icon-quote-left',
                'url'         => Backend::url('koderhut/templatetokens/config'),
                'order'       => 500,
                'keywords'    => ''
            ]
        ];
    }
}