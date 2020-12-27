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
    .tenders_list{
        display: flex;
        align-items: stretch;
        flex-wrap: wrap;
        width: 100%;
    }
    .tender_card{
        width: calc(100% / 4 - 30px);
        background: #292666;
        margin-top: 30px;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        margin-right: 30px;
    }
    .tender_card:nth-child(4n){
        margin-right: 0;
    }
    .tender_card_header{
        text-align: center;
        padding: 0px;
    }
    .tender_card_header h5{
        margin-bottom: 0;
        font-weight: bold;
        color: #fff;
        padding: 10px;
        background: #6f42c1;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        padding-bottom: 20px;
    }
    .tender_card_header h6{
        color: #fff;
        padding: 10px 0px 0px 0px;
    }
    .tender_card_body{
        background: #fff;
        padding: 10px 20px;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        margin-top: -15px;
    }
    .card_item{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .card_item h6{
        width: 50%;
        font-weight: bold;
        margin: 0;
    }
    .card_item p{
        width: 50%;
        text-align: right;
        margin: 0;
    }
    .tender_card_footer{
        padding: 5px 15px;
        text-align: left;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-weight: bold;
        font-size: 20px;
        transition: .5s;
        text-decoration: none;
    }
    .tender_card:hover .tender_card_footer{
        background: rgba(0,0,0,.5);
    }
    .time_counter{
        background: transparent !important;
    }
</style>
