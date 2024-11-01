<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>



<script>







	var pieData<?php echo (int)$chart->id ?> = [



	<?php







		foreach($chart->data as $data)



		{



			echo '{



					value: '.floatval($data->values[0]).',



					color:"'.esc_html($data->color).'",



					highlight: "#DDDDDD",



					label: "'.esc_html(addslashes($data->name)).'"



				},';



		}



	?>







	];







	/*window.onload = function(){*/

	jQuery(document).ready(function(){



		var ctx<?php echo (int)$chart->id ?> = document.getElementById("chart-area-<?php echo (int)$chart->id ?>").getContext("2d");



		window.myPie<?php echo (int)$chart->id ?> = new Chart(ctx<?php echo (int)$chart->id ?>).Pie(pieData<?php echo (int)$chart->id ?>);



	//};

	});











</script>







<canvas id="chart-area-<?php echo (int)$chart->id ?>" width="<?php echo (int)$chart->width ?>" height="<?php echo (int)$chart->height ?>"></canvas>



