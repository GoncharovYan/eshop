<?php

namespace Cache;

class FileCache
{
    public function set(string $key, mixed $value, int $ttl = 60): void
    {
        $hash = sha1($key);
        $path = ROOT . '/var/cache/' . $hash . '.php';
        $data =[
            'data' => $value,
            'ttl' => time() + $ttl,
        ];
        file_put_contents($path, serialize($data));
    }

    public function get(string $key): mixed
    {
        $hash = sha1($key);
        $path = ROOT . '/var/cache/' . $hash . '.php';


        if(!file_exists($path))
        {
            return null;
        }

        $data = unserialize(file_get_contents($path));

        $ttl = $data['ttl'];
        if (time() > $ttl)
        {
            return null;
        }

        return $data['data'];
    }

    public function remember(string $key, int $ttl, \Closure $fetcher)
    {
        $data = $this->get($key);

        if($data === null)
        {
            $value = $fetcher();
            $this->set($key,$value,$ttl);
            return $value;
        }
        else
        {
            return $data;
        }
    }

    public function delete(string $key): void
    {
        $hash = sha1($key);
        $path = ROOT . '/var/cache/';
        unlink($path . $hash . '.php');
    }

    public function deleteAll()
    {

    }
}