<?php declare(strict_types=1);

namespace App\Services\Command;

class Exec
{
    /**
     * @param string $command
     *
     * @return ?string
     */
    public static function available(string $command): ?string
    {
        return static::cmd('/bin/sh -c "command -v '.escapeshellarg($command).'" 2>/dev/null') ?: null;
    }

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
     * @return string
     */
    public static function php(): string
    {
        if ($php = env('PHP_BINARY')) {
            return $php;
        }

        if (static::phpIsCli()) {
            return PHP_BINARY;
        }

        $version = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;

        return static::available('php'.$version) ?: static::available('php');
    }

    /**
     * @return bool
     */
    protected static function phpIsCli(): bool
    {
        return (PHP_SAPI === 'cli') || defined('STDIN');
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
