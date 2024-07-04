<?php

namespace cytDiscountTable\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Http\Request;
use cytDiscountTable\Contracts\DiscountTableRepositoryContract;
use cytDiscountTable\Traits\LoggingTrait;

class ContentController extends Controller
{

    use LoggingTrait;
    
	public function version(Twig $twig)
    {
        return "DiscountTable - Version 0.1";
    }

    public function create(Request $request, DiscountTableRepositoryContract $repo): string
    {
        $data = $request->all();
        foreach($data["data"] as $item) {
            $entry = (array) ["clientClass" => $item[0], "prefix" => $item[1], "wmr" => $item[2], "kwr" => $item[3], "wkz" => $item[4], "pr" => $item[5] ];
            $this->LOG_write(__METHOD__, "\$entry", $entry);
            $newEntry = $repo->createEntry($entry);
        }

        //$newEntry = $repo->createEntry($request->all());
        //$this->LOG_write(__METHOD__, "\$all", $all);
        return "";//json_encode($all);
    }

    public function update(int $id, DiscountTableRepositoryContract $repo): string
    {
        $updateEntry = $repo->updateEntry($id);
        return json_encode($updateEntry);
    }

    public function delete(int $id, DiscountTableRepositoryContract $repo): string
    {
        $deleteEntry = $repo->deleteEntry($id);
        return json_encode($deleteEntry);
    }
    
    public function index(DiscountTableRepositoryContract $repo)
    {
        $debug = [];
        $stats = $repo->getEntries();
        return  $stats;
    }

    public function getLogUrl()
    {
        $result = $this->LOG_url();
        if (is_null($result)) {
            $result = "File does not exist!";
        }
        return $result;
    }

    public function deleteLog() {
        $result = $this->LOG_delete();
        return $result;
    }

}
