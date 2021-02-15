<template>
	<header class="main_header">
        <div class="container">
            <router-link to="/" class="logo"><img src="/img/logoUz.png" alt=""></router-link>
            <ul class="menu_list">
                <li >
                    <router-link to="/" exact> {{ $t('menu.home') }} </router-link>
                </li>
                <li>
                    <router-link to="/about">{{ $t('menu.about_tender') }}</router-link>
                </li>
                <li>
                    <router-link to="/checkcontract">{{ $t('menu.check_contract') }}</router-link>
                </li>
                <li>
                    <a href="#" role="button">{{ $t('menu.conducted_tenders') }}</a>
                    <div class="drop_down_menu">
                        <router-link to="/list-tender/active">Faol tenderlar</router-link>
                        <router-link to="/list-tender/completed">Yakunlangan tenderlar</router-link>
                    </div>
                </li>
                <li>
                    <router-link to="/contact">{{ $t('menu.contacts') }}</router-link>
                </li>
            </ul>
            <router-link to="/login" class="btn_login">
                <i class="fas fa-sign-in-alt"></i>
                {{$t('menu.login')}}
            </router-link>
        </div>
    </header>
</template>
<script>
	export default{

	}
</script>
