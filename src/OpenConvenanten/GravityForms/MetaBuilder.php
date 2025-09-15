<?php

declare(strict_types=1);

namespace Yard\OpenConvenanten\GravityForms;

class MetaBuilder
{
	private array $formValues = [];

	public function __construct(array $formValues)
	{
		$this->formValues = $formValues;
	}

	public static function make(array $formValues): self
	{
		return new static($formValues);
	}

	public function get(): array
	{
		$metaValues = [];

		foreach ($this->formValues as $key => $value) {
			$key = $this->getKey($key);
			$value = $this->getMetaField($key, $value);

			$metaValues[$key] = $value;
		}

		$metaValues = $this->getShowOnBlog($metaValues);

		return $metaValues;
	}

	protected function getShowOnBlog(array $metaValues): array
	{
		$metaValues['convenant_Website'] = (string) ($metaValues['convenant_Website'] ?? '');

		return $metaValues;
	}

	protected function getKey(string $key): string
	{
		$key = preg_replace('/[^a-zA-Z0-9_ ]/', '', $key);
		$key = str_replace(' ', '_', $key);
		$key = ucfirst($key);

		return 'convenant_' . $key;
	}

	protected function getMetaField(string $key, string $value)
	{
		if ($this->isSpecialField($key)) {
			return $this->specialField($key, $value);
		}

		return $value;
	}

	protected function isSpecialField(string $key): bool
	{
		return class_exists($this->getSpecialFieldClassName($key));
	}

	protected function specialField(string $key, string $value)
	{
		$className = $this->getSpecialFieldClassName($key);

		return $className::make($key, $value)->get();
	}

	protected function getSpecialFieldClassName(string $key): string
	{
		$key = str_replace('convenant_', '', $key);
		$key = str_replace('_', '', $key);

		return sprintf('Yard\\OpenConvenanten\\GravityForms\\Fields\\%sField', $key);
	}
}
