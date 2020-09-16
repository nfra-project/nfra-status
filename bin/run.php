<?php

require __DIR__ . "/../vendor/autoload.php";

$result = phore_yaml_decode(file_get_contents(__DIR__ . "/../watchlist.yml"));

$outfile = phore_file(__DIR__ . "/../docs/security.json");
if ( ! $outfile->exists())
    $outfile->set_json([]);
$outData = $outfile->get_json();

foreach ($result["watch"] as $container) {
    $containerName = $container["name"];
    foreach ($container["tags"] as $tag) {
        phore_out("Running security check on '$containerName:$tag'...");
        phore_exec("sudo docker pull ?", ["$containerName:$tag"]);
        $result = phore_exec("sudo docker run -it --entrypoint /kickstart/bin/security-scan.sh ?", ["$containerName:$tag"]);
        if ($result === "") {
            echo " No update required.";
        }
        echo $result;
    }
}