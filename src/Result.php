<?php

namespace Wulfheart\Option;

/**
 * @template TSuccess
 * @template TError
 *
 * @phpstan-consistent-constructor
 */
class Result
{
    private function __construct(
        private bool $ok,
        private mixed $value,
        private mixed $error = null,
    ) {}

    /**
     * @param  TSuccess|null  $value
     */
    public static function ok(mixed $value = null): static
    {
        return new static(true, $value);
    }

    /**
     * @param  TError  $error
     */
    public static function err(mixed $error): static
    {
        return new static(false, null, $error);
    }

    public function isOk(): bool
    {
        return $this->ok;
    }

    public function isErr(): bool
    {
        return ! $this->ok;
    }

    /**
     * @param  TError  $err
     */
    public function hasErr(mixed $err): bool
    {
        return $this->isErr() && $this->error == $err;
    }

    /**
     * @throws ResultUnwrapException
     *
     * @return TSuccess
     */
    public function unwrap(): mixed
    {
        if ($this->isErr()) {
            throw new ResultUnwrapException('Called `unwrap` on an `Err` value with error: ' . $this->error);
        }

        return $this->value;
    }

    public function ensure(): void
    {
        if ($this->isErr()) {
            throw new ResultUnwrapException('Assumed `Ok` value but got `Err` value with error: ' . $this->error);
        }
    }

    /**
     * @throws ResultUnwrapException
     *
     * @return TError
     */
    public function unwrapErr(): mixed
    {
        if ($this->isOk()) {
            throw new ResultUnwrapException('Called `unwrapErr` on an `Ok` value');
        }

        return $this->error;
    }
}
