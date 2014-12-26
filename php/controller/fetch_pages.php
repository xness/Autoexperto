<?php 

require_once realpath(dirname(__FILE__)) . '../../autoloads.php';

$datos = new Dato();

if( $_POST['page'] )
{
	$page = $_POST['page'];
	$cur_page = $page;
	$page -= 1;
	$per_page = 2;
	$previous_btn = true;
	$next_btn = true;
	$first_btn = true;
	$last_btn = true;
	
	$start = $page * $per_page;

	$result_pag_data = $datos->fetchByPaginator($start, $per_page);
	
	$msg = "";
	
	foreach ($result_pag_data as $index => $data) {
		if ( $index % 2 == 1 )
		{
			$msg .= "<div class='thumb-block odd' data-id='".$data['id']."' data-image='".$data['image_standard']."' data-latitude='".$data['latitude']."' data-longitude='".$data['longitude']."'>
			<img src='".$data['image_thumb']."' alt='' /></div>";
		} else {
			$msg .= "<div class='thumb-block' data-id='".$data['id']."' data-image='".$data['image_standard']."' data-latitude='".$data['latitude']."' data-longitude='".$data['longitude']."'>
			<img src='".$data['image_thumb']."' alt='' /></div>";
		}
	}


	/* --------------------------------------------- */
	$row = $datos->getCount();
	$count = $row[0]['cantidad'];
	$no_of_paginations = ceil($count / $per_page);

	/* ---------------Calculo para la paginacion al avanzar un numero y mostrar los siguientes y anteriores en el loop----------------------------------- */
	if ($cur_page >= 2) {
		$start_loop = $cur_page - 1;
		if ($no_of_paginations > $cur_page + 1)
			$end_loop = $cur_page + 1;
		else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 2) {
			$start_loop = $no_of_paginations - 2;
			$end_loop = $no_of_paginations;
		} else {
			$end_loop = $no_of_paginations;
		}
	} else {
		$start_loop = 1;
		if ($no_of_paginations > 2)
			$end_loop = 2;
		else
			$end_loop = $no_of_paginations;
	}
	/* ----------------------------------------------------------------------------------------------------------- */
	$msg .= "<div class='pagination'><ul>";

	// Para habilitar primer boton
	if ($first_btn && $cur_page > 1) {
		$msg .= "<li class='active'><a href='#' data-p='1'>Primero</a></li>";
	} else if ($first_btn) {
		$msg .= "<li class='inactive'>Primero</li>";
	}

	// para habilitar boton anterior
	if ($previous_btn && $cur_page > 1) {
		$pre = $cur_page - 1;
		$msg .= "<li class='active'><a href='#' data-p='$pre'>Anterior</a></li>";
	} else if ($previous_btn) {
		$msg .= "<li class='inactive'>Anterior</li>";
	}
	for ($i = $start_loop; $i <= $end_loop; $i++) {

		if ($cur_page == $i)
			$msg .= "<li style='color:#fff;background-color:#006699;' class='active' data-p='$i'><a href='#'>{$i}</a></li>";
		else
			$msg .= "<li class='active'><a href='#' data-p='$i'>{$i}</a></li>";
	}

	// para habilitar boton siguiente
	if ($next_btn && $cur_page < $no_of_paginations) {
		$nex = $cur_page + 1;
		$msg .= "<li class='active'><a href='#' data-p='$nex'>Siguiente</a></li>";
	} else if ($next_btn) {
		$msg .= "<li class='inactive'>Siguiente</li>";
	}

	// para habilitar ultimo boton 
	if ($last_btn && $cur_page < $no_of_paginations) {
		$msg .= "<li class='active'><a href='#' data-p='$no_of_paginations'>Ultimo</a></li>";
	} else if ($last_btn) {
		$msg .= "<li class='inactive'>Ultimo</li>";
	}
	$msg = $msg . "</ul>";
	
	echo $msg;
}