<?php
namespace JsonLogic;

use Closure;

class Parameters
{
    private $params;

    public static function from(array &$params): Parameters
    {
        return new static(
            ...array_map(
                [Rule::class, 'make'],
                $params
            )
        );
    }

    public function __construct(Closure &...$params)
    {
        $this->params = $params;
    }

    public function every(callable $fn, &$data): bool
    {
        return $this->recurseEvery($fn, $data, ...$this->params);
    }

    public function everyPairs(callable $fn, &$data): bool
    {
        return $this->recurseEveryPairs(
            $fn,
            $data,
            $this->params[0]($data),
            ...array_slice($this->params, 1)
        );
    }

    public function reduce(callable $fn, &$data, $init = null)
    {
        return is_null($init)
            ? array_reduce(
                array_slice($this->params, 1),
                function ($curry, $closure) use (&$data, &$fn) {
                    return $fn($curry, $closure($data));
                },
                $this->params[0]($data)
            )
            : array_reduce($this->params, function ($curry, $closure) use (&$data, &$fn) {
                return $fn($curry, $closure($data));
            }, $init);
    }

    public function values(&$data): array
    {
        return array_map(function ($getter) use (&$data) {
            return $getter($data);
        }, $this->params);
    }

    private function recurseEvery(callable &$fn, &$data, Closure &$getter = null, Closure &...$rest): bool
    {
        return $getter
            && $fn($getter($data))
            && $this->recurseEvery($fn, $data, ...$rest);
    }

    private function recurseEveryPairs(callable &$fn, &$data, $curr, Closure &$getter = null, Closure &...$rest): bool
    {
        $next = $getter($data);
        return count($rest)
            ? $fn($curr, $next) && $this->recurseEveryPairs($fn, $data, $next, ...$rest)
            : $fn($curr, $next);
    }
}
