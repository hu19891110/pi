<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 * @package         View
 */

namespace Pi\View\Helper;

use Pi;
use Zend\View\Helper\AbstractHtmlElement;

/**
 * Helper for building logo URL
 *
 * Look up logo in following locations:
 *  - theme/<theme-name>/asset/image/<logo-name>
 *  - static/custom/image/<logo-name>
 *  - static/image/<logo-name>
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Logo extends AbstractHtmlElement
{
    /**
     * Output logo URL
     *
     * @param  string $name    Logo filename
     *
     * @return string
     */
    public function __invoke($name = '')
    {
        $src = '';
        $name = $name ?: 'logo.png';

        $theme = Pi::service('theme')->current();
        $component = 'theme/' . $theme;
        $asset = 'image/' . $name;
        $file = Pi::service('asset')->getAssetPath($component, $asset);
        if (file_exists($file)) {
            $src = Pi::service('asset')->getAssetUrl($component, $asset);
        } else {
            $customFile = 'static/custom/image/' . $name;
            if (file_exists(Pi::path($customFile))) {
                $src = Pi::url($customFile);
            } else {
                $file = 'static/image/' . $name;
                if (file_exists(Pi::path($file))) {
                    $src = Pi::url($file);
                }
            }
        }

        return $src;
    }
}