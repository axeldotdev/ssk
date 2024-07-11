# SaaS Starter Kit (SSK)

The goal of SSK is to help you build your app quickly and it brings you a ton of cool features on top of Laravel Breeze.

If you would like a Livewire version, let's connect on Twitter. If a lot of people are interested I could make some time for it.

## Installation

```bash
git clone XXX your-project-name
cd your-project-name
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
npm install
npm run build # npm run dev
```

By default the database is **SQLite** and the session, cache and jobs are stored in it. It allows you to start building your app quickly and focus on the system later.

**SSK** is just a wrapper around **Laravel Breeze** who is a wrapper around **Laravel**. You have all the power to modify it to suit your need.

## Coming soon

- Sessions management on profile
- 2FA on profile
- Transfer company
- Companies create and edit forms
- Command bar with search and shortcuts
- Notification center
- Third party apps integrations
- Tests

## Available Features

- Sign up with email, phone, Google or Microsoft
- Sign in with email, phone, Google or Microsoft
- User verification via email or phone (depending on the sing up method)
- Reset password for email
- Onboarding (account, company, collaborators)
- Collaborators invitation by email or phone
- Multiple tenants (companies)
- Active sessions management
- Company transfer ownership
- 2FA
- API via token

## Features Flags

To activate or deactivate a feature, you just need to open the class and change the boolean returned in the `resolve` method.

### SignViaEmail

Allows you to login and register via an email address.

`\App\Features\SignViaEmail`

### SignViaPhone

Allows you to login and register via a phone number.

`\App\Features\SignViaPhone`

### SignViaSSO

Allows you to login and register via a SSO provider.

`\App\Features\SignViaSSO`

You can add providers in the `config/socialstream.php` file and register the env variable in the `config/services.php` file.

SSK comes with Google and Microsoft by default.

### VerifyUser

Allows you to verify the user by email or phone according to his sign method.

`\App\Features\VerifyUser`

### OnboardUser

Allows you to show an onboarding view to help user start using your app and register some important informations.

`\App\Features\OnboardUser`

The onboarding feature just give you a basic system, it's up to you to add forms and other things into it.

## Packages

SSK use some of the great packages  of the Laravel ecosystem to help you build the best app you can.

### Composer

- Laravel Breeze
- Laravel Horizon
- Laravel Octane
- Laravel Pennant
- Laravel Pulse
- Laravel Reverb
- Laravel Sanctum
- Laravel Telescope
- Laravel Precognition
- Inertia
- Socialstream (wrapper around Laravel Socialite)
- Filament
- Laravel Auditing
- Saloon
- Spatie Laravel Health
- Spatie Laravel Backup
- Spatie Laravel Medialibrary
- Spatie Laravel CSP
- Spatie Laravel Google Fonts

### Composer dev

- Laravel Dusk
- Larastan
- PHP Insights
- Pest
- Pint

### NPM

- Laravel Echo
- Shadcn-vue
- Vue
- Inertia
- Github Hotkey
- Tailwind CSS
- Axios

### NPM dev

- Prettier

## Testing

```bash
php artisan test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Axel Charpentier](https://github.com/axeldotdev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
