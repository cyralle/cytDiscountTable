<?php

namespace cytDiscountTable\Traits;

use Plenty\Modules\Plugin\Storage\Contracts\StorageRepositoryContract;

trait LoggingTrait
{

    public function LOG_write($method, $prop, $value)
    {
        $repository = pluginApp(StorageRepositoryContract::class);
        $key = 'log.csv';
        $pluginname = $this->getNamespace();
        $DTformat = 'c';
        $date = date($DTformat);
        $publicVisible = true;
        $body = "date/time" . "\t" . "method" . "\t" . "prop" . "\t" . "value" . "\n";
        if ($repository->doesObjectExist($pluginname, $key, $publicVisible)) {
            $curr = $repository->getObject($pluginname, $key, $publicVisible);
            $body = $curr->body;
        }
        if (!is_string($value)) {
            $value = json_encode($value);
        }
        $body .= $date . "\t" . $method . "\t" . $prop . "\t" . $value . "\n";
        $result = $repository->uploadObject($pluginname, $key, $body, $publicVisible, []);

        return $result;
    }

    public function LOG_delete() 
    {
        $repository = pluginApp(StorageRepositoryContract::class);
        $key = 'log.csv';
        $pluginname = $this->getNamespace();
        if ($repository->doesObjectExist($pluginname, $key, true)) {
            $res = $repository->deleteObject($pluginname, $key, true);
            $result = "$file deleted!<br>";
        } else {
            $result = "$file not found!<br>";
        }
        return $result;
    }

    public function LOG_url()
    {
        $repository = pluginApp(StorageRepositoryContract::class);
        $publicVisible = true;
        $pluginname = $this->getNamespace();
        $key = "log.csv";
        if ($repository->doesObjectExist($pluginname, $key, $publicVisible)) {
            $result = $repository->getObjectUrl($pluginname, $key, $publicVisible);
        } else {
            $result = null;
        }
        return $result;
    }
    
    public function getNamespace() {
        return substr(__NAMESPACE__, 0, strpos(__NAMESPACE__, '\\'));
    }

    protected function getBoolean( string $value, bool $default = false ) : bool
    {

        if ( $value === "true" || $value === "false" ) {
            return $value === "true";
        }

        return $default;
    }

}