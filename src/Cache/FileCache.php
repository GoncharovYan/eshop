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
        $path = ROOT . '/var/cache/' . $hash / '.php';

        if(!file_exists($path))
        {
            return null;
        }

        $data = unserialize(file_get_contents($path),['allowed_classes' => false]);
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
            $this->get($key,$value,$ttl);
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

        unlink($path . $hash / '.php');
    }

    public function deleteAll()
    {
        $path = ROOT . '/var/cache/';
        $files = scandir($path);
        foreach ($files as $file)
        {
            unlink($path . $file);
        }
    }
}