<?php

namespace Alkhwlani\XssMiddleware;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use voku\helper\AntiXSS;
use voku\helper\UTF8;

class XSSFilterMiddleware extends TransformsRequest
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var AntiXSS
     */
    protected $security;

    public function __construct(Repository $config)
    {
        $this->security = app(AntiXSS::class);
        $this->config = $config->get('xss-middleware');
    }

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if ($this->shouldIgnore($key, $value)) {
            return $value;
        }

        $cleaned = $this->security->xss_clean($value);

        // When the value did not contain XSS, voku leaves C0 control characters
        // (NUL, BEL, ESC, …) and DEL intact. Strip them anyway — they are
        // common vectors for null-byte injection, log-poisoning, and terminal
        // escape attacks, and have no place in user input.
        if (is_string($cleaned) && $this->security->isXssFound() === false) {
            $cleaned = UTF8::remove_invisible_characters($cleaned, true);
        }

        return $cleaned;
    }

    /**
     * determine if should ignore the field.
     */
    protected function shouldIgnore($key, $value): bool
    {
        return ! is_string($value) || in_array($key, $this->config['except'], true);
    }
}
