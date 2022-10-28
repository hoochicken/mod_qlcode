<?php
/**
 * @package		mod_qlcode
 * @copyright	Copyright (C) 2016 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

class modQlcodeHelper
{
    function __construct($params)
    {
        $this->params=$params;
    }
    public function generateFile($str,$strFilenameTemp)
    {
        $handle=fopen($strFilenameTemp,"w");
        fwrite($handle,$str,strlen($str));
        fclose($handle);
    }
    public function cleanJs($str)
    {
        preg_match('/<script(.*)>(.*)<\/script>/i', $str, $matches);
        if (is_array($matches) AND 0<count($matches)) foreach ($matches as $k=>$v)
        {
            $strClean=str_replace('<br />', '', $v);
            $str=str_replace($v, $strClean, '');
        }
        return $str;
    }
    public function cleanCss($str)
    {
        preg_match('/<style(.*)>(.*)<\/style>/i', $str, $matches);
        if (is_array($matches) AND 0<count($matches)) foreach ($matches as $k=>$v)
        {
            $strClean=str_replace('<br />', '', $v);
            $str=str_replace($v, $strClean, '');
        }
        return $str;
    }
    function addCodeParams($codeParams)
    {
        if(''==trim($codeParams)) return;
        if(1==$this->params->get('codeReplaceQuotes',0))$codeParams=str_replace('\'','"',$codeParams);
        if(is_string($codeParams))$codeParams=json_decode($codeParams);
        return $codeParams;
    }
}