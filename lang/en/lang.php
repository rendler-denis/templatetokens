<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 05/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

return [
    'plugin' => [
        'namespace'   => 'KoderHut',
        'name'        => 'KoderHut TemplateTokens',
        'description' => 'A configurable template tokens manager',

        'config'      => [
            'label'       => 'TemplateTokens',
            'description' => 'Manage user tokens in templates.',
            'category'    => 'KoderHut',
            'keywords'    => '',
        ]
    ],

    'tabs'   => [
        'general'     =>[
            'name'  => 'general',
            'label' => 'General',
        ],

        'custom_tokens' => [
            'name'  => 'custom_token',
            'label' => 'Custom Variables',
        ]
    ],

    'forms'  => [
        'create' => [
            'label' => 'Create New Variable',
        ],
    ],

    'fields' => [
        'token_name'  => [
            'label'       => 'Token Name',
            'description' => 'Enter the token name',
            'placeholder' => 'Enter the token name',
        ],

        'token_scope'  => [
            'label'       => 'Token Scope',
            'description' => 'Enter the token\'s scope',
            'placeholder' => 'Enter the token\'s scope',
        ],

        'token_value' => [
            'label'       => 'Token Value',
            'description' => 'Enter the token\'s replacement value',
            'placeholder' => 'Enter the token\'s replacement value',
        ],

        'add_token' => [
            'label'       => 'Add New Token',
        ],

        'delete_token' => [
            'label'       => 'Remove Token(s)',
        ],

        'list_page_title' => [
            'label'       => 'Manage Template Tokens',
        ],

        'create_button' => [
            'label'       => 'Add New Token',
        ],

    ],

    'popup'      => [
        'create_token' => 'Add New Token',
        'update_token' => 'Update Token',
    ],

    'exceptions' => [
        23000 => 'We were unable to save the token because it already exists in the same scope. Please choose to edit the existing one.',
        10001 => 'We were unable to inject tokens. Please contact the developer.'
    ],

    'messages'   => [
        'tokens_list_hint'     => 'Manage the tokens available in the templates.',
        'delete_token_warning' => 'Are you sure you want to delete this token?'
    ],

];