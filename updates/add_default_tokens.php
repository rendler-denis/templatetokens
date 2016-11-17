<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 07/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Updates;

use Seeder;

use Backend\Models\BrandSetting;

use KoderHut\TemplateTokens\Classes\TokensService;
use KoderHut\TemplateTokens\Models\Token;


class AddDefaultTokens
    extends Seeder
{

    
    public function run()
    {
        Token::create([
            'token_name'  => 'app_name',
            'token_value' => BrandSetting::get('app_name'),
            'token_scope' => TokensService::TOKEN_SCOPE_GLOBAL,
        ]);

        Token::create([
            'token_name'  => 'app_tagline',
            'token_value' => BrandSetting::get('app_tagline'),
            'token_scope' => TokensService::TOKEN_SCOPE_GLOBAL,
        ]);
    }
}
