<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">Stripe
			<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div">
			<?php 
        $attributes = ['class' => '', 'id' => 'stripe'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_stripe_active');?>
				</label>
				<input name="stripe" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_stripe_active');?>"
				 value="1" <?php if ($settings->stripe == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_stripe_public_key');?>
				</label>
				<input type="text" name="stripe_key" class="form-control" value="<?=$settings->stripe_key;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_stripe_private_key');?>
				</label>
				<input type="text" name="stripe_p_key" class="form-control" value="<?=$settings->stripe_p_key;?>">
			</div>

			<div class="form-group">
				<label>
					<?=$this->lang->line('application_iDEAL');?>
				</label>
				<input name="stripe_ideal" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_enable_iDEAL');?>"
				 value="1" <?php if ($settings->stripe_ideal == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>

			<div class="form-group">
				<label>
					<?=$this->lang->line('application_currency');?>
				</label>
				<select name="stripe_currency" class="formcontrol chosen-select ">
					<?php if ($settings->stripe_currency != '') {
            ?>
					<option value="<?=$settings->stripe_currency; ?>" selected="">
						<?=$settings->stripe_currency; ?>
					</option>
					<?php
        } ?>

						<option value="AFA">Afghani</option>
						<option value="AFN">Afghani</option>
						<option value="ALK">Albanian old lek</option>
						<option value="ALL">Lek</option>
						<option value="DZD">Algerian Dinar</option>
						<option value="USD">US Dollar</option>
						<option value="ADF">Andorran Franc</option>
						<option value="ADP">Andorran Peseta</option>
						<option value="AED">Arab Emirates Dirham</option>
						<option value="EUR">Euro</option>
						<option value="AOR">Angolan Kwanza Readjustado</option>
						<option value="AON">Angolan New Kwanza</option>
						<option value="AOA">Kwanza</option>
						<option value="XCD">East Caribbean Dollar</option>
						<option value="ARA">Argentine austral</option>
						<option value="ARS">Argentine Peso</option>
						<option value="ARL">Argentine peso ley</option>
						<option value="ARM">Argentine peso moneda nacional</option>
						<option value="ARP">Peso argentino</option>
						<option value="AMD">Armenian Dram</option>
						<option value="AWG">Aruban Guilder</option>
						<option value="AUD">Australian Dollar</option>
						<option value="ATS">Austrian Schilling</option>
						<option value="AZM">Azerbaijani manat</option>
						<option value="AZN">Azerbaijanian Manat</option>
						<option value="BSD">Bahamian Dollar</option>
						<option value="BHD">Bahraini Dinar</option>
						<option value="BDT">Taka</option>
						<option value="BBD">Barbados Dollar</option>
						<option value="BYR">Belarussian Ruble</option>
						<option value="BEC">Belgian Franc (convertible)</option>
						<option value="BEF">Belgian Franc (currency union with LUF)</option>
						<option value="BEL">Belgian Franc (financial)</option>
						<option value="BZD">Belize Dollar</option>
						<option value="XOF">CFA Franc BCEAO</option>
						<option value="BMD">Bermudian Dollar</option>
						<option value="INR">Indian Rupee</option>
						<option value="BTN">Ngultrum</option>
						<option value="BOP">Bolivian peso</option>
						<option value="BOB">Boliviano</option>
						<option value="BOV">Mvdol</option>
						<option value="BAM">Convertible Marks</option>
						<option value="BWP">Pula</option>
						<option value="NOK">Norwegian Krone</option>
						<option value="BRC">Brazilian cruzado</option>
						<option value="BRB">Brazilian cruzeiro</option>
						<option value="BRL">Brazilian Real</option>
						<option value="BND">Brunei Dollar</option>
						<option value="BGN">Bulgarian Lev</option>
						<option value="BGJ">Bulgarian lev A/52</option>
						<option value="BGK">Bulgarian lev A/62</option>
						<option value="BGL">Bulgarian lev A/99</option>
						<option value="BIF">Burundi Franc</option>
						<option value="KHR">Riel</option>
						<option value="XAF">CFA Franc BEAC</option>
						<option value="CAD">Canadian Dollar</option>
						<option value="CVE">Cape Verde Escudo</option>
						<option value="KYD">Cayman Islands Dollar</option>
						<option value="CLP">Chilean Peso</option>
						<option value="CLF">Unidades de fomento</option>
						<option value="CNX">Chinese People's Bank dollar</option>
						<option value="CNY">Yuan Renminbi</option>
						<option value="COP">Colombian Peso</option>
						<option value="COU">Unidad de Valor real</option>
						<option value="KMF">Comoro Franc</option>
						<option value="CDF">Franc Congolais</option>
						<option value="NZD">New Zealand Dollar</option>
						<option value="CRC">Costa Rican Colon</option>
						<option value="HRK">Croatian Kuna</option>
						<option value="CUP">Cuban Peso</option>
						<option value="CYP">Cyprus Pound</option>
						<option value="CZK">Czech Koruna</option>
						<option value="CSK">Czechoslovak koruna</option>
						<option value="CSJ">Czechoslovak koruna A/53</option>
						<option value="DKK">Danish Krone</option>
						<option value="DJF">Djibouti Franc</option>
						<option value="DOP">Dominican Peso</option>
						<option value="ECS">Ecuador sucre</option>
						<option value="EGP">Egyptian Pound</option>
						<option value="SVC">Salvadoran colón</option>
						<option value="EQE">Equatorial Guinean ekwele</option>
						<option value="ERN">Nakfa</option>
						<option value="EEK">Kroon</option>
						<option value="ETB">Ethiopian Birr</option>
						<option value="FKP">Falkland Island Pound</option>
						<option value="FJD">Fiji Dollar</option>
						<option value="FIM">Finnish Markka</option>
						<option value="FRF">French Franc</option>
						<option value="XFO">Gold-Franc</option>
						<option value="XPF">CFP Franc</option>
						<option value="GMD">Dalasi</option>
						<option value="GEL">Lari</option>
						<option value="DDM">East German Mark of the GDR (East Germany)</option>
						<option value="DEM">Deutsche Mark</option>
						<option value="GHS">Ghana Cedi</option>
						<option value="GHC">Ghanaian cedi</option>
						<option value="GIP">Gibraltar Pound</option>
						<option value="GRD">Greek Drachma</option>
						<option value="GTQ">Quetzal</option>
						<option value="GNF">Guinea Franc</option>
						<option value="GNE">Guinean syli</option>
						<option value="GWP">Guinea-Bissau Peso</option>
						<option value="GYD">Guyana Dollar</option>
						<option value="HTG">Gourde</option>
						<option value="HNL">Lempira</option>
						<option value="HKD">Hong Kong Dollar</option>
						<option value="HUF">Forint</option>
						<option value="ISK">Iceland Krona</option>
						<option value="ISJ">Icelandic old krona</option>
						<option value="IDR">Rupiah</option>
						<option value="IRR">Iranian Rial</option>
						<option value="IQD">Iraqi Dinar</option>
						<option value="IEP">Irish Pound (Punt in Irish language)</option>
						<option value="ILP">Israeli lira</option>
						<option value="ILR">Israeli old sheqel</option>
						<option value="ILS">New Israeli Sheqel</option>
						<option value="ITL">Italian Lira</option>
						<option value="JMD">Jamaican Dollar</option>
						<option value="JPY">Yen</option>
						<option value="JOD">Jordanian Dinar</option>
						<option value="KZT">Tenge</option>
						<option value="KES">Kenyan Shilling</option>
						<option value="KPW">North Korean Won</option>
						<option value="KRW">Won</option>
						<option value="KWD">Kuwaiti Dinar</option>
						<option value="KGS">Som</option>
						<option value="LAK">Kip</option>
						<option value="LAJ">Lao kip</option>
						<option value="LVL">Latvian Lats</option>
						<option value="LBP">Lebanese Pound</option>
						<option value="LSL">Loti</option>
						<option value="ZAR">Rand</option>
						<option value="LRD">Liberian Dollar</option>
						<option value="LYD">Libyan Dinar</option>
						<option value="CHF">Swiss Franc</option>
						<option value="LTL">Lithuanian Litas</option>
						<option value="LUF">Luxembourg Franc (currency union with BEF)</option>
						<option value="MOP">Pataca</option>
						<option value="MKD">Denar</option>
						<option value="MKN">Former Yugoslav Republic of Macedonia denar A/93</option>
						<option value="MGA">Malagasy Ariary</option>
						<option value="MGF">Malagasy franc</option>
						<option value="MWK">Kwacha</option>
						<option value="MYR">Malaysian Ringgit</option>
						<option value="MVQ">Maldive rupee</option>
						<option value="MVR">Rufiyaa</option>
						<option value="MAF">Mali franc</option>
						<option value="MTL">Maltese Lira</option>
						<option value="MRO">Ouguiya</option>
						<option value="MUR">Mauritius Rupee</option>
						<option value="MXN">Mexican Peso</option>
						<option value="MXP">Mexican peso</option>
						<option value="MXV">Mexican Unidad de Inversion (UDI)</option>
						<option value="MDL">Moldovan Leu</option>
						<option value="MCF">Monegasque franc (currency union with FRF)</option>
						<option value="MNT">Tugrik</option>
						<option value="MAD">Moroccan Dirham</option>
						<option value="MZN">Metical</option>
						<option value="MZM">Mozambican metical</option>
						<option value="MMK">Kyat</option>
						<option value="NAD">Namibia Dollar</option>
						<option value="NPR">Nepalese Rupee</option>
						<option value="NLG">Netherlands Guilder</option>
						<option value="ANG">Netherlands Antillian Guilder</option>
						<option value="NIO">Cordoba Oro</option>
						<option value="NGN">Naira</option>
						<option value="OMR">Rial Omani</option>
						<option value="PKR">Pakistan Rupee</option>
						<option value="PAB">Balboa</option>
						<option value="PGK">Kina</option>
						<option value="PYG">Guarani</option>
						<option value="YDD">South Yemeni dinar</option>
						<option value="PEN">Nuevo Sol</option>
						<option value="PEI">Peruvian inti</option>
						<option value="PEH">Peruvian sol</option>
						<option value="PHP">Philippine Peso</option>
						<option value="PLZ">Polish zloty A/94</option>
						<option value="PLN">Zloty</option>
						<option value="PTE">Portuguese Escudo</option>
						<option value="TPE">Portuguese Timorese escudo</option>
						<option value="QAR">Qatari Rial</option>
						<option value="RON">New Leu</option>
						<option value="ROL">Romanian leu A/05</option>
						<option value="ROK">Romanian leu A/52</option>
						<option value="RUB">Russian Ruble</option>
						<option value="RWF">Rwanda Franc</option>
						<option value="SHP">Saint Helena Pound</option>
						<option value="WST">Tala</option>
						<option value="STD">Dobra</option>
						<option value="SAR">Saudi Riyal</option>
						<option value="RSD">Serbian Dinar</option>
						<option value="CSD">Serbian Dinar</option>
						<option value="SCR">Seychelles Rupee</option>
						<option value="SLL">Leone</option>
						<option value="SGD">Singapore Dollar</option>
						<option value="SKK">Slovak Koruna</option>
						<option value="SIT">Slovenian Tolar</option>
						<option value="SBD">Solomon Islands Dollar</option>
						<option value="SOS">Somali Shilling</option>
						<option value="ZAL">South African financial rand (Funds code) (discont</option>
						<option value="ESP">Spanish Peseta</option>
						<option value="ESA">Spanish peseta (account A)</option>
						<option value="ESB">Spanish peseta (account B)</option>
						<option value="LKR">Sri Lanka Rupee</option>
						<option value="SDD">Sudanese Dinar</option>
						<option value="SDP">Sudanese Pound</option>
						<option value="SDG">Sudanese Pound</option>
						<option value="SRD">Surinam Dollar</option>
						<option value="SRG">Suriname guilder</option>
						<option value="SZL">Lilangeni</option>
						<option value="SEK">Swedish Krona</option>
						<option value="CHE">WIR Euro</option>
						<option value="CHW">WIR Franc</option>
						<option value="SYP">Syrian Pound</option>
						<option value="TWD">New Taiwan Dollar</option>
						<option value="TJS">Somoni</option>
						<option value="TJR">Tajikistan ruble</option>
						<option value="TZS">Tanzanian Shilling</option>
						<option value="THB">Baht</option>
						<option value="TOP">Pa'anga</option>
						<option value="TTD">Trinidata and Tobago Dollar</option>
						<option value="TND">Tunisian Dinar</option>
						<option value="TRY">New Turkish Lira</option>
						<option value="TRL">Turkish lira A/05</option>
						<option value="TMM">Manat</option>
						<option value="RUR">Russian rubleA/97</option>
						<option value="SUR">Soviet Union ruble</option>
						<option value="UGX">Uganda Shilling</option>
						<option value="UGS">Ugandan shilling A/87</option>
						<option value="UAH">Hryvnia</option>
						<option value="UAK">Ukrainian karbovanets</option>
						<option value="AED">UAE Dirham</option>
						<option value="GBP">Pound Sterling</option>
						<option value="USN">US Dollar (Next Day)</option>
						<option value="USS">US Dollar (Same Day)</option>
						<option value="UYU">Peso Uruguayo</option>
						<option value="UYN">Uruguay old peso</option>
						<option value="UYI">Uruguay Peso en Unidades Indexadas</option>
						<option value="UZS">Uzbekistan Sum</option>
						<option value="VUV">Vatu</option>
						<option value="VEF">Bolivar Fuerte</option>
						<option value="VEB">Venezuelan Bolivar</option>
						<option value="VND">Dong</option>
						<option value="VNC">Vietnamese old dong</option>
						<option value="YER">Yemeni Rial</option>
						<option value="YUD">Yugoslav Dinar</option>
						<option value="YUM">Yugoslav dinar (new)</option>
						<option value="ZRN">Zairean New Zaire</option>
						<option value="ZRZ">Zairean Zaire</option>
						<option value="ZMK">Kwacha</option>
						<option value="ZWD">Zimbabwe Dollar</option>
						<option value="ZWC">Zimbabwe Rhodesian dollar</option>
				</select>
			</div>




			<div class="form-group no-border">

				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>


		<div class="box-shadow">
		<div class="table-head">Authorize.net
			<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div">
			<?php 
        $attributes = ['class' => '', 'id' => 'authorize'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_authorize_active');?>
				</label>
				<input name="authorize_net" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_authorize_active');?>"
				 value="1" <?php if ($settings->authorize_net == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_api_login_id');?>
				</label>
				<input type="text" name="authorize_api_login_id" class="form-control" value="<?=$settings->authorize_api_login_id;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_api_transaction_key');?>
				</label>
				<input type="text" name="authorize_api_transaction_key" class="form-control" value="<?=$settings->authorize_api_transaction_key;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_currency');?>
				</label>

				<select id="authorize_currency" name="authorize_currency" class="chosen-select">
					<option value="<?=$settings->authorize_currency;?>" selected="">
						<?=$settings->authorize_currency;?>
					</option>
					<option value="USD">US Dollars</option>
					<option value="AUD">Australian Dollars</option>
					<option value="GBP">British Pounds</option>
					<option value="CAD">Canadian Dollars</option>
					<option value="EUR">Euros</option>
					<option value="NZD">New Zealand Dollars</option>
				</select>
			</div>



			<div class="form-group no-border">

				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>
	<div class="box-shadow">
		<div class="table-head">2Checkout
			<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div">
			<?php 
        $attributes = ['class' => '', 'id' => 'twocheckout'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_twocheckout_active');?>
				</label>
				<input name="twocheckout" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_twocheckout_active');?>"
				 value="1" <?php if ($settings->twocheckout == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_seller_id');?>
				</label>
				<input type="text" name="twocheckout_seller_id" class="form-control" value="<?=$settings->twocheckout_seller_id;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_twocheckout_publishable_key');?>
				</label>
				<input type="text" name="twocheckout_publishable_key" class="form-control" value="<?=$settings->twocheckout_publishable_key;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_twocheckout_private_key');?>
				</label>
				<input type="text" name="twocheckout_private_key" class="form-control" value="<?=$settings->twocheckout_private_key;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_currency');?>
				</label>

				<select id="twocheckout_currency" name="twocheckout_currency" class="chosen-select">
					<option value="<?=$settings->twocheckout_currency;?>" selected="">
						<?=$settings->twocheckout_currency;?>
					</option>
					<?php foreach (getCurrencyCodesForTwocheckout() as $key => $value) {
            ?>
					<option value="<?=$key; ?>">
						<?=$value; ?>
					</option>
					<?php
        } ?>
				</select>
			</div>



			<div class="form-group no-border">

				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>




	</div>