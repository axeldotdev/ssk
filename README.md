<p align="center">
    <img src="https://github.com/axeldotdev/ssk/blob/main/.github/header.png" alt="SSK UI Screenshot" />
</p>

<p align="center">
    <a href="https://php.net">
        <img alt="PHP 8.2" src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php">
    </a>
    <a href="https://laravel.com">
        <img alt="Laravel v11.x" src="https://img.shields.io/badge/Laravel-v11.x-FF2D20?style=for-the-badge&logo=laravel">
    </a>
    <a href="https://inertiajs.com/">
        <img alt="Inertia v1.x" src="https://img.shields.io/badge/Inertia-v1.x-846CEE?style=for-the-badge">
    </a>
    <a href="https://vuejs.org/">
        <img alt="Vue v3.x" src="https://img.shields.io/badge/Vue-v3.x-42B883?style=for-the-badge">
    </a>
</p>

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

By default the database is **SQLite** and the session, cache and queues are stored in it. It allows you to start building your app quickly and focus on the system later.

Horizon is installed and configure so you can switch your queues to redis very quickly.

**SSK** is just a wrapper around **Laravel Breeze** who is a wrapper around **Laravel**. You have all the power to modify it to suit your need.

## Available Features

- 🧑‍💻 Login and registration with email, phone, Google or Microsoft
- ✅ User verification via email or phone (depending on the sing up method)
- 🔑 Reset password for email
- 📜 Privacy policy and Terms of service pages (with localized markdown files)
- 🤝 Onboarding (account, company, collaborators)
- 🧑‍💼 Collaborators invitation by email or phone
- 🏁 Multiple tenants (companies)
- 🔬 Active sessions management *[coming soon]*
- 🖋️ Company transfer ownership *[coming soon]*
- 🔐 2FA *[coming soon]*
- 💻 API via token *[coming soon]*
- 🔍 Global search with shortcuts *[coming soon]*
- 📖 API documentation (with localized markdow files)
- 🇺🇸 English and 🇫🇷 French translations
- 🚦 Multiple feature flags (to enable the features listed above)

## Features Flags

To activate or deactivate a feature, you just need to open the class and change the boolean returned in the `resolve` method.

The features are located in the folder `app/Features`.

### SignViaEmail

Allows you to login and register via an email address.

### SignViaPhone

Allows you to login and register via a phone number.

### SignViaSSO

Allows you to login and register via a SSO provider.

You can add providers in the `config/socialstream.php` file and register the env variable in the `config/services.php` file.

SSK comes with Google and Microsoft by default.

### VerifyUser

Allows you to verify the user by email or phone according to his sign method.

### OnboardUser

Allows you to show an onboarding view to help user start using your app and register some important informations.

The onboarding feature just give you a basic system, it's up to you to add forms and other things into it.

### ApiTokens

Allows you to manage API tokens.

It comes with a view that list tokens and a form to create them. The tokens are default Laravel Sanctum tokens scoped on users.

### ApiDocumentation

Allows you to show an API documentation in your app when the user is authenticated.

The API works with markdown file so it's really easy to use, no PHP or Vue to add.

## Upgrading

If you need to upgrade your project to the newer version of SSk, we recommend you to follow [the upgrading guide](UPGRADING.md).

But! SSK is a starter kit and once you use it to init your project, the code is yours and you don't really need to upgrade to follow the newer version.

## Testing

```bash
php artisan test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Need Help?

🐞 If you spot a bug, please [submit a detailed issue](https://github.com/axeldotdev/ssk/issues/new?assignees=&labels=bug&template=bug_report.md), and wait for assistance.

🤔 If you have a question or feature request, please [start a new discussion](https://github.com/axeldotdev/ssk/discussions/new). For quick help, ask questions in the appropriate channel.

🔐 If you discover a vulnerability, please review [our security policy](../../security/policy).

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Axel Charpentier](https://github.com/axeldotdev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
