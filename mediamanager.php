<?php
/**
 * DokuWiki Bulma Template Media Manager Popup
 *
 * @link     http://dokuwiki.org/template:bulma
 * @author   Gilberto Miralla-Flores <miralgj@gmail.com>
 * @license  MIT (https://opensource.org/license/MIT)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
?><!DOCTYPE html>
<html class="has-background-light" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
  lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction'] ?>" class="popup no-js">
<head>
    <meta charset="UTF-8" />
    <title>
        <?php echo hsc($lang['mediaselect'])?>
        [<?php echo strip_tags($conf['title'])?>]
    </title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders()?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body>
    <div id="media__manager" class="<?php echo tpl_classes(); ?>">
        <nav id="mediamgr__aside"><div class="pad">
            <h1><?php echo hsc($lang['mediaselect'])?></h1>

            <?php /* keep the id! additional elements are inserted via JS here */?>
            <div id="media__opts"></div>

            <?php tpl_mediaTree() ?>
        </div></nav>

        <main id="mediamgr__content"><div class="pad">
            <?php tpl_mediaContent() ?>
        </div></main>
    </div>
</body>
</html>
