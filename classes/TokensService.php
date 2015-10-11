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

use KoderHut\TemplateTokens\Classes\TokensManager,
    KoderHut\TemplateTokens\Models\Token as TokensModel;

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

        $scopeBase = &$controller->vars['this'];

        foreach ($this->getScopeTokens() as $tokenScope) {
            $tokens = TokensModel::tokenScope($tokenScope)->get();

            if (self::TOKEN_SCOPE_GLOBAL === $tokenScope) {
                $scopeBase[$this->tmplTag] = new \stdClass();
                $scope     = &$scopeBase[$this->tmplTag];
            }
            else {
                $scopeBase[$tokenScope]->tk = new \stdClass();
                $scope = &$scopeBase[$tokenScope]->{$this->tmplTag};
            }

            $scope = $this->initScope($tokenScope, $tokens);
            unset($scope);
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
        $tokenConsts = [
            self::TOKEN_SCOPE_GLOBAL,
            self::TOKEN_SCOPE_PAGE,
            self::TOKEN_SCOPE_LAYOUT,
        ];

        return $tokenConsts;
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