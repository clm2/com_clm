<?php
/**
 * @ Chess League Manager (CLM) Component 
 * @Copyright (C) 2008-2021 CLM Team.  All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.chessleagueamanager.de
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class CLMViewArenaTurnier extends JViewLegacy {
	function display($tpl = null) { 
		
		//Daten vom Model
		$state 		= $this->get( 'State' );
		$saisons 	= $this->get( 'saisons' );
		$turniere 	= $this->get( 'turniere' );
		
		
		//Toolbar
		clm_core::$load->load_css("icons_images");
		JToolBarHelper::title( JText::_('TITLE_SWT_TOURNAMENT') ,'clm_headmenu_manager.png' );
		
		JToolBarHelper::custom('update','refresh.png','refresh_f2.png', JText::_('SWT_TOURNAMENT_UPDATE'), false);
		$clmAccess = clm_core::$access;
		if ($clmAccess->access('BE_tournament_create') === true) {
			JToolBarHelper::custom('add','new.png','new_f2.png', JText::_('SWT_TOURNAMENT_NEW'), false);
		}
		//CLM parameter auslesen
		$config = clm_core::$db->config();
		$test_button = $config->test_button;
		if ($test_button) {
			JToolBarHelper::custom('test','delete.png','delete_f2.png', JText::_('SWT_TOURNAMENT_TEST'), false);
		}
		JToolBarHelper::cancel();
		
		//Saison- und Turnier-Auswahl erstellen
		$options_saisons[]		= JHtml::_('select.option', '', JText::_( 'SWT_SAISONS' ));
		foreach($saisons as $saison)	{
			$options_saisons[]		= JHtml::_('select.option', $saison->id, $saison->name);
		}
		
		$options_turniere[]		= JHtml::_('select.option', '', JText::_( 'SWT_TOURNAMENTS' ));
		$arena_code	= clm_core::$load->request_string('arena_code', '');
		$current_turnier	= clm_core::$load->request_string('turnier', '');
		
		foreach($turniere as $turnier)	{
			$sf1 = strpos($turnier->bem_int, 'SWT-Importfile:');
			$sf2 = strpos($turnier->bem_int, '.SWT');
			if ($sf2 === false) $sf2 = strpos($turnier->bem_int, '.swt');
			if (!($sf1 === false) AND !($sf2 === false) AND ($sf1 < $sf2))
				$filename = substr($turnier->bem_int, ($sf1 + 15), ($sf2 + 4 - ($sf1 + 15) ));
			else $filename = '';
//			if ($filename == $swm_file)	$current_turnier = $turnier->id;
			$current_turnier = 0;

			$options_turniere[]		= JHtml::_('select.option', $turnier->id, $turnier->name);
		}
		
		$lists['saisons']	= JHtml::_('select.genericlist', $options_saisons, 'filter_saison', 'class="inputbox" onchange="this.form.submit();"', 'value', 'text', $state->get('filter_saison') );
		//$lists['turniere']	= JHtml::_('select.genericlist', $options_turniere, 'turnier', 'class="inputbox"', 'value', 'text', 0 );
		$lists['turniere']	= JHtml::_('select.genericlist', $options_turniere, 'turnier', 'class="inputbox"', 'value', 'text', $current_turnier );
		
		//Daten an Template
		$this->lists = $lists;
				
		parent::display($tpl);
	}
	
}

?>
