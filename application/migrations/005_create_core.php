<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_core extends CI_Migration
{
    public function up()
    {
        ## Create Table core
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`version` char(10) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field('`domain` varchar(65) NULL ');
        $this->dbforge->add_field('`email` varchar(80) NULL ');
        $this->dbforge->add_field('`company` varchar(100) NULL ');
        $this->dbforge->add_field('`tax` varchar(5) NULL ');
        $this->dbforge->add_field('`second_tax` varchar(5) NULL ');
        $this->dbforge->add_field('`currency` varchar(20) NULL ');
        $this->dbforge->add_field('`autobackup` int(11) NULL ');
        $this->dbforge->add_field('`cronjob` int(11) NULL ');
        $this->dbforge->add_field('`last_cronjob` int(11) NULL ');
        $this->dbforge->add_field('`last_autobackup` int(11) NULL ');
        $this->dbforge->add_field('`invoice_terms` mediumtext NULL ');
        $this->dbforge->add_field('`company_reference` int(6) NULL ');
        $this->dbforge->add_field('`project_reference` int(6) NULL ');
        $this->dbforge->add_field('`invoice_reference` int(6) NULL ');
        $this->dbforge->add_field('`subscription_reference` int(6) NULL ');
        $this->dbforge->add_field('`ticket_reference` int(10) NULL ');
        $this->dbforge->add_field('`date_format` varchar(20) NULL ');
        $this->dbforge->add_field('`date_time_format` varchar(20) NULL ');
        $this->dbforge->add_field('`invoice_mail_subject` varchar(150) NULL ');
        $this->dbforge->add_field('`pw_reset_mail_subject` varchar(150) NULL ');
        $this->dbforge->add_field('`pw_reset_link_mail_subject` varchar(150) NULL ');
        $this->dbforge->add_field('`credentials_mail_subject` varchar(150) NULL ');
        $this->dbforge->add_field('`notification_mail_subject` varchar(150) NULL ');
        $this->dbforge->add_field('`language` varchar(150) NULL ');
        $this->dbforge->add_field('`invoice_address` varchar(200) NULL ');
        $this->dbforge->add_field('`invoice_city` varchar(200) NULL ');
        $this->dbforge->add_field('`invoice_contact` varchar(200) NULL ');
        $this->dbforge->add_field('`invoice_tel` varchar(50) NULL ');
        $this->dbforge->add_field('`subscription_mail_subject` varchar(250) NULL ');
        $this->dbforge->add_field('`logo` varchar(150) NULL ');
        $this->dbforge->add_field("`template` varchar(200) NULL DEFAULT 'default' ");
        $this->dbforge->add_field("`paypal` varchar(5) NULL DEFAULT '1' ");
        $this->dbforge->add_field("`paypal_currency` varchar(200) NULL DEFAULT 'EUR' ");
        $this->dbforge->add_field("`paypal_account` varchar(200) NULL DEFAULT 'ownergy@ownergy.com.br' ");
        $this->dbforge->add_field("`invoice_logo` varchar(150) NULL DEFAULT 'assets/blackline/img/invoice_logo.png' ");
        $this->dbforge->add_field('`pc` varchar(150) NULL ');
        $this->dbforge->add_field('`vat` varchar(150) NULL ');
        $this->dbforge->add_field('`ticket_email` varchar(250) NULL ');
        $this->dbforge->add_field("`ticket_default_owner` int(10) NULL DEFAULT '1' ");
        $this->dbforge->add_field("`ticket_default_queue` int(10) NULL DEFAULT '1' ");
        $this->dbforge->add_field("`ticket_default_type` int(10) NULL DEFAULT '1' ");
        $this->dbforge->add_field("`ticket_default_status` varchar(200) NULL DEFAULT 'new' ");
        $this->dbforge->add_field('`ticket_config_host` varchar(250) NULL ');
        $this->dbforge->add_field('`ticket_config_login` varchar(250) NULL ');
        $this->dbforge->add_field('`ticket_config_pass` varchar(250) NULL ');
        $this->dbforge->add_field('`ticket_config_port` varchar(250) NULL ');
        $this->dbforge->add_field('`ticket_config_ssl` varchar(250) NULL ');
        $this->dbforge->add_field('`ticket_config_email` varchar(250) NULL ');
        $this->dbforge->add_field("`ticket_config_flags` varchar(250) NULL DEFAULT '/notls' ");
        $this->dbforge->add_field("`ticket_config_search` varchar(250) NULL DEFAULT 'UNSEEN' ");
        $this->dbforge->add_field('`ticket_config_timestamp` int(11) NULL ');
        $this->dbforge->add_field('`ticket_config_mailbox` varchar(250) NULL ');
        $this->dbforge->add_field('`ticket_config_delete` int(11) NULL ');
        $this->dbforge->add_field('`ticket_config_active` int(11) NULL ');
        $this->dbforge->add_field("`ticket_config_imap` int(11) NULL DEFAULT '1' ");
        $this->dbforge->add_field("`stripe` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`stripe_key` varchar(250) NULL ');
        $this->dbforge->add_field('`stripe_p_key` varchar(255) NULL ');
        $this->dbforge->add_field('`bank_transfer` int(11) NULL ');
        $this->dbforge->add_field('`bank_transfer_text` longtext NULL ');
        $this->dbforge->add_field("`stripe_currency` varchar(255) NOT NULL DEFAULT 'USD' ");
        $this->dbforge->add_field('`estimate_terms` longtext NULL ');
        $this->dbforge->add_field("`estimate_prefix` varchar(255) NOT NULL DEFAULT 'EST' ");
        $this->dbforge->add_field("`estimate_pdf_template` varchar(255) NOT NULL DEFAULT 'templates/estimate/default' ");
        $this->dbforge->add_field("`invoice_pdf_template` varchar(255) NOT NULL DEFAULT 'invoices/preview' ");
        $this->dbforge->add_field("`estimate_mail_subject` varchar(255) NOT NULL DEFAULT 'New Estimate #{estimate_id}' ");
        $this->dbforge->add_field("`money_currency_position` int(5) NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field("`money_format` int(5) NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field("`pdf_font` varchar(255) NOT NULL DEFAULT 'NotoSans' ");
        $this->dbforge->add_field("`pdf_path` int(10) NOT NULL DEFAULT '1' ");
        $this->dbforge->add_field("`registration` int(10) NOT NULL DEFAULT '0' ");
        $this->dbforge->add_field('`authorize_api_login_id` varchar(255) NULL ');
        $this->dbforge->add_field('`authorize_api_transaction_key` varchar(255) NULL ');
        $this->dbforge->add_field("`authorize_net` int(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`authorize_currency` varchar(30) NULL ');
        $this->dbforge->add_field('`invoice_prefix` varchar(255) NULL ');
        $this->dbforge->add_field('`company_prefix` varchar(255) NULL ');
        $this->dbforge->add_field('`quotation_prefix` varchar(255) NULL ');
        $this->dbforge->add_field('`project_prefix` varchar(255) NULL ');
        $this->dbforge->add_field('`subscription_prefix` varchar(255) NULL ');
        $this->dbforge->add_field('`calendar_google_api_key` varchar(255) NULL ');
        $this->dbforge->add_field('`calendar_google_event_address` varchar(255) NULL ');
        $this->dbforge->add_field('`default_client_modules` varchar(255) NULL ');
        $this->dbforge->add_field("`estimate_reference` int(10) NULL DEFAULT '0'");
        $this->dbforge->add_field("`login_background` varchar(255) NULL DEFAULT 'blur.jpg' ");
        $this->dbforge->add_field("`custom_colors` int(1) NULL DEFAULT '1'");
        $this->dbforge->add_field("`top_bar_background` varchar(60) NULL DEFAULT '#FFFFFF' ");
        $this->dbforge->add_field("`top_bar_color` varchar(60) NULL DEFAULT '#333333' ");
        $this->dbforge->add_field("`body_background` varchar(60) NULL DEFAULT '#e3e6ed' ");
        $this->dbforge->add_field("`menu_background` varchar(60) NULL DEFAULT '#173240' ");
        $this->dbforge->add_field("`menu_color` varchar(60) NULL DEFAULT '#FFFFFF' ");
        $this->dbforge->add_field("`primary_color` varchar(60) NULL DEFAULT '#356cc9' ");
        $this->dbforge->add_field('`twocheckout_seller_id` varchar(250) NULL ');
        $this->dbforge->add_field('`twocheckout_publishable_key` varchar(250) NULL ');
        $this->dbforge->add_field('`twocheckout_private_key` varchar(250) NULL ');
        $this->dbforge->add_field("`twocheckout` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`twocheckout_currency` varchar(250) NULL ');
        $this->dbforge->add_field('`login_logo` varchar(255) NULL ');
        $this->dbforge->add_field("`login_style` varchar(255) NULL DEFAULT 'left' ");
        $this->dbforge->add_field('`reference_lenght` int(20) NULL ');
        $this->dbforge->add_field('`stripe_ideal` int(1) NULL ');
        $this->dbforge->add_field("`zip_position` varchar(60) NULL DEFAULT 'left' ");
        $this->dbforge->add_field('`timezone` varchar(255) NULL ');
        $this->dbforge->add_field("`notifications` int(1) unsigned NULL DEFAULT '0'");
        $this->dbforge->add_field('`last_notification` varchar(100) NULL ');
        $this->dbforge->add_field('`receipt_mail_subject` varchar(200) NULL ');
        $this->dbforge->create_table('core', true);
    }

    public function down()
    {
        ### Drop table core ##
        $this->dbforge->drop_table('core', true);
    }
}
