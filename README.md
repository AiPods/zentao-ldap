# zentao-ldap
## 版本修改：
 - 1.适配测试开源版-18.3
 - 2.增加自定义端口
 - 3.默认关闭ssl密钥校验
 - 4.默认导入为外部用户
## 使用说明：
 - 1.插件安装后，在后台页面会多出一个"LDAP"子页面，可在该页面配置LDAP服务器信息
 - 2.在LDAP配置页面可以测试是否能够正常连接LDAP服务器
 - 3.保存配置后，点击“手动同步”按钮，从LDAP服务器上同步用户信息
 - 4.同步用户信息以后，可以使用LDAP用户登录禅道
 - 5.本地用户，通过在账户名称前加“$”符号来登录禅道
 - 6.ssl加密服务器名需要加ldaps：//
 - 7.ldap属性名必须是全小写，例如displayName改为displayname
