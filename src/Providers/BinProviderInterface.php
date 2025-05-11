<?php
namespace Commission\Providers;

interface BinProviderInterface {
    public function isEu(string $bin): bool;
}