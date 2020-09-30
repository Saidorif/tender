<template>
  <div class="tender_page">
    <header class="main_header">
      <div class="container">
        <a href="/" class="logo"><img src="img/logoUz.png" alt="" /></a>
        <ul class="menu_list">
          <li><a href="/">Bosh sahifa</a></li>
          <li ><a href="/about">Tender haqida</a></li>
          <li class="active"><a href="/list-tender">O'tkazilgan tenderlar</a></li>
          <li><a href="/contact">Biz bilan aloqa</a></li>
        </ul>
        <a href="/login" class="btn_login"
          ><i class="fas fa-sign-in-alt"></i>Tizimga kirish</a
        >
      </div>
    </header>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center">O'tkazilgan  <span>tenderlar</span> ro'yxati</h2>
        <p class="sub_title">Bu bo'limda siz bo'lib o'tkan tenderlar royxati bilan tanishasiz</p>
        <div class="table-responsive mt-5">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Yonalish nomi</th>
                        <th>Yonalish masofasi (km)</th>
                        <th>Korxona nomi</th>
                        <th>Sana</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Toshkent-nukus</td>
                        <td>1051</td>
                        <td>OOO 'Test'</td>
                        <td>20.12.2022</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jizzax-Buxoro</td>
                        <td>757</td>
                        <td>OOO 'MirTrans'</td>
                        <td>31.03.2021</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Andijon-Samarqand</td>
                        <td>595</td>
                        <td>OOO 'TestTrans'</td>
                        <td>15.05.2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { TokenService } from "./../../services/storage.service";
export default {
  data() {
    return {};
  },
  computed: {},
  async mounted() {},
  methods: {},
};
</script>
<style scoped>
</style>