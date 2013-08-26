<?php

add_action( 'init', 'register_portfolio' );
add_action( 'init', 'create_portfolio_taxonomies' );
add_action( 'init', 'register_team' );

// Render the Plugin options form
function ebor_cpt_render_form() { ?>
	
	<div class="wrap">
	
		<!-- Display Plugin Icon, Header, and Description -->
		<?php screen_icon('ebor-cpt'); ?>
		<h2><?php _e('Ebor CPT Settings','ebor'); ?></h2>
		<?php echo '<p>' . __('Welcome to <b>Ebor Custom Post Types</b>, our custom post type plugin letting you take your content everywhere.','ebor') . '</p>'; ?>
		<b>When you make any changes in this plugin, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks, otherwise your changes will not take effect properly.</b>
		
		<div class="wrap">
		
				<!-- Beginning of the Plugin Options Form -->
				<form method="post" action="options.php">
					<?php settings_fields('ebor_cpt_plugin_display_options'); ?>
					<?php $displays = get_option('ebor_cpt_display_options'); ?>
					
					<table class="form-table">
					<!-- Checkbox Buttons -->
									<tr valign="top">
										<th scope="row">Register Post Types</th>
										<td>
											
											<label><b>Enter the URL slug you want to use for the portfolio post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br />
											<input type="text" size="30" name="ebor_cpt_display_options[portfolio_slug]" value="<?php echo $displays['portfolio_slug']; ?>" placeholder="portfolio" />
											 <br />e.g Entering 'portfolio' will result in www.website.com/portfolio becoming the URL to your portfolio.<br />
											 <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
											 
											 <hr />
					 						
					 						<label><b>Enter the URL slug you want to use for the team post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br />
					 						<input type="text" size="30" name="ebor_cpt_display_options[team_slug]" value="<?php echo $displays['team_slug']; ?>" placeholder="team" />
					 						 <br />e.g Entering 'team' will result in www.website.com/team becoming the URL to your team.<br />
					 						 <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
										</td>
									</tr>
					</table>
					
					<?php submit_button('Save Options'); ?>
					
				</form>
		
		</div>

	</div>
<?php }