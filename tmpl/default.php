<?php
/**
 * @package        mod_qlcode
 * @copyright    Copyright (C) 2022 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
/** @var boolean $php */
/** @var string $strFilenameTemp */
/** @var string $strCode */
/** @var stdClass $module */

if ($php) {
    $moduleIdToBeDebugged = 0;
    if ($moduleIdToBeDebugged === (int) $module->id) {
        include_once(JPATH_ROOT . '/tmp/mod_qlcode_test.php');
    } else {
        include_once($strFilenameTemp);
    }
} else {
    echo $strCode;
}
