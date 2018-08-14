<?php 

/*
 * HELPERS
 */


function checkRole($role){
	$user_meta= get_userdata(get_current_user_id());
	$user_roles= is_array($user_meta->roles) ? $user_meta->roles : array($user_meta->roles) ;
	return in_array($role,$user_roles); 
};

function isCurrentUserCapoarea(){
	return checkRole('capo_area');
}

function isCurrentUserEvoluter(){
	return checkRole('evoluter');
}


function calcolaPercentuale($cifra,$percentuale){
	return $cifra * $percentuale / 100;
}

/**
 * toglie l'IVa da un prezzo
 * @param unknown $cifra
 * @return number
 */
function togliIVA($cifra){
	return $cifra / 1.22;
}

/**
 * true | false se la variazione è un prodotto originale
 * @param unknown $sku
 * @return unknown
 */
function isOriginalSKU($sku){
	return strstr(strtolower($sku), 'orig');
}

