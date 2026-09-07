{*
**
*  2009-2026 Arte e Informatica
*
*  For support feel free to contact us on our website at http://www.arteinformatica.eu
*
*  @author    Arte e Informatica <admin@arteinformatica.eu>
*  @copyright 2009-2026 Arte e Informatica
*  @version   1.0.0
*  @license   https://opensource.org/licenses/MIT MIT License
*
*}

<div class="panel artaddcss-admin-header">
    <div class="artaddcss-admin-header-main">
        <img
            src="{$module_logo_url|escape:'html':'UTF-8'}"
            alt="{$module_display_name|escape:'html':'UTF-8'}"
            class="artaddcss-admin-logo"
            width="72"
        >
        <div class="artaddcss-admin-title">
            <h2>{$module_display_name|escape:'html':'UTF-8'}</h2>
            <p>{$module_description|escape:'html':'UTF-8'}</p>
        </div>
    </div>
    <div class="artaddcss-admin-actions">
        <a
            href="{$readme_url|escape:'html':'UTF-8'}"
            class="btn btn-default"
            target="_blank"
            rel="noopener noreferrer"
        >
            <i class="icon icon-book"></i>
            {l s='Open README' mod='artaddcss'}
        </a>
        <a
            href="{$changelog_url|escape:'html':'UTF-8'}"
            class="btn btn-default"
            target="_blank"
            rel="noopener noreferrer"
        >
            <i class="icon icon-list"></i>
            {l s='Open changelog' mod='artaddcss'}
        </a>
    </div>
</div>
