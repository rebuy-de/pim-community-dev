<?php

declare(strict_types=1);

namespace spec\Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub;

use Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub\GpsTransportFactory;
use PhpSpec\ObjectBehavior;

/**
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GpsTransportFactorySpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GpsTransportFactory::class);
    }

    public function it_supports_the_gps_dsn(): void
    {
        // Supports
        $this->supports('gps:', [])->shouldBe(true);

        // Doesn't support
        $this->supports('', [])->shouldBe(false);
    }
}
