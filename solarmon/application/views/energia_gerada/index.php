<!-- Main content -->
<section class="content">
<?php $semana = array(1 => "Segunda-feira", 2=>"Terça-feira", 3=>"Quarta-feira", 4=>"Quinta-feira", 5=>"Sexta-feira", 6=>"Sábado",7=>'Domingo' ); ?>
    
    
    
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua-gradient">
            <div class="inner">
                <h3 class="tensao_medida">0</h3>

              <p>Tensão</p>
            </div>
            <div class="icon">
              <i class="ion ion-flash"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green-gradient">
            <div class="inner">
                <h3 class="corrente_medida">0</h3>

              <p>Corrente</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-shuffle-strong"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        
         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow-gradient">
            <div class="inner">
                <h3 class="temperatura_medida">0</h3>

              <p>Temperatura</p>
            </div>
            <div class="icon">
              <i class="ion ion-thermometer"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red-gradient">
            <div class="inner">
                <h3 class="valor_gerado"></h3>

              <p>Faturamento</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-usd"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        <!-- ./col -->
      </div>
    
    
    
    
    <div class="row">
        <!--Foto da Instalação-->
        <div class="col-md-6">
            <!--Foto da Instalação-->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Local</h3>
                </div>
                <div class="box-body tamanho_box" >                   
                    <div class="foto_instalacao">
                        <img class="foto" src="<?= base_url("/assets/uploads/plantas/").(!empty($foto) ? $foto : "") ?>"/>
                    </div>
                    
                    <div class="box_instalacao text-white">                         
                        <div class="linha1"><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $endereco; ?></div>
                        <div class="linha2">
                            <div class="colunaB1">Energia Gerada 
                                <br /><big><i class="fa fa-bolt" aria-hidden="true"></i></big><big class="potencia_gerada">5.32</big><small>KWh</small></div>
                            <div class="colunaB1">
                                Previsao para hoje, <?= $semana[date('N', $previsao_hoje['data'])]?><br />
                                <big><img class="w-2x" src="<?= base_url("/public/css/forecast_icon/").(!empty($previsao_hoje['icone']) ? $previsao_hoje['icone'] : "") ?>"/><?= intval($previsao_hoje['temp'])?></big><small>ºC</small>
                            </div>
                        </div>
                        <div class="linha3">
                            <div class="colunaB1">
                                <i class="fa fa-circle-o text-lime"></i> 
                                Online: Última atualização 
                                <br /> <div class="atualizacao"> 15/06/2019 às 14:34:35</div>
                            </div>
                            <!--previsao 3 dias-->
                            <div class="colunaB3 text-center">
                                <div class="linha4">
                                    <div class="colunaB1"><?= substr($semana[date('N', $previsao_hoje['data'])], 0, 3)?></div>
                                </div>
                                <div class="linha4">
                                    <div class="colunaB2">                                        
                                        <img src="<?= base_url("/public/css/forecast_icon/").(!empty($previsao_hoje['icone']) ? $previsao_hoje['icone'] : "") ?>"/>
                                    </div>
                                    <div class="colunaB2">
                                        <?= intval($previsao_hoje['min'])?>ºC<br/>
                                        <?= intval($previsao_hoje['max'])?>ºC
                                    </div>
                                </div>                                
                            </div>
                            <!--previsao 3 dias-->
                            <div class="colunaB3 text-center">
                                <div class="linha4">
                                    <div class="colunaB1"><?= substr($semana[date('N', $previsao_2dias[0]['data'])], 0, 3)?></div>
                                </div>
                                <div class="linha4">
                                    <div class="colunaB2">                                        
                                        <img src="<?= base_url("/public/css/forecast_icon/").(!empty($previsao_2dias[0]['icone']) ? $previsao_2dias[0]['icone'] : "") ?>"/>
                                    </div>
                                    <div class="colunaB2"> 
                                        <?= intval($previsao_2dias[0]['min'])?>°C<br/>
                                        <?= intval($previsao_2dias[0]['max'])?>ºC
                                    </div>
                                </div>                                
                            </div>
                            
                            <!--previsao 3 dias-->
                            <div class="colunaB3 text-center">
                                <div class="linha4">
                                    <div class="colunaB1"><?= substr($semana[date('N', $previsao_2dias[1]['data'])], 0, 3)?></div>
                                </div>
                                <div class="linha4">
                                    <div class="colunaB2">                                        
                                        <img src="<?= base_url("/public/css/forecast_icon/").(!empty($previsao_2dias[1]['icone']) ? $previsao_2dias[1]['icone'] : "") ?>"/>
                                    </div>
                                    <div class="colunaB2"> 
                                        <?= intval($previsao_2dias[1]['min'])?>°C<br/>
                                        <?= intval($previsao_2dias[1]['max'])?>ºC
                                    </div>
                                </div>                                
                            </div>
                            
                        </div>
                   </div>                                         
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        
        
        <!--Dados da Geração-->
        <div class="col-md-6">
            <!--Foto da Instalação-->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Potência</h3>
                </div>
                <div class="box-body text-center">
                    <input type="text" class="potencia_porcentagem" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125" value="100" data-width="275" data-height="275" data-fgColor="#00c0ef" data-readOnly=true>
                    <!--<input type="text" class="potencia_porcentagem"                                                                  value="90"  data-width="80"  data-height="90"  data-fgColor="#2ecc71" data-readOnly=true>-->
                    <div class="potencia_atual"></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        
        
    </div>

    
<!--    fsfsdfs-->
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red-gradient">
            <div class="inner">
                <h3 class="falhas falhas2">0</h3>

              <p>Falhas</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-warning"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
                
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow-gradient">
            <div class="inner">
                <h3 class="rssid"></h3>

              <p>RSSId</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-wifi"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua-gradient">
            <div class="inner">
                <h3 class="rssiu"></h3>

              <p>RSSIu</p>
            </div>
            <div class="icon">
              <i class="ion ion-radio-waves"></i>
            </div>
            <a href="#" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green-gradient">
            <div class="inner">
                <h3 class="arvores"></h3>

              <p>Árvores plantadas</p>
            </div>
            <div class="icon">
              <i class="ion ion-leaf"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>       
      </div>
    <!--fsdfsdfs-->
    
    
    
    


    <div class="row">
        <div class="col-xs-12">
            <!-- interactive chart -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-bar-chart-o"></i>

                    <h3 class="box-title">Potência atual</h3>

                    <div class="box-tools pull-right">
                        Real time
                        <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div id="interactive" style="height: 300px;"></div>
                </div>
                <!-- /.box-body-->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>

<!-- Page script -->


