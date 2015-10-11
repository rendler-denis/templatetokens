<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 05/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Updates;

use Schema;

use October\Rain\Database\Updates\Migration;

use KoderHut\TemplateTokens\Models\Token;

/**
 * Class CreateVariablesTable
 *
 * @package KoderHut\TemplateTokens\Updates
 */
class CreateTokensTable
    extends Migration
{

    /**
     * Create the main table where we store the new
     * tokens and their values
     */
    public function up()
    {
        Schema::create(Token::TEMPLATE_VARS_TABLE_NAME, function($table)
        {
            $table->increments('entity_id');
            $table->string('token_name', 100)
                ->nullable(false);
            $table->string('token_value')
                ->nullaable(false);
            $table->string('token_scope')
                ->nullaable(false);
            $table->timestamps();

            $table->unique(['token_name', 'token_scope',], 'UNQ_KH_TK_VAR_NAME_VAR_SCOPE');
        });
    }

    /**
     * Remove the table
     */
    public function down()
    {
        Schema::dropIfExists(Token::TEMPLATE_VARS_TABLE_NAME);
    }
}