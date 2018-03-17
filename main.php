<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']; ?>" lang="<?php echo $conf['lang']; ?>" dir="<?php echo $lang['direction']; ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo sprintf('%s &ndash; %s', ucfirst(tpl_pagetitle(null, true)), hsc($conf['title'])); ?></title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=El+Messiri">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <?php tpl_metaheaders() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <?php echo tpl_favicon(array('favicon')) ?>

    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="dokuwiki__top" class="<?php echo tpl_classes(); ?>">
        <!-- NAV -->
        <nav class="navbar navbar-light navbar-expand-md shadow-2dp">
            <div class="container">
                <a class="navbar-brand" href="/"><?php echo hsc($conf['title']); ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navbar-main" class="collapse navbar-collapse">
                    <div class="ml-auto">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="wiki-tools" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Wiki Tools</a>
                                <div class="dropdown-menu" aria-labelledby="wiki-tools">
                                    <div class="dropdown-item">
                                        <ul class="list-unstyled">
                                            <?php
                                                tpl_toolsevent('pagetools', array(
                                                    'edit'      => tpl_action('edit', 1, 'li', 1, '<span class="fas fa-edit"></span>'),
                                                    'revert'    => tpl_action('revert', 1, 'li', 1, '<span class="fas fa-undo"></span>'),
                                                    'revisions' => tpl_action('revisions', 1, 'li', 1, '<span class="fas fa-archive"></span>'),
                                                    'backlink'  => tpl_action('backlink', 1, 'li', 1, '<span class="fas fa-link"></span>'),
                                                    'subscribe' => tpl_action('subscribe', 1, 'li', 1, '<span class="fas fa-bell"></span>'),
                                                    'recent'    => tpl_action('recent', 1, 'li', 1, '<span class="fas fa-calendar"></span>'),
                                                    'media'     => tpl_action('media', 1, 'li', 1, '<span class="fas fa-images"></span>'),
                                                    'index'     => tpl_action('index', 1, 'li', 1, '<span class="fas fa-list"></span>')
                                                ));
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="user-tools" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</a>
                                <div class="dropdown-menu" aria-labelledby="user-tools">
                                    <div class="dropdown-item">
                                        <ul class="list-unstyled">
                                            <?php
                                                if(!empty($_SERVER['REMOTE_USER'])) {
                                                    tpl_userinfo(); /* Logged in as... */
                                                    echo '<li class="divider"></li>';
                                                    tpl_toolsevent('usertools', array(
                                                        tpl_action('admin', 1, 'li', 1, '<span class="fas fa-cogs"></span>'),
                                                        tpl_action('profile', 1, 'li', 1, '<span class="fas fa-user"></span>'),
                                                        tpl_action('login', 1, 'li', 1, '<span class="fas fa-sign-out-alt"></span>')
                                                    ));
                                                } else {
                                                    tpl_toolsevent('usertools', array(
                                                        tpl_action('login', 1, 'li', 1, '<span class="fas fa-sign-in-alt"></span>'),
                                                        tpl_action('register', 1, 'li', 1, '<span class="fas fa-user-plus"></span>')
                                                    ));
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <?php tpl_searchform(); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- BREADCRUMB BAR -->
        <div id="breadcrumb" class="separator-bar shadow-1dp">
            <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
                <div class="container">
                    <?php if(hsc($conf['youarehere'])): ?>
                        <div class="youarehere"><?php tpl_youarehere() ?></div>
                    <?php endif ?>
                    <?php if(hsc($conf['breadcrumbs'])): ?>
                        <div class="trace"><?php tpl_breadcrumbs() ?></div>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>

        <?php
            // render the content into buffer for later use
            ob_start();
            tpl_content(false);
            $buffer = ob_get_clean();
        ?>

        <!-- CONTENT -->
        <main role="main" class="shadow-1dp">
            <div id="content" class="container py-3">
                <div class="row">
                    <?php if($conf['maxtoclevel'] > 0 && strlen(tpl_toc(true)) > 0): ?>
                        <div class="col-md-3 pt-1">
                            <?php echo tpl_toc(); ?>
                        </div>
                        <div class="col-md-9">
                            <?php echo $buffer; ?>
                        </div>
                    <?php else: ?>
                        <div class="col-md-12">
                            <?php echo $buffer; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <!-- PAGE INFO -->
        <div id="page_info" class="separator-bar shadow-2dp">
            <div class="container">
                <?php tpl_pageinfo(); ?>
            </div>
        </div>

        <!-- FOOTER -->
        <footer id="dokuwiki__footer" class="container pt-3">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php tpl_license(''); ?>
                </div>
            </div>
        </footer>

        <?php if(tpl_getConf('showFooterButtons')): ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php
                        tpl_license('button', true, false, false); // license button, no wrapper
                        $target = ($conf['target']['extern']) ? 'target="' . $conf['target']['extern'] . '"' : '';
                    ?>
                    <a href="https://www.flawedspirit.com/donate" title="Donate to the author" <?php echo $target?>><img src="<?php echo tpl_basedir(); ?>images/button_flawedspirit.png" width="80" height="15" alt="Donate to the author" /></a>
                    <a href="https://www.dokuwiki.org/donate" title="Donate to the Dokuwiki team" <?php echo $target?>><img src="<?php echo tpl_basedir(); ?>images/button_donate.gif" width="80" height="15" alt="Donate to the Dokuwiki team" /></a>
                    <a href="https://secure.php.net" title="Powered by PHP" <?php echo $target?>><img src="<?php echo tpl_basedir(); ?>images/button_php.gif" width="80" height="15" alt="Powered by PHP" /></a>
                    <a href="https://dokuwiki.org/" title="Driven by DokuWiki" <?php echo $target ?>><img src="<?php echo tpl_basedir(); ?>images/button_dw.png" width="80" height="15" alt="Driven by DokuWiki" /></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php tpl_indexerWebBug(); ?>
</body>
</html>