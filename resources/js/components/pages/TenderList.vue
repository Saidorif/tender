<template>
  <div class="tender_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center" v-html="$t('conducted_tenders.title')"></h2>
        <p class="sub_title">{{$t('conducted_tenders.sub_title')}}</p>
        <div class="tenders_list">
            <!-- tender_card -->
            <div class="tender_card">
                <div class="tender_card_header">
                    <h6>Tender boshlanishga qolgan vaqt</h6>
                    <h5 id="myID">{{$g.dateCounter('2021-12-27 14:00:00', 'myID')}}</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Address</h6>
                        <p>	Uzbekistan Tashkent</p>
                    </div>
                    <div class="card_item">
                        <h6>Tender sanasi</h6>
                        <p>	20.01.2021</p>
                    </div>
                    <div class="card_item">
                        <h6>Lotlar</h6>
                        <p>2</p>
                    </div>
                    <div class="card_item">
                        <h6>Holati</h6>
                        <p>Tugatilmagan</p>
                    </div>
                </div>
                <router-link to='/u/show-tender-details/1' class="tender_card_footer" >Batafsil</router-link>
            </div>
            <!-- tender_card -->
            <div class="tender_card">
                <div class="tender_card_header">
                    <h6>Yo'nalish nomi</h6>
                    <h5>Jizzax - Buxoro</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Yo'nalish masofasi (km)</h6>
                        <p>	1051</p>
                    </div>
                    <div class="card_item">
                        <h6>Korxona nomi</h6>
                        <p>	OOO NargizTrans</p>
                    </div>
                    <div class="card_item">
                        <h6>Sana</h6>
                        <p>20.12.2022</p>
                    </div>
                    <div class="card_item">
                        <h6>Holati</h6>
                        <p>Tugatilgan</p>
                    </div>
                </div>
                <router-link to='/u/demand-tab/4' class="tender_card_footer" >Batafsil</router-link>
            </div>
            <!-- tender_card -->
            <div class="tender_card">
                <div class="tender_card_header">
                    <h6>Yo'nalish nomi</h6>
                    <h5>Andijon - Samarqand</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Yo'nalish masofasi (km)</h6>
                        <p>	1051</p>
                    </div>
                    <div class="card_item">
                        <h6>Korxona nomi</h6>
                        <p>	OOO NargizTrans</p>
                    </div>
                    <div class="card_item">
                        <h6>Sana</h6>
                        <p>20.12.2022</p>
                    </div>
                    <div class="card_item">
                        <h6>Holati</h6>
                        <p>Tugatilgan</p>
                    </div>
                </div>
                <router-link to='/u/demand-tab/1' class="tender_card_footer" >Batafsil</router-link>
            </div>
            <!-- tender_card -->
            <div class="tender_card">
                <div class="tender_card_header">
                    <h6>Yo'nalish nomi</h6>
                    <h5>Namangan - Toshkent</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Yo'nalish masofasi (km)</h6>
                        <p>	1051</p>
                    </div>
                    <div class="card_item">
                        <h6>Korxona nomi</h6>
                        <p>	OOO NargizTrans</p>
                    </div>
                    <div class="card_item">
                        <h6>Sana</h6>
                        <p>20.12.2022</p>
                    </div>
                    <div class="card_item">
                        <h6>Holati</h6>
                        <p>Tugatilgan</p>
                    </div>
                </div>
                <router-link to='/u/demand-tab/1' class="tender_card_footer" >Batafsil</router-link>
            </div>
            <!-- tender_card -->
            <div class="tender_card">
                <div class="tender_card_header">
                    <h6>Yo'nalish nomi</h6>
                    <h5>Namangan - Toshkent</h5>
                </div>
                <div class="tender_card_body">
                    <div class="card_item">
                        <h6>Yo'nalish masofasi (km)</h6>
                        <p>	1051</p>
                    </div>
                    <div class="card_item">
                        <h6>Korxona nomi</h6>
                        <p>	OOO NargizTrans</p>
                    </div>
                    <div class="card_item">
                        <h6>Sana</h6>
                        <p>20.12.2022</p>
                    </div>
                    <div class="card_item">
                        <h6>Lotlar</h6>
                        <p>2</p>
                    </div>
                </div>
                <router-link to='/u/demand-tab/1' class="tender_card_footer" >Batafsil</router-link>
            </div>
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
import Header from './Header'
import Loader from '../Loader'
export default {
    components:{
        Header,
        Loader
    },
  data() {
    return {laoding: true};
  },
  computed: {},
  async mounted() {
    this.laoding = false
  },
  methods: {},
};
</script>
<style scoped>
.tender_card_header .time_counter{
    background: transparent !important;
}
.time_counter{
    background: transparent !important;
}
</style>
