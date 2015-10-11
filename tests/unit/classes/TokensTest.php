<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 06/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Tests\Unit\Classes;

use App,
    PluginTestCase;

use KoderHut\TemplateTokens\Classes\TokensService;

/**
 * Class TokensTest
 *
 * @package KoderHut\TemplateTokens\Tests\Classes
 */
class TokensTest
    extends PluginTestCase
{
    const TOKEN_SCOPE_LAYOUT = 'layout';

    /**
     * @var TokensService
     */
    private $tokenObj;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->tokenObj = new TokensService(App::getFacadeRoot());
    }

    /**
     * Test the tokensservice scopes
     */
    public function testTokenScopes()
    {
        $this->assertCount(3, $this->tokenObj->getScopeTokens());

        $this->assertContains(self::TOKEN_SCOPE_LAYOUT, $this->tokenObj->getScopeTokens());
    }
}