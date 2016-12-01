<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

foreach($datas as $_value) {
	echo '<h3 class="f14"><span class="switchs cu on" title="'.lang('expand_or_contract').'"></span>'.lang($_value['name']).'</h3>';
	echo '<ul>';
	$sub_array = $admin_model->admin_menu($_value['id']);
	foreach($sub_array as $_key=>$_m) {
		//参数
		$data = '?c='.$_m['c'].'&m='.$_m['m'].'&a='.$_m['a'] .'&menuid='.$_m['id'];
		$classname = 'class="sub_menu"';
		if(! get_view($_m['c'], $_m['m'], $_m['a'])) continue;
		echo '<li id="_MP'.$_m['id'].'" '.$classname.'><a href="javascript:_MP('.$_m['id'].',\''.$data.'\');" hidefocus="true" style="outline:none;">'.lang($_m['name']).'</a></li>';
	}
	echo '</ul>';
}
?>
<script type="text/javascript">
$(".switchs").each(function(i){
	var ul = $(this).parent().next();
	$(this).click(
	function(){
		if(ul.is(':visible')){
			ul.hide();
			$(this).removeClass('on');
				}else{
			ul.show();
			$(this).addClass('on');
		}
	})
});
</script>