<?php

namespace WPDMPP\Coinbase\Commerce\Model;


abstract class Status
{
    const Created = "NEW";
    const Pending = "PENDING";
    const Confirmed = "CONFIRMED";
    const Unresolved = "UNRESOLVED";
    const Resolved = "RESOLVED";
}