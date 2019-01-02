<style>
  @media (max-width: 767px){
  .content-area {
      padding: 0;
  }
  .row.mainnavbar {
    margin-bottom: 0px;
    margin-right: 0px;
  }
}

</style>

<div class="grid">


    <div class="grid__col-sm-12 grid__col-md-12 grid__col--bleed">
      <div class="grid grid--align-content-start">
<?php if ($this->user->admin == '1') {
    ?> 

        <div class="grid__col-12">
            <div class="tile-base box-shadow no-padding" > 
             <?php  $attributes = ['class' => '', 'method' => 'POST', 'id' => '_reports'];
    echo form_open($form_action, $attributes); ?>
                <div class="grid tile-base__form-heading">
                  <div class="grid__col-md-4">
                          <div class="form-group tt">
                              <label for="reports"><?=$this->lang->line('application_reports'); ?> </label>
                              <select id="report" name="report" class="formcontrol chosen-select ">
                                    <option value="income"><?=$this->lang->line('application_income_and_expenses'); ?></option>
                                    <option value="clients" <?php if (isset($report_selected)) {
        echo 'selected';
    } ?>><?=$this->lang->line('application_income_by_client'); ?></option>          

                              </select>
                          </div>    
                  </div>

                  <div class="grid__col-md-2">
                        <div class="form-group filled">
                              <label for="start"><?=$this->lang->line('application_start_date'); ?> *</label>
                              <input class="form-control datepicker" name="start" id="start" type="text" value="<?=$stats_start_short; ?>" placeholder="<?=$this->lang->line('application_start_date'); ?>" required/>
                        </div>
                  </div>
                  <div class="grid__col-md-2">
                        <div class="form-group filled">
                              <label for="end"><?=$this->lang->line('application_end_date'); ?> *</label>
                              <input class="form-control datepicker-linked" name="end" id="end" type="text" value="<?=$stats_end_short; ?>" placeholder="<?=$this->lang->line('application_end_date'); ?>" required/>
                        </div>
                  </div>
                   <div class="grid__col-md-2 grid--align-self-end">
                        
                              <input class="btn btn-primary" name="send" type="submit" value="<?=$this->lang->line('application_apply'); ?>" placeholder="" required/>
                       
                  </div>
              </div>
              <?php form_close(); ?>
              <div class="tile-extended-header">
                  <div class="grid tile-extended-header">
                      <div class="grid__col-4">
                          <h5><?=$this->lang->line('application_statistics'); ?> </h5>
                          <div class="btn-group">
                        <button type="button" class="tile-year-selector dropdown-toggle" data-toggle="dropdown">
                          <?=$stats_start; ?> - <?=$stats_end; ?>
                        </button>
                        
                  </div>
                      </div>
                      <div class="grid__col-8">
                            <?php if (!isset($report_selected)) {
        ?>
                            <div class="grid grid--bleed grid--justify-end">
                                <div class="grid__col-md-3 tile-text-right">
                                    <h5><?=$this->lang->line('application_income'); ?></h5>
                                    <h1><?=display_money($totalIncomeForYear, false); ?></h1>
                                </div>
                                <div class="grid__col-md-3 tile-text-right tile-negative">
                                    <h5><?=$this->lang->line('application_expenses'); ?></h5>
                                    <h1><?=display_money($totalExpenses, false); ?></h1>
                                </div>
                                <div class="grid__col-md-3 tile-text-right tile-positive">
                                    <h5><?=$this->lang->line('application_profit'); ?></h5>
                                    <h1><?=display_money($totalProfit, false); ?></h1>
                                </div>
                          </div>
                          <?php
    } ?>
                      </div>
                      <div class="grid__col-12 grid--align-self-end">
                          <div class="tile-body">
                              <canvas id="tileChart" width="auto" height="80" style="margin-bottom: -11px;"></canvas>
                          </div>
                      </div>
                    </div>
                  </div>   
            </div>
</div> 





     <div class="grid__col-12">
          <div class="tile-base tile-responsive box-shadow" > 
          <button class="btn btn-primary excel-export"><?=$this->lang->line('application_export_to_xls'); ?></button>
          <br><br>
            <div id="table_wrapper">
              <table border="1" class="table table-striped table__excel">
                <tbody>
                  <tr>
                    <th colspan="3"></th>
                    <th class="table__excel--category table__excel--green-bg" colspan="3"><?=$this->lang->line('application_income'); ?></th>
                    <th class="table__excel--category table__excel--red-bg" colspan="3"><?=$this->lang->line('application_expenses'); ?></th>             
                    <th class="table__excel--category table__excel--purple-bg" colspan="2"><?=$this->lang->line('application_tax'); ?></th>
                  </tr>

                  <tr>
                    <th><?=$this->lang->line('application_document_number'); ?></th>
                    <th><?=$this->lang->line('application_date'); ?></th>
                    <th><?=$this->lang->line('application_transaction'); ?></th>

                    <th><?=$this->lang->line('application_net'); ?></th>
                    <th><?=$this->lang->line('application_tax'); ?></th>
                    <th><?=$this->lang->line('application_total'); ?></th>

                    <th><?=$this->lang->line('application_net'); ?></th>
                    <th><?=$this->lang->line('application_tax'); ?></th>
                    <th><?=$this->lang->line('application_total'); ?></th>

                    <th><?=$this->lang->line('application_paid_tax'); ?></th>
                    <th><?=$this->lang->line('application_owed_tax'); ?></th>
                  </tr>

                  <?php 
                    $i = 1;
    $tax_outstanding = 0;
    $tax_paid_total = 0;
    $tax_owed_total = 0;
    $income_total = 0;
    $expenses_total = 0;

    foreach ($invoices as $invoice) {
        $number = $i++;
        $date = date($core_settings->date_format, human_to_unix($invoice->issue_date . ' 00:00'));
        $transaction = '#' . $core_settings->invoice_prefix . $invoice->reference;

        $tax = floatval('1.' . $invoice->tax);
        $net = ($invoice->sum / $tax);

        $tax = $invoice->sum - $net;
        $total = $invoice->sum;

        $tax_owed_total = $tax_owed_total + $tax;
        $income_total = $income_total + $total; ?>
                 
                      <tr>
                        <td><?=$number?></td>
                        <td><?=$date?></td>
                        <td><?=$transaction?></td>

                        <td><?=display_money($net)?></td>
                        <td><?=display_money($tax)?></td>
                        <td><?=display_money($total)?></td>

                        <td></td>
                        <td></td>
                        <td></td>

                        <td></td>
                        <td><?=display_money($tax)?></td>
                      </tr>

                  <?php
    } ?>

                  <?php foreach ($expenses as $expense) {
        $number = $i++;
        $date = date($core_settings->date_format, human_to_unix($expense->date . ' 00:00'));
        $transaction = $expense->description;

        $vat = floatval('1.' . sprintf('%02d', $expense->vat));
        $net = ($expense->value / $vat);

        $net = ($expense->category != 'Steuer') ? $net : '';
        $vat = ($expense->category != 'Steuer') ? $expense->value - $net : '';
        $total = ($expense->category != 'Steuer') ? $expense->value : '';

        $tax_paid = ($expense->category != 'Steuer') ? $vat : '';
        $tax_owed = ($expense->category == 'Steuerschuld') ? $net : '';

        $tax_paid_total = $tax_paid_total + $tax_paid;
        $tax_outstanding = $tax_outstanding - $tax_paid + $tax_owed;
        $expenses_total = $expenses_total + $total; ?>
                 
                      <tr>
                        <td><?=$number?></td>
                        <td><?=$date?></td>
                        <td><?=$transaction?></td>

                        <td></td>
                        <td></td>
                        <td></td>

                        <td><?=display_money($net)?></td>
                        <td><?=display_money($vat)?></td>
                        <td><?=display_money($total)?></td>
      
                        <td><?='-' . display_money($tax_paid)?></td>
                        <td><?=display_money($tax_owed)?></td>
                      </tr>

                  <?php
    } ?>
                  <tr border="2" style="border-top: 2px solid #1e75b3;">
                    <th><?=$this->lang->line('application_total'); ?></th>
                    <th></th>
                    <th></th>
                    <th colspan="3" class="text-right"><?=display_money($income_total)?></th>
                    <th colspan="3" class="text-right"><?=display_money($expenses_total)?></th>
                    <th colspan="2" class="text-right"><?=display_money($tax_owed_total - $tax_paid_total)?></th>
                  </tr>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  </tbody>
                </table>     
            </div>
                  <?php if ($current_language == 'german' && $report_selected != 'clients') {
        $fields = [
                            'bmf_form_ekst:ekst_bj' => urlencode($report_year),
                            'bmf_form_ekst:ekst_zve' => urlencode($totalProfit),
                            'bmf_form_ekst:ekst_pv' => urlencode(0),
                            'bmf_form_ekst:income_ekst' => urlencode('Berechnen'),
                    ];
        $html = curl_post('https://www.bmf-steuerrechner.de/ekst/eingabeformekst.xhtml', $fields);
        $dom = new DomDocument();
        $dom->loadHTML($html);

        $ekst = $dom->getElementById('resEkst');
        $soli = $dom->getElementById('resSoli');
        $sum_ekst = $dom->getElementById('resSumme'); ?>
                <div class="row">
                  <div class="col-md-4">
                      <table class="table table-striped table__excel" >
                          <tr>
                            <th colspan="2">Einkommensteuer für <?=$report_year?></th>
                          </tr>
                          <tr>
                            <td>Einkommensteuer</td>
                            <td><?php if(isset($ekst)) {
                                echo $ekst->getAttribute('value');
                            }?></td>
                          </tr>
                           <tr>
                            <td>Solidaritätszuschlag</td>
                            <td><?php if(isset($soli)) {
                                echo $soli->getAttribute('value');
                            }?></td>
                          </tr>
                           <tr>
                            <th>Gesamt</th>
                            <td><b><?php if (isset($sum_ekst)) {
                                    echo $sum_ekst->getAttribute('value'); 
                                  }?></b></td>

                          </tr>
                      </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-striped table__excel">
                            <tr>
                              <th>Ust. im letzten Monat (<?=$last_month?>)</th>
                              <th>Netto</th>
                              <th>Ust. Vorabzugsfähig</th>
                            </tr>
                            <tr>
                              
                              <td><?=display_money($tax_of_last_month); ?></td>
                              <td><?=display_money($gross_of_last_month)?></td>
                              <td><?=display_money($paid_tax_of_last_month)?></td>
                            </tr>

                            <tr>
                              <th>Ust. im aktuellen Monat (<?=$last_month?>)</th>
                              <th>Netto</th>
                              <th>Ust. Vorabzugsfähig</th>
                            </tr>
                             <tr>
                              <td><?=display_money($tax_of_this_month); ?></td>
                              <td></td>
                              <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
    } ?>

                  
              

          </div>
     </div>






<?php
} ?>

        


      </div>
    </div>


</div>


 



<script type="text/javascript">
$(document).ready(function(){

  //chartjs

  var ctx = document.getElementById("tileChart");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?=strtoupper($labels)?>],
      datasets: [<?php if ($line2 != 0) {
        ?>{
        label: "<?=$this->lang->line('application_owed'); ?>",
        backgroundColor: "rgba(237,85,101,0.6)",
        borderColor: "rgba(237,85,101,1)",
        pointBorderColor: "rgba(0,0,0,0)",
        pointBackgroundColor: "#ffffff",
        pointHoverBackgroundColor: "rgba(237, 85, 101, 0.5)",
        pointHitRadius: 25,
        pointRadius: 1,
        data: [<?=$line2?>],
      },<?php
    } ?>{
        label: "<?=$this->lang->line('application_received');?>",
        backgroundColor: "rgba(46,204,113,0.6)",
        borderColor: "rgba(46,204,113,1)",
        pointBorderColor: "rgba(0,0,0,0)",
        pointBackgroundColor: "#ffffff",
        pointHoverBackgroundColor: "rgba(79, 193, 233, 1)",
        pointHitRadius: 25,
        pointRadius: 1,
        data: [<?=$line1?>],
      },
      ]
    },
    options: {
      tooltips:{
        xPadding: 10,
        yPadding: 10,
        cornerRadius:2,
        mode: 'label',
        multiKeyBackground: 'rgba(0,0,0,0.2)'
      },
      legend:{
        display: false
      },
      scales: {
         
        yAxes: [{
          display: true,
          gridLines:[{
                      drawOnChartArea: false,
          }],
          ticks: {
                      fontColor: "#A4A5A9",
                      fontFamily: "Open Sans",
                      fontSize: 11,
                      beginAtZero:true,
                      maxTicksLimit:6,
                  }
        }],
        xAxes: [{
          display: true,
          ticks: {
                      fontColor: "#A4A5A9",
                      fontFamily: "Open Sans",
                      fontSize: 11,
                 }
        }]
      }
    }
  });



});
</script>



 