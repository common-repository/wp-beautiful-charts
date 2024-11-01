<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php



	$height_legend = 40;

	$graph_height = $chart->height-$height_legend;



	$color_axis = $chart->text_color;

	$color_axis_y_values = $chart->text_color;

	$color_axis_x_values = $chart->text_color;

	$color_circles_hover = "#dddddd";

	$color_lines = !empty($atts['line_color']) ? $atts['line_color'] : '#1111ff';

	$color_circles_hover = "#dddddd";



	$margin_top = 10;	

	$margin_axis_x = 15;

	$margin_cols = 5;

	$margin_left = $margin_axis_x+$margin_cols;



	$nb_level_y_axis = 10;

	$max_value_y_axis = 0;



	foreach($chart->data as $value)

	{

		if($value->values[0] > $max_value_y_axis)

			$max_value_y_axis = $value->values[0];

	}



	//on arrondi la valeur max de l'axe de y

	$round_nb = strlen((string)round($max_value_y_axis))-2;	

	$max_value_y_axis = round($max_value_y_axis, -$round_nb, PHP_ROUND_HALF_EVEN);



	$text_y_axis_offset = 15;



	$height_percent_axis_y = 100-$margin_top;



	$currency = "&euro;";



	$col_anim_duration = '0.2s';



?>

<script>



	function colorHover(evt) {

	    evt.target.setAttributeNS(null,"fill","<?php echo esc_attr($color_circles_hover) ?>");

	}	 



	function colorNormal(evt) {

	    evt.target.setAttributeNS(null,"fill", evt.target.getAttributeNS(null,"normal_color"));

	}



</script>



		<svg style="width: <?php echo (int)$chart->width ?>px; height: <?php echo (int)$chart->height ?>px">

			<svg width="100%" height="<?php echo (int)($chart->height-$height_legend) ?>px">				

				<?php

					$i = 0;

					$graph_margin_bottom = $chart->height/(100-$height_percent_axis_y);

					$graph_margin_left = $chart->width/$margin_axis_x;

					$width_graph = $chart->width*(100-$margin_axis_x)/100;

					$cols_offest_x = $width_graph/sizeof($chart->data);

					$real_graph_height = $graph_height*(100-$margin_top)/100;

					$margin_top_height = $graph_height*$margin_top/100;

					$x = ((100-$margin_left)/sizeof($chart->data[0]->values)+1);



					$path = '<path stroke="'.$color_lines.'" fill="none" stroke-width="2" d="';

					$circles = '';



					foreach($chart->data as $key => $value)

					{	

						$j = 0;

						foreach($value->values as $line) {

							$x = ($graph_margin_left+$cols_offest_x*($i+1));

							$y = ($margin_top_height+$real_graph_height-($line*$real_graph_height/$max_value_y_axis));

							

							if($i == 0)

								$path .= 'M '.$x.','.$y;

							else

								$path .= ' L '.$x.','.$y;



							$circles .= '<circle cx="'.$x.'" cy="'.$y.'" r="7" fill="'.$value->color.'" title="'.$line.' '.$atts['unit'].'" normal_color="'.$value->color.'" onmouseover="colorHover(evt)" onmouseout="colorNormal(evt)" />';

							

							$j++;

						}						



						$i++;

					}



					$path .= '"/>';



					echo $path;

					echo $circles;



				?>				

			</svg>

			<svg width="100%" height="<?php echo (int)($chart->height+$margin_top) ?>px">

				<?php



					$height_percent_axis_y = 100-$margin_top;



					//axes x/y

					echo '<line x1="0%" y1="'.(int)$graph_height.'" x2="100%" y2="'.(int)$graph_height.'" stroke="'.esc_attr($color_axis).'" stroke-width="1"/>';

					echo '<line x1="'.(int)$margin_axis_x.'%" y1="0%" x2="'.(int)$margin_axis_x.'%" y2="100%" stroke="'.esc_attr($color_axis).'" stroke-width="1"/>';



					//axe des y

					for($i = 0; $i < $nb_level_y_axis; $i++)

					{	

						$y = ($margin_top_height+($i*$height_percent_axis_y/$nb_level_y_axis)*$real_graph_height/$height_percent_axis_y);	

						$value = ($max_value_y_axis-($i*$max_value_y_axis/$nb_level_y_axis));

						echo '<text x="'.(float)((6-strlen($value))/6*50).'" y="'.(int)($y+5).'px" font-size="'.(int)$chart->text_size.'" fill="'.esc_attr($color_axis_y_values).'">'.esc_html($value).'</text>';

						echo '<line x1="'.(int)($margin_axis_x-1).'%" y1="'.(int)$y.'" x2="'.($margin_axis_x+1).'%" y2="'.(int)$y.'" stroke="'.esc_attr($color_axis).'" stroke-width="1"/>';

					}



					//axe des x

					$i = 0;

					foreach($chart->data as $key => $value)

					{

						//$x = ($margin_left+($i+$i*$margin_cols));

						$x = ($graph_margin_left+$cols_offest_x*($i+1)) - strlen($value->name)/2*$chart->text_size/1.9;

						echo '<text x="'.(int)$x.'" y="'.(int)($chart->height-15).'" font-size="'.(int)$chart->text_size.'" fill="'.esc_attr($color_axis_x_values).'">'.esc_html($value->name).'</text>';

						$i++;

					}

				?>

			</svg>

		</svg>