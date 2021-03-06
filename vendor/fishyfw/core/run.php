<?php

/*
 * Copyright 2008 Wilker Lucio <wilkerlucio@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License. 
 */

//set some system definitios
define('FISHY_SYSTEM_CLASS_PREFIX', 'Fishy_');

//load core exceptions
require_once FISHY_SYSTEM_CORE_PATH . '/core_exceptions.php';

//some simple usefull helpers functions
require_once FISHY_SYSTEM_CORE_PATH . '/core_helpers.php';

//autoloader for classes
include_once FISHY_SYSTEM_CORE_PATH . '/autoloader.php';


//load uri
$current_uri = Fishy_Uri::get_querystring();


//load configuration basics
$conf = include FISHY_CONFIG_PATH . '/config.php';

define('FISHY_BASE_URL', $conf->base_url);
define('FISHY_INDEX_PAGE', $conf->index_page);


//load router configuration
$router_conf = require_once FISHY_CONFIG_PATH . '/router.php';

$ROUTER = new UserRouter();

//load slice routes
$glob = glob(FISHY_SLICES_PATH . "/*/config/router.php");


if ($glob) {
	foreach ($glob as $router) {
		include_once $router;
	}
}

try {
	$current_route = $ROUTER->match($current_uri);

} catch (Fishy_RouterException $e) {
	dispatch_error($e, 404);
}


//disable magic quotes
include_once FISHY_SYSTEM_CORE_PATH . '/magic_quotes.php';

//transform upload format
include_once FISHY_SYSTEM_CORE_PATH . '/upload_transform.php';

//load database
require_once FISHY_SYSTEM_DATABASE_PATH . '/ActiveRecord.php';

$db_conf = include FISHY_CONFIG_PATH . '/db.php';

FieldAct::set_upload_path(FISHY_UPLOAD_PATH . '/');
DBCommand::configure($db_conf->host, $db_conf->user, $db_conf->password, $db_conf->database);

//if your submodules needs to do something, this is the time!
$glob = glob(FISHY_SLICES_PATH . "/*/config/setup.php");


if ($glob) {
	foreach ($glob as $setup) {
		include_once $setup;
	}
}


//run!
try {

	Fishy_Controller::run($current_route);


} catch (Exception $e) {
	echo $e->getMessage();
	//dispatch_error($e);
}
