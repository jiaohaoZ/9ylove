<?php   
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="article" name="m">
<input type="hidden" value="message" name="c">
<input type="hidden" value="27" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo lang('addtime')?>：
				<?php echo calendar('start_time', $start_time)?>-
				<?php echo calendar('end_time', $end_time)?>		
				<?php echo lang('title')?>：
				<input name="title" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo lang('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="?c=message&m=article_sort" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
		    <th  align="center" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
			<th align="center"><?php echo lang('listorder')?></th>
			<th align="center">ID</th>
			<th align="center" style="width: 25%;"><?php echo lang('title')?></th>
			<th align="center"><?php echo lang('modifytime')?></th>
			<th align="center"><?php echo lang('status')?></th>
			<th align="center"><?php echo lang('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($lists)){
	foreach($lists as $k=>$v) {
?>
    <tr>
    	<td align="center"><input type="checkbox" value="<?php echo $v['art_id']?>" name="ids[]"></td>
		<td align="center"><input name='listorders[<?php echo $v['art_id'];?>]' type='text' size='3' value='<?php echo $v['sort_order'];?>' class='input-text-c'></td>
        <td align="center"><?php echo $v['art_id']?></td>
		<td align="center" ><?php echo $v['title']?></td>
		<td align="center"><?php echo date('Y-m-d H:i:s', $v['modify_time'])?></td>
		<td align="center"><?php echo $article_status[$v['status']]?></td>
		<td align="center"><a href="?c=message&m=article_edit&menuid=27&art_id=<?php echo $v['art_id']?>"><?php echo lang('edit')?></a><span>|</span>
		<a href="javascript:confirmurl('?c=message&m=article_del&a=delete&art_id=<?php echo $v['art_id']?>', '是否删除该公告？')"><?php echo lang('delete')?></a></td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="btn">
<input name="dosubmit" type="submit" class="button" value="<?php echo lang('listorder')?>"> 
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo lang('edit').lang('member')?>《'+name+'》',id:'edit',iframe:'?m=member&c=member&a=edit&userid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function checkuid() {
	var ids='';
	$("input[name='ids[]']:checked").each(function(i, n){
		ids += $(n).valang() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo lang('plsease_select').lang('company')?>',lock:true,width:'300',height:'200',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

function member_infomation(company_id) {
	window.top.art.dialog({id:'company_info'}).close();
	window.top.art.dialog({title:'<?php echo lang('company_info')?>',id:'company_info',iframe:'?m=company_info&c=member&company_id='+company_id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'company_info'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'company_info'}).close()});
}

//-->
</script>
</body>
</html>