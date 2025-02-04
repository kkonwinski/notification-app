<?php

namespace App\Service;

class FizzBuzzService
{
    public function getSequence(int $n): array
    {
        $result = [];

        for ($i = 1; $i <= $n; $i++) {
            $value = '';
            if ($i % 3 === 0) {
                $value .= 'Fizz';
            }
            if ($i % 5 === 0) {
                $value .= 'Buzz';
            }
            $result[] = $value === '' ? (string) $i : $value;
        }

        return $result;
    }
}
