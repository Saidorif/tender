<template>
  <div class="tender_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center" v-html="$t('conducted_tenders.title')"></h2>
        <p class="sub_title">{{$t('conducted_tenders.sub_title')}}</p>
        <div class="table-responsive mt-5">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>{{$t('conducted_tenders.table.direction_name')}}</th>
                        <th>{{$t('conducted_tenders.table.directional_distance')}}</th>
                        <th>{{$t('conducted_tenders.table.company_name')}}</th>
                        <th>{{$t('conducted_tenders.table.date')}}</th>
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
</style>
