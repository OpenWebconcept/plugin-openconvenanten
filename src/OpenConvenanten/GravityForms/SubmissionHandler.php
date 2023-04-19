<?php declare(strict_types=1);

namespace Yard\OpenConvenanten\GravityForms;

class SubmissionHandler
{
    private array $entry;
    private array $form;

    public function __construct($entry, $form)
    {
        $this->entry = $entry;
        $this->form = $form;
    }

    public static function make($entry, $form): self
    {
        return new static($entry, $form);
    }

    public function handle(): void
    {
        if (! $this->isOpenConvenantForm()) {
            return;
        }

        $enteredValues = $this->getEnteredValues();

        $this->savePost($enteredValues);
    }

    /**
     * Gets key value pairs of labels and entered values.
     */
    private function getEnteredValues(): array
    {
        $mapping = $this->getMapping();
        $values = [];
        foreach ($this->entry as $key => $value) {
            if (! is_numeric($key)) {
                continue;
            }

            $values[$mapping[$key]] = $value;
        }

        return $values;
    }

    /**
     * Transforms the form fields into a key value pair of field id and label
     */
    private function getMapping(): array
    {
        $mapping = [];

        foreach ($this->form['fields'] as $field) {
            if (empty($field['id']) || empty($field['label'])) {
                continue;
            }

            if (empty($field['inputs'])) {
                $mapping[$field['id']] = $field['label'];

                continue;
            }

            foreach ($field['inputs'] as $input) {
                $mapping[$input['id']] = $input['label'];
            }
        }

        return $mapping;
    }

    private function savePost(array $values): int
    {
        return PostBuilder::make($values)->save();
    }

    private function isOpenConvenantForm(): bool
    {
        return strpos($this->form['cssClass'] ?? '', 'convenanten') !== false;
    }
}
