<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_header', TEMPLATE_INCLUDEPATH)) : (include template('web/_header', TEMPLATE_INCLUDEPATH));?>
<div class="w1200 m0a">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('tabs', TEMPLATE_INCLUDEPATH)) : (include template('tabs', TEMPLATE_INCLUDEPATH));?>
<div class="rightlist">
<form id="setform"  action="" method="post" class="form-horizontal form">
    <div class='panel panel-default'>
           <div class='panel-heading'>
            分红设置
        </div>
        <div class='panel-body'>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队分红</label>
                <div class="col-sm-6">
                    <select  class="form-control" name="setdata[start]">
                        <option value="0" <?php  if(empty($set['start'])) { ?>selected<?php  } ?>>不开启团队分红</option>
                        <option value="1" <?php  if($set['start']==1) { ?>selected<?php  } ?>>开启团队分红</option>
                    </select>
                </div>
            </div> 
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队分红级差</label>
                <div class="col-sm-9 col-xs-12">
                     <label class="radio-inline"><input type="radio"  name="setdata[isdistinction]" value="0" <?php  if($set['isdistinction'] ==0) { ?> checked="checked"<?php  } ?> /> 是</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[isdistinction]" value="1" <?php  if($set['isdistinction'] ==1) { ?> checked="checked"<?php  } ?> /> 否</label>
                    <span class='help-block'>级差代理，如选择否为同等级不拿分红外，分红比例正常没有级差</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区分红</label>
                <div class="col-sm-6">
                    <select  class="form-control" name="setdata[area_start]">
                        <option value="0" <?php  if(empty($set['area_start'])) { ?>selected<?php  } ?>>不开启地区分红</option>
                        <option value="1" <?php  if($set['area_start']==1) { ?>selected<?php  } ?>>开启地区分红</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区分红级差</label>
                <div class="col-sm-9 col-xs-12">
                     <label class="radio-inline"><input type="radio" class="distinction_area"  name="setdata[isdistinction_area]" value="0" <?php  if($set['isdistinction_area'] ==0) { ?> checked="checked"<?php  } ?> /> 是</label>
                    <label class="radio-inline"><input type="radio" class="distinction_area"  name="setdata[isdistinction_area]" value="1" <?php  if($set['isdistinction_area'] ==1) { ?> checked="checked"<?php  } ?> /> 否</label>
                    <span class='help-block'>地区代理，如选择否为同等级不拿分红外，分红比例正常没有级差</span>
                </div>
            </div>
            <div class="form-group form-areaall" style="display:none;">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区多人分红</label>
                <div class="col-sm-9 col-xs-12">
                     <label class="radio-inline"><input type="radio"  name="setdata[isdistinction_area_all]" value="1" <?php  if($set['isdistinction_area_all'] ==1) { ?> checked="checked"<?php  } ?> /> 是</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[isdistinction_area_all]" value="0" <?php  if($set['isdistinction_area_all'] ==0) { ?> checked="checked"<?php  } ?> /> 否</label>
                    <span class='help-block'>一个地区可设置多人进行分红</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认分销佣金比例</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">省级</div>
                        <input type="text" name="setdata[bonus_commission1]" class="form-control" value="<?php  echo $set['bonus_commission1'];?>"  />
                        <div class="input-group-addon">%</div>
                        
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">市级</div>
                        <input type="text" name="setdata[bonus_commission2]" class="form-control" value="<?php  echo $set['bonus_commission2'];?>"  />
                        <div class="input-group-addon">%</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">区级</div>
                        <input type="text" name="setdata[bonus_commission3]" class="form-control" value="<?php  echo $set['bonus_commission3'];?>"  />
                        <div class="input-group-addon">%</div>
                    </div>
                    <?php  if($trade['is_street'] != 1) { ?>
                  <span class='help-block'>按订单收货地址，省市区代理获得相应比例分红</span>
                  <?php  } ?>
                </div>
            </div>
            <?php  if($trade['is_street'] == 1) { ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">街级</div>
                        <input type="text" name="setdata[bonus_commission4]" class="form-control" value="<?php  echo $set['bonus_commission4'];?>"  />
                        <div class="input-group-addon">%</div>
                    </div>
                  <span class='help-block'>按订单收货地址，省市区街代理获得相应比例分红</span>
                </div>

            </div>
            <?php  } ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">内购得分红</label>
                <div class="col-sm-9 col-xs-12">
                     <label class="radio-inline"><input type="radio"  name="setdata[selfbuy]" value="0" <?php  if($set['selfbuy'] ==0) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[selfbuy]" value="1" <?php  if($set['selfbuy'] ==1) { ?> checked="checked"<?php  } ?> /> 开启</label>
                    <span class='help-block'>开启内购得分红，自己购买商品，享受订单分红</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红计算方式</label>
                <div class="col-sm-4">
                    <select  class="form-control" name="setdata[culate_method]">
                        <option value="0" <?php  if(empty($set['culate_method'])) { ?>selected<?php  } ?>>分红金额</option>
                        <option value="1" <?php  if($set['culate_method']==1) { ?>selected<?php  } ?>>实付款金额</option>
                        <option value="2" <?php  if($set['culate_method']==2) { ?>selected<?php  } ?>>商品原价</option>
                        <option value="3" <?php  if($set['culate_method']==3) { ?>selected<?php  } ?> >商品现价</option>
                        <option value="4" <?php  if($set['culate_method']==4) { ?>selected<?php  } ?> >商品成本价</option>
                        <option value="5" <?php  if($set['culate_method']==5) { ?>selected<?php  } ?> >商品利润（实付款金额-成本价）</option>

                    </select>
                </div>
            </div>
        </div>
        <div class='panel-heading'>
            分红打款设置
        </div>
        <div class='panel-body'>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红打款</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="setdata[paymethod]" value="0" <?php  if($set['paymethod'] ==0) { ?> checked="checked"<?php  } ?> /> 余额</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[paymethod]" value="1" <?php  if($set['paymethod'] ==1) { ?> checked="checked"<?php  } ?> /> 微信钱包</label>
                    <span class='help-block'>分红打款给代理商</span>
                </div>
               </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">打款方式</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="setdata[sendmethod]" value="0" <?php  if($set['sendmethod'] ==0) { ?> checked="checked"<?php  } ?> /> 手动</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[sendmethod]" value="1" <?php  if($set['sendmethod'] ==1) { ?> checked="checked"<?php  } ?> /> 自动</label>
                    <span class='help-block'>选择打款方式</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">打款周期</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio" class="sendmoth" name="setdata[sendmonth]" value="0" <?php  if($set['sendmonth'] ==0) { ?> checked="checked"<?php  } ?> /> 天</label>
                    <label class="radio-inline"><input type="radio" class="sendmoth"  name="setdata[sendmonth]" value="1" <?php  if($set['sendmonth'] ==1) { ?> checked="checked"<?php  } ?> /> 月</label>
                    <span class='help-block'>结算后第二天打款的时间(需选择自动打款起效)</span>
                </div>
            </div>
            <div class="form-group form-interval" style="display:none;">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <div class="input-group">
                        <div class="input-group-addon">分红间隔</div>
                        <input type="text" name="setdata[interval_day]" class="form-control" value="<?php  echo $set['interval_day'];?>"  />
                        <div class="input-group-addon">天</div>
                    </div>
                    <span class='help-block'>结算后分红间隔几天发放</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">打款时间</label>
                <div class="col-sm-5 col-xs-12">
                    <select  class="form-control" name="setdata[senddaytime]">
                      <?php  for($i=1; $i<25; $i++){?>
                        <option value="<?php  echo $i?>" <?php  if($set['senddaytime']==$i) { ?>selected<?php  } ?>><?php  echo $i?>点</option>
                      <?php  }?>
                    </select>
                    <span class='help-block'>结算后第二天打款的时间(需选择自动打款起效)</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红结算天数</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="setdata[settledays]" class="form-control" value="<?php  echo $set['settledays'];?>"  />
                    <span class="help-block">当订单完成后的n天后，才发相应订单分红</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红需消费</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="setdata[consume_withdraw]" class="form-control" value="<?php  echo $set['consume_withdraw'];?>"  />
                    <span class="help-block">分红需消费的金额，订单完成后计算</span>
                </div>
            </div>
            <?php  if(p('love')) { ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现间隔</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="input-group">
                        <input type="text" name="setdata[withdraw_day]" class="form-control" value="<?php  echo $set['withdraw_day'];?>"  />
                        <div class="input-group-addon">天</div>
                    </div>
                    <span class='help-block'>代理商提现间隔时间</span>
                </div>
            </div>
            <?php  } ?>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红代理等级说明连接</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="setdata[levelurl]" class="form-control" value="<?php  echo $set['levelurl'];?>"  />
                    <span class="help-block">分红代理等级说明连接</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">代理商审核</label>
                <div class="col-sm-9 col-xs-12">
                  <label class="radio-inline"><input type="radio"  name="setdata[become_check]" value="0" <?php  if(empty($set['become_check'])) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[become_check]" value="1" <?php  if($set['become_check'] ==1) { ?> checked="checked"<?php  } ?> /> 开启</label>
                    
                    <span class="help-block">如开启代理不通过审核将无法得到分红</span>
                </div> 
           </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">代理商订单商品详情</label>
                <div class="col-sm-9 col-xs-12">
                  <label class="radio-inline"><input type="radio"  name="setdata[openorderdetail]" value="0" <?php  if(empty($set['openorderdetail'])) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[openorderdetail]" value="1" <?php  if($set['openorderdetail'] ==1) { ?> checked="checked"<?php  } ?> /> 显示</label>
                    
                    <span class="help-block">代理商订单是否显示商品详情</span>
                </div> 
           </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">代理商订单购买者详情</label>
                <div class="col-sm-9 col-xs-12">
                  <label class="radio-inline"><input type="radio"  name="setdata[openorderbuyer]" value="0" <?php  if(empty($set['openorderbuyer'])) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[openorderbuyer]" value="1" <?php  if($set['openorderbuyer'] ==1) { ?> checked="checked"<?php  } ?> /> 显示</label>
                    
                    <span class="help-block">代理商订单是否显示购买者</span>
                </div> 
           </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示位置</label>
                <div class="col-sm-9 col-xs-12">
                  <label class="radio-inline"><input type="radio"  name="setdata[bonushow]" value="0" <?php  if(empty($set['bonushow'])) { ?> checked="checked"<?php  } ?> /> 会员中心</label>
                    <label class="radio-inline"><input type="radio"  name="setdata[bonushow]" value="1" <?php  if($set['bonushow'] ==1) { ?> checked="checked"<?php  } ?> /> 分销中心</label>
                    
                    <span class="help-block">选择显示位置，会员中心栏目单独分红中心，分销中心栏目显示</span>
                </div> 
           </div>
 </div>
	  <div class="panel-heading">
            等级设置
        </div>
	<div class='panel-body'>
		  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认级别名称</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="setdata[levelname]" class="form-control" value="<?php echo empty($set['levelname'])?'普通等级':$set['levelname']?>"  />
                    <span class="help-block">代理商默认等级名称，不填写默认“普通等级”</span>
                </div>
            </div> 
		<div class='panel-body'>
		  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">代理商等级升级依据</label>
                <div class="col-sm-9 col-xs-12">
              
                        
		                <!-- <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="1" <?php  if($set['leveltype']==1) { ?>checked<?php  } ?>/> 一级分销订单金额(完成的订单)
                        </label>		<br/>
						
					
		                <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="2" <?php  if($set['leveltype']==2) { ?>checked<?php  } ?>/> 分销订单总数(完成的订单)
                        </label>
					    <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="3" <?php  if($set['leveltype']==3) { ?>checked<?php  } ?>/> 一级分销订单总数(完成的订单)
                        </label> -->
				        <!-- <br /><br /> -->	
		                <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="leveltype[]" value="4" <?php  if(in_array('4', $set['leveltype'])) { ?>checked<?php  } ?>/> 自购订单金额(完成的订单)
                        </label>		
						<!-- <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="5" <?php  if($set['leveltype']==5) { ?>checked<?php  } ?>/> 自购订单数量(完成的订单)
                        </label>		
                    <br/>				
                		   
                		<br />
	                    <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="6" <?php  if($set['leveltype']==6) { ?>checked<?php  } ?>/> 下线总人数（分销商+非分销商）
                        </label>		
		                <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="7" <?php  if($set['leveltype']==7) { ?>checked<?php  } ?>/> 一级下线人数（分销商+非分销商）
                        </label> 
					    <br /> -->	
		                <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="leveltype[]" value="8" <?php  if(in_array('8', $set['leveltype'])) { ?>checked<?php  } ?>/> 下级分销商总人数
                        </label>	
                        <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="leveltype[]" value="11" <?php  if(in_array('11', $set['leveltype'])) { ?>checked<?php  } ?>/> 分销订单总额(完成的订单)
                        </label>	
		                <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="leveltype[]" value="9" <?php  if(in_array('9', $set['leveltype'])) { ?>checked<?php  } ?>/> 一级分销商人数
                        </label>
                        <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="leveltype[]" value="12" <?php  if(in_array('12', $set['leveltype'])) { ?>checked<?php  } ?>/> 二级分销商人数
                        </label>
                        <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="leveltype[]" value="13" <?php  if(in_array('13', $set['leveltype'])) { ?>checked<?php  } ?>/> 三级分销商人数
                        </label>
				        <!-- <br /><br />
				        <label class="checkbox checkbox-inline" style="width:240px">
                              <input type="checkbox" name="setdata[leveltype][]" value="10" <?php  if($set['leveltype']==10) { ?>checked<?php  } ?>/> 已提现佣金总金额
                        </label> -->	
                        
                      
                </div>
            </div>
			
 </div> </div> 
	
           <div class='panel-heading'>
            文字设置
        </div>
        <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红中心</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[center]" class="form-control" value="<?php echo empty($set['texts']['center'])?'分红中心':$set['texts']['center']?>"  />
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">代理商名称</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[agent]" class="form-control" value="<?php echo empty($set['texts']['agent'])?'代理商':$set['texts']['agent']?>"  />
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">全球分红</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[premiername]" class="form-control" value="<?php echo empty($set['texts']['premiername'])?'全球分红':$set['texts']['premiername']?>"  />
                    </div>
              </div>
            
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分红佣金</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[commission]" class="form-control" value="<?php echo empty($set['texts']['commission'])?'分红佣金':$set['texts']['commission']?>"  />
                    </div>
              </div>
             <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">累计团队地区分红佣金</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[commission_total]" class="form-control" value="<?php echo empty($set['texts']['commission_total'])?'累计团队地区分红佣金':$set['texts']['commission_total']?>"  />
                    </div>
              </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队地区待分红佣金</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[commission_ok]" class="form-control" value="<?php echo empty($set['texts']['commission_ok'])?'团队地区待分红佣金':$set['texts']['commission_ok']?>"  />
                    </div>
              </div>
			  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队地区已分红佣金</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[commission_pay]" class="form-control" value="<?php echo empty($set['texts']['commission_pay'])?'团队地区已分红佣金':$set['texts']['commission_pay']?>"/>
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队地区全球分红明细</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[commission_detail]" class="form-control" value="<?php echo empty($set['texts']['commission_detail'])?'团队地区全球分红明细':$set['texts']['commission_detail']?>"/>
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[team]" class="form-control" value="<?php echo empty($set['texts']['team'])?'团队':$set['texts']['team']?>"/>
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[area]" class="form-control" value="<?php echo empty($set['texts']['area'])?'地区':$set['texts']['area']?>"/>
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">全球</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[global]" class="form-control" value="<?php echo empty($set['texts']['global'])?'全球':$set['texts']['global']?>"/>
                    </div>
              </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队分红订单</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[order]" class="form-control" value="<?php echo empty($set['texts']['order'])?'团队订单':$set['texts']['order']?>"  />
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区分红订单</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[order_area]" class="form-control" value="<?php echo empty($set['texts']['order_area'])?'地区订单':$set['texts']['order_area']?>"  />
                    </div>
              </div>
              
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">团队无限级下线</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="texts[mycustomer]" class="form-control" value="<?php echo empty($set['texts']['mycustomer'])?'我的下线':$set['texts']['mycustomer']?>"  />
                    </div>
              </div>
              <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9">
                        <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick='return formcheck()' />
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    </div>
              </div>
        </div>
    </div>
</form>
</div>
</div>
<script type="text/javascript">

$(document).ready(function(){
  $(".sendmoth").click(function(){
    interval_day();
  });
  $(".distinction_area").click(function(){
    distinction_area();
  });
  
});

function interval_day(){
   if($('.sendmoth:checked').val()==1){
        $(".form-interval").show();
    }else{
       $(".form-interval").hide(); 
    } 
}
function distinction_area(){
   if($('.distinction_area:checked').val()==1){
        $(".form-areaall").show();
    }else{
       $(".form-areaall").hide(); 
    } 
}
interval_day();
distinction_area();
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
