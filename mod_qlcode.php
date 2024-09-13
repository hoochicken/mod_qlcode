<?php
/**
 * @package        mod_qlcode
 * @copyright    Copyright (C) 2022 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/** @var JRegistry $params  */
$php = (bool) $params->get('php', 0);
$strCode = $params->get('code', '');
/** @var stdClass $module */

require_once(dirname(__FILE__) . '/helper.php');
$obj_helper = new modQlcodeHelper($params);

switch ($params->get('clean', 0)) {
    case 1:
        $strCode = $obj_helper->cleanJs($strCode);
        break;
    case 2:
        $strCode = $obj_helper->cleanCss($strCode);
        break;
    case 3:
        $strCode = str_replace('<br />', '', $strCode);
        break;
}
if ($php) {
    $codeParams = $obj_helper->addCodeParams($params->get('codeParams', ''));
    $strFilenameTemp = tempnam(JPATH_SITE . '/tmp', 'mod_qlcode_' . $module->id . '_');
    // $strFilenameTemp .= '.php';
    $obj_helper->generateFile($strCode, $strFilenameTemp);
}

require JModuleHelper::getLayoutPath('mod_qlcode', $params->get('layout', 'default'));
if ($php && file_exists($strFilenameTemp)) {
    unlink($strFilenameTemp);
}
