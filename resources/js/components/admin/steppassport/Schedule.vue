<template>
  <div class="add_area">
    <div class="card">
      <div class="card-header tabCard">
        <PassportTab/>
      </div>
      <div class="card-body">
        <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
          <div class="row col-md-12">
            <div class="form-group col-md-3">
              <label for="reys_to_count">Reyslar soni Toshkent tomondan</label>
              <input
                type="number"
                v-model="reys_to_count"
                id="reys_to_count"
                class="form-control input_style"
                :class="isRequired(reys_to_count) ? 'isRequired' : ''"
                @input="calcCountReys('reys_to_count')"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="reys_from_count">Reyslar soni Nukus tomondan</label>
              <input
                type="number"
                v-model="reys_from_count"
                id="reys_from_count"
                class="form-control input_style"
                :class="isRequired(reys_from_count) ? 'isRequired' : ''"
                @input="calcCountReys('reys_from_count')"
              />
            </div>
          </div>
          <h2>{{titulData.type.type}} - {{titulData.pass_number}} - sonli "{{titulData.name}}"Avtobus yo'nalishi qatnov yo'li masofasini va xarakat vaqtini olchash qaydnomasi</h2>
          <div class="col-md-4">
            <p>
              Qatnov yo'l masofasi
              <b v-if="titulData.timing_with.length">{{titulData.timing_with[titulData.timing_with.length - 1].end_speedometer}} km</b>
            </p>
          </div>
          <div class="col-md-4">
            <p>Qatnovchi avtomobillar soni  {{count_bus}}</p>
          </div>
          <div class="col-md-4">
            <p>Yolkira xaqqi so'm</p>
          </div>
          <template v-if="titulData.timing_with.length && titulData.timing_with[titulData.timing_with.length - 1].end_speedometer > 400">
            <div class="table-responisve"  v-for="(p_index) in Math.ceil(reys_to_count / 4)"  :key="p_index" >
              <table class="table table-bordered text-center table-hover table-striped" v-if="form.length">
                <thead>
                  <tr>
                    <th scope="col" colspan="8">{{form[0].reyses_from.where.name}} tomonga</th>
                    <th scope="col" rowspan="4">Toxtash joylarining nomlari</th>
                    <th scope="col" colspan="8">{{form[0].reyses_to.where.name}} tomonga</th>
                    <th scope="col" rowspan="4">Ochirib tashlash</th>
                  </tr>
                  <tr>
                    <th scope="col" colspan="8">Qatnov raqamlari va astronomik vaqt (soat-min)</th>
                    <th scope="col" colspan="8">Qatnov raqamlari va astronomik vaqt (soat-min)</th>
                  </tr>
                  <tr>
                    <th scope="col" class="reyslist reys1" data-reysnumber="reys1" colspan="2">Reys 1</th>
                    <th scope="col" class="reyslist reys2" data-reysnumber="reys2" colspan="2">Reys 2</th>
                    <th scope="col" class="reyslist reys3" data-reysnumber="reys3" colspan="2">Reys 3</th>
                    <th scope="col" class="reyslist reys4" data-reysnumber="reys4" colspan="2">Reys 4</th>
                    <th scope="col" class="reyslist reys5" data-reysnumber="reys5" colspan="2">Reys 1</th>
                    <th scope="col" class="reyslist reys6" data-reysnumber="reys6" colspan="2">Reys 2</th>
                    <th scope="col" class="reyslist reys7" data-reysnumber="reys7" colspan="2">Reys 3</th>
                    <th scope="col" class="reyslist reys8" data-reysnumber="reys8" colspan="2">Reys 4</th>
                  </tr>
                  <tr>
                    <th  colspan="1" class="reys1">Kelish vaqti</th>
                    <th  colspan="1" class="reys1">Jonash vaqti</th>
                    <th  colspan="1" class="reys2">Kelish vaqti</th>
                    <th  colspan="1" class="reys2">Jonash vaqti</th>
                    <th  colspan="1" class="reys3">Kelish vaqti</th>
                    <th  colspan="1" class="reys3">Jonash vaqti</th>
                    <th  colspan="1" class="reys4">Kelish vaqti</th>
                    <th  colspan="1" class="reys4">Jonash vaqti</th>
                    <th  colspan="1" class="reys5">Kelish vaqti</th>
                    <th  colspan="1" class="reys5">Jonash vaqti</th>
                    <th  colspan="1" class="reys6">Kelish vaqti</th>
                    <th  colspan="1" class="reys6">Jonash vaqti</th>
                    <th  colspan="1" class="reys7">Kelish vaqti</th>
                    <th  colspan="1" class="reys7">Jonash vaqti</th>
                    <th  colspan="1" class="reys8">Kelish vaqti</th>
                    <th  colspan="1" class="reys8">Jonash vaqti</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(table,index) in form"  :key="index" >
                  <template>
                      <td  class="reys1" colspan="1"><input  v-model="table.reyses_from.reyses[p_index-1].time_to_1" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys1"><input  v-model="table.reyses_from.reyses[p_index-1].time_from_1" type="text" class="table_input"></td>
                      <td  colspan="1" class="reys2 th_with_input"><input  v-model="table.reyses_from.reyses[p_index-1].time_to_2" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys2"><input  v-model="table.reyses_from.reyses[p_index-1].time_from_2" type="text" class="table_input" ></td>
                      <td  colspan="1"  class="reys3 th_with_input"><input v-model="table.reyses_from.reyses[p_index-1].time_to_3" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys3"><input  v-model="table.reyses_from.reyses[p_index-1].time_from_3" type="text" class="table_input"></td>
                      <td  colspan="1"  class="reys4 th_with_input"><input v-model="table.reyses_from.reyses[p_index-1].time_to_4" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys4"><input  v-model="table.reyses_from.reyses[p_index-1].time_from_4" type="text" class="table_input"></td>
                    </template>
                    <td  colspan="1">{{  table.stationName.name}}</td>
                    <template>
                      <td  class="th_with_input reys1" colspan="1"><input  v-model="table.reyses_to.reyses[p_index-1].time_to_1" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys1"><input  v-model="table.reyses_to.reyses[p_index-1].time_from_1" type="text" class="table_input"></td>
                      <td  colspan="1" class="reys2 th_with_input"><input  v-model="table.reyses_to.reyses[p_index-1].time_to_2" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys2"><input  v-model="table.reyses_to.reyses[p_index-1].time_from_2" type="text" class="table_input" ></td>
                      <td  colspan="1"  class="reys3 th_with_input"><input  v-model="table.reyses_to.reyses[p_index-1].time_to_3" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys3"><input  v-model="table.reyses_to.reyses[p_index-1].time_from_3" type="text" class="table_input"></td>
                      <td  colspan="1"  class="reys4 th_with_input"><input  v-model="table.reyses_to.reyses[p_index-1].time_to_4" type="text" class="table_input"></td>
                      <td  colspan="1" class="th_with_input reys4"><input  v-model="table.reyses_to.reyses[p_index-1].time_from_4" type="text" class="table_input"></td>
                    </template>
                    <td  colspan="1" class="th_with_input"><button @click="removeItem(index)" type="button" class="btn btn-danger btn_trash"><i  class="fas fa-trash"></i></button></td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </template>
          <template v-else>
            <div class="table-responisve"  >
              <table class="table table-bordered text-center table-hover table-striped" v-if="form.length">
                <thead>
                  <tr>
                    <th scope="col" rowspan="5">Рейс</th>
                    <th scope="col" colspan="6">От {{form[0].reyses_from.where.name}}</th>
                    <th scope="col" colspan="6">От {{form[0].reyses_to.where.name}}</th>
                  </tr>
                  <tr>
                    <th colspan="2">наименование начального пункта</th>
                    <th colspan="2">наименование контрольного пункта</th>
                    <th colspan="1">наименование кончного пункта</th>
                    <th colspan="1" rowspan="2">Рейс изчиллиги</th>
                    <th colspan="2">наименование начального пункта</th>
                    <th colspan="2">наименование контрольного пункта</th>
                    <th colspan="1">наименование кончного пункта</th>
                    <th colspan="1" rowspan="2">Рейс изчиллиги</th>
                  </tr>
                  <tr>
                    <th>Прибытие</th>
                    <th>Отправление</th>
                    <th>Прибытие</th>
                    <th>Отправление</th>
                    <th>Прибытие</th>
                    <th>Прибытие</th>
                    <th>Отправление</th>
                    <th>Прибытие</th>
                    <th>Отправление</th>
                    <th>Прибытие</th>
                  </tr>
                </thead>
                <tbody>
                  <tr   v-for="(p_item, p_index) in form[0].reyses_from.reyses"  >
                    <td>{{ p_index + 1 }}</td>
                      <td  class="reys1" colspan="1"><input v-model="p_item.time_from_1"   type="text" class="table_input"></td>
                      <td  class="reys1 th_with_input" colspan="1"><input v-model="p_item.time_to_1"   type="text" class="table_input"></td>
                      <td  class="reys1" colspan="1"><input v-model="p_item.time_from_2"   type="text" class="table_input"></td>
                      <td  class="reys1 th_with_input" colspan="1"><input v-model="p_item.time_to_2"   type="text" class="table_input"></td>
                      <td  class="reys1" colspan="1"><input v-model="p_item.time_from_3"   type="text" class="table_input"></td>
                      <td  class="reys1 th_with_input" colspan="1"><input v-model="p_item.sequence"   type="text" class="table_input"></td>
                      <td  class="reys1" colspan="1"><input v-model="form[0].reyses_to.reyses[p_index].time_from_1"   type="text" class="table_input"></td>
                      <td  class="reys1 th_with_input" colspan="1"><input v-model="form[0].reyses_to.reyses[p_index].time_to_1"   type="text" class="table_input"></td>
                      <td  class="reys1" colspan="1"><input v-model="form[0].reyses_to.reyses[p_index].time_from_2"   type="text" class="table_input"></td>
                      <td  class="reys1 th_with_input" colspan="1"><input v-model="form[0].reyses_to.reyses[p_index].time_to_2"   type="text" class="table_input"></td>
                      <td  class="reys1" colspan="1"><input v-model="form[0].reyses_to.reyses[p_index].time_from_3"   type="text" class="table_input"></td>
                      <td  class="reys1 th_with_input" colspan="1"><input v-model="form[0].reyses_to.reyses[p_index].sequence"   type="text" class="table_input"></td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </template>
          <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
            <button  type="submit" class="btn btn-primary btn_save_category"><i  class="fas fa-save"></i>
              Сохранить
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>

import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import PassportTab from "./PassportTab";
export default {
  components: {
    DatePicker,
    PassportTab,
  },
  data() {
    return {
      titulData: [],
      form: [],
      count_bus: 5,
      reys_to_count:1,
      reys_from_count:1,
    };
  },
  async mounted() {
    await this.actionEditDirection(this.$route.params.directionId);
    this.titulData = this.getDirection
    this.titulData.timing_with.forEach((element, index) => {
      let dataObj = {
        reyses_to:{
          reyses:[{
            time_from_1: '',
            time_to_1: '',
            time_from_2: '',
            time_to_2: '',
            time_from_3: '',
            time_to_3: '',
            time_from_4: '',
            time_to_4: '',
            sequence: ''
          }],
          where: this.titulData.timing_with[0].whereForm
        },
        reyses_from:{
          reyses:[{
            time_from_1: '',
            time_to_1: '',
            time_from_2: '',
            time_to_2: '',
            time_from_3: '',
            time_to_3: '',
            time_from_4: '',
            time_to_4: '',
            sequence: ''
          }],
          where: this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo
        },
        stationName:  element.whereForm,
      }
      this.form.push(dataObj)
        if (index === this.titulData.timing_with.length - 1){ 
          let lastObj = {
            reyses_to:{
              reyses:[{
                time_from_1: '',
                time_to_1: '',
                time_from_2: '',
                time_to_2: '',
                time_from_3: '',
                time_to_3: '',
                time_from_4: '',
                time_to_4: '',
                sequence: ''
              }],
              where: this.titulData.timing_with[0].whereForm
            },
            reyses_from:{
              reyses:[{
                time_from_1: '',
                time_to_1: '',
                time_from_2: '',
                time_to_2: '',
                time_from_3: '',
                time_to_3: '',
                time_from_4: '',
                time_to_4: '',
                sequence: ''
              }],
              where: this.titulData.timing_with[this.titulData.timing_with.length - 1].whereTo
            },
            stationName:  element.whereTo
          }
          this.form.push(lastObj)
        }
    });
    $('.reyslist').hover(  function() {
      $('.'+$(this).attr('data-reysnumber')).addClass('hovered');
      }, function() {
        $('.'+$(this).attr('data-reysnumber')).removeClass('hovered');
      });
    },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ["getSchedule"]),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable", 'actionGetScheduleTable']),
    async saveData() {
      await this.actionGetScheduleTable({id: this.$route.params.directionId, data:this.form})
      if(this.getSchedule.success){
        toast.fire({
            type: "success",
            icon: "success",
            title: 'Malumotlar saqlandi'
          });
      }else{
        toast.fire({
            type: "error",
            icon: "error",
            title: 'nmadir nito'
        });
      }
    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    removeItem(index){
      this.form.splice(index, 1);
    },
    calcToTime(fromTime, toTime, index, thisItem){
      let nextItem = this.form[index]
    },
    calcCountReys(inputName){
        if(this[inputName] > 0){
          this.form.forEach((item)=>{
            let reyses_to = {}
            let reyses_from = {}
            let type_table = this.form[this.form.length - 1].end_speedometer;
            let forEachCount;
            if(type_table > 400){
              forEachCount= this.reys_from_count > this.reys_to_count ? Math.ceil(this.reys_from_count / 4) : Math.ceil(this.reys_to_count / 4)
            }else{
              forEachCount= this.reys_from_count > this.reys_to_count ? Math.ceil(this.reys_from_count) : Math.ceil(this.reys_to_count)
            }
            item.reyses_from.reyses = []
            item.reyses_to.reyses = []
            for (let index = 0; index <  forEachCount; index++) {
              reyses_from = {
                time_from_1: '',
                time_to_1: '',
                time_from_2: '',
                time_to_2: '',
                time_from_3: '',
                time_to_3: '',
                time_from_4: '',
                time_to_4: '',
                sequence: ''
              },
              reyses_to = {
                time_from_1: '',
                time_to_1: '',
                time_from_2: '',
                time_to_2: '',
                time_from_3: '',
                time_to_3: '',
                time_from_4: '',
                time_to_4: '',
                sequence: ''
              }
              item.reyses_from.reyses.push(reyses_from)
              item.reyses_to.reyses.push(reyses_to)
            }
          })
        }
    }
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.th_with_input{
  padding: 0;
}
.table_input{
  width: 70px;
  padding: 0.25rem;
  border: none;
  background: transparent;
}
.btn_trash{
    width: 30px;
    height: 30px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    margin-left: auto;
    margin-right: auto;
}
.input_bd_none{
  border: none;
  width: 20px;
  text-align: center;
}
.reys8.hovered,
.reys7.hovered,
.reys6.hovered,
.reys5.hovered,
.reys4.hovered,
.reys3.hovered,
.reys2.hovered,
.reys1.hovered{
  background-color: #e0f3ff;
}
tbody tr td:focus-within {
  border-bottom: 1px solid #000;
}
</style>