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
        if ( ! isset($memInfo['SwapTotal']) || ! isset($memInfo['SwapFree']) || ! isset($memInfo['SwapCached'])) {
            $memInfo['SwapTotal'] = 1;
            $memInfo['SwapFree'] = 0;
            $memInfo['SwapCached'] = 0;
        }
        return [
            'mem' => round(($memInfo['MemTotal'] - $memAvailable)/$memInfo['MemTotal']*100 , 1),
            'swap' => round(($memInfo['SwapTotal'] - $memInfo['SwapFree'] - $memInfo['SwapCached'])/$memInfo['SwapTotal']*100, 1 )
            ];
    }

    public static function getDiskTotalSpace($human = false)
    {
        static $space = null;
        if (null === $space) {
            $space = \disk_total_space('/');
        }
        if ( ! $space) {
            return 0;
        }
        if (true === $human) {
            return self::formatBytes($space);
        }
        return $space;
    }

    public static function getDiskFreeSpace($human = false)
    {
        static $space = null;
        if (null === $space) {
            try {
                $space = \disk_free_space('/');
            } catch (\Exception $e) {
                $space = 0;
            }
        }
        if ( ! $space) {
            return 0;
        }
        if (true === $human) {
            return self::formatBytes($space);
        }
        return $space;
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        if ( ! $bytes) {
            return 0;
        }
        $base     = \log($bytes, 1024);
        $suffixes = array('', ' K', ' M', ' G', ' T');
        return \round(\pow(1024, $base - \floor($base)), $precision) . $suffixes[\floor($base)];
    }
}