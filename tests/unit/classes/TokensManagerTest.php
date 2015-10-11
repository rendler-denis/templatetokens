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

use PluginTestCase;

use Illuminate\Database\Eloquent\Collection;

use KoderHut\TemplateTokens\Classes\TokensManager,
    KoderHut\TemplateTokens\Models\Token;

class TokensManagerTest
    extends PluginTestCase
{

    /**
     * Token scopes
     */
    const TOKEN_SCOPE_GLOBAL = 'global';
    const TOKEN_SCOPE_PAGE   = 'page';
    const TOKEN_SCOPE_LAYOUT = 'layout';

    /**
     * Token scopes array
     *
     * @var array
     */
    private $tokenConsts = [
        self::TOKEN_SCOPE_GLOBAL,
        self::TOKEN_SCOPE_PAGE,
        self::TOKEN_SCOPE_LAYOUT,
    ];

    private $tokensCollection = [];

    /**
     * Set up the tests object
     */
    public function setUp()
    {
        parent::setUp();

        $token = new Token();

        foreach ($this->tokenConsts as $scope) {
            $this->tokensCollection[$scope] = Collection::make();

            for ($i = 0; $i <= 4; $i++) {
                $item = $token->newInstance([
                    'token_name'  => 'val_' . ($i + 1),
                    'token_value' => "val-{$scope}-" . ($i + 1),
                    'token_scope' => $scope
                ]);

                $this->tokensCollection[$scope]->add($item);
            }
        }
    }

    /**
     * Test the tokensmanager tokens collection
     */
    public function testTokensCollection()
    {
        $tokenMgrGlobal = new TokensManager();
        $tokenMgrPage   = new TokensManager();
        $tokenMgrGlobal->setTokens($this->tokensCollection[self::TOKEN_SCOPE_GLOBAL]);
        $tokenMgrPage->setTokens($this->tokensCollection[self::TOKEN_SCOPE_PAGE]);

        //check if null value is returned when token is not found
        $this->assertNull($tokenMgrGlobal->{'null_value'});

        //check that the correct token value is returned
        $this->assertEquals('val-global-1', $tokenMgrGlobal->val_1);
        $this->assertEquals('val-page-1', $tokenMgrPage->val_1);

        //check that the scope vars differ
        $this->assertNotEquals($tokenMgrPage->val_2, $tokenMgrGlobal->val_2);

    }
}