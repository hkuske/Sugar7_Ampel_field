{*
/*********************************************************************************
 AMPEL
 ********************************************************************************/
*}
{assign var="value" value=$parentFieldArray.$col }
{assign var="range_min" value=$vardef.range_min }
{assign var="range_max" value=$vardef.range_max }
{if empty($value) || $value==0}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_b.png" />
{elseif $value < $range_min}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_r.png" />
{elseif $value >= $range_min && $value < $range_max}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_y.png" />
{elseif $value >= $range_max}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_g.png" />
{/if}
