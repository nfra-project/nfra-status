<?php

namespace App;


use Nfra\Status\Type\TContainer;
use Nfra\Status\Type\TOutput;

require __DIR__ . "/../vendor/autoload.php";

$result = phore_yaml_decode(file_get_contents(__DIR__ . "/../watchlist.yml"));

$outfile = phore_file(__DIR__ . "/../docs/security.json");
if ( ! $outfile->exists())
    $outfile->set_json((array)new TOutput());
$output = phore_hydrate($outfile->get_json(), TOutput::class);
assert($output instanceof TOutput);


foreach ($result["watch"] as $container) {
    $containerName = $container["name"];
    foreach ($container["tags"] as $tag) {
        phore_out("Running security check on '$containerName:$tag'...");
        phore_exec("sudo docker pull ?", ["$containerName:$tag"]);
        $result = phore_exec("sudo docker run -it --entrypoint /kickstart/bin/security-scan.sh ?", ["$containerName:$tag"]);

        $obj = TContainer::select($output->container, ["name" => $containerName, "tag" => $tag]);

        if ($result === "") {
            echo " No update required.";
            $obj->packages_affected = [];
            $obj->update_required = false;
            continue;
        }
        if ($obj->update_required === false) {
            $obj->date_open = date("Y-m-d");
        }
        $obj->update_required = true;
        $obj->packages_affected = [];
        echo $result;
    }
}
$output->last_check = date("Y-m-d");
$outfile->set_json((array)$output);
phore_out("done");