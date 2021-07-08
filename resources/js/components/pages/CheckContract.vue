<template>
  <div class="about_page">
    <Loader v-if="laoding"/>
    <Header/>
    <div class="container tender_block">
      <div class="col-md-12">
        <h2 class="title" align="center" v-html="$t('conducted_tenders.title')"></h2>
        <p class="sub_title">{{$t('conducted_tenders.sub_title')}}</p>
        <div class="row justify-content-end">
              <div class="col-8 col-sm-3">
                <input
                    type="text"
                    class="form-control input_style"
                    id="number"
                    v-mask="'********'"
                    v-model="filter.number"
                    :class="isRequired(filter.number) ? 'isRequired' : ''"
                  >
              </div>
                <button type="button" class="btn btn-secondary mr-3" @click.prevent="saveData">
                    <i class="fas fa-search"></i>
                    {{$t('Qidirish')}}
                </button>
        </div>
        <div class="table-responsive mt-5">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>{{$t('conducted_tenders.table.direction_name')}}</th>
                        <th>{{$t('Tashuvchi nomi')}}</th>
                        <th>{{$t('conducted_tenders.table.company_name')}}</th>
                        <th>{{$t('Shartnoma muddati')}}</th>
                        <th>{{$t('Litsenziya raqami')}}</th>
                        <th>{{$t('Litsenziya muddati')}}</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>Jizzax-Buxoro</td>
                        <td>Abdulla</td>
                        <td>OOO 'MirTrans'</td>
                        <td>31.03.2021</td>
                        <td>12334</td>
                        <td>22.08.2022</td>
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
    return {
      filter:{
        number:''
      },
      laoding: true,
      requiredInput: false,
    };
  },
  computed: {},
  async mounted() {
    this.laoding = false
  },
  methods: {
    isRequired(input){
      return this.requiredInput && input === '';
    },
  },
};
</script>
<style scoped>
</style>
