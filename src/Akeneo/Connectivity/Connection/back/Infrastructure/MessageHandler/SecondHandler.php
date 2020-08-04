<?php

declare(strict_types=1);

namespace Akeneo\Connectivity\Connection\Infrastructure\MessageHandler;

use Akeneo\Pim\Enrichment\Bundle\Message\ProductUpdated;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class SecondHandler implements MessageSubscriberInterface
{
    public static function getHandledMessages(): iterable
    {
        yield ProductUpdated::class  => [
            'from_transport' => 'business_event'
        ];
    }

    public function __invoke(ProductUpdated $message)
    {
        echo "SECOND\t" . $message->getContent() . PHP_EOL;
    }
}
