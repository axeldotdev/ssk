<?php

namespace App\Notifications;

use App\Models\CompanyInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class InviteCollaborator extends Notification
{
    use Queueable;

    public function __construct(
        public CompanyInvitation $invitation,
    ) {
    }

    /** @return array<int, string> */
    public function via(): array
    {
        if ($this->invitation->phone) {
            return [
                'database',
                // 'vonage',
            ];
        }

        return ['email'];
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'url' => route('companies.invitations.update', $this->invitation),
        ];
    }

    public function toVonage(): VonageMessage
    {
        $appName = config('app.name');
        $company = $this->invitation->company->name;
        $url = route('companies.invitations.update', $this->invitation);

        return (new VonageMessage())->content(
            __('[:App] You have been invited to join :Company. :url', [
                'app' => $appName,
                'company' => $company,
                'url' => $url,
            ]),
        );
    }

    public function toMail(): MailMessage
    {
        $app = config('app.name');
        $company = $this->invitation->company->name;

        return (new MailMessage())
            ->subject(__('[:App] You have been invited to join :Company', [
                'app' => $app,
                'company' => $company,
            ]))
            ->greeting(__('Hello!'))
            ->line(__('You have been invited to join :Company on :App.', [
                'company' => $company,
                'app' => $app,
            ]))
            ->action(
                __('Accept Invitation'),
                route('companies.invitations.update', $this->invitation),
            )
            ->line(__('See you soon!'));
    }
}
