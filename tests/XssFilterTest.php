<?php

namespace Alkhwlani\XssMiddleware\Tests;

use PHPUnit\Framework\Attributes\Test;

class XssFilterTest extends TestCase
{
    #[Test]
    public function it_will_filter_xss_as_global_by_default()
    {
        $this->post('add-middleware-auto', $this->uncleanData)->assertJson($this->cleanData);
    }
}
