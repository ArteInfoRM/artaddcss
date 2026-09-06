<?php
/**
*  2009-2026 Arte e Informatica
*
*  For support feel free to contact us on our website at http://www.arteinformatica.eu
*
*  @author    Arte e Informatica <admin@arteinformatica.eu>
*  @copyright 2009-2026 Arte e Informatica
*  @license   https://opensource.org/licenses/MIT MIT License
*  @version   1.1.8
*/

if (!defined('_PS_VERSION_'))
exit;
 
class Artaddcss extends Module {
    public function __construct() {
        $this->name = 'artaddcss';
        $this->tab = 'front_office_features';
        $this->version = '1.1.8';
        $this->author = 'Tecnoacquisti.com';
        $this->need_instance = 0;
		$this->bootstrap = true;

        parent::__construct();
 
        $this->displayName = $this->l('Art Theme add CSS');
        $this->description = $this->l('Art Theme add CSS (Cascading Style Sheets) is a simple module for adding style (e.g., fonts, colors, spacing) to your Shop Theme');
    }
    public function install() {
		$query = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_."art_cssadd (
				 `id_configuration` int(10) NOT NULL AUTO_INCREMENT,
			     `id_shop` int(11) NOT NULL,
                 `name` varchar(254) NOT NULL,
				 `value` text,
                  PRIMARY KEY (`id_configuration`)
                 ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

       return parent::install() && 
	   $this->registerHook('displayHeader') &&
	   //$this->registerHook('backOfficeHeader') &&
	   //$this->registerHook('header') &&
	   DB::getInstance()->Execute($query) &&
	   Configuration::updateValue('ART_HEADER_FEATURE_ACTIVE', '0');
	   
    }
	
	public function uninstallDB()
	{
		return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'art_cssadd`');
	}
 
    public function uninstall()
    {
        return Configuration::deleteByName('ART_HEADER_FEATURE_ACTIVE') &&
            $this->uninstallDB() &&
            parent::uninstall();
    }

    public function getContent()
    {
        $id_shop = $this->context->shop->id;
        if (!is_numeric($id_shop)) {
            $id_shop = 1;
        }
        $output = null;
		
		
		if (Tools::isSubmit('submitSetting'))
		{
			$id_configuration = NULL;
			$art_rule = pSQL(Tools::getValue('ART_HEADER_FEATURE_ACTIVE'));
			
			if (Configuration::updateValue('ART_HEADER_FEATURE_ACTIVE', (int)$art_rule)) {
				$output .= $this->displayConfirmation($this->l('Settings updated'));	
				}
			else {
				$output .= $this->displayError($this->l('Settings failed.'));
				}
			
            $art_text = Tools::getValue('ART_HEADER_CODE');	
						
		
						
			$query = "SELECT `id_configuration` FROM `"._DB_PREFIX_."art_cssadd` WHERE `name` = 'ART_HEADER_CODE' AND `id_shop` = ".(int)$id_shop."";
							if ($results = Db::getInstance()->ExecuteS($query))
						
						foreach ($results as $row) {
							$id_configuration = $row['id_configuration'];		
														
							} 
						if ($id_configuration > 0){
							$query = "UPDATE `"._DB_PREFIX_."art_cssadd` SET `value` = '".pSQL($art_text)."' WHERE `name` = 'ART_HEADER_CODE'";
							Db::getInstance()->Execute($query);
						  					
							} else {
							$query = "INSERT INTO `"._DB_PREFIX_."art_cssadd`(`id_shop`, `name`, `value`) VALUES ('".(int)$id_shop."','ART_HEADER_CODE','".pSQL($art_text)."')";
							Db::getInstance()->Execute($query);	
							
							}											
						
				
		}

        $output .= $this->display(__FILE__, 'views/templates/admin/configure.tpl');
        $output .= $this->displayForm();
        $output .= $this->display(__FILE__, 'views/templates/admin/copyright.tpl');
        return $output;
							
		}

        public function hookDisplayHeader()
        {

		$id_shop = $this->context->shop->id;
		
	    if (!is_numeric($id_shop)) {
            $id_shop = 1;
        }
		
        $art_rule = (int)Configuration::get('ART_HEADER_FEATURE_ACTIVE');
		$query = "SELECT `value` FROM `"._DB_PREFIX_."art_cssadd` WHERE `name` = 'ART_HEADER_CODE' AND `id_shop` = ".(int)$id_shop."";
		$art_text = Db::getInstance()->getValue($query);					
							
		
		$this->smarty->assign(array(
			'art_rule' => $art_rule,
			'art_text' => $art_text
			));  
		return $this->display(__FILE__, 'artaddcss.tpl');
        }

        public function displayForm()
        {
            $fields_form = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('Configuration'),
                        'icon' => 'icon-cogs'
                    ),
                    'input' => array(
                        array(
                            'type' => 'textarea',
							'label' => $this->l('Custom Css Code'),
							'name' => 'ART_HEADER_CODE',
							'desc' => $this->l('Enter here the CSS code to add to your Template'),
							'rows' => 25,
					        'required' => true
                        ),
                        array(
                            'type' => 'switch',
                            'label' => $this->l('Enable Custom Css Code'),
                            'name' => 'ART_HEADER_FEATURE_ACTIVE',
                            'desc' => $this->l('Enables or disables custom CSS code'),
                            'values' => array(
                                array(
                                    'id' => 'active_on',
                                    'value' => 1,
                                    'label' => $this->l('Enabled')
                                ),
                                array(
                                    'id' => 'active_off',
                                    'value' => 0,
                                    'label' => $this->l('Disabled')
                                )
                            ),
                            ),
                        ),
                    'submit' => array(
                        'title' => $this->l('Save')
                    )
                ),
                );
	
            $helper = new HelperForm();

            $helper->show_toolbar = false;
            $helper->table =  $this->table;
            $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->default_form_language = $lang->id;
            $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
            $this->fields_form = array();

            $helper->identifier = $this->identifier;
            $helper->submit_action = 'submitSetting';
            $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $helper->tpl_vars = array(
                'fields_value' => $this->getConfigFieldsValues(),
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id
            );

        // Load current value
        $form = $helper->generateForm(array($fields_form));
        return $form;

	}		
	
	public function getConfigFieldsValues()
	{
		$id_shop = $this->context->shop->id;
	    if (!is_numeric($id_shop)) {
            $id_shop = 1;
        }
		$query = "SELECT `value` FROM `"._DB_PREFIX_."art_cssadd` WHERE `name` = 'ART_HEADER_CODE' AND `id_shop` = ".(int)$id_shop."";
		$art_text = Db::getInstance()->getValue($query);
		return array(
			'ART_HEADER_FEATURE_ACTIVE' => Tools::getValue('ART_HEADER_FEATURE_ACTIVE', Configuration::get('ART_HEADER_FEATURE_ACTIVE')),
			'ART_HEADER_CODE' => $art_text
		);
	}
	
	
	
}
