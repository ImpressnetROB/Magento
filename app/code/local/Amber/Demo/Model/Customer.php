<?php
class Amber_Demo_Model_Customer extends Mage_Customer_Model_Customer {
		public function getThem(){
			$collection = Mage::getResourceModel('customer/customer_collection');
			echo "<br/>";
		//	var_dump($collection);
 		foreach($collection as $customer)
		{
			$fullcustomer = Mage::getModel("customer/customer")->load($customer->getId());
			$lista = ($fullcustomer->getId().' '.$fullcustomer->getFirstname().' '.$fullcustomer->getLastname().' , email:  '.$fullcustomer->getEmail().'  Created at:  '.$fullcustomer->getCreated_at());
			echo $lista,'<br/>';
		}
	}
}