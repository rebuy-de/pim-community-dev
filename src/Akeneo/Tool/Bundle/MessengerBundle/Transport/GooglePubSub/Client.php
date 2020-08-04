<?php

declare(strict_types=1);

namespace Akeneo\Tool\Bundle\MessengerBundle\Transport\GooglePubSub;

use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Subscription;
use Google\Cloud\PubSub\Topic;

/**
 * Simple abstraction over the Google PubSubClient.
 *
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Client
{
    /** @var string */
    private $topicName;

    /** @var string */
    private $subscriptionName;

    /** @var PubSubClient */
    private $pubSubClient;

    /**
     * @param string $dsn Must be `gps:`
     * @param array{
     *      transport_name: string,
     *      project_id: string
     *      topic_name: string,
     *      subscription_name: string
     *  } $options
     */
    public static function fromDsn(
        string $dsn,
        array $options = [],
        PubSubClientFactory $pubSubClientFactory = null
    ): self {
        if (0 !== strpos($dsn, 'gps:')) {
            throw new \InvalidArgumentException(sprintf('DSN "%s" is invalid.', $dsn));
        }

        foreach (['project_id', 'topic_name', 'subscription_name'] as $key) {
            if (!isset($options[$key]) || !is_string($options[$key])) {
                throw new \InvalidArgumentException(
                    sprintf('Option "%s" is missing or invalid.', $key)
                );
            }
        }

        $client = new self(
            $options['project_id'],
            $options['topic_name'],
            $options['subscription_name'],
            $pubSubClientFactory
        );

        return $client;
    }

    public function __construct(
        string $projectId,
        string $topicName,
        string $subscriptionName,
        PubSubClientFactory $pubSubClientFactory = null
    ) {
        $this->pubSubClient = ($pubSubClientFactory ?? new PubSubClientFactory())->createPubSubClient([
            'projectId' => $projectId
        ]);

        $this->topicName = $topicName;
        $this->subscriptionName = $subscriptionName;
    }

    public function setup(): void
    {
        if (false === $this->pubSubClient->topic($this->topicName)->exists()) {
            $this->pubSubClient->createTopic($this->topicName);
        }

        if (false === $this->pubSubClient->topic($this->topicName)->subscription($this->subscriptionName)->exists()) {
            $this->pubSubClient->subscribe($this->subscriptionName, $this->topicName);
        }
    }

    public function getTopic(): Topic
    {
        return $this->pubSubClient->topic($this->topicName);
    }

    public function getSubscription(): Subscription
    {
        return $this->pubSubClient->subscription($this->subscriptionName);
    }
}
