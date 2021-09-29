<?php


use mataluis2k\shipwire\Stock;

class StockTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testStock()
    {
        $stock = new Stock();
        $stockRet = $stock->getStockBySKUs(['CAPTRACKERBLUE']);
        $this->assertTrue(is_array($stockRet) && isset($stockRet['items']) && count($stockRet['items']));
    }

}