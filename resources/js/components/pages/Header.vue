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
                    <router-link to="/list-tender"> {{ $t('menu.conducted_tenders') }}</router-link>
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
