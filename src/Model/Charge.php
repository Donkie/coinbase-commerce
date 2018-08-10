<?php
namespace WPDMPP\Coinbase\Commerce\Model;

/**
 * Description of Charge
 *
 * This Model class represents the input data used identify the charge information
 * according to cryptocurrency payment
 *
 * @author WPDMPP <support@wpdownloadmanager.com>
 */

class Charge {

	/**
     * Name
     * Charge name
     *
     * @var string 
     */
    protected $name;

    /**
     * Description
     * More detailed description of the charge
     *
     * @var string 
     */
    protected $description;

    /**
     * Pricing Type
     * Charge pricing type no_price or fixed_price
     *
     * @var string 
     */
    protected $pricing_type;

    /**
     * Local price
     * Price in local fiat currency
     *
     * @var money 
     */
    protected $local_price;

    /**
     * Redirect url
     * Redirect URL
     *
     * @var string 
     */
    protected $redirect_url;

    /**
     * Metadata
     * User-specified metadata
     *
     * @var array
     */
    protected $metadata;

    /**
     * Get name
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get description
     * 
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Get pricing type
     * 
     * @return string
     */
    public function getPricingType() {
        return $this->pricing_type;
    }

    /**
     * Get local price
     * 
     * @return Money
     */
    public function getLocalPrice() {
        return json_encode($this->local_price);
    }

    /**
     * Get redirect url
     * 
     * @return string
     */
    public function getRedirectUrl() {
        return $this->redirect_url;
    }

    /**
     * Get metadata
     *
     * @return array
     */
    public function getMetadata() {
        return $this->metadata;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    /**
     * Set pricing type
     *
     * @param string $pricing_type
     * @return $this
     */
    public function setPricingType($pricing_type){
        $this->pricing_type = $pricing_type;
        return $this;
    }

    /**
     * Set local price
     *
     * @param Money $local_price
     * @return $this
     */
    public function setLocalPrice(Money $local_price){
        $this->local_price = $local_price;
        return $this;
    }

    /**
     * Set redirect url
     *
     * @param string $redirect_url
     * @return $this
     */
    public function setRedirectUrl($redirect_url){
        $this->redirect_url = $redirect_url;
        return $this;
    }

    /**
     * Set metadata
     *
     * @param array $metadata
     * @return Charge
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

}

