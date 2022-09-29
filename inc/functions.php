function bulma_breadcrumbs() {
    $out='';
    $out .= '<nav class="breadcrumb" aria-label="breadcrumbs">';
    $out .= '<ul>';
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
    print $out;
}
