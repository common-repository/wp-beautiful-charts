<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>



<script>







	jQuery(document).ready(function(){



		jQuery('.form_wpbc .add_column').click(function(){



			var nb_cols = jQuery('.form_wpbc table tr:first-child td ').length;



			jQuery('.form_wpbc table tr:first-child').append( '<td><input type="text" name="name[]" /> <br /><input type="color" name="color[]" /> <a href="#" class="remove_col"><img src="<?php echo esc_url(plugins_url( 'wp-beautiful-charts/images/remove.png')) ?>" alt="x" /></a></td>' );			



			jQuery('.form_wpbc table tr:not(:first-child)').append( '<td><input type="text" name="data['+(nb_cols-1)+'][]" /></td>' );



			jQuery('.form_wpbc tr td:last-child .remove_col').click(function(){



				var td = jQuery(this).parent();

				var i = jQuery('.form_wpbc tr:first-child td').index(td);

				alert(i);



				jQuery('.form_wpbc tr').each(function(){

					jQuery(this).find('td').eq(i).remove();

				}) 



				return false;



			});



			return false;



		});





		jQuery('.form_wpbc .add_line').click(function(){





			var nb_cols = jQuery('.form_wpbc table tr:first-child td').length;



			var nb_lines = jQuery('.form_wpbc table tr').length;



			jQuery('.form_wpbc table').append( '<tr>' );



			var tds = '<td>Line '+nb_lines+'</td>';



			for(var i=0; i<(nb_cols-1); i++)



				tds += '<td><input type="text" name="data['+i+'][]" /></td>';



			jQuery('.form_wpbc table tr:last-child').append(tds);



			return false;



		});



		jQuery('.form_wpbc .remove_col').click(function(){



			var td = jQuery(this).parent();

			var i = jQuery('.form_wpbc tr:first-child td').index(td);

			alert(i);



			jQuery('.form_wpbc tr').each(function(){

				jQuery(this).find('td').eq(i).remove();

			}) 



			return false;



		});



	});



</script>



<h2>Manage chart "<?php echo esc_html($chart->name) ?>"</h2>



<form action="" method="post" class="form_wpbc">



	<input type="hidden" name="id" value="<?php echo esc_attr($chart->id) ?>" />



	<a href="" class="add_column button-secondary">Add a column</a> <!--- <a href="" class="add_line">Add a line</a>-->



	<table>



		<tr>



			<td>Columns</td>



<?php







	if(sizeof($chart->data) > 0)



	{



		foreach( $chart->data as $data )



		{



			echo '<td><input type="text" name="name[]" value="'.esc_attr($data->name).'" /><br />



			<input type="color" name="color[]" value="'.esc_attr($data->color).'" /> <a href="#" class="remove_col"><img src="'.esc_url(plugins_url( 'wp-beautiful-charts/images/remove.png')).'" alt="x" /></a></td>';



		}



	}



	else



		echo '<td><input type="text" name="name[]" />



		<input type="color" name="color[]" value="'.esc_attr($data->color).'" /></td>';	







?>



		</tr>



<?php







	if(sizeof($chart->data) > 0)



	{



		$i = 0;



		$nb_lines = sizeof($chart->data[0]->values);



		for($i=0; $i<$nb_lines; $i++)



		{



			echo '<tr><td>Values</td>';



			foreach( $chart->data as $key => $data )



			{				



				echo '<td><input type="text" name="data['.(int)$key.'][]" value="'.esc_attr($data->values[$i]).'" /></td>';



			}



			echo '</tr>';



		}



	}



	else



	{



		echo '<td>Values</td>';



		echo '<td><input type="text" name="data[0][]" /></td>';



	}	



?>

		</tr>



	</table>



	<input type="submit" value="Save data" class="button-primary" /> <a href="<?php echo esc_url(admin_url('admin.php?page=wp_beautiful_charts')); ?>">Back to charts list</a>



</form>