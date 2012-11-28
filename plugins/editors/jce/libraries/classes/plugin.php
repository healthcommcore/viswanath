<?php
/**
 * @version		$Id: jce.php 2007-08-04 09:50:57Z happy_noodle_boy $
 * @package		JCE
 * @copyright	Copyright (C) 2005 - 2007 Ryan Demmer. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JCE class
 *
 * @static
 * @package		JCE
 * @since	1.5
 */

class JContentEditor extends JObject {
	/*
	*  @var varchar
	*/
	var $_version = '150rc1';
	/*
	*  @var varchar
	*/
	var $_site_url = null;
	/*
	*  @var int
	*/
	var $_user = null;
	/*
	*  @var int
	*/
	var $_id = null;
	/*
	*  @var varchar
	*/
	var $_usertype = null;
	/*
	*  @var varchar
	*/
	var $_username = null;
	/*
	*  @var varchar
	*/
	var $_plugin = null;
	/*
	*  @var varchar
	*/
	var $_plugin_type = null;
	/*
	 *  @var object
	 */
	var $_params = null;
	/*
	*  @var varchar
	*/
	var $_url = array();
	/*
	*  @var varchar
	*/
	var $_request = null;
	/*
	*  @var array
	*/
	var $_scripts = array();
	/*
	*  @var array
	*/
	var $_css = array();
	/*
	*  @var boolean
	*/
	var $_debug = false;
	/**
	* Constructor activating the default information of the class
	*
	* @access	protected
	*/
	function __construct(){
		global $mainframe;
		$this->_user =& JFactory::getUser();
						                     
        $this->_site_url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
		
		$this->_usertype = strtolower( $this->_user->get('usertype') );
        $this->_username = $this->_user->get('username');
		
		if( !$this->_user->get('id') ){
			$gid = 0;
		}else{
			$query = "SELECT gid"
			. "\n FROM #__users"
			. "\n WHERE id = '".$this->_user->get('id')."' LIMIT 1";
			;
			$gid = $this->_query( $query, 'loadResult' );
		}
		$this->_id = intval( $gid );
		
		$this->_plugin = JRequest::getVar( 'plugin', '' );
		
		if( $this->_plugin ){
			$this->_plugin_type = JRequest::getVar( 'type', 'standard' );
			define( 'JCE_PLUGIN', JCE_PLUGINS . DS . $this->_plugin );
			$this->_params = $this->getPluginParams();
		}
	}
	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser = &JCE::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance(){
		static $instance;

		if ( !is_object( $instance ) ){
			$instance = new JContentEditor();
		}
		return $instance;
	}
	/**
	 * Process a query
	 *
	 * Wrapper function for a db query
	 *
	 * @access private
	 * @param string	The query text
	 * @param string	The result type
	 * @return query result
	*/
	function _query( $query, $result ){
		$db	=& JFactory::getDBO();
		$db->setQuery( $query );
		
		switch( $result ){
			case 'loadResult':
				return $db->loadResult();
				break;
			case 'loadResultArray':
				return $db->loadResultArray();
				break;
			case 'loadObjectList':
				return $db->loadObjectList();
				break;
		}		
	}
	function getUser( $option='id' ){
		return $this->_user->get( $option );
	}
	/**
	 * Get the Super Administrator status
	 *
	 * Determine whether the user is a Super Administrator
	 *
	 * @access public
	 * @return boolean
	*/
	function isSuperAdmin(){
		return ( $this->_usertype == 'superadministrator' || $this->_usertype == 'super administrator' || $this->_id == 25 ) ? true : false;	
    }
	/**
	 * Set the current plugin
	 *
	 * @access public
	 * @param string	The plugin
	*/
	function setPlugin( $plugin ){
		$this->_plugin = $plugin;
	}
	/**
	 * Return the current plugin
	 *
	 * @access 		public
	 * @return 		The current plugin
	*/
	function getPlugin(){
		return $this->_plugin;
	}
	/**
	 * Set the current plugin type
	 *
	 * @access public
	 * @param string	The plugin
	*/
	function setPluginType( $type ){
		$this->_plugin_type = $type;
	}
	/**
	 * Return the current plugin
	 *
	 * @access 		public
	 * @return 		The current plugin
	*/
	function getPluginType(){
		return $this->_plugin_type;
	}
	/**
	 * Do an authorisation check
	 *
	 * Check the users id against an authorisation level
	 *
	 * @access public
	 * @return boolean
	*/
    function authCheck( $level ){
		if( $this->isSuperAdmin() || intval( $level ) != 99 || $this->_id >= intval( $level ) ){
			return true;
		} 
		return false;
    }
	/**
	 * Return the JCE Mambot's parameters
	 *
	 * @access public
	 * @return object
	*/
	function getEditorParams(){		
		$query = "SELECT params FROM #__plugins"
		. "\n WHERE element = 'jce'"
		. "\n AND folder = 'editors'" 
		. "\n AND published = 1" 
		. "\n LIMIT 1";
		$params = $this->_query( $query, 'loadResult' );
		
		return new JParameter( $params );
	}
	/**
	 * Return a list of published JCE plugins
	 *
	 * @access public
	 * @return string list
	*/
	function getPlugins( $exclude ){		
		$query = "SELECT name"
        . "\n FROM #__jce_plugins"
        . "\n WHERE access <= '".$this->_id."' AND published = 1 AND type = 'plugin'"
        ;
		$plugins = $this->_query( $query, 'loadResultArray' );
		if( $exclude ){
			foreach( $exclude as $excluded ){
				if( in_array( $excluded, $plugins ) && in_array( $excluded . '_ext', $plugins )){
					unset( $plugins[array_search( $excluded, $plugins )] );
				}
			}
		}
        return implode( ',', $plugins );
	}
	/**
	 * Return a list of font familys
	 *
	 * @access public
	 * @return string list
	*/
	function getEditorFonts( $add, $remove ){
		// Default font list
		$fonts = array('Andale Mono=andale mono,times',
		'Arial=arial,helvetica,sans-serif',
		'Arial Black=arial black,avant garde',
		'Book Antiqua=book antiqua,palatino',
		'Comic Sans MS=comic sans ms,sans-serif',
		'Courier New=courier new,courier',
		'Georgia=georgia,palatino',
		'Helvetica=helvetica',
		'Impact=impact,chicago',
		'Symbol=symbol',
		'Tahoma=tahoma,arial,helvetica,sans-serif',
		'Terminal=terminal,monaco',
		'Times New Roman=times new roman,times',
		'Trebuchet MS=trebuchet ms,geneva',
		'Verdana=verdana,geneva',
		'Webdings=webdings',
		'Wingdings=wingdings,zapf dingbats');
		
		$add 	= explode( ';', $add );
		$remove = explode( ';', $remove );	
		
		for( $i=0; $i<count( $fonts ); $i++ ){
			$kv = explode( '=', $fonts[$i] );
			foreach( $remove as $gone ){
				// Match family to remove
				if( strtolower( $kv[0] ) == strtolower( $gone ) ){
					// Remove family
					unset( $fonts[$i] );
				}
			}
		}
		foreach( $add as $new ){
		// Add new font family
			if( preg_match( '/([^\=]+)(\=)([^\=]+)/', trim( $new ) ) && !in_array( $new, $fonts ) ){
				$fonts[] = $new;
			}
		}
		natcasesort( $fonts );
		return implode( ';', $fonts );
	}
	/**
	 * Return the curernt language code
	 *
	 * @access public
	 * @return language code
	*/
	function getLanguageDir(){
		$language =& JFactory::getLanguage();
		return $language->isRTL() ? 'rtl' : 'ltr';
	}
	/**
	 * Return the curernt language code
	 *
	 * @access public
	 * @return language code
	*/
	function getLanguageTag(){
		$language =& JFactory::getLanguage();
		return $language->getTag();
	}
	/**
	 * Return the curernt language code
	 *
	 * @access public
	 * @return language code
	*/
	function getLanguage(){
		$language =& JFactory::getLanguage();
		$tag = $language->getTag();
		if( file_exists( JPATH_SITE .DS. 'language' .DS. $tag .DS. $tag .'.com_jce.xml' ) ){
			return substr( $tag, 0, strpos( $tag, '-' ) );
		}
		return 'en';
	}
	/**
	 * Load a language file
	 *
	 * @access public
	*/
	function loadLanguage( $prefix, $path = JPATH_SITE ){
		$language =& JFactory::getLanguage();		
		$language->load( $prefix, $path );
	}
	/**
	 * Load a plugin language file
	 *
	 * @access public
	*/
	function loadPluginLanguage( $plugin = '' ){
		if( !$plugin ){
			$plugin = $this->_plugin;
		}
		$this->loadLanguage( 'com_jce_'. trim( $plugin ) );
	}
	/**
	 * Load the language files for the current plugin
	 *
	 * @access public
	*/
	function loadLanguages(){
		$this->loadLanguage( 'com_jce' );	
		$this->loadPluginLanguage();
	}
	/**
	 * Return the current site template name
	 *
	 * @access public
	*/
	function getSiteTemplate(){
		$query = 'SELECT template'
		. ' FROM #__templates_menu'
		. ' WHERE client_id = 0'
		. ' AND menuid = 0'
		;
		return $this->_query( $query, 'loadResult' );
	}
	function getSkin(){
		$params = $this->getEditorParams();
		return $params->get('inlinepopups_skin', 'clearlooks2');
	}
	/**
	 * Remove a key from an array
	 *
	 * @param array	    The array
	 * @param string	The key to remove
	 * @access public
	*/
	function removeKey( $array, $key ){
		if( in_array( $key, $array ) ){
			unset( $array[$key] );
		}
	}
	/**
	 * Add a key to a string list
	 *
	 * @param string	The string list to create an array from
	 * @param string	The key to add
	 * @param string	The list item seperator
	 * @access public
	 * @return The string list with added key or the key
	*/
	function addKey( $string, $key, $separator ){
		if( $string ){
			$array 	= explode( $separator, $string );
			if( !in_array( $key, $array ) ){
				$array[] = $key;
			}
			return implode( $separator, $array );
		}else{
			return $key;
		}
	}
	/**
	 * Remove linebreaks and carriage returns from a parameter value
	 *
	 * @param string	The parameter value
	 * @access public
	 * @return The modified value
	*/
	function cleanParam( $param ){
		return preg_replace( '/\n|\r|\t(\r\n)[\s]+/', '', $param );
	}
	/**
	 * Get a JCE editor or plugin parameter
	 *
	 * @param object	The parameter object
	 * @param string	The parameter object key
	 * @param string	The parameter default value
	 * @param string	The parameter default value
	 * @access public
	 * @return The parameter
	*/
	function getParam( $params, $key, $p, $t='' ){
		$v = $this->cleanParam( $params->get( $key, $p ) );
		return ( $v == $t ) ? '' : $v;
	}
	/**
	 * Return a string of JCE Commands to be removed
	 *
	 * @access public
	 * @return The string list
	*/
	function getRemovePlugins(){
		$query = "SELECT name"
        . "\n FROM #__jce_plugins"
        . "\n WHERE type = 'command'"
		. "\n AND published = 0"
        ;
		$remove = $this->_query( $query, 'loadResultArray' );
		if( $remove ){
			return implode( ',', $remove );
		}else{
			return '';
		}
	}
	/**
	 * Return a list of icons for each JCE editor row
	 *
	 * @access public
	 * @param string	The number of rows
	 * @return The row array
	*/
	function getRows(){
		$params = $this->getEditorParams();		
		$num 	= intval( $params->get( 'layout_rows', '5' ) );
		
		$rows = array();
		for( $i=1; $i<=$num; $i++ ){
			$query = "SELECT icon"
        	. "\n FROM #__jce_plugins"
        	. "\n WHERE access <= ". $this->_id
        	. "\n AND published = 1"
        	. "\n AND row = " . $i
        	. "\n AND icon != ''"
        	. "\n ORDER BY ordering ASC"
        	;
			$result = $this->_query( $query, 'loadResultArray' );
			if( $result ){
				$rows[$i] = implode( ',', $result );
			}
		}
        return $rows;
	}
	/**
	 * Return a string of extended elements for a plugin
	 *
	 * @access public
	 * @return The string list
	*/
	function getElements(){		
		$params = $this->getEditorParams();		
		$jce_elements = explode( ',', $this->cleanParam( $params->get( 'extended_elements', '' ) ) );
		$query = "SELECT elements"
    	. "\n FROM #__jce_plugins"
    	. "\n WHERE elements != ''"
    	. "\n AND published = 1"
    	. "\n AND access <= ".$this->_id
    	;
		$plugin_elements = $this->_query( $query, 'loadResultArray' );
		
		$elements = array_merge( $jce_elements, $plugin_elements );
		return implode( ',', $elements );		
	}
	/**
	 * Return the plugin parameter object
	 *
	 * @access 			public
	 * @param string	The plugin
	 * @return 			The parameter object
	*/
	function getPluginParams( $plugin='' ){			
		if( !$plugin ){
			$plugin = $this->_plugin;
		}
		
		$query = "SELECT params FROM #__jce_plugins"
		. "\n WHERE name = '" . $plugin . "'"
		. "\n AND published = 1" 
		. "\n LIMIT 1";
		$params = $this->_query( $query, 'loadResult' );
		
		return new JParameter( $params );
	}
	/**
	 * Return the variable object for all plugins
	 *
	 * @access 			public
	 * @return 			An array of variable objects
	*/
	function getPluginVariables(){					
		$variables = array();
		
		$query = "SELECT variables" 
		. "\n FROM #__jce_plugins" 
		. "\n WHERE variables != ''" 
		. "\n AND published = 1";
		$results = $this->_query( $query, 'loadResultArray' );
		
		foreach( $results as $result ){
			$variables[] = new JParameter( $result );
		}
		return $variables;
	}
	/**
	 * Determine whether a plugin is loaded
	 *
	 * @access 			public
	 * @param string	The plugin
	 * @return 			boolean
	*/
	function isLoaded( $plugin ){		
        $query = "SELECT id"
        . "\n FROM #__jce_plugins"
        . "\n WHERE name = '" . $plugin . "'"
		. "\n AND published = 1 LIMIT 1"
        ;
		$id = $this->_query( $query, 'loadResult' );
		
		return ( $id ) ? true : false;
	}
	function getAuthOption( $key, $def, $type='bool' ){
		$params = $this->getPluginParams();
		if( $type == 'int' ){
			return $this->authCheck( $params->get( $key, $def ) ) == true ? 1 : 0;
		}
		return $this->authCheck( $params->get( $key, $def ) );
	}
	/**
	 * Returns a an array of Help topics
	 *
	 * @access	public
	 * @return	Array
	 * @since	1.5
	 */
	function getHelpTopics(){
		// Load plugin xml file
		$result = '';
		if( $this->_plugin_type == 'manager' ){
			$file = JCE_LIBRARIES .DS. "xml" .DS. "help" .DS. "manager.xml";			
			$result .= '<dl><dt><span>'. JText::_('MANAGER HELP') .'<span></dt>';		
			if( file_exists( $file ) ){				
				$xml =& JFactory::getXMLParser('Simple');
				if( $xml->loadFile( $file ) ){
					$root =& $xml->document;									
					if( $root ){
						foreach( $root->children() as $topic ){
							$result .= '<dd id="'. $topic->attributes('key') .'"><a href="javascript:;" onclick="helpDialog.loadFrame(this.parentNode.id)">'. JText::_( $topic->attributes('title') ) .'</a></dd>';
						}
					}
				}
			}
			$result .= '</dl>';
		}
		
		$file = JCE_PLUGIN .DS. $this->_plugin. ".xml";			
		$result .= '<dl><dt><span>'. JText::_('PLUGIN HELP') .'<span></dt>';
		
		if( file_exists( $file ) ){
			$xml =& JFactory::getXMLParser('Simple');
			
			if( $xml->loadFile( $file ) ){
				
				$root =& $xml->document;				
				$topics = $root->getElementByPath('help');
				
				if( $topics ){
					foreach( $topics->children() as $topic ){
						$result .= '<dd id="'. $topic->attributes('key') .'"><a href="javascript:;" onclick="helpDialog.loadFrame(this.parentNode.id)">'. trim( JText::_( $topic->attributes('title') ) ) .'</a></dd>';
					}
				}
			}
		}
		$result .= '</dl>';
		return $result;
	}
	/**
	 * Returns a JCE resource url
	 *
	 * @access	public
	 * @param	string 	The path to resolve eg: libaries
	 * @param	boolean Create a relative url
	 * @return	full url
	 * @since	1.5
	 */
	function url( $path, $relative=false ){
		global $mainframe;
		// Use a relative path
		$site = ( !$relative ) ? $this->_site_url : '../';
		// Check if value is already stored
		if( !array_key_exists( $path, $this->_url ) ){
			switch( $path ){
				// JCE root folder
				case 'jce':
					$pre = 'plugins/editors/jce';
					break;
				// JCE libraries resource folder
				case 'libraries':
					$pre = 'plugins/editors/jce/libraries';
					break;
				// JCE skin resource folder
				case 'skins':
					$pre = 'plugins/editors/jce/tiny_mce/themes/advanced/skins/dialog/' .$this->getSkin();
					break;
				// TinyMCE folder
				case 'tiny_mce':
					$pre = 'plugins/editors/jce/tiny_mce';
					break;
				// JCE current plugin folder
				case 'plugins':
					$pre = 'plugins/editors/jce/tiny_mce/plugins/' .$this->_plugin;
					break;
				// Joomla! media folder
				case 'extensions':
					$pre = 'plugins/editors/jce/tiny_mce/plugins/' .$this->_plugin. '/extensions';
					break;
				// Joomla! folders
				case 'joomla':
					$pre = '';
					break;
			}
			// Store url
			$this->_url[$path] =  $site . $pre;	
		}	
		return $this->_url[$path];
	}
	/**
	 * Upload form action url
	 *
	 * @access	public
	 * @param	string 	The target action file eg: upload.php
	 * @return	Joomla! component url
	 * @since	1.5
	 */
	function getUploadAction(){
		$file = JRequest::getVar( 'file', $this->_plugin );
		return JURI::base() .'index.php?option=com_jce&task=plugin&plugin=' . $this->_plugin . '&file=' . $file .'&action=upload'; 
	}
	/**
	 * Convert a url to path
	 *
	 * @access	public
	 * @param	string 	The url to convert
	 * @return	Full path to file
	 * @since	1.5
	 */
	function urlToPath( $url ){
		jimport('joomla.filesystem.path');
		$site = strpos( $url, '../' ) !== false ? '../' : $this->_site_url;
		return JPath::clean( str_replace( $site, JPATH_SITE .DS, $url ) );
	}
	function removeScript( $script ){
		if( isset( $this->_scripts[$script] ) ){
			unset( $this->_scripts[$script] );
		}
	}
	function removeCss( $css ){
		if( isset( $this->_css[$css] ) ){
			unset( $this->_css[$css] );
		}
	}
	/**
	 * Loads a javascript file
	 *
	 * @access	public
	 * @param	string 	The file to load including path eg: libaries.manager
	 * @param	boolean Debug mode load src file
	 * @return	echo script html
	 * @since	1.5
	 */
	function script( $files, $root = 'libraries' ){		
		settype( $files, 'array' );
		
		foreach( $files as $file ){
			$parts = explode( '.', $file );
			$parts = preg_replace( '#[^A-Z0-9-_]#i', '', $parts );
			
			$file	= array_pop( $parts );
			$path	= implode( '/', $parts );
			
			if( $path ){
				$path .= '/';
			}

			// Different path for tiny_mce file
			if( $root != 'tiny_mce' ){
				$file = 'js/' .$file;
			}
			if( !in_array( $this->url( $root ). "/" . $path.$file, $this->_scripts ) ){
				$this->_scripts[] = $this->url( $root ). "/" . $path.$file; 
			}
		}  
    }
	/**
	 * Loads a css file
	 *
	 * @access	public
	 * @param	string 	The file to load including path eg: libaries.manager
	 * @param	boolean Load IE6 version
	 * @param	boolean Load IE7 version
	 * @return	echo css html
	 * @since	1.5
	 */
	function css( $files, $root = 'libraries' ){
		settype( $files, 'array' );
		
		foreach( $files as $file ){
			$parts = explode( '.', $file );
			$parts = preg_replace( '#[^A-Z0-9-_]#i', '', $parts );
			
			$file	= array_pop( $parts );
			$path	= implode( '/', $parts );
			
			if( $path ){
				$path .= '/';
			}
			
			// Different path for tiny_mce file
			if( $root != 'tiny_mce' ){
				$file = 'css/' .$file;
			}		
			
			$url = $this->url( $root ). "/" .$path.$file;
			if( !in_array( $url, $this->_css ) ){
				$this->_css[] = $url; 
			}
		}
	}
	/**
	 * Print <script> html
	 *
	 * @access	public
	 * @return	echo <script> html
	 * @since	1.5
	 */
	function printScripts(){
		//$stamp = $this->_debug ? '?'.time() : '';
		$stamp		= '?'. $this->_version;
		foreach( $this->_scripts as $script ){
			echo "\t<script type=\"text/javascript\" src=\"" . $script . ".js". $stamp ."\"></script>\n";
		}
	}
	/**
	 * Print <link> css html with browser detection
	 *
	 * @access	public
	 * @return	echo <link> html
	 * @since	1.5
	 */
	function printCss(){
		jimport('joomla.environment.browser');
		jimport('joomla.filesystem.path');
		$browser 	=& JBrowser::getInstance();
		//$stamp 		= $this->_debug ? '?'.time() : '';
		$stamp		= '?'. $this->_version;
		foreach( $this->_css as $css ){
			echo "\t<link href=\"" . $css . ".css". $stamp ."\" rel=\"stylesheet\" type=\"text/css\" />\n";
			if( $browser->getBrowser() == 'msie' ){
				$file =  $css. '_ie' .$browser->getMajor(). '.css';
				if( is_file( $this->urlToPath( $file ) ) ){
					echo "\t<link href=\"" . $file . "\" rel=\"stylesheet\" type=\"text/css\" />\n";
				}
			}
		}
	}
	/**
	 * Returns an image url
	 *
	 * @access	public
	 * @param	string 	The file to load including path and extension eg: libaries.image.gif
	 * @return	Image url
	 * @since	1.5
	 */
	function image( $image, $root = 'libraries' ){
		$parts = explode( '.', $image );
		$parts = preg_replace( '#[^A-Z0-9-_]#i', '', $parts );
			
		$ext	= array_pop( $parts );
		$name	= array_pop( $parts );
		$path	= implode( '/', $parts );		
			
		return $this->url( $root ). "/" .$path. "/img/" . $name . "." . $ext;
	}
	/**
	 * Load a plugin extension
	 *
	 * @access	public
	 * @since	1.5
	 */
	function getExtensions( $plugin ){
		$query = 'SELECT id'
        . ' FROM #__jce_plugins'
        . ' WHERE name = "'. $plugin .'"' 
		. ' AND published = 1 LIMIT 1'
        ;
		$id = $this->_query( $query, 'loadResult' );
		
		$query = 'SELECT extension'
        . ' FROM #__jce_extensions'
		. ' WHERE pid = '.(int) $id
		. ' AND published = 1'
        ;
		return $this->_query( $query, 'loadResultArray' );
	}
	/**
	 * Load & Call an extension
	 *
	 * @access	public
	 * @since	1.5
	 */
	function loadExtensions( $base_dir = '', $plugin = '', $base_path = JCE_PLUGIN ){		
		if( !$plugin ){
			$plugin = $this->_plugin;
		}
		// Create extensions path
		$path = $base_path .DS. 'extensions' .DS. $base_dir;
		// Get installed extensions
		$extensions = $this->getExtensions( $plugin );

		$result = array();
		
		if( !empty( $extensions ) ){
			foreach( $extensions as $extension ){
				$root = $path .DS. $extension. '.php';
				if( file_exists( $root ) ){
					// Load root extension file
					require_once( $root );
					// Load Extension language file
					$this->loadLanguage( 'com_jce_'. $plugin .'_'. $extension, JPATH_SITE );
					// Call as function, eg corelinks() to array
					$result[] = call_user_func( $extension );
				}
			}
		}
		// Return array
		return $result;
	}
	/**
	 * XML encode a string.
	 *
	 * @access	public
	 * @param 	string	String to encode
	 * @return 	string	Encoded string
	*/
	function xmlEncode( $string ){
		return preg_replace( array( '/&/', '/</', '/>/', '/\'/', '/"/' ), array( '&amp;', '&lt;', '&gt;', '&apos;', '&quot;' ), $string );
	}
	/**
	 * XML decode a string.
	 *
	 * @access	public
	 * @param 	string	String to decode
	 * @return 	string	Decoded string
	*/
	function xmlDecode( $string ){
		return preg_replace( array( '&amp;', '&lt;', '&gt;', '&apos;', '&quot;' ), array( '/&/', '/</', '/>/', '/\'/', '/"/' ), $string );
	}
	/**
	 * Setup an ajax function
	 *
	 * @access public
	 * @param array		An array containing the function and object
	 * @param string	The ajax mode
	*/
	function setXHR( $function ){
		if( is_array( $function ) ){
			$this->_request[$function[1]] = array( 
				'fn' => array( $function[0], $function[1] )
			);
		}else{
			$this->_request[$function] = array( 
				'fn' => $function
			);
		}
	}
	/**
	 * Returns a reference to a json object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $json =& JContentEditor::getJson();</pre>
	 *
	 * @access	public
	 * @return	json  a json services object.
	 * @since	1.5
	 */
	function &getJson(){
		static $json;
		if( !is_object( $json ) ){
			if( !class_exists( 'Services_JSON' ) ){
				include_once( dirname(__FILE__) .DS. 'json' .DS. 'json.php' );
			}
			$json = new Services_JSON();
		}
		return $json;
	}
	/**
	 * JSON Encode wrapper for PHP function or PEAR class
	 *
	 * @access public
	 * @param string	The string to encode
	 * @return			The json encoded string
	*/
	function json_encode( $string ){
		if( function_exists( 'json_encode' ) ){
			return json_encode( $string );
		}else{
			$json =& JContentEditor::getJson();
			return $json->encode( $string );
		}
	}
	/**
	 * JSON Decode wrapper for PHP function or PEAR class
	 *
	 * @access public
	 * @param string	The string to decode
	 * @return			The json decoded string
	*/
	function json_decode( $string ){
		if( function_exists( 'json_decode' ) ){
			return json_decode( $string );
		}else{
			$json =& JContentEditor::getJson();
			return $json->decode( $string );
		}
	}
	/**
	 * Process an ajax call and return result
	 *
	 * @access public
	 * @return string
	*/
	function processXHR(){										
		$json 	= JRequest::getVar( 'json', '', 'POST', 'STRING', 2 );
		$action = JRequest::getVar( 'action', '' );
				
		if( $action == 'upload' ){
			$func 	= $this->_request['uploadFiles']['fn'];			
			$result = call_user_func( $func );
			exit();
		}		
		if( $json ){								
			$GLOBALS['xhrErrorHandlerText'] = '';
			set_error_handler('_xhrErrorHandler');

			$json 	= $this->json_decode( $json );
			$fn 	= $json->fn;
			$args 	= $json->args;
		
			$result = null;
			$error	= null;
			$func 	= $this->_request[$fn]['fn'];

			if( $fn ){
				if( array_key_exists( $fn, $this->_request ) ){	
					$result = call_user_func_array( $func, $args );
					if( !empty( $GLOBALS['xhrErrorHandlerText'] ) ){			
						$error = 'PHP Error Message: ' . addslashes( $GLOBALS['xhrErrorHandlerText'] );
					}
				}else{
					$error = 'Cannot call function '. addslashes( $fn ) .'. Function not registered!';
				}
				$output = array(
					"result" 	=> $result,
					"error" 	=> $error
				);
				header('Content-type: text/json; charset=utf-8');
				die( $this->json_encode( $output ) );
			}
		}
	}
}
/**
 * XHR error handler function
 *
 * @param string The error code
 * @param string The error string
 * @param string The file producing the error
 * @param string The line number of the error
 * @access private
 * @return error string
*/
function _xhrErrorHandler( $num, $string, $file, $line ){
	$reporting = error_reporting();
	if ( ( $num & $reporting ) == 0 ) return;
		
	switch( $num ){
		case E_NOTICE :
			$type = "NOTICE";
			break;
		case E_WARNING :
			$type = "WARNING";
			break;
		case E_USER_NOTICE :
			$type = "USER NOTICE";
			break;
		case E_USER_WARNING :
			$type = "USER WARNING";
			break;
		case E_USER_ERROR :
			$type = "USER FATAL ERROR";
			break;
		case E_STRICT :
			return;
			break;
		default:
			$type = "UNKNOWN: ". $num;
	}
	$GLOBALS['xhrErrorHandlerText'] .= $type . $string ."Error in line ". $line ." of file ".$file;
}
?>