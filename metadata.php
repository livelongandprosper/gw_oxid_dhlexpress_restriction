<?php
/**
 * @abstract
 * @author 	Gregor Wendland <gregor@gewend.de>
 * @copyright Copyright (c) 2018, Gregor Wendland
 * @package gw
 * @version 2018-11-12
 */

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'           => 'gw_oxid_dhlexpress_restriction',
    'title'        => 'DHL Express Beschränkung',
//     'thumbnail'    => 'out/admin/img/logo.jpg',
    'version'      => '1.0.0',
    'author'       => 'Gregor Wendland',
    'email'		   => 'kontakt@gewend.de',
    'url'		   => 'https://www.gewend.de',
    'description'  => array(
    	'de'		=> 'DHL Express Versandart beschränken<ul>
							<li>Nur Bestellungen erlauben, bei denen die Artikel auch so viel Bestand haben, wie im Warenkorb vorhanden</li>
							<li>Abo-Bestellungen verbieten (Abo Modul von exonn.de)</li>
							<li>Postleitzahlen ausschließen</li>
						</ul>',
    ),
    
    /* extend */
    'extend'       => array(
	    // models
 		'oxdeliverylist' 		=> 'gw/gw_oxid_dhlexpress_restriction/application/models/gw_oxid_dhlexpress_restriction_oxdeliverylist',
    ),
    /* settings */
    'settings'		=> array(
		array( 'group' => 'gw_oxid_dhlexpress_restriction_settings', 	'name' => 'gw_oxid_dhlexpress_restriction_delivery_methods', 'type' => 'arr', 'value' => array("6758ef953edbad2f0f2c18dc8fb2c9b1")),
		array( 'group' => 'gw_oxid_dhlexpress_restriction_settings', 	'name' => 'gw_oxid_dhlexpress_restriction_zipcodes', 'type' => 'arr', 'value' => array("17406","18574","25996","17419","18581","25997","17424","18586","25999","17429","18609","26465","17440","23769","26474","17449","23999","26486","17454","25849","26548","17459","25859","26571","18528","25863","26579","18546","25867","26757","18551","25869","27498","18556","25938","27499","18565","25946","18569","25980","18573","25992",)),
    ),

	/* events */
	'events'		=> array(
    ), 

    /* files */
    'files'			=> array(
    ),

    'blocks'		=> array(
		/* admin blocks */
    ),

    /* templates */
	'templates'		=> array(
		
		/* admin */
// 		'gw_actions_main.tpl'				=> 'gw/gw_unq_functions/application/views/admin/tpl/gw_actions_main.tpl',
    )
    
);
?>