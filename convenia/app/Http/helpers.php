<?php

function format_real($valor)
{
	return str_replace(',','.',str_replace('.','',$valor));
}