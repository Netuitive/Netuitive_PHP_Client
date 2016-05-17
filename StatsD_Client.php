<?php
/**
 * Sends statistics to the stats daemon over UDP
 *
 **/
   /**
     * Gauge
     *
     * @param string $gaugeName The gauge metric name
     * @param string $val value
     **/
    function gauge($gaugeName, $value) {
       send(array($gaugeName => "$value|g"));
    }

   /**
     * Timmer
     *
     * @param string $stats The metric to in log timing info
     * @param float $time The ellapsed time (ms) to log
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     **/
    function timing($stat, $time, $sampleRate=1) {
        send(array($stat => "$time|ms"), $sampleRate);
    }
    /**
     * Counter. Increments 
     *
     * @param string|array $stats The metric(s) to increment.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @return boolean
     **/
    function increment($stats, $sampleRate=1) {
        updateStats($stats, 1, $sampleRate);
    }
    /**
     * Counter. Decrements
     *
     * @param string|array $stats The metric(s) to decrement.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @return boolean
     **/
    function decrement($stats, $sampleRate=1) {
        updateStats($stats, -1, $sampleRate);
    }
    /**
     * Updates one or more stats counters by arbitrary amounts.
     *
     * @param string|array $stats The metric(s) to update. Should be either a string or array of metrics.
     * @param int|1 $delta The amount to increment/decrement each metric by.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @return boolean
     **/
    function updateStats($stats, $delta=1, $sampleRate=1) {
        if (!is_array($stats)) { $stats = array($stats); }
        $data = array();
        foreach($stats as $stat) {
            $data[$stat] = "$delta|c";
        }
        send($data, $sampleRate);
    }
    /*
     * Send metrics over UDP
     **/
    function send($data, $sampleRate=1) {
        // sampling
        $sampledData = array();
        if ($sampleRate < 1) {
            foreach ($data as $stat => $value) {
                if ((mt_rand() / mt_getrandmax()) <= $sampleRate) {
                    $sampledData[$stat] = "$value|@$sampleRate";
                }
            }
        } else {
            $sampledData = $data;
        }
        if (empty($sampledData)) { return; }
        // Wrap this in a try/catch - failures in any of this should be silently ignored
        // Up to the dev to make sure statsd is running
        try {
            $fp = fsockopen("udp://localhost", 8125, $errno, $errstr);
            if (! $fp) { return; }
            foreach ($sampledData as $stat => $value) {
                fwrite($fp, "$stat:$value");
            }
            fclose($fp);
        } catch (Exception $e) {
        }
    }
?>