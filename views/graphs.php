<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>



<script>







	jQuery(document).ready(function(){







		jQuery( '.show_help_wpbc' ).click(function(){







			jQuery( '.help_wpbc' ).toggle('fast');







	    });







	});







</script>



<h2>All charts</h2>







<a href="<?php echo esc_url(admin_url('admin.php?page=wp_beautiful_charts&task=new')) ?>">Add a new chart</a> - <img src="<?php echo esc_url(plugins_url( 'wp-beautiful-charts/images/help.png' )) ?>" class="show_help_wpbc" />



<div class="help_wpbc">You can add these parameters to your shortcodes : <br />



		<ul>



			<li><b>show_title</b>: if true show the title of chart</li>



			<li><b>unit</b>: unit to display after values. Example: € (only for lines and bars charts)</li>



			<li><b>line_color</b>: choose color of lines (only for lines charts)</li>



		</ul>



		Example: [wp-beautiful-chart id='1' line_color='#FC0000' show_title=true unit='€']</div></a><br />



<?php







	if(sizeof($charts) > 0)



	{







		foreach($charts as $chart)



		{



			echo '<div class="beautiful_chart"><h3>'.esc_html($chart->name).'</h3>



			<a href="'.esc_url(admin_url('admin.php?page=wp_beautiful_charts&task=manage&id='.(int)$chart->id)).'" title="Manage chart"><img src="'.esc_url(plugins_url( 'wp-beautiful-charts/images/chart.png')).'" /></a>



			<a href="'.esc_url(admin_url('admin.php?page=wp_beautiful_charts&task=edit&id='.(int)$chart->id)).'" title="Edit chart"><img src="'.esc_url(plugins_url( 'wp-beautiful-charts/images/edit.png')).'" /></a>



			<a href="'.esc_url(admin_url('admin.php?page=wp_beautiful_charts&task=remove&id='.(int)$chart->id)).'" title="Remove chart"><img src="'.esc_url(plugins_url( 'wp-beautiful-charts/images/remove.png')).'" /></a>



			<br />



			<b>Shortcode : </b>



			<input type="text" value="[wp-beautiful-chart id='.(int)$chart->id.']" readonly onClick="this.select();" />



			</div>';



		}



	}



	else



		echo 'No chart created yet !';







?>



<h3>Like InfoD74 to check new plugins: <a href="https://www.facebook.com/infod74/" target="_blank"><img src="<?php echo esc_url(plugins_url( 'images/fb.png', dirname(__FILE__))) ?>" alt="" /></a></h3>