<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class VerifyPhone extends Notification
{
    use Queueable;

    public function __construct(
        public string|int $verificationCode,
    ) {}

    /** @return array<int, string> */
    public function via(): array
    {
        return [
            'database',
            // 'vonage',
        ];
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'verification_code' => $this->verificationCode,
        ];
    }

    public function toVonage(): VonageMessage
    {
        $appName = config('app.name');

        return (new VonageMessage())
            ->content(
                __(
                    '[:App] Your verification code is :code. Do not share this code with anyone.',
                    [
                        'app' => $appName,
                        'code' => $this->verificationCode,
                    ],
                ),
            );
    }
}
