<?php

require_once('plugins/login-servers.php');

/** Set supported servers
  * @param array array($description => array("server" => , "driver" => "server|pgsql|sqlite|..."))
  */

return new AdminerLoginServers([
	"PostgreSQL 13" => ["server" => "sol_workspace_database", "driver" => "pgsql"],
]);
