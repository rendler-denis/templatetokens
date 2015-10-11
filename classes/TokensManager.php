<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 06/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Classes;

use Illuminate\Database\Eloquent\Collection;

use KoderHut\TemplateTokens\Models\Token;

/**
 * Class TokensManager
 * Manage the tokens inside the templates. Its role is to store and
 * retrieve the token values. When requested by Twig retrieve the value
 * from the Token items collection
 *
 * @package KoderHut\TemplateTokens\Classes
 */
class TokensManager
{
    /**
     * Facade accessor name
     */
    const FACADE_ACCESSOR = 'KoderHut\TemplateTokens\TokensManager';

    /**
     * Define the scope
     *
     * @var string
     */
    private $scope  = '';

    /**
     * Tokens and their values in current scope
     *
     * @var Collection
     */
    private $tokens = null;

    /**
     * Set the tokens scope
     *
     * @param string $scope
     *
     * @return $this
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Set the tokens collection
     *
     * @param Collection $tokens
     *
     * @return $this
     */
    public function setTokens(Collection $tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * Retrieve token data
     *
     * @param string $tokenName
     *
     * @return mixed
     */
    public function __get($tokenName)
    {
        $token = $this->tokens->find($tokenName);

        if (! $token instanceof Token) {
            return null;
        }

        $tokenVal = $token->token_value;

        return $tokenVal;
    }

    /**
     * Check if token is available
     *
     * @param string $tokenName
     *
     * @return bool
     */
    public function __isset($tokenName)
    {
        return (bool)$this->tokens->contains($tokenName);
    }
}