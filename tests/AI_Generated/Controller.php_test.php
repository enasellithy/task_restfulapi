```php
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\Controller;

class ControllerTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_an_abstract_class()
    {
        $this->assertTrue(is_abstract(Controller::class));
    }

    /**
     * @test
     */
    public function it_extends_nothing()
    {
        $this->assertNull(get_parent_class(Controller::class));
    }
}
```