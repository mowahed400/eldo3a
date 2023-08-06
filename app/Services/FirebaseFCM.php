<?php

namespace App\Services;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseFCM
{
    protected Messaging $messaging;
    protected string $body;
    protected string $title;
    protected array $data;

    public function __construct($title, $body, array $data = [])
    {
        $this->messaging = app('firebase.messaging');
        $this->body = $body;
        $this->title = $title;
        $this->data = $data;
    }

    /**
     * @param $token
     * @return void
     */
    public function sendByToken($token)
    {
        try {
//            $validation = $this->messaging->validateRegistrationTokens($token);
//
//            if (!empty($validation['valid']))
//            {
                $message = CloudMessage::withTarget('token', $token)
                    ->withNotification($this->getFireBaseNotification())
                    ->withApnsConfig(
                        ApnsConfig::new()
                            ->withImmediatePriority()
                    )->withData($this->data);

                $this->messaging->send($message);
//            }
        } catch (\Exception $e) {
        }

    }

    public function sendByTopic($topic)
    {
        try {
            $message = CloudMessage::withTarget('topic', $topic)
                ->withNotification($this->getFireBaseNotification())
                ->withApnsConfig(
                    ApnsConfig::new()
                        ->withImmediatePriority()
                )->withData($this->data);

            $this->messaging->send($message);
        } catch (\Exception $e) {
        }
    }

    /**
     * Subscribe in topic
     * @param $topic
     * @param $token
     * @return void
     */
    public static function subscribe($topic, $token)
    {
        $messaging = app('firebase.messaging');

        $validation = $messaging->validateRegistrationTokens($token);

        if (!empty($validation['valid'])) {
            $messaging->subscribeToTopic($topic, $token);
        }
    }

    /**
     * @param array $tokens
     * @return void
     */
    public function sendMulticastDeviceNotification(array $tokens)
    {
        $tokens = $this->messaging->validateRegistrationTokens($tokens);

        $message = CloudMessage::new()->withNotification($this->getFireBaseNotification())
            ->withData($this->data);

        $this->messaging->sendMulticast($message, $tokens['valid']);
    }

    /**
     * @return Notification
     */
    private function getFireBaseNotification(): Notification
    {
        return Notification::fromArray([
            'title'=>$this->title,
            'body'=>$this->body,
        ]);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return FirebaseFCM
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return FirebaseFCM
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return FirebaseFCM
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

}
