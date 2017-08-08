<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 06/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Classes\Support\Facades;

use Illuminate\Support\Facades\Facade;
use KoderHut\TemplateTokens\Classes\TokensService as TKS;

/**
 * Class Tokens
 * Facade class
 *
 * @package KoderHut\TemplateTokens\Classes\Support\Facades
 */
class Tokens extends Facade
{
    /**
     * Return the facade namespace
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return TKS::FACADE_ACCESSOR;
    }
}