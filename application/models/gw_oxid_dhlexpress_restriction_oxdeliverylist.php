<?php
/**
 * gw_oxid_dhlexpress_restriction
 *
 * @abstract
 * @author 	Gregor Wendland <kontakt@gewend.de>
 * @copyright Copyright (c) 2018 Gregor Wendland
 * @package gw_oxid_dhlexpress_restriction
 * @version 2018-11-12
 */

/**
 * Class gw_oxid_dhlexpress_restriction_oxdelivery
 */
	class gw_oxid_dhlexpress_restriction_oxdeliverylist extends gw_oxid_dhlexpress_restriction_oxdeliverylist_parent {


		/**
		 * Check the restricted Deliverysets
		 * - articles have to be on stock
		 *
		 * Original:
		 * Checks if deliveries in list fits for current basket and delivery set
		 *
		 * @param $oBasket
		 * @param $oUser
		 * @param $sDelCountry
		 * @param $sDeliverySetId
		 * @return bool
		 */
		public function hasDeliveries($oBasket, $oUser, $sDelCountry, $sDeliverySetId) {
			$parent_return =  parent::hasDeliveries($oBasket, $oUser, $sDelCountry, $sDeliverySetId);
			$oConfig = $this->getConfig();
			$restricted_delivery_methods = $oConfig->getConfigParam('gw_oxid_dhlexpress_restriction_delivery_methods');
			$restricted_zip_codes = $oConfig->getConfigParam('gw_oxid_dhlexpress_restriction_zipcodes');

			// check if this is a restricted delivery method
			if(is_array($restricted_delivery_methods) && in_array($sDeliverySetId, $restricted_delivery_methods)) {
				// check if this is a abo order
				if(oxRegistry::getSession()->getVariable("abo") == 1) {
					return false;
				}

				// check if each basket content element is on stock
				$basket_contents = $oBasket->getContents();
				if(sizeof($basket_contents) > 0) {
					foreach($basket_contents as $basket_element) {
						$oArticle = $basket_element->getArticle();
						if($basket_element->getAmount() > $oArticle->oxarticles__oxstock->value) {
							return false;
						}
					}
				}

				// check for zip codes that are forbidden
				$delivery_zip = null;
				$delivery_street = null;
				$delivery_firstname = null;
				$delivery_lastname = null;
				$delivery_company = null;
				$delivery_addinfo = null;

				if(!$oUser->getSelectedAddressId()) {
					$delivery_zip = $oUser->oxuser__oxzip->value;
					$delivery_street = $oUser->oxuser__oxstreet->value;
					$delivery_firstname = $oUser->oxuser__oxfname->value;
					$delivery_lastname = $oUser->oxuser__oxlname->value;
					$delivery_company = $oUser->oxuser__oxcompany->value;
					$delivery_addinfo = $oUser->oxuser__oxaddinfo->value;
				} else {
					$delivery_address = oxNew('oxaddress');
					$delivery_address->load($oUser->getSelectedAddressId());
					$delivery_zip = $delivery_address->oxaddress__oxzip->value;
					$delivery_street = $delivery_address->oxaddress__oxstreet->value;
					$delivery_firstname = $delivery_address->oxaddress__oxfname->value;
					$delivery_lastname = $delivery_address->oxaddress__oxlname->value;
					$delivery_company = $delivery_address->oxaddress__oxcompany->value;
					$delivery_addinfo = $delivery_address->oxaddress__oxaddinfo->value;
				}
				if(is_array($restricted_zip_codes) && in_array($delivery_zip,$restricted_zip_codes)) {
					return false;
				}

				// pack stations are forbidden
				if(
						stripos($delivery_street, "Packstation") !== false
					||	stripos($delivery_street, "Postfiliale") !== false

					||	stripos($delivery_firstname, "Packstation") !== false
					||	stripos($delivery_firstname, "Postfiliale") !== false

					||	stripos($delivery_lastname , "Packstation") !== false
					||	stripos($delivery_lastname , "Postfiliale") !== false

					||	stripos($delivery_company, "Packstation") !== false
					||	stripos($delivery_company, "Postfiliale") !== false

					||	stripos($delivery_zip, "Packstation") !== false
					||	stripos($delivery_zip, "Postfiliale") !== false

					||	stripos($delivery_addinfo, "Packstation") !== false
					||	stripos($delivery_addinfo, "Postfiliale") !== false
				) {
					return false;
				}
			}

			return $parent_return;
		}
	}
?>