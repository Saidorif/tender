<template>
	<header class="main_header">
        <div class="container">
            <router-link to="/" class="logo"><img src="img/logoUz.png" alt=""></router-link>
            <ul class="menu_list">
                <li >
                    <router-link to="/" exact>Bosh sahifa</router-link>
                </li>
                <li>
                    <router-link to="/about">Tender haqida</router-link>
                </li>
                <li>
                    <router-link to="/list-tender">O'tkazilgan tenderlar</router-link>
                </li>
                <li>
                    <router-link to="/contact">Biz bilan aloqa</router-link>
                </li>
            </ul>
            <router-link to="/login" class="btn_login">
                <i class="fas fa-sign-in-alt"></i>
                Tizimga kirish
            </router-link>
        </div>
    </header>
</template>
<script>
	export default{
		
	}
</script>