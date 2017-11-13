<?php 
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Ajax extends WPCD
{	

	private $logs;
	/**
	 * Register Ajax Hooks 
	 *
	 * @since  1.0
	 * @access public
	 * @return void
	 */

	public function __construct()
	{
		parent::__construct();
		add_action( "wp_ajax_save_git_user_data", array( $this, "save_git_user_data" ) );
		add_action( "wp_ajax_generate_ssh_keys", array( $this, "generate_ssh_keys" ) );
		add_action( "wp_ajax_add_ssh_keys", array( $this, "ssh_add" ) );
	}

	
	/**
	 * Ajax Save Git User 
	 *
	 * @since  1.0
	 * @access public
	 * @param POST
	 * @return void
	 */

	public function save_git_user_data()
	{
		$response['message'] = '';
		if( isset( $_POST['username'] ) )
		{
			$username = sanitize_text_field( $_POST['username'] );
		}
		if( isset( $_POST['useremail'] ) )
		{
			$useremail = filter_var( sanitize_text_field( $_POST['useremail'] ), FILTER_VALIDATE_EMAIL );
		}	
		if( !$username || empty( $username ) )
		{
			$response['message'] .= self::admin_danger( __( "Invalid Username!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid user name. Update failed.' );
		}
		if( !$useremail || empty( $useremail ) )
		{
			$response['message'] .= self::admin_danger( __( "Invalid User Email!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  invalid user email. Update failed.' );
		}
		if( !isset( $response['error'] ) )
		{
			update_option( "_wpcd_username_username", $username, "yes" );
			update_option( "_wpcd_username_useremail", $useremail, "yes" );
			$response['message'] .= self::admin_success( __( "Userdata has been successful saved!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  updated local user data' );
		}
		echo json_encode( $response );
		wp_die();
	}

	public function generate_ssh_keys()
	{
		if( self::is_public_key_exists() ){
			unlink( self::is_public_key_exists() );
		}
		if( self::is_private_key_exists() ){
			unlink( self::is_private_key_exists() );
		}
		$generateKeyCommand = "ssh-keygen -t rsa -b 4096 -f ".WPCD_PLUGIN_KEYS_DIR."id_rsa";
		exec( $generateKeyCommand, $output, $return );
		if( $return == 0 ){
			$response['message'] = self::admin_success( __( "Keys has been successful generated!" ), false );
			$response['public'] = file_get_contents( self::is_public_key_exists() );
			$response['private'] = file_get_contents( self::is_private_key_exists() );

			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  updated ssh keys' );
		}else{
			$response['message'] = self::admin_danger( __( "An error occurred while generating the keys!" ), false );
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).$output );
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).'  an error occurred while generating the keys' );
		}
		echo json_encode( $response );
		wp_die();
	}

	public function ssh_add()
	{
		$command = "ssh-add ".self::is_private_key_exists();
		if( self::is_public_key_exists() && self::is_private_key_exists() ){	
			print exec( $command, $output, $return ); die;
			if( $return == 0 ){
				$response['message'] = self::admin_success( __( "Keys has been successful added!" ), false );
				/*Log*/
				WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).' Key '.self::is_private_key_exists().' successful added' );
			}else{
				$response['message'] = self::admin_danger( __( $output ), false );
				/*Log*/
				WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).$output );
				WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).' Fail add key '.self::is_private_key_exists() );
			}
		}else{
			/*Log*/
			WPCD_Logs::writeLog( date( "Y-m-d H:i:s" ).' Keys doesn\'t exists' );
				$response['message'] = self::admin_danger( __( 'Keys doesn\'t exists' ), false );
		}
		echo json_encode( $response );
	}
}

