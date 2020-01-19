<?php
/**
 * @ Chess League Manager (CLM) Component 
 * @Copyright (C) 2008-2019 CLM Team.  All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.chessleguemanager.de
 * @author Thomas Schwietert
 * @email fishpoke@fishpoke.de
 * @author Andreas Dorn
 * @email webmaster@sbbl.org
*/
defined('_JEXEC') or die('Restricted access');

class CLMModelTurRegistrationEdit extends JModelLegacy {


	// benötigt für Pagination
	function __construct() {
		
		parent::__construct();


		// user
		$this->user =JFactory::getUser();
		
		// get parameters
		$this->_getParameters();

		// get Player
		$this->_getRegistrationData();
		
		// get turnier
		$this->_getTurnierData();

		

	}


	// alle vorhandenen Parameter auslesen
	function _getParameters() {
	
		// registrationid
		$this->param['registrationid'] = clm_core::$load->request_int('registrationid');
	
	}

	
	function _getRegistrationData() {
	
		$query = 'SELECT * '
			. ' FROM #__clm_online_registration'
			. ' WHERE id = '.$this->param['registrationid']
			;
		$this->_db->setQuery($query);
		$this->registrationData = $this->_db->loadObject();
	
	}


	function _getTurnierData() {
	
		$query = 'SELECT * '
			. ' FROM #__clm_turniere'
			. ' WHERE id = '.$this->registrationData->tid
			;
		$this->_db->setQuery($query);
		$this->turnierData = $this->_db->loadObject();
	
	}


}

?>
