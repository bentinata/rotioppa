<br>
<div class="jb-topbar">
	<a href="<?=site_url('home/index')?>"></a>
			<!--<div class="log">
				<? if($this->login_lib->m_has_login()){?>
					<a href="<?=site_url('login/logout')?>" class="login">Log Out</a>
					<a href="<?=site_url('member')?>" class="daftar">Member</a>
				<? }else{?>
					<a href="<?=site_url('login') ?>" class="login">Sign In</a> 
					<a href="<?=site_url('home/reg') ?>" class="daftar">Register</a>
				<? }?>
			</div-->
		<div id="block-wrap">
			<div class="jb-topbar-left">
				<a href="<?=site_url('home/home')?>"><img src="<?=theme_img('logo.png',false)?>" /></a>
			</div>
			
			<div class="jb-topbar-right">
				
				<form method="post" action="<?=site_url('home/search')?>" class="cart-search">
					<ul>
						<li><input type="text" name="search" required="required" placeholder="Search Item" /><span class="search">&nbsp;</span></li>
						<li>
							<img src="<?=theme_img('cartw.png',false)?>" class="cart-top" width="20" height="20" align="left"> &nbsp;&nbsp;&nbsp;
							<span style="color:black; font-weight:bold; margin-right:5px"><?=$count_cart?></span>
							<span style="color:black; font-weight:bold">RP. 0</span>
							<img src="<?=theme_img('clik.png',false)?>" id="panahe" class="cart-top" width="20" height="20" align="right" style="padding-right:20px">
							<!--a href="<?=site_url('home/cart')?>"><?=$count_cart?></a-->
							<ul class="panah">
								<li><a href="<?=site_url('home/cart')?>">My Cart</a></li>
								<li><a href="<?=site_url('home/cekout')?>">Checkout</a></li>
							</ul>
						</li>
						
					</ul>
				</form>
			</div>
		</div>
</div>

	<nav id='cssmenu'>
    
		<!--<div id="head-mobile">
        	<div class="nav-login" style="margin:-11px 35px 0px 0; height:30px; float:left;">
            	<a href="<?=site_url('home/cart')?>" style="margin-right:20px" class="cart-button"><img src="<?=theme_img('cart24.png',false)?>" /></a>
                <img style="margin-right:20px" class="search-button" src="<?=theme_img('search24.png',false)?>"  />
                <img style="margin-right:20px" class="user-button" src="<?=theme_img('user24.png',false)?>" />
            </div>
        </div>
        
        <div class="nav-search" style="width:100%;height:40px; border-top:solid #e81b3d 1px">
        		<div id='search-box'>
                    <form action="<?=site_url('home/search')?>" id="search-form" method="post">
                        <input id="search-text" name="search" required="required" placeholder="Masukan Nama Barang" type="text"/>
                        <button id='search-button' type='submit'><span>Cari</span></button>
                    </form>
                </div>
        </div>-->
        <div class="nav-user" style="width:100%;height:40px; border-top:solid #e81b3d 1px">
        		<div id='user-box'>
                 
                </div>
        </div>
        
        
		<div class="mbutton"></div>
		<ul class="nav">
			
		</ul>
	</nav>
<script type="text/javascript">
$(document).ready(function() {
	$("#panahe").click(function(){
		$(".panah").toggle("slideDown");
	});
});
</script>