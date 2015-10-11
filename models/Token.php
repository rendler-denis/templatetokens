<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 05/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Models;

use Model;

use KoderHut\TemplateTokens\Classes\Support\Facades\Tokens as TokensFacade;

/**
 * Config Model
 */
class Token
    extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * Main table for the plug-in
     * This table is used to store the tokens and their values
     */
    const TEMPLATE_VARS_TABLE_NAME = 'koderhut_template_tokens';

    /**
     * @var string The database table used by the model.
     */
    public $table = self::TEMPLATE_VARS_TABLE_NAME;

    /**
     * The model's primary key.
     * This is different from the primary key stored in the DB
     * in order to better use the Collections models
     *
     * @var string
     */
    public $primaryKey = 'token_name';

    public $rules = [
        'token_name'  => 'required',
        'token_value' => 'required',
        'token_scope' => 'required',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['token_name', 'token_value', 'token_scope'];

    /**
     * Query scope method to add the token_scope constraint
     *
     * @param        $query
     * @param string $tokenScope
     *
     * @return mixed
     */
    public function scopeTokenScope($query, $tokenScope)
    {
        return $query->where('token_scope', $tokenScope);
    }

    /**
     * Set up the token scope dropdown values
     *
     * @return array
     */
    public function getTokenScopeOptions()
    {
        $tokenScopes = [];
        $scopes      = TokensFacade::getScopeTokens();

        foreach ($scopes as $scopeName) {
            $tokenScopes[$scopeName] = ucfirst($scopeName);
        }

        return $tokenScopes;
    }
}