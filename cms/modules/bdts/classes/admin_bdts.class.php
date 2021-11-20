<?php
class admin_bdts {

    private $zzurl = [
        'add' => 'http://data.zz.baidu.com/urls',
        'edit' => 'http://data.zz.baidu.com/update',
        'del' => 'http://data.zz.baidu.com/del',
    ];


    private $zzconfig;

    // 配置信息
    public function getConfig() {

        if ($this->zzconfig) {
            return $this->zzconfig;
        }

        if (is_file(CACHE_PATH.'caches_bdts/bdts.php')) {
            $this->zzconfig = require CACHE_PATH.'caches_bdts/bdts.php';
            return $this->zzconfig;
        }

        return [];
    }

    // 配置信息
    public function setConfig($data) {

        $this->file(CACHE_PATH.'caches_bdts/bdts.php', '站长配置文件', 32)->to_require($data);

    }
    
    public function file($file, $name = '', $space = 32) {
        $this->file = $file;
        $this->space = $space;
        $this->header = '<?php'.
            PHP_EOL.PHP_EOL.
            '/**'.PHP_EOL.
            ' * '.$name.PHP_EOL.
            ' */'.PHP_EOL.PHP_EOL
        ;
        return $this;
    }
    
    public function to_require($data) {

        $body = $this->header.'return ';
        $body .= str_replace(array('  ', ' '), array('    ', ' '), var_export($data, TRUE));
        $body .= ';';
        !is_dir(dirname($this->file)) && create_folder(dirname($this->file));

        // 重置Zend OPcache
        function_exists('opcache_reset') && opcache_reset();

        return @file_put_contents($this->file, $body, LOCK_EX);
    }

    // 进行百度推送
    public function module_bdts($mid, $url, $action = 'add', $code = '') {
        $siteid = get_siteid() ? get_siteid() : 1 ;

        $config = $this->getConfig();
        if (!$config) {
            if ($code) {
                dr_json(0, L('百度推送配置为空，不能推送'));
            }
            return;
        } elseif (!in_array($mid, $config['use'])) {
            if ($code) {
                dr_json(0, L('模块【'.$mid.'】百度推送配置没有开启，不能推送'));
            }
            return;
        }

        // pc域名
        $purl = $url;
        $uri = parse_url($purl);
        $site = $uri['host'];
        if (!$site) {
            if ($code) {
                dr_json(0, L('百度推送没有获取到内容url（'.$purl.'）的host值，不能推送'));
            }
            return;
        }

        // 获取移动端域名
        $murl = str_replace(siteurl($siteid), sitemobileurl($siteid), $url);
        $uri = parse_url($murl);
        $m_site = $uri['host'];
        if ($m_site && $m_site != $site) {
            $murl = str_replace($site, $m_site, $purl); // 替换移动端url
        } else {
            $m_site = '';
        }

        // 百度主动推送
        if ($config['bdts']) {
            $token = '';
            $m_token = '';
            foreach ($config['bdts'] as $t) {
                if ($t['site'] == $site && !$token) {
                    $token = $t['token'];
                }
                if ($m_site && $t['site'] == $m_site && !$m_token) {
                    $m_token = $t['token'];
                }
            }
            if ($token) {
                // pc域名
                if (strpos($purl, siteurl($siteid)) === false ) {
                    @file_put_contents(CACHE_PATH.'caches_bdts/bdts_log.php', date('Y-m-d H:i:s').' PC端['.$purl.'] - 域名规范或者域名不是PC域名（'.siteurl($siteid).'） - 未推送 '.PHP_EOL, FILE_APPEND);
                } else {
                    $api = $this->zzurl[$action].'?site='.$site.'&token='.$token;
                    $urls = [$purl];
                    $ch = curl_init();
                    $options =  array(
                        CURLOPT_URL => $api,
                        CURLOPT_POST => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => implode("\n", $urls),
                        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
                    );
                    curl_setopt_array($ch, $options);
                    $rt = json_decode(curl_exec($ch), true);
                    if ($rt['error']) {
                        // 错误日志
                        @file_put_contents(CACHE_PATH.'caches_bdts/bdts_log.php', date('Y-m-d H:i:s').' PC端['.$purl.'] - 失败 - '.$rt['message'].PHP_EOL, FILE_APPEND);
                    } else {
                        // 推送成功
                        @file_put_contents(CACHE_PATH.'caches_bdts/bdts_log.php', date('Y-m-d H:i:s').' PC端['.$purl.'] - 成功'.PHP_EOL, FILE_APPEND);
                    }
                }
            }
            if ($m_token && $m_site) {
                // 移动端
                if (strpos($murl, sitemobileurl($siteid)) === false ) {
                    @file_put_contents(CACHE_PATH.'caches_bdts/bdts_log.php', date('Y-m-d H:i:s').' 移动端['.$murl.'] - 域名规范或者域名不是移动端域名（'.sitemobileurl($siteid).'） - 未推送 '.PHP_EOL, FILE_APPEND);
                } else {
                    $api = $this->zzurl[$action] . '?site=' . $m_site . '&token=' . $m_token;
                    $urls = [$murl];
                    $ch = curl_init();
                    $options = array(
                        CURLOPT_URL => $api,
                        CURLOPT_POST => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => implode("\n", $urls),
                        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
                    );
                    curl_setopt_array($ch, $options);
                    $rt = json_decode(curl_exec($ch), true);
                    if ($rt['error']) {
                        // 错误日志
                        @file_put_contents(CACHE_PATH . 'caches_bdts/bdts_log.php', date('Y-m-d H:i:s') . ' 移动端[' . $murl . '] - 失败 - ' . $rt['message'] . PHP_EOL, FILE_APPEND);
                    } else {
                        // 推送成功
                        @file_put_contents(CACHE_PATH . 'caches_bdts/bdts_log.php', date('Y-m-d H:i:s') . ' 移动端[' . $murl . '] - 成功' . PHP_EOL, FILE_APPEND);
                    }
                }
            }

        }

    }

}