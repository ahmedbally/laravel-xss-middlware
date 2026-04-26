<?php

namespace Alkhwlani\XssMiddleware\Tests;

use PHPUnit\Framework\Attributes\Test;

class EvilOptionsTest extends TestCase
{
    #[Test]
    public function it_strips_extra_evil_attributes_when_configured()
    {
        // `style` is not in voku's default evil-attribute list. Wiring it via
        // the `evil.attributes` config key should make the middleware strip it.
        $payload = ['snippet' => '<p style="color:red">hi</p>'];

        $response = $this->post('add-middleware-auto', $payload)->json('snippet');

        $this->assertStringNotContainsString('style=', $response);
        $this->assertStringContainsString('hi', $response);
    }

    #[Test]
    public function it_strips_extra_evil_html_tags_when_configured()
    {
        // `<svg>` is not in voku's default evil-tag list. With `evil.tags`
        // configured, the inner content is preserved but the tag is stripped.
        $payload = ['snippet' => '<svg>danger</svg>safe'];

        $response = $this->post('add-middleware-auto', $payload)->json('snippet');

        $this->assertStringNotContainsString('<svg', $response);
        $this->assertStringContainsString('safe', $response);
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('xss-middleware.evil', [
            'attributes' => ['style'],
            'tags' => ['svg'],
        ]);
    }
}
