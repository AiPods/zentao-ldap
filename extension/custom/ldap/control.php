<?php

class ldap extends control
{
    public $referer;

    /**
     * Construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->locate(inlink('setting'));
    }

    public function setting()
    {
        $this->view->title = $this->lang->ldap->common . $this->lang->colon . $this->lang->ldap->setting;
        $this->view->position[] = html::a(inlink('index'), $this->lang->ldap->common);
        $this->view->position[] = $this->lang->ldap->setting;

        $this->display();
    }

    public function save()
    {
        if (!empty($_POST)) {
            $this->config->ldap->host = $this->post->ldapHost;
            $this->config->ldap->port = $this->post->ldapPort;
            $this->config->ldap->bindDN = $this->post->ldapBindDN;
            $this->config->ldap->bindPWD = $this->post->ldapPassword;
            $this->config->ldap->baseDN = $this->post->ldapBaseDN;
            $this->config->ldap->searchFilter = $this->post->ldapFilter;
            $this->config->ldap->uid = $this->post->ldapAttr;
            $this->config->ldap->mail = $this->post->ldapMail;
            $this->config->ldap->name = $this->post->ldapName;

            // 此处我们把配置写入配置文件
            $ldapConfig = "<?php \n"
                . "\$config->ldap = new stdclass();\n"
                . "\$config->ldap->host = '{$this->post->ldapHost}';\n"
                . "\$config->ldap->port = '{$this->post->ldapPort}';\n"
                . "\$config->ldap->bindDN = '{$this->post->ldapBindDN}';\n"
                . "\$config->ldap->bindPWD = '{$this->post->ldapPassword}';\n"
                . "\$config->ldap->baseDN = '{$this->post->ldapBaseDN}';\n"
                . "\$config->ldap->searchFilter = '{$this->post->ldapFilter}';\n"
                . "\$config->ldap->uid = '{$this->post->ldapAttr}';\n"
                . "\$config->ldap->mail = '{$this->post->ldapMail}';\n"
                . "\$config->ldap->name = '{$this->post->ldapName}';\n";

            $file = fopen("config.php", "w") or die("Unable to open file!");
            fwrite($file, $ldapConfig);
            fclose($file);

            $this->locate(inlink('setting'));
            echo "alert('ok')";
        }
    }

    public function test()
    {
        echo $this->ldap->identify($this->post->host, $this->post->port, $this->post->dn, $this->post->pwd);
    }

    public function sync()
    {
        $users = $this->ldap->sync2db($this->config->ldap);
        echo $users;
    }

    public function identify($user, $pwd)
    {
        $ret = false;
        $account = $this->config->ldap->uid . '=' . $user . ',' . $this->config->ldap->baseDN;
        if (0 == strcmp('Success', $this->ldap->identify($this->config->ldap->host, $this->config->ldap->port, $account, $pwd))) {
            $ret = true;
        }

        echo $ret;
    }
}