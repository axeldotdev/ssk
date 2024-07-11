<?php

namespace App\Support;

use Illuminate\Http\Request;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy;
use Symfony\Component\HttpFoundation\Response;

class CspPolicy extends Policy
{
    public function configure(): void
    {
        $this->addGeneralDirectives();
        $this->addStyleDirectives();
        $this->addScriptDirectives();
    }

    public function addGeneralDirectives(): Policy
    {
        return $this
            ->addDirective(Directive::BASE, 'self')
            ->addDirective(Directive::FORM_ACTION, [
                'orvea.app',
                'orvea.test',
            ])
            ->addDirective(Directive::IMG, [
                '*',
                'unsafe-inline',
                'data:',
            ])
            ->addDirective(Directive::OBJECT, 'none');
    }

    public function addStyleDirectives(): Policy
    {
        return $this->addDirective(Directive::STYLE, [
            'orvea.app',
            'orvea.test',
            'orvea.test:5173',
            'unsafe-inline',
        ]);
    }

    public function addScriptDirectives(): Policy
    {
        return $this
            ->addNonceForDirective(Directive::SCRIPT)
            ->addDirective(Directive::SCRIPT, [
                'orvea.app',
                'orvea.test',
                'orvea.test:5173',
                'cdn.usefathom.com',
                'unsafe-eval',
                'unsafe-inline',
            ]);
    }

    public function addFontDirectives(): Policy
    {
        return $this->addDirective(Directive::FONT, [
            'orvea.app',
            'orvea.test',
            'orvea.test:5173',
            'unsafe-inline',
            'data:',
        ]);
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        if (str($request->route()->uri)->startsWith('tools/')
            || $response->isServerError()
            || $response->isClientError()) {
            return false;
        }

        return parent::shouldBeApplied($request, $response);
    }
}
