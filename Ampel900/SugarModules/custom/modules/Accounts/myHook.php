<?php

class myHook 
{
    /**
     * My Function
     * @param SugarBean $seed a bean that fired event
     * @param string $event event name
     * @param array $arguments event arguments 
     */
    public function myFunction(SugarBean &$bean, $event, $arguments)
    {
		if ($event=="before_save")
		{
			$bean->ampel_scoring_c = rand(1,100);
		}
    }

}
