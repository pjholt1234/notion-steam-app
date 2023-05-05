<?php

function formatMarketHash(string $str): string
{
    return rawurlencode($str);
}

function formatMoneyCell($value): string
{
    if(isset($value)) {
        return '£'.$value;
    }

    return '';
}
