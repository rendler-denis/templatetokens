<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 06/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Controllers;

use Illuminate\Database\QueryException;
use System\Classes\SettingsManager;
use Backend\Classes\Controller as BackendController;
use KoderHut\TemplateTokens\Classes\TokenException;
use KoderHut\TemplateTokens\Models\Token;

/**
 * Config Back-end Controller
 */
class Config extends BackendController
{

    /**
     * Implemented behaviors
     *
     * @var array
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    public $formConfig = 'config_form.yaml';

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    public $listConfig = 'config_list.yaml';

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();

        \BackendMenu::setContext('October.System', 'system', 'config');
        SettingsManager::setContext('KoderHut.TemplateTokens', 'token_config');

        $this->addJs('/plugins/koderhut/templatetokens/assets/js/templatetokens.js');
    }

    /**
     * @return mixed
     *
     * @throws \SystemException
     */
    public function onCreateToken()
    {
        $this->asExtension('FormController')->create();

        return $this->makePartial('create_token');
    }

    /**
     * @return mixed
     * @throws TokenException
     */
    public function onCreate()
    {
        try {
            $this->asExtension('FormController')->create_onSave();

            return $this->listRefresh();
        } catch (QueryException $exc) {
            \App::make('Illuminate\Contracts\Debug\ExceptionHandler')->report($exc);

            throw new TokenException('', $exc->getCode());
        }
    }

    /**
     * Create the popup to edit the token
     *
     * @return mixed
     *
     * @throws \SystemException
     */
    public function onUpdateToken()
    {
        $this->asExtension('FormController')->update(post('record_id'));
        $this->vars['recordId'] = post('record_id');

        return $this->makePartial('update_token');
    }

    /**
     * Update the info on the token
     *
     * @return mixed
     *
     * @throws TokenException
     */
    public function onUpdate()
    {
         try {
            $this->asExtension('FormController')->update_onSave(post('record_id'));

            return $this->listRefresh();
        } catch (QueryException $exc) {
            \App::make('Illuminate\Contracts\Debug\ExceptionHandler')->report($exc);

            throw new TokenException('', $exc->getCode());
        }
    }

    /**
     * Delete one or more tokens
     *
     * @return mixed
     *
     * @throws TokenException
     */
    public function onDelete()
    {
        $checkedIds = post('checked') ?: (array)post('record_id');

        try {
            if (is_array($checkedIds) && count($checkedIds)) {

                foreach ($checkedIds as $recordId) {
                    if (!$record = Token::find($recordId)) {
                        continue;
                    }

                    $record->delete();
                }

                \Flash::success(\Lang::get('backend::lang.list.delete_selected_success'));
            }
            else {
                \Flash::error(\Lang::get('backend::lang.list.delete_selected_empty'));
            }
        } catch (QueryException $exc) {
            \App::make('Illuminate\Contracts\Debug\ExceptionHandler')->report($exc);

            throw new TokenException('', $exc->getCode());
        }

        return $this->listRefresh();
    }
}