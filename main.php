<?php
/**
 * DokuWiki Bulma Template
 *
 * @link     http://dokuwiki.org/template:bulma
 * @author   Gilberto Miralla-Flores <miralgj@gmail.com>
 * @license  MIT (https://opensource.org/license/MIT)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */

$_toc = tpl_toc(true);
$showToc = !empty($_toc) ? true : false;
$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
$sidebarElement = tpl_getConf('sidebarIsNav') ? 'nav' : 'aside';
?><!DOCTYPE html>
<html class="has-background-light" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
<?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
         should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>
<body>
    <div id="dokuwiki__top" class="<?php echo tpl_classes(); ?> <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
    <!-- NAVBAR -->
    <nav class="navbar has-shadow is-link mb-4" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <!-- LOGO -->
                <?php
                    $logo = tpl_getMediaFile(array('images/logo.svg'), true);
                    tpl_link(
                        wl(),
                        '<img src="'. $logo .'"  alt="" />',
                        'class="navbar-item brand-text" accesskey="h" title="[H]"'
                    );
                ?>
                <!-- TITLE -->
                <div class="navbar-item brand-text">
                    <?php echo $conf['title']; ?>
                </div><!-- /title -->
            </div><!-- /navbar-brand -->
            <div class="navbar-end">
                 <?php _tpl_tools_menu(); ?>
                 <?php _tpl_user_menu(); ?>
            </div><!-- /navbar-end --> 
    </nav><!-- /navbar -->

    <div class="container is-fluid">

        <div class="columns">

            <!-- SIDEBAR -->
            <div id="bulma-sidebar" class="sidebar column is-2">
                <?php if($showSidebar): ?>
                    <nav class="content is-small">
                        <?php tpl_include_page($conf['sidebar'], true, true) ?>
                    </nav>
                <?php endif; ?>
            </div><!-- /bulma-sidebar -->

            <!-- CONTENT COLUMN -->
            <div class="bulma-content column has-background-white is-8">

                <!-- BREADCRUMBS -->
                <?php
                if($conf['breadcrumbs']) {
                    _tpl_breadcrumbs();
                }
                if($conf['youarehere']){ ?>
                    <div class="breadcrumbs"><?php tpl_youarehere() ?></div>
                <?php } ?>

                <!-- CONTENT -->
                <main id="dokuwiki__content" class="content pl-4 pr-4">
                    <article><?php _tpl_content(false) ?></article>
                </main><!-- /content -->
            </div><!-- /content column -->

            <div class="bulma-toc-pagetools column is-2">
                <div class="bulma-search">
                    <?php _tpl_searchform() ?>
                </div>
                <?php if ($showToc) _tpl_toc(); ?>
                <div id="bulma-pagetools" style="position: sticky; top: 0px">
                    <h3 class="has-text-grey-light is-size-7">Page tools</h3>
                    <?php _tpl_page_tools(); ?>
                </div><!-- /bulma-pagetools -->
            </div><!-- /bulma-toc -->

        </div><!-- /columns -->
    </div><!-- /container -->

    </div><!-- /dokuwiki__top -->
    
    <footer>
        <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    </footer>
</body>
</html>
