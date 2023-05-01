<?php

function formatMarketHash(string $str): string
{
    return rawurlencode($str);
}
