<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    /**
     * @var string
     */
    public string $class;

    /**
     * @param \Illuminate\Http\Request $request
     * @param array|\Illuminate\Support\Collection $options,
     * @param string $value = '',
     * @param string|int|array $text = '',
     * @param string $label = '',
     * @param string $name = '',
     * @param string $id = '',
     * @param array|string|null $selected = null,
     * @param string $placeholder = ''
     * @param bool $valueOnly = false
     * @param bool $optionsWithAttributes = false
     *
     * @return self
     */
    public function __construct(
        public Request $request,
        public array|Collection $options,
        public string $value = '',
        public string|int|array $text = '',
        public string $label = '',
        public string $name = '',
        public string $id = '',
        public array|string|null $selected = null,
        public string $placeholder = '',
        public bool $valueOnly = false,
        public bool $optionsWithAttributes = false,
    ) {
        $this->text = array_filter((array)$text);
        $this->selected = $this->selected($selected);
        $this->options = $this->options($options);
        $this->id = $id ?: 'input-'.uniqid();
        $this->placeholder($placeholder);
        $this->class();
    }

    /**
     * @param array|string|null $selected
     *
     * @return string|array
     */
    protected function selected(array|string|null $selected): string|array
    {
        $selected ??= $this->request->input(helper()->arrayKeyDot($this->name));

        return is_array($selected) ? $selected : strval($selected);
    }

    /**
     * @param array|\Illuminate\Support\Collection $options
     *
     * @return array
     */
    protected function options(array|Collection $options): array
    {
        if ($options instanceof Collection) {
            $options = $options->toArray();
        }

        if ($this->valueOnly) {
            return $this->optionsValue($options);
        }

        if (empty($this->value) || empty($this->text)) {
            return $this->optionsKeyValue($options);
        }

        return $this->optionsAssociative($options);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function optionsValue(array $options): array
    {
        return array_map($this->optionsValueOption(...), $options);
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    protected function optionsValueOption($value): array
    {
        return [
            'value' => $value,
            'text' => $value,
            'selected' => $this->optionsValueOptionSelected($value),
        ];
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function optionsValueOptionSelected($value): bool
    {
        if (is_array($this->selected)) {
            return in_array($value, $this->selected);
        }

        return strval($value) === $this->selected;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function optionsKeyValue(array $options): array
    {
        return array_map($this->optionsKeyValueOption(...), array_keys($options), $options);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return array
     */
    protected function optionsKeyValueOption($key, $value): array
    {
        return [
            'value' => $key,
            'text' => $value,
            'selected' => $this->optionsKeyValueOptionSelected($key),
        ];
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    protected function optionsKeyValueOptionSelected($key): bool
    {
        if (is_array($this->selected)) {
            return in_array($key, $this->selected);
        }

        return strval($key) === $this->selected;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function optionsAssociative(array $options): array
    {
        return array_map($this->optionsAssociativeOption(...), $options);
    }

    /**
     * @param array $option
     *
     * @return array
     */
    protected function optionsAssociativeOption(array $option): array
    {
        return [
            'value' => $this->optionsAssociativeOptionValue($option),
            'text' => $this->optionsAssociativeOptionText($option),
            'selected' => $this->optionsAssociativeOptionSelected($option),
            'attributes' => $this->optionsAssociativeOptionAttributes($option),
        ];
    }

    /**
     * @param array $option
     *
     * @return string
     */
    protected function optionsAssociativeOptionValue(array $option): string
    {
        return strval($option[$this->value] ?? '');
    }

    /**
     * @param array $option
     *
     * @return string
     */
    protected function optionsAssociativeOptionText(array $option): string
    {
        return implode(' - ', array_filter(array_map(fn ($key) => data_get($option, $key, ''), $this->text)));
    }

    /**
     * @param array $option
     *
     * @return bool
     */
    protected function optionsAssociativeOptionSelected(array $option): bool
    {
        $key = $option[$this->value] ?? '';

        if (is_array($this->selected)) {
            return in_array($key, $this->selected);
        }

        return strval($key) === $this->selected;
    }

    /**
     * @param array $option
     *
     * @return string
     */
    protected function optionsAssociativeOptionAttributes(array $option): string
    {
        if ($this->optionsWithAttributes === false) {
            return '';
        }

        $option = array_diff_key($option, array_flip(array_merge([$this->value, 'selected'], $this->text)));

        return helper()->arrayHtmlAttributes(array_filter($option));
    }

    /**
     * @param string $placeholder
     *
     * @return void
     */
    protected function placeholder(string $placeholder): void
    {
        if (empty($placeholder)) {
            return;
        }

        array_unshift($this->options, [
            'value' => '',
            'text' => $placeholder,
            'selected' => false,
        ]);
    }

    /**
     * @return void
     */
    protected function class(): void
    {
        $this->class = 'form-select form-select-lg bg-white';
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.select');
    }
}
