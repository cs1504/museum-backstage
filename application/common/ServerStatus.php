<?php

namespace app\common;


class ServerStatus
{
    public static function getCpuUsage()
    {
        static $cpu = null;
        if (null !== $cpu) {
            return $cpu;
        }

        $filePath = ('/proc/stat');
        if ( ! \is_readable($filePath)) {
            $cpu = array();
            return $cpu;
        }
        $stat1 = \file($filePath);
        \sleep(1);
        $stat2       = \file($filePath);
        $info1       = \explode(' ', \preg_replace('!cpu +!', '', $stat1[0]));
        $info2       = \explode(' ', \preg_replace('!cpu +!', '', $stat2[0]));
        $dif         = array();
        $dif['user'] = $info2[0] - $info1[0];
        $dif['nice'] = $info2[1] - $info1[1];
        $dif['sys']  = $info2[2] - $info1[2];
        $dif['idle'] = $info2[3] - $info1[3];
        $total       = \array_sum($dif);
        $cpu         = array();
        foreach ($dif as $x => $y) {
            $cpu[$x] = \round($y / $total * 100, 1);
        }
        return $cpu['user'] + $cpu['nice'] + $cpu['sys'];
    }

    public static function getMemoryUsage()
    {

        static $memInfo = null;
        if (null === $memInfo) {
            $memInfoFile = '/proc/meminfo';
            if (!\is_readable($memInfoFile)) {
                $memInfo = 0;
                return 0;
            }
            $memInfo = \file_get_contents($memInfoFile);
            $memInfo = \str_replace(array(
                ' kB',
                '  ',
            ), '', $memInfo);
            $lines = array();
            foreach (\explode("\n", $memInfo) as $line) {
                if (!$line) {
                    continue;
                }
                $line = \explode(':', $line);
                $lines[$line[0]] = (int)$line[1];
            }
            $memInfo = $lines;
        }
        $memAvailable = 0;
        if (isset($memInfo['MemAvailable'])) {
            $memAvailable = $memInfo['MemAvailable'];
        } elseif (isset($memInfo['MemFree'])) {
            $memAvailable = $memInfo['MemFree'];
        }
        return $memInfo['MemTotal'] - $memAvailable;
    }
}