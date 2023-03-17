<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    /**
     * @var \Illuminate\Http\Request
     */
    public Request $request;

    /**
     * @var string
     */
    public string $value;

    /**
     * @var array
     */
    public array $text;

    /**
     * @var array
     */
    public array $options;

    /**
     * @var string|array
     */
    public string|array $selected;

    /**
     * @var string
     */
    public string $label;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var bool
     */
    public bool $valueOnly;

    /**
     * @var bool
     */
    public bool $optionsWithAttributes;

    /**
     * @param \Illuminate\Http\Request $request
     * @param array|\Illuminate\Support\Collection $options,
     * @param string $value = '',
     * @param string|int|array $text = '',
     * @param string $label = '',
     * @param string $name = '',
     * @param string $id = '',
     * @param mixed $selected = null,
     * @param string $placeholder = ''
     * @param bool $valueOnly = false
     * @param bool $optionsWithAttributes = false
     *
     * @return self
     */
    public function __construct(
        Request $request,
        array|Collection $options,
        string $value = '',
        string|int|array $text = '',
        string $label = '',
        string $name = '',
        string $id = '',
        mixed $selected = null,
        string $placeholder = '',
        bool $valueOnly = false,
        bool $optionsWithAttributes = false,
    ) {
        $this->request = $request;
        $this->name = $name;
        $this->value = $value;
        $this->valueOnly = $valueOnly;
        $this->optionsWithAttributes = $optionsWithAttributes;
        $this->text = array_filter((array)$text);
        $this->selected = $this->selected($selected);
        $this->options = $this->options($options);
        $this->label = $label;
        $this->id = $id ?: 'input-'.uniqid();
        $this->placeholder($placeholder);
    }

    /**
     * @param mixed $selected
     *
     * @return string|array
     */
    protected function selected(mixed $selected): string|array
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
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.select');
    }
}
