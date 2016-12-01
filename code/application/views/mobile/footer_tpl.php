
<nav class="mui-bar mui-bar-tab index-footer-bar">
    <a class="mui-tab-item <?php if(current_url() == site_url('home/index') || current_url() == site_url('home')){ echo 'mui-active';}?>"
       href="<?= site_url('home/index') ?>">
        <span class="mui-icon iconfont icon-home"></span>
        <span class="mui-tab-label">首页</span>
    </a>
    <a class="mui-tab-item <?php if(current_url() == site_url('home/account')){ echo 'mui-active';}?>"
       href="<?= site_url('home/account') ?>">
        <span class="mui-icon iconfont icon-zhanghu"></span>
        <span class="mui-tab-label">账户</span>
    </a>
    <a class="mui-tab-item <?php if(current_url() == site_url('find/index')){ echo 'mui-active';}?>"
       href="<?= site_url('find/index') ?>">
        <span class="mui-icon iconfont icon-faxian"></span>
        <span class="mui-tab-label">发现</span>
    </a>
    <a class="mui-tab-item <?php if(current_url() == site_url('user/index')){ echo 'mui-active';}?>"
       href="<?= site_url('user/index') ?>">
        <span class="mui-icon iconfont icon-wode"></span>
        <span class="mui-tab-label">我的</span>
    </a>
</nav>

<script type="text/javascript" charset="utf-8">
    (function ($, doc) {
        $('.index-footer-bar').on('tap', '.mui-tab-item', function () {
            var href = this.getAttribute('href');
            window.location.href = href;
        })
    }(mui, document));
</script>