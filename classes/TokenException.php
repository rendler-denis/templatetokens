<?php
/**
 * Author  : Denis-Florin Rendler
 * Date    : 08/10/15
 * Copyright (c) 2015 Denis-Florin Rendler <connect@rendler.me>
 *
 * License : MIT - WITH THE EXCEPTION THAT YOU ARE NOT ALLOWED TO SELL
 *  THE CODE EITHER AS YOUR OWN CODE OR USING THE KODERHUT NAME
 */

namespace KoderHut\TemplateTokens\Classes;

/**
 * Class TokenException
 *
 * @package KoderHut\TemplateTokens\Classes
 */
class TokenException extends \Exception
{
    /**
     * Class constructor
     *
     * @param string         $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $translatedMessage = \Lang::get('koderhut.templatetokens::lang.exceptions.' . $code);

        if (null !== $translatedMessage) {
            $this->message = $translatedMessage;
        }
    }
}