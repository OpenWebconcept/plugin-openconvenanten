<?php

namespace Yard\OpenConvenanten\GravityForms;

class GravityFormsHelpers
{
    public static function loadFormJSON(): ?array
    {
        $path = OCV_ROOT_PATH . '/gravityforms/form.json';

        if (! file_exists($path)) {
            return null;
        }

        $content = file_get_contents($path);

        if (empty($content)) {
            return null;
        }

        return json_decode($content, true);
    }

    public static function formExists(string $title): bool
    {
        $forms = \GFAPI::get_forms();

        foreach ($forms as $form) {
            if (strpos($form['title'], $title) !== false) {
                return true;
            }
        }

        return false;
    }
}
