<?php
/**
 * cms缓存
 */

class cachefile {
    protected $path;
    protected $mode;

    public function __construct() {

        $this->path = CACHE_PATH.'caches_file/caches_data/';
        $this->path = rtrim($this->path, '/') . '/';

        if (!$this->is_really_writable($this->path)) {
            return false;
        }

        $this->mode   = 0777;
    }

    public function get(string $key) {
        $data = $this->getItem($key);

        return is_array($data) ? $data['data'] : null;
    }

    public function save(string $key, $value, int $ttl = 60) {

        !is_dir($this->path) ? create_folder($this->path, 0777) : '';
        $contents = [
            'time' => time(),
            'ttl'  => $ttl,
            'data' => $value,
        ];

        if ($this->writeFile($this->path . $key, serialize($contents)))
        {
            try
            {
                chmod($this->path . $key, $this->mode);
            }
            catch (Throwable $e)
            {
                log_message('error', 'Failed to set mode on cache file: ' . $e->getMessage());
            }

            return true;
        }

        return false;
    }

    public function delete(string $key) {

        return is_file($this->path . $key) && unlink($this->path . $key);
    }

    public function clean() {
        return $this->deleteFiles($this->path, false, true);
    }

    protected function getItem(string $filename) {
        if (! is_file($this->path . $filename))
        {
            return false;
        }

        $data = @unserialize(file_get_contents($this->path . $filename));
        if (! is_array($data) || ! isset($data['ttl']))
        {
            return false;
        }

        if ($data['ttl'] > 0 && SYS_TIME > $data['time'] + $data['ttl'])
        {
            if (is_file($this->path . $filename))
            {
                @unlink($this->path . $filename);
            }

            return false;
        }

        return $data;
    }

    protected function writeFile($path, $data, $mode = 'wb') {
        if (($fp = @fopen($path, $mode)) === false)
        {
            return false;
        }

        flock($fp, LOCK_EX);

        for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result)
        {
            if (($result = fwrite($fp, substr($data, $written))) === false)
            {
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return is_int($result);
    }

    protected function deleteFiles(string $path, bool $delDir = false, bool $htdocs = false, int $_level = 0): bool {
        $path = rtrim($path, '/\\');

        if (! $currentDir = @opendir($path))
        {
            return false;
        }

        while (false !== ($filename = @readdir($currentDir)))
        {
            if ($filename !== '.' && $filename !== '..')
            {
                if (is_dir($path . DIRECTORY_SEPARATOR . $filename) && $filename[0] !== '.')
                {
                    $this->deleteFiles($path . DIRECTORY_SEPARATOR . $filename, $delDir, $htdocs, $_level + 1);
                }
                elseif ($htdocs !== true || ! preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $filename))
                {
                    @unlink($path . DIRECTORY_SEPARATOR . $filename);
                }
            }
        }

        closedir($currentDir);

        return ($delDir === true && $_level > 0) ? @rmdir($path) : true;
    }
    protected function is_really_writable(string $file): bool
    {
        if (DIRECTORY_SEPARATOR === '/' || ! ini_get('safe_mode'))
        {
            return is_writable($file);
        }
        if (is_dir($file))
        {
            $file = rtrim($file, '/') . '/' . bin2hex(random_bytes(16));
            if (($fp = @fopen($file, 'ab')) === false)
            {
                return false;
            }

            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);

            return true;
        }

        if (! is_file($file) || ($fp = @fopen($file, 'ab')) === false)
        {
            return false;
        }

        fclose($fp);

        return true;
    }
}
