<?php
/**
 * Template Functions
 *
 * This file provides template specific custom functions that are
 * not provided by the DokuWiki core.
 * It is common practice to start each function with an underscore
 * to make sure it won't interfere with future core functions.
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

use dokuwiki\Extension\Event;

/**
 * Modified version of tpl_breadcrumbs() that adds Bulma classes
 */
function _tpl_breadcrumbs() {
    $out='';
    $out .= '<nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">';
    $out .= '<ul>';
    $out .= '<li class="is-active"><a>Trace</a></li>';
    $crumbs = breadcrumbs(); //setup crumb trace

    //render crumbs, highlight the last one
    $last = count($crumbs);
    $i    = 0;
    foreach($crumbs as $id => $name) {
        $i++;
        if($i == $last) {
            $out .= '<li class="is-active">';
        } else {
            $out .= '<li>';
        }
        $out .= tpl_link(wl($id), hsc($name), 'aria-current="page" title="'.$id.'"', true);
        $out .= '</li>';
    }
    $out .= '</ul>';
    $out .= '</nav>';
    echo $out;
}

/**
 * Modified version of tpl_content() that adds Bulma classes to basic
 * elements
 */
function _tpl_content($prependTOC = false) {
    global $ACT;
    global $INFO;
    $INFO['prependTOC'] = $prependTOC;

    ob_start();
    Event::createAndTrigger('TPL_ACT_RENDER', $ACT, 'tpl_content_core');
    $html_output = ob_get_clean();
    $libxml_errors = libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    //$dom->loadHTML($html_output);
    $dom->loadHTML(mb_convert_encoding($html_output, 'HTML-ENTITIES', 'UTF-8'));
    libxml_clear_errors();
    libxml_use_internal_errors($libxml_errors);
    // add button class to buttons, reset, and submit
    foreach ($dom->getElementsByTagName('button') as $ele) {
        $ele->setAttribute('class', 'button is-small');
    }
    foreach ($dom->getElementsByTagName('reset') as $ele) {
        $ele->setAttribute('class', 'button is-small');
    }
    foreach ($dom->getElementsByTagName('submit') as $ele) {
        $ele->setAttribute('class', 'button is-small');
    }
    // add select class to selects
    foreach ($dom->getElementsByTagName('select') as $ele) {
        // skip a select on the acl page because it looks weird
        $name = $ele->getAttribute('name');
        if ($name == 'acl_t') continue;
        $ele->parentNode->setAttribute('class', 'select is-small');
    }
    // add checkbox, radio, and input classes
    foreach ($dom->getElementsByTagName('input') as $ele) {
        $type = $ele->getAttribute('type');
        switch ($type) {
            case 'checkbox':
                $label = $ele->parentNode;
                $label->setAttribute('class', $label->getAttribute('class') . ' checkbox');
                break;
            case 'radio':
                $label = $ele->parentNode;
                $label->setAttribute('class', $label->getAttribute('class') . ' radio');
                break;
            default:
                $ele->setAttribute('class', $ele->getAttribute('class') . ' input is-small');
                break;
        }
        //if ($type != 'checkbox') {
        //    $ele->setAttribute('class', $ele->getAttribute('class') . ' input is-small');
        //} else {
        //    $label = $ele->parentNode;
        //    $label->setAttribute('class', $label->getAttribute('class') . ' checkbox');
        //}
    }
    // add proper classes to odered lists
    foreach ($dom->getElementsByTagName('ol') as $ele) {
        foreach ($ele->childNodes as $i) {
            // skip non DOMNode elements
            if ($i->nodeType != 1) continue;
            // skip non li elements
            if ($i->nodeName != 'li') continue;
            // apply proper class to ordered list based on what level# the
            // first li element is
            switch (substr($i->getAttribute('class'), 5, 1)) {
                case '1':
                    break;
                case '2':
                    $ele->setAttribute('class', 'is-lower-alpha');
                    break;
                case '3':
                    $ele->setAttribute('class', 'is-upper-roman');
                    break;
                case '4':
                    $ele->setAttribute('class', 'is-upper-alpha');
                    break;
                default:
                    $ele->setAttribute('class', 'is-lower-roman');
                    break;
            }
            // break because we only need to evaluate the very first one
            // to get the level
            break;
        }
    }
    // add table class to tables
    foreach ($dom->getElementsByTagName('table') as $ele) {
        $ele->setAttribute('class', 'table inline is-bordered is-striped is-narrow is-hoverable');
        // get parent div and add table-container class
        $div = $ele->parentNode;
        $classes = $div->getAttribute('class');
        $div->setAttribute('class', $classes . ' table-container');
    }
    // fix centered table data
    foreach ($dom->getElementsByTagName('td') as $ele) {
        $classes = $ele->getAttribute('class');
        $classes = str_replace('centeralign', 'has-text-centered', $classes);
        $classes = str_replace('leftalign', 'has-text-left', $classes);
        $classes = str_replace('rightalign', 'has-text-right', $classes);
        $ele->setAttribute('class', $classes);
    }
    // fix centered table data and make table headers nicer
    foreach ($dom->getElementsByTagName('th') as $ele) {
        $classes = $ele->getAttribute('class');
        $classes = $classes . ' has-background-white-ter has-text-weight-bold';
        $classes = str_replace('centeralign', 'has-text-centered', $classes);
        $classes = str_replace('leftalign', 'has-text-left', $classes);
        $classes = str_replace('rightalign', 'has-text-right', $classes);
        $ele->setAttribute('class', $classes);
    }
    foreach ($dom->getElementsByTagName('thead') as $ele) {
        $ele->setAttribute('class', 'has-background-white-ter has-text-weight-bold');
    }
    // add textarea class to textareas
    foreach ($dom->getElementsByTagName('textarea') as $ele) {
        $ele->setAttribute('class', $ele->getAttribute('class') .' textarea');
    }
    $html_output = $dom->saveHTML($dom->documentElement);
    Event::createAndTrigger('TPL_CONTENT_DISPLAY', $html_output, 'ptln');

    return !empty($html_output);
}

/**
 * Modified version of tpl_page_tools() that adds Bulma classes and custom formatting
 */
function _tpl_page_tools() {
    $items = (new \dokuwiki\Menu\PageMenu())->getItems();
    $out = '';
    $out .= '<ul class="page-tools">';
    foreach ($items as $item) {
        $out .= '<li> ';
        $out .= '<a ';
        $out .= buildAttributes($item->getLinkAttributes('button is-light is-small '));
        $out .= '>';
        //$out .= inlineSVG($item->getSvg());
        $out .= $item->getLabel();
        $out .= '</a>';
        $out .= '</li>';
    }
    $out .= '</ul>';
    echo $out;
}

/**
 * Custom search form that excludes the button.
 */
function _tpl_searchform($ajax = true, $autocomplete = true) {
    global $lang;
    global $ACT;
    global $QUERY;
    global $ID;

    // don't print the search form if search action has been disabled
    if(!actionOK('search')) return false;

    $searchForm = new dokuwiki\Form\Form([
        'action' => wl(),
        'method' => 'get',
        'role' => 'search',
        'class' => 'field has-addons is-horizontal pb-2 search',
        'id' => 'dokuwiki__search',
    ], true);
    $searchForm->setHiddenField('do', 'search');
    $searchForm->setHiddenField('id', $ID);
    $searchForm->addTextInput('q')
        ->addClass('edit input is-small')
        ->attrs([
            'title' => '[F]',
            'accesskey' => 'f',
            'placeholder' => $lang['btn_search'],
            'autocomplete' => $autocomplete ? 'on' : 'off',
        ])
        ->id('qsearch__in')
        ->val($ACT === 'search' ? $QUERY : '')
        ->useInput(false)
    ;
    if ($ajax) {
        $searchForm->addTagOpen('div')->id('qsearch__out')->addClass('ajax_qsearch JSpopup');
        $searchForm->addTagClose('div');
    }
    Event::createAndTrigger('FORM_QUICKSEARCH_OUTPUT', $searchForm);

    echo $searchForm->toHTML();

    return true;
}

/**
 * Modified version of tpl_sidebar() that adds Bulma classes and custom formatting
 */
function _tpl_sidebar() {
    $sb = strval(tpl_include_page($conf['sidebar'], false, true));
    $dom = new DOMDocument();
    //$dom->loadHTML($sb);
    $dom->loadHTML(mb_convert_encoding($sb, 'HTML-ENTITIES', 'UTF-8'));
    $uls = $dom->getElementsByTagName('ul');
    foreach ($uls as $ul) {
        $ul->setAttribute('class', 'menu-list');
    }
    echo $dom->saveHTML($dom->documentElement);
}

/**
 * Modified version of tpl_toc() that adds Bulma classes and custom formatting
 */
function _tpl_toc() {
    $t = strval(tpl_toc(true));
    $dom = new DOMDocument();
    //$dom->loadHTML($t);
    $dom->loadHTML(mb_convert_encoding($t, 'HTML-ENTITIES', 'UTF-8'));
    $dw__toc = $dom->getElementById('dw__toc');
    $dw__toc->setAttribute('id', 'bulma-toc');
    $dw__toc->setAttribute('class', 'is-size-7');
    $h3s = $dom->getElementsByTagName('h3');
    foreach ($h3s as $h3) {
        $h3->setAttribute('class', 'has-text-grey-light');
        $h3->nodeValue = 'On this page';
    }
    $lis = $dom->getElementsByTagName('li');
    foreach ($lis as $li) {
        if ($li->getAttribute('class') == 'level2') {
            $li->setAttribute('class', 'level2 pl-2');
        }
        if ($li->getAttribute('class') == 'level3') {
            $li->setAttribute('class', 'level2 pl-4');
        }
    }
    $as = $dom->getElementsByTagName('a');
    foreach ($as as $a) {
        $a->setAttribute('class', 'button is-light is-small');
    }
    echo $dom->saveHTML($dom->documentElement);
}

/**
 * Modified version of tpl_tools_menu() that adds Bulma classes and custom formatting
 */
function _tpl_tools_menu() {
    $out = '';
    if (!empty($_SERVER['REMOTE_USER'])) {
        $out .= '<div class="navbar-item has-dropdown is-hoverable">';
        $out .= '<a class="navbar-link">Tools</a>';
        $out .= '<div class="navbar-dropdown">';
        try{
            $items = (new \dokuwiki\Menu\SiteMenu())->getItems();
            foreach ($items as $item) {
                $out .= $item->asHtmlLink('navbar-item ', false);
            }
        } catch(\RuntimeException $ignored) {
            // item not available
        }
        $out .= '</div>';
        $out .= '</div>';
    }
    echo $out;
}

/**
 * Modified version of tpl_user_menu() that adds Bulma classes and custom formatting
 */
function _tpl_user_menu() {
    $out = '';
    if (!empty($_SERVER['REMOTE_USER'])) {
        $out .= '<div class="navbar-item has-dropdown is-hoverable">';
        $out .= '<a class="navbar-link">Account</a>';
        $out .= '<div class="navbar-dropdown">';
        try{
            $out .= (new \dokuwiki\Menu\Item\Admin())->asHtmlLink('navbar-item ', false);
        } catch(\RuntimeException $ignored) {
            // item not available
        }
        try{
            $out .= (new \dokuwiki\Menu\Item\Register())->asHtmlLink('navbar-item ', false);
        } catch(\RuntimeException $ignored) {
            // item not available
        }
        $out .= '<hr class="navbar-divider">';
        $out .= (new \dokuwiki\Menu\Item\Login())->asHtmlLink('navbar-item ', false);
        $out .= '</div>';
        $out .= '</div>';
    }
    else {
        $out .= (new \dokuwiki\Menu\Item\Login())->asHtmlLink('navbar-item ', false);
    }
    echo $out;
}
