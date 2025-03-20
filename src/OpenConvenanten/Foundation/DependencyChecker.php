<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\Foundation;

class DependencyChecker
{
    protected DismissableAdminNotice $dismissableAdminNotice;
    private array $dependencies = [];
    private array $suggestions = [];
    private array $failed = [];

    public function __construct(DismissableAdminNotice $dismissableAdminNotice, array $dependencies, array $suggestions = [])
    {
        $this->dismissableAdminNotice = $dismissableAdminNotice;
        $this->dependencies = $dependencies;
        $this->suggestions = $suggestions;
    }

    /**
     * Determines if the dependencies are not met.
     */
    public function hasFailures(): bool
    {
        foreach ($this->dependencies as $dependency) {
            switch ($dependency['type']) {
                case 'class':
                    $this->checkClass($dependency);

                    break;
                case 'plugin':
                    $this->checkPlugin($dependency);

                    break;
				case 'function':

					$this->checkFunction($dependency);
					break;
            }
        }

        return 0 < count($this->failed);
    }

    /**
     * Determines if the dependencies are not met.
     */
    public function hasSuggestions(): bool
    {
        foreach ($this->suggestions as $suggestion) {
            switch ($suggestion['type']) {
                case 'class':
                    $this->checkClass($suggestion);

                    break;
                case 'plugin':
                    $this->checkPlugin($suggestion);

                    break;
            }
        }

        return 0 < count($this->suggestions);
    }

    /**
     * Notifies the administrator which plugins need to be enabled,
     * or which plugins have the wrong version.
     */
    public function notifyFailed(): void
    {
        \add_action('admin_notices', function () {
            $list = '<p>' . __(
                'De volgende plugins zijn vereist om gebruik te maken van de OpenConvenanten plugin:',
                'openconvenanten'
            ) . '</p><ol>';

            foreach ($this->failed as $dependency) {
                $info = isset($dependency['message']) ? ' (' . $dependency['message'] . ')' : '';
                $list .= sprintf('<li>%s%s</li>', $dependency['label'], $info);
            }

            $list .= '</ol>';

            printf('<div class="notice notice-error"><p>%s</p></div>', $list);
        });
    }

    /**
     * Notifies the administrator which plugins need to be enabled,
     * or which plugins have the wrong version.
     */
    public function notifySuggestions(): void
    {
        \add_action('admin_notices', function () {
            if (! $this->dismissableAdminNotice->isAdminNoticeActive('dependency-suggestions-forever')) {
                return;
            }

            $list = '<p>' . __(
                'De volgende plugins of bibliotheken worden aangeraden en ondersteund om gebruik te maken van de OpenConvenanten plugin:',
                'openconvenanten'
            ) . '</p><ol>';

            foreach ($this->suggestions as $suggestion) {
                $info = (isset($suggestion['message']) and (! empty($suggestion['message']))) ? ' (' . $suggestion['message'] . ')' : '';
                $list .= sprintf('<li>%s%s</li>', $suggestion['label'], $info);
            }

            $list .= '</ol>';

            printf('<div data-dismissible="dependency-suggestions-forever" class="updated notice notice-info is-dismissible"><p>%s</p></div>', $list);
        });
    }

    /**
     * Marks a dependency as failed.
     */
    private function markFailed(array $dependency, string $defaultMessage): void
    {
        $this->failed[] = array_merge([
            'message' => $dependency['message'] ?? $defaultMessage,
        ], $dependency);
    }

    /**
     * Checks if required class exists.
     */
    private function checkClass(array $dependency): void
    {
        if (! class_exists($dependency['name'])) {
            $this->markFailed($dependency, __('Klasse bestaat niet', 'openconvenanten'));

            return;
        }
    }

    /**
     * Check if a plugin is enabled and has the correct version.
     */
    private function checkPlugin(array $dependency): void
    {
        if (! function_exists('is_plugin_active')) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if (! $this->checkPluginActive($dependency)) {
            $this->markFailed($dependency, __('Inactief', 'openconvenanten'));

            return;
        }

        // If there is a version lock set on the dependency...
        if (isset($dependency['version'])) {
            if (! $this->checkVersion($dependency)) {
                $this->markFailed($dependency, __('Minimale versie:', 'openconvenanten') . ' <b>' . $dependency['version'] . '</b>');
            }
        }
    }

    protected function checkPluginActive(array $dependency): bool
    {
        $files = $dependency['file'];
        if (! is_array($files)) {
            $files = [$files];
        }
        $results = array_map(function ($plugin) {
            return \is_plugin_active($plugin);
        }, $files);

        return (0 < count(array_filter($results, function ($item) {
            return (true === $item);
        })));
    }

	/**
	 * Checks if required function exists.
	 */
	private function checkFunction(array $dependency): void
	{
		if (! function_exists($dependency['name'])) {
			$this->markFailed($dependency, __('Function does not exist:', 'openconvenanten') . ' <b>' . $dependency['name'] . '</b>');
		}
	}


	/**
     * Checks the installed version of the plugin.
     */
    private function checkVersion(array $dependency): bool
    {
        $files = $dependency['file'];
        if (! is_array($files)) {
            $files = [$files];
        }
        $results = array_map(function ($file) use ($dependency) {
            $file = WP_PLUGIN_DIR . '/' . $file;
            if (! file_exists($file)) {
                return false;
            }

            return $this->checkVersionOfFile($file, $dependency);
        }, $files);

        return (0 < count(array_filter($results, function ($item) {
            return (true === $item);
        })));
    }

    private function checkVersionOfFile(string $file, array $dependency): bool
    {
        if (false !== ($file = file_get_contents($file))) {
            preg_match('/^(?: ?\* ?Version: ?)(.*)$/m', $file, $matches);
            $version = isset($matches[1]) ? str_replace(' ', '', $matches[1]) : '0.0.0';

            return version_compare($version, $dependency['version'], '>=');
        }

        return false;
    }
}
