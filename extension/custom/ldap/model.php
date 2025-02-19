<?php
# 关闭密钥验证
putenv('LDAPTLS_REQCERT=never');
class ldapModel extends model
{
    public function getUserDn($config, $account)
    {
        $ret = null;
        $ds = ldap_connect($config->host, $config->port);
        if ($ds) {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind($ds, $config->bindDN, $config->bindPWD);
            $filter = "($config->uid=$account)";
            $rlt = ldap_search($ds, $config->baseDN, $filter);
            $count = ldap_count_entries($ds, $rlt);

            if ($count > 0) {
                $data = ldap_get_entries($ds, $rlt);
                $ret = $data[0]['dn'];
                $str = serialize($data);
            }

            ldap_unbind($ds);
            ldap_close($ds);
        }
        return $ret;
    }

    public function identify($host, $port, $dn, $pwd)
    {
        $ret = '';
        $ds = ldap_connect($host, $port);
        if ($ds) {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind($ds, $dn, $pwd);

            $ret = ldap_error($ds);
            ldap_close($ds);
        } else {
            $ret = ldap_error($ds);
        }

        return $ret;
    }

    public function getUsers($config)
    {
        $ds = ldap_connect($config->host, $config->port);
        if ($ds) {
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind($ds, $config->bindDN, $config->bindPWD);

            $attrs = [$config->uid, $config->mail, $config->name];

            $rlt = ldap_search($ds, $config->baseDN, $config->searchFilter, $attrs);
            $data = ldap_get_entries($ds, $rlt);
            return $data;
        }

        return null;
    }

    public function sync2db($config)
    {
        $ldapUsers = $this->getUsers($config);
        $user = new stdclass();
        $account = '';
        $i = 0;
        for (; $i < $ldapUsers['count']; $i++) {
            $user->account = $ldapUsers[$i][$config->uid][0];
            $user->email = $ldapUsers[$i][$config->mail][0];
            $user->realname = $ldapUsers[$i][$config->name][0];

            $account = $this->dao->select('*')->from(TABLE_USER)->where('account')->eq($user->account)->fetch('account');
            if ($account == $user->account) {
                $this->dao->update(TABLE_USER)->set('visits = visits + 1')->where('account')->eq($user->account)->exec();
                $this->dao->update(TABLE_USER)->data($user)->where('account')->eq($user->account)->autoCheck()->exec();
            } else {
                $user->type = "outside";
                $user->gender = "m";
                $this->dao->insert(TABLE_USER)->data($user)->autoCheck()->exec();
            }

            if (dao::isError()) {
                echo js::error(dao::getError());
                die(js::reload('parent'));
            }
        }

        return $i;
    }
}