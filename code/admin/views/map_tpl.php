<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header_tpl');
?>
<div class="pad-10">
<?php $n=1; foreach ($menu as $key=>$v):if($n==1) {echo '<div class="map-menu lf">';}?>
<ul>
<li class="title"><?php echo lang($v['name'])?></li>
<?php foreach ($v['childmenus'] as $k=>$r):?>
<li class="title2"><?php echo lang($r['name'])?></li>
<?php $menus = $menu[$v['id']]['children'][$r['id']];foreach ($menus as $s=>$r):?>
<li><a href="javascript:go('?m=<?php echo $r['m']?>&c=<?php echo $r['c']?>&a=<?php echo $r['a']?>&menuid=<?php echo $r['id']?><?php echo isset($r['data']) ? $r['data'] : ''?>')"><?php echo lang($r['name'])?></a></li>
<?php endforeach;endforeach;?>
</ul>
<?php if($n%2==0) {echo '</div><div class="map-menu lf">';}$n++; endforeach;?>
</div>

<script type="text/javascript">
<!--
 function go(url) {
	 window.top.document.getElementById('rightMain').src=url;
	 window.top.art.dialog({id:'map'}).close();
}
//-->
</script>
</body>
</html>