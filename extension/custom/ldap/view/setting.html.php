<?php
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php'; ?>
<?php include $app->getModuleRoot() . 'common/view/datepicker.html.php'; ?>
<div class='container mw-700px'>
    <div id='titlebar'>
        <div class='heading'>
            <span class='prefix'>
                <?php echo html::icon($lang->icons['mail']); ?>
            </span>
            <strong>
                <?php echo $lang->ldap->common; ?>
            </strong>
            <small class='text-muted'>
                <?php echo $lang->ldap->setting; ?>
                <?php echo html::icon('cog'); ?>
            </small>
        </div>
    </div>
    <form class='form-condensed pdt-20' method='post' action='<?php echo inlink('save'); ?>'>
        <table class='table table-form'>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->host; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapHost', $config->ldap->host, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->port; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapPort', $config->ldap->port, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->bindDN; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapBindDN', $config->ldap->bindDN, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->password; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::password('ldapPassword', $config->ldap->bindPWD, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <td class='w-p25'></td>
                <td class="text-right">
                    <label id='testRlt'></label>
                    <button type='button' onclick='javascript:onClickTest()' class='btn '>测试连接</button>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->baseDN; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapBaseDN', $config->ldap->baseDN, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->filter; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapFilter', $config->ldap->searchFilter, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->attributes; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapAttr', $config->ldap->uid, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->mail; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapMail', $config->ldap->mail, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <th class='w-p25'>
                    <?php echo $lang->ldap->name; ?>
                </th>
                <td class='w-p50'>
                    <?php echo html::input('ldapName', $config->ldap->name, "class='form-control'"); ?>
                </td>
            </tr>
            <tr>
                <td class='w-p25'></td>
                <td class="text-center">
                    <?php
                    echo html::submitButton($lang->ldap->save);
                    echo html::commonButton($lang->ldap->sync, 'onclick="javascript:sync()"');
                    ?>
                </td>
            </tr>

        </table>
    </form>
</div>
<?php include '../../common/view/footer.html.php'; ?>

<?php
echo '<script>';
include '../js/setting.js';
echo '</script>';
; ?>