<?php

namespace WPDMPP\Coinbase\Commerce\Model;


use WPDMPP\Coinbase\Commerce\Util;

class EventResource
{
    /**
     * Event UUID
     *
     * @var string
     */
    protected $id;
    /**
     * Resource name (always "event")
     *
     * @var string
     */
    protected $resource;
    /**
     * Event type, one of ("charge:created", "charge:confirmed", "charge:delayed" or "charge:failed")
     *
     * @var string
     */
    protected $type;
    /**
     * The Coinbase Commerce API version of the data charge object, e.g. "2018-03-22"
     *
     * @var string
     */
    protected $api_version;
    /**
     * Event creation time
     *
     * @var \DateTime
     */
    protected $created_at;
    /**
     * The charge associated with the event
     *
     * @var ChargeResource
     */
    protected $data;

    /**
     * Event constructor.
     * @param array $eventObj
     */
    public function __construct($eventObj)
    {
        $this->id = $eventObj["id"];
        $this->resource = $eventObj["resource"];
        $this->type = $eventObj["type"];
        $this->api_version = $eventObj["api_version"];
        $this->created_at = Util::parseZuluTimeString($eventObj["created_at"]);
        $this->data = new ChargeResource($eventObj["data"]);
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->api_version;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return ChargeResource
     */
    public function getData()
    {
        return $this->data;
    }
}