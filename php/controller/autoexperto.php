<?php 

// get Data from db

$datos = new Dato();

$position = 0;
$items_per_page = 4;

$media = $datos->fetchByPaginator($position,$items_per_page);

$cantidad = $datos->getCount();

//break total records into pages
$pages = ceil($cantidad[0]['cantidad']/$items_per_page);

$pagination = "";

if ( $pages > 1 )
{ 
    $pagination .= '<ul class="paginate">';
    for($i = 1; $i<=$pages; $i++)
    {
        $pagination .= '<li><a href="#" class="paginate_click" id="'.$i.'-page">'.$i.'</a></li>';
    }
    $pagination .= '</ul>';
}

?>