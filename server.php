<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * RESTful web service entry point. The authentication is done via header tokens.
 *
 * @package    webservice_restful
 * @copyright  Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * NO_DEBUG_DISPLAY - disable moodle specific debug messages and any errors in output
 */
define('NO_DEBUG_DISPLAY', true);
define('WS_SERVER', true);

require('../../config.php');
require_once("$CFG->dirroot/webservice/restful/locallib.php");

if (!webservice_protocol_is_enabled('restful')) {
    header("HTTP/1.0 403 Forbidden");
    debugging(
        'The server died because the web services or the REST protocol are not enable',
        DEBUG_DEVELOPER
    );
    die;
}

$config = get_config('webservice_restful');
$secondary_authorization_param_name = null;

if (
    isset($config->secondary_authorization_param_name) &&
    $config->secondary_authorization_param_name != ''
) {
    $secondary_authorization_param_name = $config->secondary_authorization_param_name;
}

$server = new webservice_restful_server(WEBSERVICE_AUTHMETHOD_PERMANENT_TOKEN, $secondary_authorization_param_name);
$server->run();
die;
