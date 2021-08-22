<?php
defined('BASEPATH') or exit('No direct script access allowed');

function rupiah($rp)
{
    return number_format($rp, 0, ".", ".");
}
