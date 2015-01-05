<?php

class Shipbeat
{
    public function deliveries()
    {
        return new Shipbeat_Deliveries($this);
    }

    public function areas()
    {
        return new Shipbeat_Areas($this);
    }
}
