<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Taxonomy;

class TaxonomyController
{
    /**
     * Add 'show on' additional explanation.
     */
    public function addShowOnExplanation(string $taxonomy): void
    {
        if ('openconvenanten-show-on' !== $taxonomy) {
            return;
        }

        echo '<div class="form-field">
            <h3>' . __('Aanvullende uitleg', 'openconvenanten') . '</h3>
            <p>' . __('De waarde van de slug moet het ID zijn van de blog die je wilt toevoegen als term. Het ID wordt gebruikt om de juiste openconvenant-items weer te geven op alle blogs.', 'openconvenanten') . '</p>
            </div>';
    }
}
