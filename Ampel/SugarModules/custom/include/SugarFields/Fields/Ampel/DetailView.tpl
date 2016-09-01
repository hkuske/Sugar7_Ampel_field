{*
/*********************************************************************************
 AMPEL
 ********************************************************************************/
*}
<span class="sugar_field" id="{{sugarvar key='name'}}">
{assign var="value" value={{sugarvar key='value' string=true}} }
{assign var="range_min" value={{sugarvar key='range_min' string=true}} }
{assign var="range_max" value={{sugarvar key='range_max' string=true}} }
{if $value > 0 && $value < $range_min}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_r.png" />
{elseif $value >= $range_min && $value < $range_max}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_y.png" />
{elseif $value >= $range_max}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_g.png" />
{else}
<img src="custom/include/SugarFields/Fields/Ampel/ampel_b.png" />
{/if}
</span>
