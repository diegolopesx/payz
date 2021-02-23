<?php

class TransactionTest extends TestCase
{
    public function testBasicExample()
    {
        $this->json('POST', '/transactions/create', [
            "value" => "100",
            "payer" => 1,
            "payee" => 2
        ])->seeJson([
            "message" => "Autorizado"
        ]);
    }
}
