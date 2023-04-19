<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\GravityForms;

use Yard\OpenConvenanten\Foundation\ServiceProvider;

class GravityFormsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! $this->hasValidDependencies()) {
            return;
        }

        $this->loadHooks();
    }

    private function loadHooks(): void
    {
        \add_action('gform_after_submission', function ($entry, $form) {
            SubmissionHandler::make($entry, $form)->handle();
        }, 10, 2);
    }

    private function hasValidDependencies(): bool
    {
        return class_exists('\GFAPI');
    }
}
