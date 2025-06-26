<?php

namespace App\Entity\Traits;

use App\Entity\Customer;

trait CustomerTrait
{
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
