<?php

namespace WPDMPP\Coinbase\Commerce;


class Util
{
    /**
     * Parses a "zulu time" string (2017-01-31T20:50:02Z) into a DateTime object
     * @param string|null $timeString
     * @return \DateTime|null
     */
    public static function parseZuluTimeString($timeString = null){
        if(is_null($timeString))
            return null;

        $dt = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $timeString, new \DateTimeZone("Etc/UTC"));
        if($dt === FALSE)
            return null;

        return $dt;
    }
}