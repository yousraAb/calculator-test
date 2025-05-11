<?php
use PHPUnit\Framework\TestCase;
use Commission\Calculator\CommissionCalculator;
use Commission\Providers\BinProviderInterface;
use Commission\Providers\ExchangeRateProviderInterface;

class CommissionCalculatorTest extends TestCase {
    public function testCalculateEuCurrency() {
        $binProvider = $this->createMock(BinProviderInterface::class);
        $binProvider->method('isEu')->willReturn(true);

        $rateProvider = $this->createMock(ExchangeRateProviderInterface::class);
        $rateProvider->method('getRate')->willReturn(1);

        $calculator = new CommissionCalculator($binProvider, $rateProvider);

        $transaction = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');
        $this->assertEquals('1.00', $calculator->calculate($transaction));
    }
}