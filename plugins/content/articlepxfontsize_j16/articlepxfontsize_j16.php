<?php
/**
 * articlepxfontsize_j16 - Plugin Article PXFont Size for Joomla! 2.5
 *
 * @package		Plugin for Joomla! 1.6, 1.7, 2.5
 * @version 2.2.1 (August 27, 2012)
 * @author/email karmanyy@gmail.com
 * @copyright (C) 2012 by karmany (http://www.karmany.net)
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

 *
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU/GPLv3 General Public License.
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );

class plgContentarticlepxfontsize_j16 extends JPlugin {
	
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		//Cargamos el lenguaje
		$this->loadLanguage();
		if (!JFactory::getApplication()->isAdmin())
		{
			$contador = 0;
		}
	}
	
	function onContentPrepare($context, &$articulo, &$params, $limitstart) {
		global $contador;
		
		$vista = JRequest::getCmd( 'view' );
		$insertar_txt = true;
		
		//Modo debug. Solo depuran los administradores
		$param_debug_mode = $this->params->get('debug_mode');
		$administrador = (JFactory::getUser()->authorise('core.admin'));	
		if ($administrador && $param_debug_mode && !$contador)
		{
			JFactory::getApplication()->enqueueMessage( (JText::_('ENABLE_DEBUG_MODE')). '. View: '. $vista, 'notice' );
		}
				
		//Verifica contexto y parametros.
		$currentOption = JRequest::getCmd("option");
		if( ($currentOption != "com_content") OR !isset($this->params) OR ($context === 'mod_custom.content'))
		{
			if ($administrador && $param_debug_mode)
			{
				JFactory::getApplication()->enqueueMessage( JText::_('UNUSUAL_CONTEXT'), 'message' );
			}
         return '';            
      }
		// En J2.5 en $vista "category", "categories" y "featured" NO existe $articulo->id
		if ($vista === 'article'){
			if (!isset($articulo) OR empty($articulo->id))
			{
				if ($administrador && $param_debug_mode)
				{
					JFactory::getApplication()->enqueueMessage( JText::_('EMPTY_ARTICLE'), 'message' );
				}
				return '';
			}
		}
		elseif ($vista === 'featured' OR $vista === 'category' OR $vista === 'categories'){
			if (!isset($articulo) OR !isset($articulo->text) OR empty($articulo->text))
			{
				if ($administrador && $param_debug_mode)
					{
						JFactory::getApplication()->enqueueMessage( JText::_('EMPTY_ARTICLE'), 'message' );
					}
				return '';
			}
		}
		else return '';
        
		//Carga hidefa, expresion regular
		$busca_expreg = '/{hidefa\s*.*?}/i';
	
		//Quita hidefa
		if (preg_match_all( $busca_expreg, $articulo->text, $encontrado ))
		{
			$articulo->text = preg_replace( $busca_expreg, '', $articulo->text );
			$insertar_txt = false;
		}
		
		//Comprueba plugin activado o texto hidefa
 		if (!$this->params->get('activado') OR !$insertar_txt)
 		{
 			if ($administrador && $param_debug_mode)
			{
				JFactory::getApplication()->enqueueMessage( JText::_('PLUGIN_DISABLED'), 'message' );
			}
			return '';
 		}
	
		++$contador;

		//Obtenemos los parametros del plugin
		$sz_inicial = $this->params->get('sz_inicial');
		$sz_maximo = $this->params->get('sz_maximo');
		$sz_minimo = $this->params->get('sz_minimo');
		$sz_inc = $this->params->get('sz_inc');
		$formato = $this->params->get('formato');
		
		$param_estilo = $this->params->get('estilo');
		$param_titulo = $this->params->get('titulo');
		$param_font_style = $this->params->get('font_style');
		$param_option_css_title = $this->params->get('option_css_title');
		$param_articulos_excluidos = $this->params->get('articulos_excluidos');
		$param_categorias_excluidas = $this->params->get('categorias_excluidas');
		$param_tooltip_mas = $this->params->get('tooltip_mas');
		$param_tooltip_menos = $this->params->get('tooltip_menos');
		$param_tooltip_igual = $this->params->get('tooltip_igual');
		$param_tooltip_visual = $this->params->get('tooltip_visual');
		$param_tags = $this->params->get('include_tags');
		$param_show_visual_button = $this->params->get('show_visual_button');
		$param_show_reset_button = $this->params->get('show_reset_button');
		
		//Obtener el array de articulos excluidos:
		if(!empty($param_articulos_excluidos)){
			$param_articulos_excluidos = explode(',', $param_articulos_excluidos);
		}
		settype($param_articulos_excluidos, 'array');
		JArrayHelper::toInteger($param_articulos_excluidos);
		
		//Obtener el array de categorias excluidas:
		if(!empty($param_categorias_excluidas)){
			$param_categorias_excluidas = explode(',', $param_categorias_excluidas);
		}
		settype($param_categorias_excluidas, 'array');
		JArrayHelper::toInteger($param_categorias_excluidas);
		
		//El usuario debe introducir el tamano maximo, minimo, incremento e inicial numerico:
		if (!is_numeric($sz_inicial) OR !is_numeric($sz_maximo) OR !is_numeric($sz_minimo) OR !is_numeric($sz_inc))
		{
			if ($administrador && $param_debug_mode && $contador == 1)
			{
				JFactory::getApplication()->enqueueMessage( JText::_('NON_NUMERIC_PARAM'), 'message' );
			}
			return'';
		}
		
		//Verifica y formatea los tags a insertar:
		if(!empty($param_tags)){
			$param_tags = explode(',', $param_tags);
		}
		$param_tags = implode("','", $param_tags);
		$param_tags = "'".$param_tags."'";
	
		//Verifica vista: articulo, seccion, blog o categoria
		switch($vista){
			case 'article':
			break;
			case 'featured':
				if (!$this->params->get('view_featured')) return '';
			break;
			case 'category':
				if (!$this->params->get('view_category')) return '';
			break;
			case 'categories':
				if (!$this->params->get('view_categories')) return '';
			break;
			default:
			return '';
			break;
		}
		
		//Excluye articulos y categorias
		if (!empty($articulo->id)) {
			if(in_array($articulo->id, $param_articulos_excluidos) OR in_array($articulo->catid, $param_categorias_excluidas)) return '';
		}
		
		if ($contador == 1){
			//Insertamos archivo js y css
			$doc =& JFactory::getDocument();
			$doc->addScript( JURI::root().'plugins/content/articlepxfontsize_j16/articlepxfontsize_j16/article_font.js');
			//Inserta o no el archivo de estilo dependiendo de la opcion del usuario
			if (!$this->params->get('option_css_buttons'))
			{
				$doc->addStyleSheet( JURI::root().'plugins/content/articlepxfontsize_j16/articlepxfontsize_j16/'.$param_estilo.'.css');
			}
			else
			{
				$estilo_propio = $this->params->get('css_buttons');
				//Parametros a reemplazar
				$buscar = array('IMG_BTN01','IMG_BTN02','IMG_BTN03','IMG_BTN04');
				$img_mas = JURI::root().'plugins/content/articlepxfontsize_j16/articlepxfontsize_j16/mas'.substr($param_estilo,-2).'.png';
				$img_menos = JURI::root().'plugins/content/articlepxfontsize_j16/articlepxfontsize_j16/menos'.substr($param_estilo,-2).'.png';
				$img_igual = JURI::root().'plugins/content/articlepxfontsize_j16/articlepxfontsize_j16/igual'.substr($param_estilo,-2).'.png';
				$img_visual = JURI::root().'plugins/content/articlepxfontsize_j16/articlepxfontsize_j16/visual01.png';
				$reemplazar = array($img_mas, $img_menos,$img_igual,$img_visual);
				$estilo_propio = str_replace($buscar, $reemplazar, $estilo_propio);
				//Add estilo propio
				$doc->addStyleDeclaration($estilo_propio);
			}
			
			//Insertamos en Javascript los tags a modificar ya formateados
			echo "<script type='text/javascript'>";
			echo  "var tgs = new Array(" .$param_tags. "); ";
			echo "</script>";
			//Inicializa los datos comunes en todos los articulos una sola vez:
			echo "<script type='text/javascript'>init_common_datos($sz_inicial,$sz_maximo,$sz_minimo,\"$formato\",$sz_inc);</script>";
		}
		
		//Inicializa solo datos individuales de cada articulo:
		echo "<script type='text/javascript'>init_individual_datos($contador);</script>";
			
		//Insertamos texto html en articulo
		$txt = '<div class="plg_fa_karmany">';
		//Boton discapacidad visual:
		$currentOption = JRequest::getVar('visleer'); //En modo lectura, se elimina la creacion de nueva ventana.
		//Evita posible NO inicializacion y error E_NOTICE:
		$currentOption = (!isset($currentOption)?'':$currentOption);
		
		if (($vista === 'article') && (!$currentOption) && ($this->params->get('open_window_visual'))){
			//Vista article: abre nueva ventana:
			$url  = ContentHelperRoute::getArticleRoute($articulo->slug, $articulo->catid);
			//$url .= '&tmpl=component&print=1&layout=default&page='.@ $request->limitstart;
			$url .= '&tmpl=component&visleer=1';

			$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
			$attribs['title']	= $param_tooltip_visual;
			$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
			$attribs['rel']		= 'nofollow';

			$url = JHtml::_('link', JRoute::_($url), $text, $attribs);
			$txt .= ((!$param_show_visual_button)?'':'<span class="plg_fa_karmany_visual">'.$url.'</span>');
		}
		else{
			//Otra vista: aumenta tamano texto inline:
			$txt .= ((!$param_show_visual_button)?'':'<span class="plg_fa_karmany_visual"><a title="'.$param_tooltip_visual.'" href="javascript:modify_size('."'articlepxfontsize'".',2,'."'".$contador."'".')"></a></span>');
		}
		
		//Boton menos:
		$txt .= '<span class="plg_fa_karmany_menos"><a title="'.$param_tooltip_menos.'" href="javascript:modify_size('."'articlepxfontsize'".',-1,'."'".$contador."'".')"></a></span>';
		//Boton igual:
		$txt .= ((!$param_show_reset_button)?'':'<span class="plg_fa_karmany_igual"><a title="'.$param_tooltip_igual.'" href="javascript:modify_size('."'articlepxfontsize'".',0,'."'".$contador."'".')"></a></span>');
		//Boton mas:
		$txt .= '<span class="plg_fa_karmany_mas"><a title="'.$param_tooltip_mas.'" href="javascript:modify_size('."'articlepxfontsize'".',1,'."'".$contador."'".')"></a></span>';
		//Titulo:
		$txt .= (($param_titulo=='HIDE')?'':((!$param_option_css_title)?'<span class="plg_fa_karmany_titulo">'.$param_titulo.'</span>':'<span style="'.$param_font_style.'">'.$param_titulo.'</span>'));
		$txt .= '</div>';
		//clearboth:
		$txt .= '<div class="karmany_clearboth"></div>';
		
		$articulo->text = $txt . '<div id="articlepxfontsize' .$contador. '">' . $articulo->text . '</div>';

		return true;
	
	}
	function onContentAfterDisplay($context, &$articulo, &$params, $limitstart = 0){
	
		if(strcmp($context,'com_content.article') == 0) {
			// No mostrar script en modulo
			$data = $params->toArray();
			if (isset($data['moduleclass_sfx'])) {
				return '';
			}
			//Boton discapacidad visual:
			$vista_lectura = JRequest::getVar('visleer'); //En modo lectura, inserta script para aumentar tamano.
			if (isset($vista_lectura) && !empty($vista_lectura)){
				$status = "<script type='text/javascript'>";
				$status .= 'modify_size('."'articlepxfontsize'".',2,1'.')';
				$status .= "</script>";
				$articulo->text .= $status;
			}
			
			return;
		}
		return '';
}

}
?>