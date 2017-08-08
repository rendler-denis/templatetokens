<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 05/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Classes;

use Illuminate\Container\Container;
use Cms\Classes\Controller as CmsController;
use KoderHut\TemplateTokens\Models\Token;

/**
 * Class Tokens
 * Tokens injector class. It injects the tokens for each scope
 *
 * @package KoderHut\TemplateTokens\Classes
 */
class TokensService
{
    /**
     * Facade accessor name
     */
    const FACADE_ACCESSOR = 'KoderHut\TemplateTokens\TokensRegistrationService';

    /**
     * Token scopes
     */
    const TOKEN_SCOPE_GLOBAL = 'global';
    const TOKEN_SCOPE_PAGE   = 'page';
    const TOKEN_SCOPE_LAYOUT = 'layout';

    /**
     * App container placeholder
     *
     * @var Container
     */
    private $app;

    /**
     * The tag name used in the templates to access
     * the token values
     *
     * @var string
     */
    private $tmplTag = 'tk';

    /**
     * Class container
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    /**
     * Inject the tokens into each scope
     *
     * @param CmsController $controller
     *
     * @return $this
     */
    public function initScopeTokens(CmsController $controller = null)
    {
        if (! $controller instanceof CmsController) {
            return $this;
        }

        foreach ($this->getScopeTokens() as $tokenScope) {
            $tokens = Token::tokenScope($tokenScope)->get();

            if (self::TOKEN_SCOPE_GLOBAL === $tokenScope) {
                $controller->vars['this'][$this->tmplTag] = $this->initScope($tokenScope, $tokens);
                continue;
            }

            $controller->vars['this'][$tokenScope]->{$this->tmplTag} = $this->initScope($tokenScope, $tokens);
        }

        return $this;
    }

    /**
     * Return the token scopes
     *
     * @return array
     */
    public function getScopeTokens()
    {
        return [
            self::TOKEN_SCOPE_GLOBAL,
            self::TOKEN_SCOPE_PAGE,
            self::TOKEN_SCOPE_LAYOUT,
        ];
    }

    /**
     * Inject the tokens in each scope
     *
     * @param string     $scope
     * @param Collection $tokens
     */
    protected function initScope($scope, $tokens)
    {
        $scopeObj = null;

        try {
            $scopeObj = $this->app
                ->make(TokensManager::FACADE_ACCESSOR)
                ->setScope($scope)
                ->setTokens($tokens);
        }
        catch (\Exception $exc) {
            throw new TokenException($exc->getMessage(), 10001);
        }

        return $scopeObj;
    }
}