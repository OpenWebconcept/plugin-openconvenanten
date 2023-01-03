<?php

namespace Yard\OpenConvenanten\GravityForms;

use Yard\OpenConvenanten\Foundation\ServiceProvider;

class GravityFormsServiceProvider extends ServiceProvider
{
    private const FORM_TITLE = 'OpenConvenant';

    public function register(): void
    {
        if (! $this->hasValidDependencies()) {
            return;
        }

        $this->registerForm();
        $this->loadHooks();
    }

    private function registerForm(): void
    {
        if (GravityFormsHelpers::formExists(self::FORM_TITLE)) {
            return;
        }

        $form = GravityFormsHelpers::loadFormJSON();

        if (null === $form) {
            return;
        }

        \GFAPI::add_form($form);
    }

    private function loadHooks(): void
    {
        $handler = new SubmissionHandler();
        $this->plugin->loader->addAction('gform_advancedpostcreation_post_after_creation', $handler, 'transform', 10, 4);
        add_filter('gform_advancedpostcreation_excerpt', '__return_true', 10, 1);
    }

    private function hasValidDependencies(): bool
    {
        return class_exists('\GFAPI');
    }
}
