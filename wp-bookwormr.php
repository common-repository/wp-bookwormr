<?php
/*
Plugin Name: WP-Bookwormr
Plugin URI: http://blog.bookwormr.com
Description: Retrieves books from your bookwormr reading lists
Author: Mormanski
Version: 1.0.0
Author URI: http://www.mormanski.net/
*/

add_action('admin_menu', 'bookwormr_config_page');

function is_post() 
{
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function bookwormr_get($url)
{
	if (function_exists('curl_init')):
	{
		$curl = curl_init();
	
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		
		$data = curl_exec($curl);
	}
	else:
	{
		$f = fopen($url, 'r');
		
		if ($f):
		{
			while (!feof($f)):
			{
				$data .= fread($f, 4096);
			}
			endwhile;
			
			fclose($f);
		}
		endif;
	}
	endif;
	
	return $data;
}

function bookwormr_config_page() {
	global $wpdb;
	if (function_exists('add_submenu_page')) 
	{
		add_submenu_page('plugins.php', __('Bookwormr Configuration'), __('Bookwormr Configuration'), 1, __FILE__, 'bookwormr_conf');
	}
}

function bookwormr_verify_user($username)
{
	$url = sprintf('http://www.bookwormr.com/user/userexists/username/%s', $username);
	$data = bookwormr_get($url);
	
	if ($data == "True"):
	{
	  return True;
	}
	else:
	{
	  return False;
	}
	endif;
}

function bookwormr_display()
{
	global $wpdb;
   
	if ($username = get_option('wordpress_bookwormr_username')): 
	{
		$url = sprintf('http://www.bookwormr.com/reading/randomfeed/username/%s', $username);
		$data = bookwormr_get($url);
		$lines = explode("@", $data);
		
        if ($lines[2]):
        {
          echo '<h2><a href="http://www.bookwormr.com/user/show/username/' . $username . '">I\'m Reading</a></h2>';
          echo '<br />';
          echo '<p align="center"><a href="http://www.bookwormr.com/book/show/isbn/' . $lines[1] . '"><img style="width: 70px;" src="' . $lines[2] . '" /></a></p>';
          echo '<p>Title: <a href="http://www.bookwormr.com/book/show/isbn/' . $lines[1] . '">' . $lines[0] . '</a></p>';
         }
         else:
         {
           echo '<h2>I\'m Reading</h2>';
           echo '<br />';
           echo '<p>I\'m not currently reading any books.</p>';
         }
         endif;
	}
	endif;
}

function bookwormr_conf() {
	if (is_post()):
	{
		check_admin_referer();
		
		$username = $_POST['username'];
		$mode = $_POST['mode'];
		
		if (bookwormr_verify_user($username)): 
		{
			update_option('wordpress_bookwormr_username', $username);
			update_option('wordpress_bookwormr_mode', $mode);
		}
		
		else: 
		{
			$invalid_username = true;
			update_option('wordpress_bookwormr_username', '');
		}
		endif;
	}
	endif;
?>

<div class="wrap">
<h2><?php _e('Bookwormr Configuration'); ?></h2>	

<form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post" id="bookwormr-conf" >
<h3><label for="username"><?php _e('Bookwormr Username'); ?></label></h3>
<?php if ( $invalid_username ): ?>
	<p><?php _e('Your username wasn\'t found. Please double-check it and ensure you have a valid account at <a href="http://www.bookwormr.com">Bookwormr.com</a>.'); ?></p>
<?php endif; ?>
<p><input id="username" name="username" type="text" size="16" maxlength="16" value="<?php echo get_option('wordpress_bookwormr_username'); ?>" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" /></p>
<p>
	<input type="hidden" name="mode" value="publish" />
</p>
<p class="submit"><input type="submit" name="submit" value="<?php _e('Update &raquo;'); ?>" /></p>
</form>
</div>
<?php } //closing function?>
