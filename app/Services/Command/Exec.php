<?php declare(strict_types=1);

namespace App\Services\Command;

class Exec
{
    /**
     * @param string $command
     *
     * @return string
     */
    public static function cmd(string $command): string
    {
        return trim(strval(shell_exec($command)));
    }

    /**
     * @param string $command
     *
     * @return array
     */
    public static function cmdArray(string $command): array
    {
        return static::toArray(static::cmd($command));
    }

    /**
     * @param string $command
     *
     * @return array
     */
    public static function cmdArrayInt(string $command): array
    {
        return array_map('intval', static::toArray(static::cmd($command)));
    }

    /**
     * @param string $command
     *
     * @return float
     */
    public static function cmdFloat(string $command): float
    {
        return intval(static::cmd($command));
    }

    /**
     * @param string $command
     *
     * @return int
     */
    public static function cmdInt(string $command): int
    {
        return intval(static::cmd($command));
    }

    /**
     * @param string $command
     *
     * @return array
     */
    public static function cmdLines(string $command): array
    {
        return static::toLines(static::cmd($command));
    }

    /**
     * @param string $command
     *
     * @return array
     */
    public static function cmdLinesArray(string $command): array
    {
        return static::filter(array_map(
            static fn ($line) => static::toArray($line),
            static::cmdLines($command)
        ));
    }

    /**
     * @param string $output
     *
     * @return array
     */
    protected static function toArray(string $output): array
    {
        return static::explode(' ', preg_replace('/\s+/', ' ', $output));
    }

    /**
     * @param string $output
     *
     * @return array
     */
    protected static function toLines(string $output): array
    {
        return static::explode("\n", $output);
    }

    /**
     * @param string $delimiter
     * @param string $output
     *
     * @return array
     */
    protected static function explode(string $delimiter, string $output): array
    {
        return static::filter(explode($delimiter, $output));
    }

    /**
     * @param array $output
     *
     * @return array
     */
    protected static function filter(array $output): array
    {
        return array_values(array_filter($output, static function ($value) {
            return is_string($value) ? strlen($value) : $value;
        }));
    }
}
