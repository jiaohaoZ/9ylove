<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('mobile/header_tpl'); ?>
<body>
	<header class="mui-bar mui-bar-nav nav-bg">
		<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title">爱心活动</h1>
	    <link href="<?= theme_css('dropload.css') ?>" rel="stylesheet">
	</header>
	<div class="mui-content load-content">
		<ul class="nav-4">
		<?php if (!empty($lists)): ?>
			<?php foreach ($lists as $k => $v): ?>
				<li class="item" value="<?php echo $v['art_id']; ?>">
					<a href="<?php echo site_url("article/article_detail?art_id={$v['art_id']}") ?>">
						<p class="tit"><?php echo $v['title']; ?></p>
						<p class="date"><?php echo $v['year'].'年'.$v['month'].'月'.$v['day'].'日'; ?></p>
						<div class="img-box">
							<?php if (strlen($v['img']) > 2): ?>
								<?php echo $v['img']; ?>
							<?php endif ?>
						</div>
						<p class="click">立即查看</p>
					</a>
			</li>
			<?php endforeach ?>
			
		<?php endif ?>
			
			
		</ul>
	</div>
</body>
<script src="<?=theme_js('dropload.min.js') ?>"></script>
<script type="text/javascript" charset="utf-8">
(function($, doc) {
		$.init();
	
}(mui, document));

   $(function () {
        var num = 1;
        // dropload
        var dropload = $('.load-content').dropload({
            scrollArea: window,
            loadDownFn: function (me) {
                	num++;
                    $.ajax({
                        type: 'POST',
                        url: "<?=site_url('article/article_ajax')?>",
                        data:{'pnum':num},
                        dataType: 'json',
                        success: function (data) {
                        	if (data.sign=='none') {me.lock();me.noData();me.resetload();return;}
                        	$require = ''
                        	imgs =''
                        	console.log(data);
                        	rlength = data.lists.length;
                        	for(var i = 0; i < rlength;i++){
                        		detailUrl = "<?php echo site_url("article/article_detail?art_id=")?>" + data.lists[i].art_id
                        		if(data.lists[i].img.length >2){
                        		imgs = data.lists[i].img;
                        		}
							 	require = '<li class="item" value="'+data.lists[i].art_id+'"><a href="'+detailUrl+'"><p class="tit">'+data.lists[i].title+'</p><p class="date">'+data.lists[i].year+'年'+data.lists[i].month+'月'+data.lists[i].day+'日</p><div class="img-box">'+imgs+'</div><p class="click">立即查看</p></a></li>' ;
		                   		console.log(require);

		                  	$('.nav-4').eq(0).append(require);
                             me.resetload();		                 
		                    } 
                        },
                    });
                
            }
        });
    });


</script>
