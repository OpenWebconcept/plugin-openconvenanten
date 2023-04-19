<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Migrate;

use WP_CLI;
use Yard\OpenConvenanten\Traits\GravityFormsUploadToMediaLibrary;

class MigrateToCMB2
{
    use GravityFormsUploadToMediaLibrary;

    private const COMMAND = 'openconvenant migrate-to-cmb2';

    public function __invoke($args, $assocArgs)
    {
        $this->migrate();
    }
    
    public function register(): void
    {
        if (! class_exists('WP_CLI')) {
            return;
        }

        WP_CLI::add_command(self::COMMAND, $this, [
            'shortdesc' => 'Migrate Metabox.io values from old to new format so they can work with CMB2',
        ]);
    }

    public function migrate(): void
    {
        $posts = $this->getPosts();

        if (empty($posts)) {
            WP_CLI::error('No openconvenant items found, stopping the execution of this command.');
        }

        $this->updatePosts($posts);
    }

    private function getPosts(): array
    {
        $query = new \WP_Query([
            'post_type' => 'openconvenant-item',
            'post_status' => ['publish', 'draft'],
            'posts_per_page' => -1
        ]);

        return $query->posts;
    }
    
    private function updatePosts(array $posts): void
    {
        foreach ($posts as $post) {
            $this->convertTitleToSubject($post);
            $this->replaceSummary($post);
            $this->replaceParties($post);
            $this->replaceID($post);
            $this->replaceDuration($post);
            $this->replaceMultipleAttachmentsURLs($post);
        }
    }

    private function getOldMeta(\WP_Post $post, array $keys): array
    {
        $meta = [];

        foreach ($keys as $key) {
            $meta[$key] = \get_post_meta($post->ID, $key, true);
        }

        return array_filter($meta);
    }

    private function convertTitleToSubject(\WP_Post $post): void
    {
        $oldValue = \get_post_meta($post->ID, 'convenant_Titel', true);

        if (empty($oldValue)) {
            return;
        }

        $newSubject = \update_post_meta($post->ID, 'convenant_Onderwerp', $oldValue);

        if (! $newSubject) {
            return;
        }
        
        \delete_post_meta($post->ID, 'convenant_Titel');
    }

    private function replaceSummary(\WP_Post $post): void
    {
        $summary = \get_post_meta($post->ID, 'convenant_Samenvatting', true);

        if (empty($summary)) {
            return;
        }

        $post->post_excerpt = '';
        \wp_update_post($post);
    }

    private function replaceParties(\WP_Post $post): void
    {
        $oldValue = \get_post_meta($post->ID, 'convenant_Partijen');

        if (empty($oldValue)) {
            return;
        }

        $newAttachmentsField = \update_post_meta($post->ID, 'convenant_Partijen_bij_convenant', $oldValue);

        if (! $newAttachmentsField) {
            return;
        }
        
        \delete_post_meta($post->ID, 'convenant_Partijen');
    }

    private function replaceID(\WP_Post $post): void
    {
        $oldValue = \get_post_meta($post->ID, 'convenant_ID', true);

        if (empty($oldValue)) {
            return;
        }

        $newAttachmentsField = \update_post_meta($post->ID, 'convenant_Zaaknummer_ID', $oldValue);

        if (! $newAttachmentsField) {
            return;
        }

        \delete_post_meta($post->ID, 'convenant_ID');
    }

    private function replaceDuration(\WP_Post $post): void
    {
        $oldValue = \get_post_meta($post->ID, 'convenant_Duur', true);

        if (empty($oldValue)) {
            return;
        }

        $newAttachmentsField = \update_post_meta($post->ID, 'convenant_Duur_van_het_convenant', $oldValue);

        if (! $newAttachmentsField) {
            return;
        }

        \delete_post_meta($post->ID, 'convenant_Duur');
    }

    private function replaceMultipleAttachmentsURLs(\WP_Post $post): void
    {
        $keys = [
            'convenant_Bijlagen'
        ];

        $oldMeta = $this->getOldMeta($post, $keys);
        
        if (empty($oldMeta['convenant_Bijlagen']) || ! is_array($oldMeta['convenant_Bijlagen'])) {
            return;
        }

        $newAttachmentsField = \update_post_meta($post->ID, 'convenant_Bijlagen_bestanden', $this->handleMultipleAttachments($oldMeta['convenant_Bijlagen']));
        
        if (! $newAttachmentsField) {
            return;
        }

        \delete_post_meta($post->ID, 'convenant_Bijlagen');
    }

    private function handleMultipleAttachments(array $attachment): array
    {
        $holder = [];
        if (empty($attachment['convenant_Bijlagen_Bestand'])) {
            $holder[] = $attachment;

            return $holder;
        }
            
        if (! empty($attachment['convenant_Bijlagen_Bestand'][0])) { // When attachment is saved in an array.
            $attachmentID = $attachment['convenant_Bijlagen_Bestand'][0];
            $attachmentURL = \wp_get_attachment_url($attachmentID);
        } else {
            $attachmentID = $attachment['convenant_Bijlagen_Bestand'][0];
            $attachmentURL = \wp_get_attachment_url($attachmentID);
        }

        if (! $attachmentURL || ! $attachmentID) {
            $holder[] = $attachment;
                
            return $holder;
        }

        $attachment['convenant_Bijlagen_Bestand_id'] = (int) $attachmentID;
        $attachment['convenant_Bijlagen_Bestand'] = $attachmentURL;
        unset($attachment['_index_convenant_Bijlagen_Bestand']);
        $holder[] = $attachment;

        return $holder;
    }
}
