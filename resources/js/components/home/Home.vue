<template>
    <header class="main_header">
        <div class="container">
            <a href="/" class="logo"><img src="img/logoUz.png" alt=""></a>
            <ul class="menu_list">
                <li><a href="#">Bosh saxifa</a></li>
                <li><a href="#">Tender haqida</a></li>
                <li><a href="#">Otqizilgan tenderlar</a></li>
                <li><a href="#">Biz bilan aloqa</a></li>
            </ul>
            <a href="#" class="btn_login"><i class="fas fa-sign-in-alt"></i>Tizimga kirish</a>
        </div>
    </header>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {};
  },
  computed: {},
  async mounted() {},
  methods: {},
};
</script>
<style  scoped>
.container{
    max-width: 1440px;
}
.main_header{
    background: #ffffff;
    background-color: #ffffff;
    padding: 15px 0px;
    background-color: #fff;
    -webkit-box-shadow: 0px 11px 68px 0px rgba(0, 0, 0, 0.14);
    box-shadow: 0px 11px 68px 0px rgba(0, 0, 0, 0.14);
    width: 100%;
}
.main_header .logo{
    width: 300px;
    display: block;
}
.main_header .logo img{
    width: 100%;
}
.main_header .container{
    display: flex;
    align-items: center;
}
.main_header .menu_list{
    display: flex;
    margin-left: auto;
    margin-bottom: 0;
}
.main_header .menu_list li{
    list-style: none;
}
.main_header .menu_list li a{
    font-size: 15px;
    font-weight: 600;
    margin-right: 55px;
    font-family: "Poppins-Regular";
    color: #000;
    position: relative;
        transition: .3s all ease-in-out;
}
.main_header .menu_list li a:before {
    content: '';
    position: absolute;
    height: 2px;
    width: 0%;
    background-color: #292666;
    left: 2px;
    -webkit-transition: .3s all ease-in-out;
    -o-transition: .3s all ease-in-out;
    transition: .3s all ease-in-out;
    bottom: -5px;
}
.main_header .menu_list li a:hover {
    color: #292666;
}
.main_header .menu_list li a:hover:before {
    width: 100%;
}
.btn_login{
    line-height: 40px;
    border-radius: 30px;
    background-color: #292666;
    padding-left: 30px;
    padding-right: 30px;
    color: #fff;
    font-weight: 600;
    font-family: "Poppins-Regular";
}
.btn_login i{
    margin-right: 10px;
}
.main_header .menu_list li a,
.btn_login:hover{
    text-decoration: none;
}

</style>