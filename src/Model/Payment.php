<?php

namespace WPDMPP\Coinbase\Commerce\Model;


class Payment
{
    /**
     * Crypto currency network, e.g. "ethereum"
     *
     * @var string
     */
    protected $network;
    /**
     * Transaction ID, e.g. "0xabcdef"
     *
     * @var string
     */
    protected $transaction_id;
    /**
     * Payment status
     *
     * @var string
     */
    protected $status;
    /**
     * Price information objects
     *
     * @var Money[]
     */
    protected $value;
    /**
     * Blockchain block information
     *
     * @var array
     */
    protected $block;

    /**
     * Payment constructor.
     * @param array paymentObj A payment object array
     */
    public function __construct($paymentObj)
    {
        $this->network = $paymentObj["network"];
        $this->transaction_id = $paymentObj["transaction_id"];
        $this->status = $paymentObj["status"];
        $this->value = $paymentObj["value"];
        $this->block = $paymentObj["block"];

        if(!is_null($paymentObj["value"])){
            $this->value = [];

            foreach ($paymentObj["value"] as $name => $valueObj){
                $this->value[$name] = new Money($valueObj["amount"], $valueObj["currency"]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }
}