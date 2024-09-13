<?php
/**
 * @package        mod_qlcode
 * @copyright    Copyright (C) 2024 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

class modQlcodeHelper
{
    /** @var JRegistry */
    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function generateFile(string $str, string $filenameTemp)
    {
        $handle = fopen($filenameTemp, "w");
        fwrite($handle, $str, strlen($str));
        fclose($handle);
    }

    public function deleteFile(string $filenameTemp)
    {
        unlink($filenameTemp);
    }

    public function cleanJs(string $str)
    {
        preg_match('/<script(.*)>(.*)<\/script>/i', $str, $matches);
        if (!is_array($matches) || 0 >= count($matches)) {
            return $str;
        }

        foreach ($matches as $v) {
            $strClean = str_replace('<br />', '', $v);
            $str = str_replace($v, $strClean, '');
        }

        return $str;
    }

    public function cleanCss(string $str)
    {
        preg_match('/<style(.*)>(.*)<\/style>/i', $str, $matches);
        if (!is_array($matches) and 0 < count($matches)) {
            return $str;
        }
        foreach ($matches as $k => $v) {
            $strClean = str_replace('<br />', '', $v);
            $str = str_replace($v, $strClean, '');
        }
        return $str;
    }

    public function addCodeParams(string $codeParams): stdClass
    {
        if (empty(trim($codeParams))) {
            return new stdClass();
        }
        if ($this->params->get('codeReplaceQuotes', false)) {
            $codeParams = str_replace('\'', '"', $codeParams);
        }
        if (is_string($codeParams)) {
            $codeParams = json_decode($codeParams);
        }
        return $codeParams;
    }
}
