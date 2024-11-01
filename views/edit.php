<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>



<script>



		jQuery(document).ready(function(){



			check_gaph_type();



			jQuery('.form_wpbc select[name=type]').change(function(){



				check_gaph_type();



			});



		});





		function check_gaph_type()

		{



			var chart_type = jQuery('.form_wpbc select[name=type]').val();



			console.log( chart_type );



			if(chart_type != 'pie.php')



			{



				jQuery('.form_wpbc .options_bars_and_lines').show('fast');



			}



			else



			{



				jQuery('.form_wpbc .options_bars_and_lines').hide('fast');



			}



		}



</script>



<h2>Add/edit a chart</h2>



<form action="" method="post" class="form_wpbc">



	<input type="hidden" name="id" value="<?php echo (int)$chart->id ?>" />



	<label for="">Name : </label> <input type="text" name="name" value="<?php echo esc_attr($chart->name) ?>" /><br />



	<label for="">Width : </label> <input type="text" name="width" value="<?php echo esc_attr($chart->width) ?>" />px<br />



	<label for="">Height : </label> <input type="text" name="height" value="<?php echo esc_attr($chart->height) ?>" />px<br />



	<div class="options_bars_and_lines">



		<label for="">Legend size : </label> <input type="text" name="text_size" value="<?php echo esc_attr($chart->text_size) ?>" />px<br />



		<label for="">Legend and axes color : </label> <input type="color" name="text_color" value="<?php echo esc_attr($chart->text_color) ?>" /><br />



	</div>



	<label for="">Type : </label>	



	<select name="type">



		<option value="bars.php" <?php echo ($chart->type == 'bars.php' ? 'selected="selected"' : '') ?>>Bars chart</option>



		<option value="lines.php" <?php echo ($chart->type == 'lines.php' ? 'selected="selected"' : '') ?>>Lines chart</option>



		<option value="pie.php" <?php echo ($chart->type == 'pie.php' ? 'selected="selected"' : '') ?>>Pie chart</option>



	</select><br />



	<input type="submit" value="Save chart" class="button-primary" /> <a href="<?php echo esc_url(admin_url('admin.php?page=wp_beautiful_charts')); ?>">Back to charts list</a>



</form>