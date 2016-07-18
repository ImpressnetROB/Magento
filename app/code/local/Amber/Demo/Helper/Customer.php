<?php
class Amber_Demo_Helper_Customer {
	public function getCustomerlist(){
		$collection = Mage::getResourceModel('customer/customer_collection');
			echo "<br/>";

 		foreach($collection as $customer)
		{
			$fullcustomer = Mage::getModel("customer/customer")->load($customer->getId());
			$lista = ($fullcustomer->getId().' '.$fullcustomer->getFirstname().' '.$fullcustomer->getLastname().' , email:  '.$fullcustomer->getEmail().'  Created at:  '.$fullcustomer->getCreated_at());
			echo $lista,'<br/>';
		}
		
	}
}