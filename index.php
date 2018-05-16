<?php

/*
 * MyPac
 * Dynamic Proxy auto-config (PAC) manager  
 * https://github.com/hamidsamak/mypac
 */

header('Content-Type: application/x-ns-proxy-autoconfig');
header('Content-Disposition: inline; filename="mypac.pac"');

?>
function FindProxyForURL(url, host) {
	var servers = [<?php

	$servers = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'servers.txt');
	$servers = explode("\n", $servers);
	$servers = array_map('trim', $servers);
	$servers = array_filter($servers);

	if (count($servers) > 0)
		print '"' . implode('", "', $servers) . '"';

	?>];

	var domains = [<?php
	
	$domains = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'domains.txt');
	$domains = explode("\n", $domains);
	$domains = array_map('trim', $domains);
	$domains = array_filter($domains);

	if (count($domains) > 0)
		print '"' . implode('", "', $domains) . '"';

	?>];

	for (var i = 0; i < domains.length; i++)
		if (shExpMatch(host, domains[i]))
			return servers.join(", ");

	return "DIRECT";
}