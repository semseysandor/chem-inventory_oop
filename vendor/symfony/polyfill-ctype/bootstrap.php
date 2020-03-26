<?php

/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

use Symfony\Polyfill\Ctype as p;

if (!function_exists('ctype_alnum')) {
    function ctype_alnum($text) { return p\Ctype::ctype_alnum($text); }
    function ctype_alpha($text) { return p\Ctype::ctype_alpha($text); }
    function ctype_cntrl($text) { return p\Ctype::ctype_cntrl($text); }
    function ctype_digit($text) { return p\Ctype::ctype_digit($text); }
    function ctype_graph($text) { return p\Ctype::ctype_graph($text); }
    function ctype_lower($text) { return p\Ctype::ctype_lower($text); }
    function ctype_print($text) { return p\Ctype::ctype_print($text); }
    function ctype_punct($text) { return p\Ctype::ctype_punct($text); }
    function ctype_space($text) { return p\Ctype::ctype_space($text); }
    function ctype_upper($text) { return p\Ctype::ctype_upper($text); }
    function ctype_xdigit($text) { return p\Ctype::ctype_xdigit($text); }
}
