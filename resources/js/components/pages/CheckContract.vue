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
                    id="auto_number"
                    v-model="filter.auto_number"
                    @input="checkInput"
                    :class="isRequired(filter.auto_number) ? 'isRequired' : ''"
                  >
              </div>
                <button type="button" class="btn btn-secondary mr-3" @click.prevent="carCheck">
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
                        <th>{{$t('conducted_tenders.table.company_name')}}</th>
                        <th>{{$t('Shartnoma muddati')}}</th>
                        <th>{{$t('Litsenziya raqami')}}</th>
                        <th>{{$t('Litsenziya muddati')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="items != ''">
                      <td>{{items.id}}</td>
                      <td>
                        <div v-if="items.directions">
                          <div v-for="(item_d,index_d) in items.directions">
                            №{{item_d.direction_number}} {{item_d.direction_name}}
                          </div>
                        </div>
                      </td>
                      <td>{{items.user}}</td>
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
        auto_number:''
      },
      items:[],
      laoding: true,
      requiredInput: false,
    };
  },
  computed: {
    ...mapGetters('contract',['getContracts'])
  },
  async mounted() {
    this.laoding = false
  },
  methods: {
    ...mapActions('contract',['actionContractCheck']),
    checkInput(){
      this.filter.auto_number = this.filter.auto_number.toUpperCase();
      this.filter.auto_number = this.filter.auto_number.replace(/[^A-Z0-9]+/i, "");
      if (this.filter.auto_number.length > 8) {
        this.filter.auto_number = this.filter.auto_number.slice(0,8)
      }
      
    },
    async carCheck(){
      if(this.filter.auto_number.length == 8){
        await this.actionContractCheck(this.filter)
        if(this.getContracts.success){
          this.items = this.getContracts.result
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: this.getContracts.message,
          });
        }
      }else{
      }
    },
    isRequired(input){
      return this.requiredInput && input === '';
    },
  },
};
</script>
<style scoped>
</style>
