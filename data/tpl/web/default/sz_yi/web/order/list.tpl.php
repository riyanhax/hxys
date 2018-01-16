<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_header', TEMPLATE_INCLUDEPATH)) : (include template('web/_header', TEMPLATE_INCLUDEPATH));?>
<div class="w1200 m0a">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/order/tabs', TEMPLATE_INCLUDEPATH)) : (include template('web/order/tabs', TEMPLATE_INCLUDEPATH));?>
<link href="../addons/sz_yi/static/js/dist/select2/select2.css" rel="stylesheet">
<link href="../addons/sz_yi/static/js/dist/select2/select2-bootstrap.css" rel="stylesheet">
<script language="javascript" src="../addons/sz_yi/static/js/dist/select2/select2.min.js"></script>
<script language="javascript" src="../addons/sz_yi/static/js/dist/select2/select2_locale_zh-CN.js"></script>
<style type='text/css'>
.trhead td {  background:#f8f8f8;text-align: center}
.trbody td {  text-align: center; vertical-align:top;border-left:1px solid #DEDEDE;overflow: hidden;}
.goods_info{position:relative;width:60px;}
.goods_info img {width:50px;background:#fff;border:1px solid #DEDEDE;padding:1px;}
.goods_info:hover {z-index:1;position:absolute;width:auto;}
.goods_info:hover img{width:320px; height:320px;}
.form-control .select2-choice {
        border: 0 none;
        border-radius: 2px;
        height: 32px;    line-height: 32px;
    }
</style>
<div class="rightlist">
<?php  if($status != 9) { ?>
<div class="panel panel-default" style='margin-top:60px'>
    <div class="panel-body sx-border">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
            <input type="hidden" name="p" value="list" id="form_p" />
            <input type="hidden" name="do" value="order" id="form_do" />
            <input type="hidden" name="status" value="<?php  echo $status;?>" />
            <input type="hidden" name="agentid" value="<?php  echo $_GPC['agentid'];?>" />
            <input type="hidden" name="refund" value="<?php  echo $_GPC['refund'];?>" />  
            <div class="form-group">
                <div class="col-sm-8 col-lg-12 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>订单号</div>
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="订单号/支付单号">
                        <div class='input-group-addon'>商品名称</div>
                        <input class="form-control" name="good_name" type="text" value="<?php  echo $_GPC['good_name'];?>" placeholder="商品名称">
                        <div class='input-group-addon'>商品ID</div>
                        <input class="form-control" name="good_id" type="text" value="<?php  echo $_GPC['good_id'];?>" placeholder="商品ID">
                        <div class='input-group-addon'>快递单号</div>
                        <input class="form-control" name="expresssn" type="text" value="<?php  echo $_GPC['expresssn'];?>" placeholder="快递单号">
                        <div class='input-group-addon'>用户信息</div>
                        <input class="form-control" name="member" type="text" value="<?php  echo $_GPC['member'];?>" placeholder="用户手机号/姓名/昵称/绑定手机号, 收件人姓名/手机号 ">
                        <div class='input-group-addon'>支付方式</div>
                        <select name="paytype" class="form-control">
                            <option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>不限</option>
                            <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
                            <option value="<?php  echo $key;?>" <?php  if($_GPC['paytype'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
            </div> 
            <div class='form-group'>
                  <div class="col-sm-8 col-lg-12 col-xs-12">
                    <div class='input-group'>
                   <div class='input-group-addon'>核销员</div>
                        <input class="form-control" name="saler" type="text" value="<?php  echo $_GPC['saler'];?>" placeholder="核销员昵称/姓名/手机号/绑定手机号">
                        <div class='input-group-addon'>核销门店</div>
                        <select name="storeid" class="form-control">
                            <option value="" ></option>
             <?php  if(is_array($stores)) { foreach($stores as $store) { ?>
            <option value="<?php  echo $store['id'];?>" <?php  if($_GPC['storeid'] ==$store['id']) { ?> selected="selected" <?php  } ?>><?php  echo $store['storename'];?></option>
            <?php  } } ?>
                        </select>
                    <?php  if($p_cashier) { ?>
                        <div class='input-group-addon'>收银商户</div>
                        <select name="csid" class="form-control">
                            <option value="" ></option>
             <?php  if(is_array($cashier_stores)) { foreach($cashier_stores as $cashier_store) { ?>
            <option value="<?php  echo $cashier_store['id'];?>" <?php  if($_GPC['csid'] ==$cashier_store['id']) { ?> selected="selected" <?php  } ?>><?php  echo $cashier_store['name'];?></option>
            <?php  } } ?>
                        </select>
                    <?php  } ?>
                        <div class='input-group-addon'>门店取消订单
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='cancel' <?php  if($_GPC['cancel']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='cancel' <?php  if($_GPC['cancel']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
            </div>
                  </div>
            </div>

            <?php  if(p('supplier')) { ?>
            <div class='form-group'>
                <div class="col-sm-8 col-lg-12 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>供应商</div>
                        <select name="supplier_uid" class="form-control">
                            <option value="" ></option>
                            <?php  if(is_array($suppliers)) { foreach($suppliers as $supplier) { ?>
                            <option value="<?php  echo $supplier['uid'];?>" <?php  if($_GPC['supplier_uid'] ==$supplier['uid']) { ?> selected="selected" <?php  } ?>><?php  echo $supplier['username'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php  } ?>

            <div class="form-group">
                    <div class="col-sm-12 col-lg-6">
                        <div class='input-group'>
                            <div class='input-group-addon'>下单时间
                                <label class='radio-inline' style='margin-top:-7px;'>
                                    <input type='radio' value='0' name='searchtime' <?php  if($_GPC['searchtime']=='0') { ?>checked<?php  } ?>>不搜索
                                </label>
                                <label class='radio-inline'  style='margin-top:-7px;'>
                                    <input type='radio' value='1' name='searchtime' <?php  if($_GPC['searchtime']=='1') { ?>checked<?php  } ?>>搜索
                                </label>
                            </div>
                            <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>
                        </div>
                        <div class='input-group'>
                          <div class='input-group-addon'>完成时间
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='fsearchtime' <?php  if($_GPC['fsearchtime']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='fsearchtime' <?php  if($_GPC['fsearchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                        <?php  echo tpl_form_field_daterange('ftime', array('starttime'=>date('Y-m-d H:i', $fstarttime),'endtime'=>date('Y-m-d H:i', $fendtime)),true);?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class='input-group'>
                            <div class='input-group-addon'>付款时间
                                <label class='radio-inline' style='margin-top:-7px;'>
                                    <input type='radio' value='0' name='psearchtime' <?php  if($_GPC['psearchtime']=='0') { ?>checked<?php  } ?>>不搜索
                                </label>
                                <label class='radio-inline'  style='margin-top:-7px;'>
                                    <input type='radio' value='1' name='psearchtime' <?php  if($_GPC['psearchtime']=='1') { ?>checked<?php  } ?>>搜索
                                </label>
                            </div>
                            <?php  echo tpl_form_field_daterange('ptime', array('starttime'=>date('Y-m-d H:i', $pstarttime),'endtime'=>date('Y-m-d H:i', $pendtime)),true);?>
                        </div>
                        <div class='input-group'>
                            <div class='input-group-addon'>发货时间
                                <label class='radio-inline' style='margin-top:-7px;'>
                                    <input type='radio' value='0' name='ssearchtime' <?php  if($_GPC['ssearchtime']=='0') { ?>checked<?php  } ?>>不搜索
                                </label>
                                <label class='radio-inline'  style='margin-top:-7px;'>
                                    <input type='radio' value='1' name='ssearchtime' <?php  if($_GPC['ssearchtime']=='1') { ?>checked<?php  } ?>>搜索
                                </label>
                            </div>
                            <?php  echo tpl_form_field_daterange('stime', array('starttime'=>date('Y-m-d H:i', $sstarttime),'endtime'=>date('Y-m-d H:i', $sendtime)),true);?>
                        </div>
                    </div>

                    <div class='input-group'>


                    </div>


            </div>
            <div class="form-group">
                <?php  if(!empty($agentid) && $level>0) { ?>   
                <div class="col-sm-3">
                    <div class='input-group'>
                        <div class='input-group-addon'>分销订单级数</div>
                        <select name="olevel" class="form-control">
                            <option value="" >不限</option>
                            <option value="1" <?php  if($_GPC['olevel'] ==1) { ?> selected="selected" <?php  } ?>>一级订单</option>
                            <option value="2" <?php  if($_GPC['olevel'] ==2) { ?> selected="selected" <?php  } ?>>二级订单</option>
                            <option value="3" <?php  if($_GPC['olevel'] ==3) { ?> selected="selected" <?php  } ?>>三级订单</option>
                        </select>
                    </div>    </div>
                <?php  } ?>
            </div>
            <div class="form-group">

                <div class="col-sm-7 col-lg-9 col-xs-12">
                    <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <button type="button" name="export" value="1" id="export" class="btn btn-primary">导出 Excel</button>
                    <a class="btn btn-warning" href="<?php  echo $this->createWebUrl('order/export')?>">自定义导出</a>
                </div>

            </div>
     
        </form>
    </div>
</div>

        <table class='table' style='float:left;margin-bottom:0;table-layout: fixed;line-height: 40px;height: 40px'>
                 <tr class='trhead'>
                    <td colspan='8' style="text-align: left;">
                        订单数: <span id="total">--</span>  订单金额: <span id="totalmoney" style="color:red">--</span>元&nbsp;<?php  if($perm_role == 1) { ?>结算金额: <span style="color:red"><?php  if($costmoney>0) { ?><?php  echo $costmoney;?></span>元 &nbsp;<a class="btn btn-default" href="<?php  echo $this->createWebUrl('order/list',array('applytype'=>1))?>">提现</a><?php  if(!empty($shopset['weixin'])) { ?><a class='btn btn-default' onclick="return confirm('确认微信钱包提现?')" href="<?php  echo $this->createWebUrl('order/list',array('applytype'=>2));?>">微信提现</a><?php  } ?><?php  } else { ?>没有可提现金额<?php  } ?><?php  } ?>                        
                    </td>
                </tr>
        </table>
        <table class='table' style='float:left;margin-bottom:5px;table-layout: fixed;line-height: 40px;height: 40px'>
                <tr class='trhead' style='line-height: 40px'>
                    <td colspan='2'style="width: 19%;text-align:left;">商品</td>
                    <td style='text-align:left;'>单价/数量</td>
                    <td>买家</td>
                    <td>支付方式/配送方式</td>
                    <td>价格</td>             
                    <td>状态</td>
                    <td>操作</td>
                </tr>
            </table>
          
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
  <table class='table' style='float:left;border:1px solid #ccc;margin-top:5px;margin-bottom:0px;table-layout: fixed;'>
                <tr >
                    <td colspan='8'  style='border-bottom:1px solid #ccc;background:#f8f8f8;' > 
                        <b>订单编号:</b>  <?php  echo $item['ordersn_general'];?> 
                        <?php  if($item['pay_ordersn']) { ?>
                        <b>支付单号:</b>  <?php  echo $item['pay_ordersn'];?> 
                        <?php  } ?>
                        <b>下单时间:  </b><?php  echo date('Y-m-d H:i:s', $item['createtime'])?>
                        <?php  if(!empty($item['refundstate'])) { ?><label class='label label-danger'><?php  echo $r_type[$item['rtype']];?>申请</label><?php  } ?>
                        <?php  if($item['rstatus'] == 4) { ?><label class='label label-primary'>客户已经寄出快递</label><?php  } ?>
                        
                        <label class="label label-info"><?php  echo $item['vendor'];?></label>
                        <?php  if(!empty($item['storename'])) { ?>
                        <label class="label label-primary">所属门店：<?php  echo $item['storename'];?></label>
                        <?php  } ?>
                    <td style='border-bottom:1px solid #ccc;background:#f8f8f8;text-align: center' >
                          <?php  if(empty($item['statusvalue'])) { ?>
                           <?php if(cv('order.op.close')) { ?>
                                  <a class="btn btn-default btn-sm" href="javascript:;" onclick="$('#modal-close').find(':input[name=id]').val('<?php  echo $item['id'];?>')" data-toggle="modal" data-target="#modal-close">关闭订单</a>
                            <?php  } ?>
                            <?php  } ?>
                    </td>

                    <?php  if(empty($_W['isagent']) && $item['isempty'] == 1 && $item['ismaster'] == 1) { ?>
                    <td style="...">
                        <input class='itemid'  type='hidden' value="<?php  echo $item['id'];?>"  />
                        <a class="btn btn-primary btn-sm" href="javascript:;" onclick="sendagent(this)" data-toggle="modal" data-target="#modal-changeagent">选择门店</a>
                    </td>
                    <?php  } ?>

                         
                </tr>
  </table>
      <table class='table' style='float:left;border:1px solid #ccc;border-top:none;table-layout: fixed;'>

<?php  if(is_array($item['goods'])) { foreach($item['goods'] as $k => $g) { ?>
                <tr class='trbody'>
                    <td class="goods_info">
                         <img src="<?php  if($item['cashier']==1) { ?><?php  echo $item['name']['thumb'];?><?php  } else { ?><?php  echo tomedia($g['thumb'])?><?php  } ?>"> 
                    </td>
                    <td valign='top'  style='border-left:none;text-align: left;/*width:400px*/;'  >
                        <?php  if($item['cashier']==1) { ?><?php  echo $item['name']['name'];?><?php  } else { ?><?php  echo $g['title'];?><?php  } ?><?php  if(!empty($g['optiontitle'])) { ?><br/><span class="label label-primary sizebg"><?php  echo $g['optiontitle'];?></span><?php  } ?>
                        <br/><?php  echo $g['goodssn'];?>
                    </td>
                    <td style='border-left:none;text-align:left;/*width:150px*/'>原价: <?php  echo number_format( $g['price']/$g['total'],2)?> <br />应付: <?php  echo number_format($g['realprice']/$g['total'],2)?>
        <br/>数量: <?php  echo $g['total'];?>           
                    </td>
                    
                    <?php  if($k==0) { ?>
                    <td rowspan="<?php  echo count($item['goods'])?>" >
                         <?php if(cv('member.member.edit')) { ?>
                         <a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail', 'id'=>$item['mid']))?>"> <?php  echo $item['nickname'];?></a>
                         <?php  } else { ?>
                             <?php  echo $item['nickname'];?>
                             <?php  } ?>
                             
                             <br/>
                        <?php  echo $item['addressdata']['realname'];?><br/><?php  echo $item['addressdata']['mobile'];?></td>
                    <td rowspan="<?php  echo count($item['goods'])?>"    >
                    <?php  if($item['statusvalue'] > 0) { ?>
                    <label class='label label-<?php  echo $item['css'];?>'><?php  echo $item['paytype'];?></label><br/>
                    <?php  } else if($item['statusvalue'] == 0) { ?>
                    <?php  if($item['paytypevalue'] == 3) { ?>
                    <label class='label label-default'>货到付款</label><br/>
                    <?php  } else { ?>
                    <label class='label label-default'>未支付</label><br/>
                    <?php  } ?>
                    <?php  } else if($item['statusvalue'] == -1) { ?>
                    <label class='label label-default'><?php  echo $item['paytype'];?></label><br/>
                    <?php  } ?>
                                       <?php  echo $item['dispatchname'];?>
                                       <?php  if($item['addressid']!=0 && $item['statusvalue']>=2) { ?><br/>
                                       <button type='button' class='btn btn-default btn-sm' onclick='express_find(this,"<?php  echo $item['id'];?>")' >查看物流</button>
                                       <?php  } ?>
                    </td>
                    <td  rowspan="<?php  echo count($item['goods'])?>" style='width:18%;'>
                        <table style='width:100%;'>
                            <tr>
                                <td  style='border:none;text-align:right;'>商品小计：</td>
                                <td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['goodsprice'] ,2)?></td>
                            </tr>
                            <tr>
                                <td  style='border:none;text-align:right;'>运费：</td>
                                <td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['olddispatchprice'],2)?></td>
                            </tr>
                            <?php  if($item['discountprice']>0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>会员折扣：</td>
                                <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['discountprice'],2)?></td>
                            </tr>
                            <?php  } ?>
                            <?php  if($item['deductyunbimoney']>0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'><?php  if(!empty($yunbiset['yunbi_title'])) { ?><?php  echo $yunbiset['yunbi_title']?><?php  } else { ?>云币<?php  } ?>抵扣：</td>
                                <td  style='border:none;text-align:right;;'>-￥<?php  echo $item['deductyunbimoney']?></td>
                            </tr>
                            <?php  } ?>
                            <?php  if($item['deductprice']>0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>积分抵扣：</td>
                                <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductprice'],2)?></td>
                            </tr>
                            <?php  } ?>
                            <?php  if($item['deductcredit2']>0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>余额抵扣：</td>
                                <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductcredit2'],2)?></td>
                            </tr> 
                            <?php  } ?>
                            <?php  if($item['deductenough']>0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>满额立减：</td>
                                <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductenough'],2)?></td>
                            </tr>
                            <?php  } ?>
                            <?php  if($item['couponprice']>0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>优惠券优惠：</td>
                                <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['couponprice'],2)?></td>
                            </tr>
                            <?php  } ?>
                            <?php  if(intval($item['changeprice'])!=0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>卖家改价：</td>
                                <td  style='border:none;text-align:right;;'><span style="<?php  if(0<$item['changeprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>"><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo number_format(abs($item['changeprice']),2)?></span></td>
                            </tr>
                                 <?php  } ?>
                            <?php  if(intval($item['changedispatchprice'])!=0) { ?>
                            <tr>
                                <td  style='border:none;text-align:right;'>卖家改运费：</td>
                                <td  style='border:none;text-align:right;;'><span style="<?php  if(0<$item['changedispatchprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>"><?php  if(0<$item['changedispatchprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo abs($item['changedispatchprice'])?></span></td>
                            </tr>
                                 <?php  } ?> 
                        <tr>
                                <td style='border:none;text-align:right;'>应收款：</td>
                                <td  style='border:none;text-align:right;color:green;'>￥<?php  echo number_format($item['price'],2)?></td>
                            </tr>
                                    <?php if(cv('order.op.changeprice')) { ?>
            <?php  if(empty($item['statusvalue'])) { ?>
                            <tr>
                                <td style='border:none;text-align:right;'></td>
                                <?php  if($item['ischangePrice'] == 1) { ?>
                                <td  style='border:none;text-align:right;color:green;'><a href="javascript:;" class="btn btn-link " onclick="changePrice('<?php  echo $item['id'];?>')">修改价格</a></td>
                                <?php  } ?>
                            </tr>
                            <?php  } ?>  <?php  } ?>
                        </table>
                 
                 
     
                    </td>
                    <td   rowspan="<?php  echo count($item['goods'])?>" ><label class='label label-<?php  echo $item['statuscss'];?>'><?php  echo $item['status'];?></label><br />
                    <a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $item['id']))?>"   >查看详情</a></td>
                     <td   rowspan="<?php  echo count($item['goods'])?>" width="10%">
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/order/ops', TEMPLATE_INCLUDEPATH)) : (include template('web/order/ops', TEMPLATE_INCLUDEPATH));?>
                     </td>
            <?php  } ?> 
        </tr>
        
    <?php  } } ?>
        <tr>
            <td colspan="4">
                <?php  if(!empty($level)) { ?>
                    <?php  if(!empty($item['agentid']) && (!empty($item['commission1']) || !empty($item['commission2']) || !empty($item['commission3']) )) { ?>
                    <i class="iconfont icon-sitemap biz" style="color:#fff;background-color: #3366FF;"></i>
                     <b style="color:#3366FF">分销佣金:</b>
                     <?php  } ?>
                      <?php  if(empty($agentid)) { ?>
                      <?php  if($item['commission1']>0) { ?><b>1级佣金:</b> <?php  echo $item['commission1'];?> 元 <?php  } ?>
                      <?php  if($item['commission2']>0) { ?><b>2级佣金:</b> <?php  echo $item['commission2'];?> 元 <?php  } ?>
                      <?php  if($item['commission3']>0) { ?><b>3级佣金:</b> <?php  echo $item['commission3'];?> 元 <?php  } ?>
                      <?php  } ?>
                      <?php  if(!empty($item['agentid'])) { ?>
                    <?php if(cv('commission.changecommission')) { ?>
                    <a href='javascript:;' class='btn btn-default' onclick="commission_change('<?php  echo $item['id'];?>')">修改佣金</a>
                    <?php  } ?>
                      <?php  } ?>
                 
                 <?php  } ?>
            </td>
            <td colspan="4">
                <?php  if($item['bonus_range_money'] > 0 || $item['bonus_area_money'] > 0) { ?>
                    <i class="iconfont icon-fh biz" style="color:#fff;background-color: #FF3300;"></i>
                    <b style="color:#FF3300">分红佣金:</b>
                    <?php  if($item['bonus_range_money'] > 0) { ?>
                        <b>订单代理分红:</b> <?php  echo $item['bonus_range_money'];?>元
                    <?php  } ?>
                    <?php  if($item['bonus_area_money'] > 0) { ?>
                        <b>订单区域分红:</b> <?php  echo $item['bonus_area_money'];?>元
                    <?php  } ?>
                    <?php  if($item['bonus_range_money'] > 0 && $item['bonus_area_money'] > 0) { ?>
                        <b>订单总分红:</b> <?php  echo $item['bonus_money_all'];?>元
                    <?php  } ?> 
                <?php  } ?> 
            </td>
        </tr>
   </table>
<?php  } } ?>
            
<?php  } else { ?>
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner" >
                <tr>
                    <th style='width:8%;'>供应商ID</th>
                    <th style='width:22%;'>提现单号</th>
                    <th style='width:20%;'>提现金额</th>
                    <th style='width:10%;'>提现方式<br>手动/微信</th>
                    <th style='width:22%;'>申请时间<br>完成时间</th>
                    <th style='width:29%;'>状态</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($supplierapply)) { foreach($supplierapply as $row) { ?>
                    <?php  if(!empty($row['uid'])) { ?>
                        <tr>
                            <td><?php  echo $row['uid'];?></td>
                            <td><?php  echo $row['applysn'];?></td>
                            <td><a class="btn btn-danger" href="<?php  if($row['status'] == 0) { ?><?php  echo $this->createPluginWebUrl('supplier/supplier_list',array('apply_id' => $row['id']));?><?php  } else { ?>#<?php  } ?>">金额：<?php  echo $row['apply_money'];?>元<?php  if($row['status'] == 0) { ?>(点击查看订单)<?php  } ?></a></td>
                            <td><?php  if($row['type']==1) { ?><button type="button" class="btn btn-warning">手动提现</button><?php  } else if($row['type']==2) { ?><button type="button" class="btn btn-success">微信提现</button><?php  } ?></td>
                            <?php  if($row['status'] == 0) { ?>
                            <td><?php  echo date('Y-m-d H:i:s',$row['apply_time']);?></td>
                            <td  style="overflow:visible;">
                                <button type="button" class="btn btn-info">申请中，等待审核</button>
                            </td>
                            <?php  } else { ?>
                            <td><?php  echo date('Y-m-d H:i:s',$row['finish_time']);?></td>
                            <td  style="overflow:visible;">
                                <button type="button" class="btn btn-danger">已打款，审核通过</button>
                            </td>
                            <?php  } ?>
                        </tr>
                    <?php  } ?>
                <?php  } } ?>
            </tbody>
        </table>
    </div>
</div>
<?php  } ?>  
<div id="pager"></div>
</div>
</div>                                                      
<script language="javascript">
    

    function send(btn){
        var modal =$('#modal-confirmsend');
        var itemid = $(btn).parent().find('.itemid').val();
            modal.find(':input[name=id]').val( itemid );
            var addressdata  = eval('(' +$(btn).parent().find('.addressdata').val()+')');
            modal.find('.realname').html(addressdata.realname);
            modal.find('.mobile').html(addressdata.mobile);
            modal.find('.address').html(addressdata.address);
    }
    $(function () {
        $.ajax({
            url: window.location.href,
            type: 'post',
            success: function (serverData) {
                if(serverData){
                    eval("var data=" + serverData + "");
                    $("#pager").html(data.result.pager);
                    $("#total").html(data.result.total);
                    $("#totalmoney").html(data.result.totalmoney);
                }
            }
        })
        $('#export').click(function(){
            $('#form_p').val("exportOrder");
            $('#form1').submit();   
            $('#form_p').val("list");
        });
        $('.select2').select2({
            search: true,
            placeholder: "请选择门店",
            allowClear: true
        });
    });
    function sendagent(btn){
        var modal =$('#modal-changeagent');
        var itemid = $(btn).parent().find('.itemid').val();
        modal.find(':input[name=id]').val( itemid );
    }
</script> 
                    
         <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/order/modals', TEMPLATE_INCLUDEPATH)) : (include template('web/order/modals', TEMPLATE_INCLUDEPATH));?>
          <?php  if(p('commission')) { ?>
          
           <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('commission/changecommission', TEMPLATE_INCLUDEPATH)) : (include template('commission/changecommission', TEMPLATE_INCLUDEPATH));?>
          <?php  } ?>
        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
