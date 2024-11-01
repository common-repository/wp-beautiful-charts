<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>



<?php







	$height_legend = 40;



	$graph_height = $chart->height-$height_legend;







	$color_axis = $chart->text_color;



	$color_axis_y_values = $chart->text_color;



	$color_axis_x_values = $chart->text_color;



	$color_column = $chart->data[0]->color;



	$color_column_hover = "#dddddd";







	$axis_y_text_size = 16;



	$axis_x_text_size = 18;







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



	$max_value_y_axis = round($max_value_y_axis, -$round_nb);







	$text_y_axis_offset = 15;







	$height_percent_axis_y = 100-$margin_top;







	$col_anim_duration = '0.4s';







?>



<script>







	function colorHover(evt) {



	    evt.target.setAttributeNS(null,"fill","<?php echo esc_attr($color_column_hover) ?>");



	}	 







	function colorNormal(evt) {



	    evt.target.setAttributeNS(null,"fill", evt.target.getAttributeNS(null,"normal_color"));



	}







</script>


		<svg style="width: <?php echo (int)$chart->width ?>px; height: <?php echo (int)$chart->height ?>px">


			<svg width="100%" height="<?php echo (int)$graph_height ?>px">


				<g transform="scale(1,-1) translate(0,-<?php echo (int)($graph_height+50) ?>)">

				<?php

					$i = 0;

					$width_col = (100-$margin_left-($margin_cols*sizeof($data)))/sizeof($data);


					foreach($chart->data as $key => $value)
					{

						$j = 0;

						foreach($value->values as $bar) {

							$height_rect = ($bar/$max_value_y_axis*$height_percent_axis_y);


							echo '<rect title="'.(int)$bar.' '.esc_html($atts['unit']).'" width="'.($width_col/sizeof($chart->data[0]->values)).'%" height="'.(int)$height_rect.'%" y="50" x="'.(int)($margin_left+($i*$width_col+$i*$margin_cols)+$j*$width_col/sizeof($chart->data[0]->values)).'%" fill="'.esc_attr($value->color).'" normal_color="'.esc_attr($value->color).'" onmouseover="colorHover(evt)" onmouseout="colorNormal(evt)">';

							if($i > 0)

								echo '<animate attributeName="height" attributeType="XML" id="rect'.(int)$i.'"	fill="freeze" from="0" to="'.(int)$height_rect.'%"	begin="rect'.(int)($i-1).'.end'.'" dur="'.(int)$col_anim_duration.'"/>';



							echo '</rect>';



							$j++;							



						}



						$i++;						



					}







				?>				



				</g>



			</svg>



			<svg width="100%" height="<?php echo (int)($chart->height+$margin_top) ?>px">



				<?php







					$height_percent_axis_y = 100-$margin_top;



					$real_graph_height = $graph_height*(100-$margin_top)/100;



					$margin_top_height = $graph_height*$margin_top/100;







					//axes x/y



					echo '<line x1="0%" y1="'.(int)$graph_height.'" x2="100%" y2="'.(int)$graph_height.'" stroke="'.esc_attr($color_axis).'" stroke-width="1"/>';



					echo '<line x1="'.(int)$margin_axis_x.'%" y1="0%" x2="'.(int)$margin_axis_x.'%" y2="100%" stroke="'.esc_attr($color_axis).'" stroke-width="1"/>';







					//axe des y



					for($i = 0; $i < $nb_level_y_axis; $i++)



					{	



						$y = ($margin_top_height+($i*$height_percent_axis_y/$nb_level_y_axis)*$real_graph_height/$height_percent_axis_y);	



						$value = ($max_value_y_axis-($i*$max_value_y_axis/$nb_level_y_axis));



						echo '<text x="'.(float)((6-strlen($value))/6*50).'" y="'.(float)($y+5).'px" font-size="'.(int)$chart->text_size.'" fill="'.esc_attr($color_axis_y_values).'">'.esc_html($value).'</text>';



						echo '<line x1="'.(int)($margin_axis_x-1).'%" y1="'.(float)$y.'" x2="'.(int)($margin_axis_x+1).'%" y2="'.(float)$y.'" stroke="'.esc_attr($color_axis).'" stroke-width="1"/>';



					}







					//axe des x



					$i = 0;



					foreach($chart->data as $key => $value)



					{



						$diff_width = $width_col-100*((strlen($value->name))*($axis_x_text_size/1.5))/$chart->width; //différence de taille entre 1 colonne et le texte



						$x = ($margin_left+($i*$width_col+$i*$margin_cols)) + $diff_width/2;



						echo '<text x="'.(int)$x.'%" y="'.(int)($chart->height-15).'" font-size="'.(int)$chart->text_size.'" fill="'.esc_attr($color_axis_x_values).'">'.esc_html($value->name).'</text>';



						$i++;



					}



				?>



			</svg>



		</svg>



