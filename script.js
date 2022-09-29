// template-related scripts go here... 

// The following code is based off a toggle menu by @Bradcomp
// source: https://gist.github.com/Bradcomp/a9ef2ef322a8e8017443b626208999c1
/*(function() {
    var burger = document.querySelector('.burger');
    var menu = document.querySelector('#'+burger.dataset.target);
    burger.addEventListener('click', function() {
        burger.classList.toggle('is-active');
        menu.classList.toggle('is-active');
    });
})();*/


var bulma = {
    init: function () {
        // TOC changes
        //var $dw__toc = jQuery('#dw__toc');
        //$dw__toc.addClass('menu');
        //$dw__toc.find('h3').addClass('menu-label');
        //$dw__toc.find('ul').addClass('menu-list');

        // Content changes
        var $dokuwiki__content = jQuery('#dokuwiki__content');
        //$bulma-content.find('submit, button, reset').addClass('button is-small');
        //$bulma-content.find('table').not('.htCore').addClass('table is-bordered is-striped is-narrow is-hoverable');
        //$bulma-content.find('table thead tr').addClass('has-background-white-ter');
        $dokuwiki__content.find('div.editbutton_table').css({'margin-top': '0'});

        // ACL changes
        //var $acl__user = jQuery('#acl__user');
        //$acl__user.find('select').addClass('input select is-inline is-small').removeClass('edit');
        //$acl__user.find('input').addClass('input is-inline is-small').removeClass('edit');

        // Config changes
        //var $config__manager = jQuery('#config__manager');
        //$config__manager.find('input, select, textarea').removeClass('edit input');
        //$config__manager.find('input')
        //    .not('[type=submit], [type=reset], [type=button], [type=hidden], [type=image], [type=checkbox], [type=radio]')
        //    .addClass('input is-small');
        //$config__manager.find('tr.default input, tr.default select, tr.default textarea, .selectiondefault')
        //    .addClass('is-info').css('background-color','inherit');
        //$config__manager.find('textarea').addClass('input');
        //$config__manager.find('select').addClass('is-small');
        //$config__manager.find('select').closest('.input').addClass('select is-small').removeClass('input');
        //$config__manager.find('div.input').removeClass('input');

        // Plugin changes
        //var $extension__manager = jQuery('#extension__manager');
        //$extension__manager.find('ul.tabs').wrap('<div class="tabs is-centered"></div>');
        //$extension__manager.find('ul.tabs').removeClass('tabs');
        //$extension__manager.find('li.active').addClass('is-active').removeClass('active');
        //$extension__manager.find('.panelHeader').addClass('box').removeClass('panelHeader');
        //$extension__manager.find('input').addClass('input is-inline is-small').removeClass('edit');

        //// User manager
        //var $user__manager = jQuery('#user__manager');
        //$user__manager.find('input.edit').addClass('input is-inline is-small').removeClass('edit');
        //$user__manager.find('input.button').addClass('user-search').removeClass('button');
    },
};

//jQuery(bulma.init);
