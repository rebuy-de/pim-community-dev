<?php

declare(strict_types=1);

namespace spec\Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub;

use Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub\Client;
use Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub\GpsTransport;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

/**
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GpsTransportSpec extends ObjectBehavior
{
    public function let(Client $client, SerializerInterface $serializer): void
    {
        $this->beConstructedWith($client, $serializer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GpsTransport::class);
    }
}
