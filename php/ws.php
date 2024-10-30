<?php
/* Appel webservice */
function mk_connexion(){
	try{
		$tab		= mk_read_id();
		$service 	= new SoapClient("http://webservices.mailkitchen.com/server.wsdl", array('trace' => 1, 'soap_version'   => SOAP_1_2));
		$token = $service->SimpleAuthenticate($tab['pass']);
		return array("service"=>$service,"token"=>$token);
	}
	catch (SoapFault $exception) {
		echo 'ERREUR : ' . $exception->faultcode . ' => ' . $exception->getMessage();
		echo "\n\n\n\n";
		print_r($service->__getLastResponse());
	}
}

function view_member_list(){
	$liste = array();
	try{
		$tab = mk_connexion();
		$service=$tab['service'];
		$token=$tab['token'];
		$liste=$service->GetSubscriberLists();
		return $liste;
	}
	catch (SoapFault $exception) {
		echo 'ERREUR : ' . $exception->faultcode . ' => ' . $exception->getMessage();
		echo "\n\n\n\n";
		print_r($service->__getLastResponse());
	}
}

function insert_member($numform,$membre) {
	$tab	= mk_read_id();
	$form 	= mk_read_form($numform);
	$listeDiff = $form ['list_name'];
	try{
		$tab = mk_connexion();
		$service=$tab['service'];
		$token=$tab['token'];
		$donnees = array (
			'header'	=> array ('email'),
			'datas'		=> array (
				0 => array($membre),
			)
		);
		$listeListeDiffusion = array($listeDiff);
		
		if ($service->IsMemberInList($membre, $listeDiff)) {
			return 0;
		}
		else{
			$liste = $service->ImportMember($listeListeDiffusion, $donnees);
			return 1;
		}
	}
	catch (SoapFault $exception) {
		echo 'ERREUR : ' . $exception->faultcode . ' => ' . $exception->getMessage();
		echo "\n\n\n\n";
		print_r($service->__getLastResponse());
		return "error";
	}
}



?>