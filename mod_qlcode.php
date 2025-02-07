<?php
/**
 * @package        mod_qlcode
 * @copyright    Copyright (C) 2024 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/** @var JRegistry $params  */
$php = (bool) $params->get('php', 0);
$code = $params->get('code', '');
/** @var stdClass $module */

require_once(__DIR__ . '/helper.php');
$helper = new modQlcodeHelper($params);

switch ((int)$params->get('clean', 0)) {
    case 1:
        $code = $helper->cleanJs($code);
        break;
    case 2:
        $code = $helper->cleanCss($code);
        break;
    case 3:
        $code = str_replace('<br />', '', $code);
        break;
}
if ($php) {
    $codeParams = $helper->addCodeParams($params->get('codeParams', ''));
    $filenameTemp = @tempnam(JPATH_SITE . '/tmp', 'mod_qlcode_' . $module->id . '_');
    $helper->generateFile($code, $filenameTemp);
}

require JModuleHelper::getLayoutPath('mod_qlcode', $params->get('layout', 'default'));

if ($php && file_exists($filenameTemp)) {
    $helper->deleteFile($filenameTemp);
}
