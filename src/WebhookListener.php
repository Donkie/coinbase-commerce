<?php

namespace WPDMPP\Coinbase\Commerce;

use WPDMPP\Coinbase\Commerce\Model\Event;

if (!function_exists('hash_equals')) {
    function hash_equals($str1, $str2)
    {
        // Run constant-time comparison for PHP < 5.6 which doesn't support hmac_equals
        $str1_len = strlen($str1);
        $str2_len = strlen($str2);
        // Calculate XOR
        $diff = $str1_len ^ $str2_len;
        for ($x = 0; $x < $str1_len && $x < $str2_len; $x++) {
            $diff |= ord($str1[$x]) ^ ord($str2[$x]);
        }
        return $diff === 0;
    }
}

class WebhookListener
{
    /**
     * The last error generated
     * @var string
     */
    protected $last_error;
    /**
     * Webhook UUID
     * @var string
     */
    protected $id;
    /**
     * When the webhook was scheduled to deliver
     * @var \DateTime
     */
    protected $scheduled_for;
    /**
     * Attempt number
     * @var integer
     */
    protected $attempt_number;
    /**
     * Parsed event from the payload
     * @var Event
     */
    protected $event;
    /**
     * The webhook shared secret key
     * @var string
     */
    private $webhook_secret;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getScheduledFor()
    {
        return $this->scheduled_for;
    }

    /**
     * @return int
     */
    public function getAttemptNumber()
    {
        return $this->attempt_number;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Processes an incoming webhook and validates it.
     * If a webhook key is set, it verifies the payload using it
     *
     * @param string|null $payload Optional json payload data. Uses request body if null.
     * @return bool Valid request
     */
    public function process($payload = null)
    {
        if (empty($payload))
            $payload = file_get_contents('php://input');

        if (empty($payload)) {
            $this->last_error = "Empty payload.";
            return false;
        }

        if (!empty($this->webhook_secret)) {
            if (!isset($_SERVER["HTTP_X_CC_Webhook_Signature"])) {
                $this->last_error = "X-CC-Webhook-Signature header not found.";
                return false;
            }

            $signature = $_SERVER["HTTP_X_CC_Webhook_Signature"];
            if (!$this->verifySignature($payload, $signature, $this->webhook_secret)) {
                $this->last_error = "Couldn't verify payload HMAC with sent header signature.";
                return false;
            }
        } else {
            trigger_error("Webhook not verified with webhook shared secret key!", E_USER_WARNING);
        }

        $data = json_decode($payload, true);

        $this->attempt_number = $data["attempt_number"];
        $this->id = $data["id"];
        $this->scheduled_for = Util::parseZuluTimeString($data["scheduled_for"]);

        if (isset($data["event"])) {
            try {
                $this->event = new Event($data["event"]);
            } catch (\Exception $e) {
                $this->last_error = "Failed to parse event payload: {$e->getMessage()}";
                return false;
            }
        } else {
            $this->last_error = "Unknown webhook payload type";
            return false;
        }

        return true;
    }

    /**
     * Verifies the payload using HMAC hash comparison
     *
     * @param string $payload
     * @param string $signature
     * @param string $secret
     * @return bool Valid payload
     */
    private function verifySignature($payload, $signature, $secret)
    {
        return hash_equals(hash_hmac("sha512", $payload, $secret), $signature);
    }

    /**
     * @param string $webhooksecret
     */
    public function setWebhookKey($webhooksecret)
    {
        $this->webhook_secret = $webhooksecret;
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->last_error;
    }
}
