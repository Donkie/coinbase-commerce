<?php

namespace WPDMPP\Coinbase\Commerce\Model;


use WPDMPP\Coinbase\Commerce\Util;

class ChargeResource
{
    /**
     * Charge UUID
     *
     * @var string
     */
    protected $id;
    /**
     * Resource name (always "charge")
     *
     * @var string
     */
    protected $resource;
    /**
     * Charge user-friendly primary key
     *
     * @var string
     */
    protected $code;
    /**
     * Charge name
     *
     * @var string
     */
    protected $name;
    /**
     * Charge description
     *
     * @var string
     */
    protected $description;
    /**
     * Charge image URL
     *
     * @var string
     */
    protected $logo_url;
    /**
     * Charge hosted URL (payment gateway)
     *
     * @var string
     */
    protected $hosted_url;
    /**
     * Charge creation time
     *
     * @var \DateTime
     */
    protected $created_at;
    /**
     * Charge expiration time
     *
     * @var \DateTime
     */
    protected $expires_at;
    /**
     * Charge confirmation time
     *
     * @var \DateTime
     */
    protected $confirmed_at;
    /**
     * Associated checkout resource
     *
     * @var array
     */
    protected $checkout;
    /**
     * Status update objects
     *
     * @var array
     */
    protected $timeline;
    /**
     * Metadata associated with the charge
     *
     * @var array
     */
    protected $metadata;
    /**
     * Pricing type: 'no_price' or 'fixed_price'
     *
     * @var string
     */
    protected $pricing_type;
    /**
     * Charge price information object
     *
     * @var Money[]
     */
    protected $pricing;
    /**
     * Charge payments objects
     *
     * @var Payment[]
     */
    protected $payments;
    /**
     * Set of addresses associated with the charge
     *
     * @var array
     */
    protected $addresses;

    /**
     * ChargeResource constructor.
     * @param array $chargeObj
     */
    public function __construct($chargeObj)
    {
        if(isset($chargeObj["id"]))
            $this->id = $chargeObj["id"];
        $this->resource = $chargeObj["resource"];
        $this->code = $chargeObj["code"];
        $this->name = $chargeObj["name"];
        $this->description = $chargeObj["description"];
        if(isset($chargeObj["logo_url"]))
            $this->logo_url = $chargeObj["logo_url"];
        $this->hosted_url = $chargeObj["hosted_url"];
        $this->created_at = Util::parseZuluTimeString($chargeObj["created_at"]);
        $this->expires_at = Util::parseZuluTimeString($chargeObj["expires_at"]);
        if(isset($chargeObj["confirmed_at"]))
            $this->confirmed_at = Util::parseZuluTimeString($chargeObj["confirmed_at"]);
        if(isset($chargeObj["checkout"]))
            $this->checkout = (array)$chargeObj["checkout"];
        $this->metadata = (array)$chargeObj["metadata"];
        $this->pricing_type = $chargeObj["pricing_type"];
        $this->addresses = $chargeObj["addresses"];

        if(isset($chargeObj["timeline"])){
            $this->timeline = [];
            foreach ($chargeObj["timeline"] as $statusObj){
                $this->timeline[] = [
                    "time" => Util::parseZuluTimeString($statusObj["time"]),
                    "status" => $statusObj["status"],
                    "context" => $statusObj["context"],
                ];
            }
        }

        if(isset($chargeObj["pricing"])){
            $this->pricing = [];
            foreach ($chargeObj["pricing"] as $name => $pricingObj){
                $this->pricing[$name] = new Money($pricingObj["amount"], $pricingObj["currency"]);
            }
        }

        if(isset($chargeObj["payments"])){
            $this->payments = [];
            foreach ($chargeObj["payments"] as $paymentObj){
                $this->payments[] = new Payment($paymentObj);
            }
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logo_url;
    }

    /**
     * @return string
     */
    public function getHostedUrl()
    {
        return $this->hosted_url;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmedAt()
    {
        return $this->confirmed_at;
    }

    /**
     * @return array
     */
    public function getCheckout()
    {
        return $this->checkout;
    }

    /**
     * @return array
     */
    public function getTimeline()
    {
        return $this->timeline;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return string
     */
    public function getPricingType()
    {
        return $this->pricing_type;
    }

    /**
     * @return Money[]
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * @return Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }


}