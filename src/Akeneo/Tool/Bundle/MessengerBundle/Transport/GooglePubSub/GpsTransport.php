<?php

declare(strict_types=1);

namespace Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\SetupableTransportInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

/**
 * Google PubSub Transport for Symfony Messenger.
 *
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
final class GpsTransport implements TransportInterface, SetupableTransportInterface
{
    /** @var Client */
    private $client;

    /** @var GpsSender */
    private $sender;

    /** @var GpsReceiver */
    private $receiver;

    public function __construct(Client $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->sender = new GpsSender($client, $serializer);
        $this->receiver = new GpsReceiver($client, $serializer);
    }

    public function setup(): void
    {
        $this->client->setup();
    }

    public function send(Envelope $envelope): Envelope
    {
        return $this->sender->send($envelope);
    }

    public function get(): iterable
    {
        return $this->receiver->get();
    }

    public function ack(Envelope $envelope): void
    {
        $this->receiver->ack($envelope);
    }

    public function reject(Envelope $envelope): void
    {
        $this->receiver->reject($envelope);
    }
}
