<?php
class Codewpx_AIL_Main {
    public function __construct() {
        new Codewpx_AIL_Admin();
        new Codewpx_AIL_Public();
    }
}