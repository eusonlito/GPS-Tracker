<?php declare(strict_types=1);

namespace App\Domains\User\Model\Traits;

trait Preferences
{
    /**
     * @param string $key
     * @param mixed $input = null
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function preference(string $key, mixed $input = null, mixed $default = null): mixed
    {
        if ($input !== null) {
            return $this->preferenceSet($key, $input);
        }

        if (($value = $this->preferences[$key] ?? null) !== null) {
            return $value;
        }

        if (isset($default)) {
            return $this->preferenceSet($key, $default);
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function preferenceSet(string $key, mixed $value): mixed
    {
        $preferences = (array)$this->preferences;

        if (($preferences[$key] ?? null) !== $value) {
            $this->preferences = [$key => $value] + $preferences;
            $this->save();
        }

        return $value;
    }
}
