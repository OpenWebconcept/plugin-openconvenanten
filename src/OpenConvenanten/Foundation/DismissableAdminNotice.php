<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Foundation;

class DismissableAdminNotice
{
    const STATE_OPTION = OCV_SLUG . '-dependencies';

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [__CLASS__, 'loadScript']);
        add_action('wp_ajax_dismiss_admin_notice_handler', [__CLASS__, 'dismissAdminNotice']);
    }

    /**
     * Enqueue javascript and variables.
     */
    public static function loadScript(): void
    {
        if (\is_customize_preview()) {
            return;
        }

        $js_url = \plugins_url('/resources/js/dismissable-admin-notice.js', OCV_FILE);
        \wp_enqueue_script('dismissible-notices', $js_url, ['jquery', 'common' ], false, true);
        \wp_localize_script(
            'dismissible-notices',
            'dismissible_notice',
            [
                'nonce' => \wp_create_nonce('dismissible-notice')
            ]
        );
    }

    /**
     * Handles Ajax request to persist notices dismissal.
     * Uses check_ajax_referer to verify nonce.
     */
    public static function dismissAdminNotice(): void
    {
        $optionName = \sanitize_text_field($_POST['option_name']);
        $dismissibleLength = \sanitize_text_field($_POST['dismissible_length']);

        if ('forever' != $dismissibleLength) {
            // If $dismissibleLength is not an integer default to 1
            $dismissibleLength = (0 == \absint($dismissibleLength)) ? 1 : $dismissibleLength;
            $dismissibleLength = strtotime(\absint($dismissibleLength) . ' days');
        }
        if ('forever' === $dismissibleLength or false === $dismissibleLength) {
            $dismissibleLength = -1;
        }

        if (is_string($dismissibleLength)) {
            $dismissibleLength = (int) $dismissibleLength;
        }

        \check_ajax_referer('dismissible-notice', 'nonce');
        self::setAdminNoticeCache($optionName, $dismissibleLength);
        \wp_die();
    }

    /**
     * Is admin notice active?
     *
     * @param string $arg data-dismissible content of notice.
     *
     * @return bool
     */
    public function isAdminNoticeActive(string $arg): bool
    {
        $array = explode('-', $arg);
        $length = array_pop($array);
        $optionName = implode('-', $array);
        $dbRecord = $this->getAdminNoticeCache($optionName);

        if ('-1' == $dbRecord) {
            return false;
        }
        if (\absint($dbRecord) >= time()) {
            return false;
        }

        return true;
    }

    /**
     * Returns admin notice cached timeout.
     *
     * @param string $id admin notice name or false.
     *
     * @return array|bool The timeout. False if expired.
     */
    public function getAdminNoticeCache(string $id = null)
    {
        if (! $id) {
            return false;
        }
        $cache_key = self::STATE_OPTION .'-' . md5($id);
        $timeout = \get_site_option($cache_key);
        $timeout = '-1' === $timeout ? time() + 60 : $timeout;

        if (empty($timeout) || time() > $timeout) {
            return false;
        }

        return $timeout;
    }

    /**
     * Sets admin notice timeout in site option.
     *
     * @access public
     *
     * @param string    $id       Data Identifier.
     * @param int       $timeout  Timeout for admin notice.
     *
     * @return bool
     */
    public static function setAdminNoticeCache(string $id, int $timeout): bool
    {
        $cacheKey = self::STATE_OPTION . '-' . md5($id);
        \update_site_option($cacheKey, $timeout);

        return true;
    }
}
