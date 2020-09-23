<template>
  <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="row tabRow">
    <h2>{{titulData.type.type}} - {{titulData.pass_number}} - sonli "{{titulData.name}}"Avtobus yo'nalishi qatnov yo'li masofasini va xarakat vaqtini olchash qaydnomasi</h2>
    <div class="col-md-4">
      <p>
        Qatnov yo'l masofasi
        <b>{{titulData.timing_with[titulData.timing_with.length - 1].end_speedometer}} km</b>
      </p>
    </div>
    <div class="col-md-4">
      <p>Qatnovchi avtomobillar soni</p>
    </div>
    <div class="col-md-4">
      <p>Yolkira xaqqi so'm</p>
    </div>
    <div class="table-responisve">
      <table class="table table-bordered text-center table-hover table-striped">
        <thead>
          <tr>
            <th scope="col" colspan="8">Toshkent tomonga</th>
            <th scope="col" rowspan="3">Toxtash joylarining nomlari</th>
            <th scope="col" colspan="8">Nukus tomonga</th>
            <th scope="col" rowspan="3">Ochirib tashlash</th>
          </tr>
          <tr>
            <th scope="col" colspan="8">Qatnov raqamlari va astronomik vaqt (soat-min)</th>
            <th scope="col" colspan="8">Qatnov raqamlari va astronomik vaqt (soat-min)</th>
          </tr>
          <tr>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
            <th  colspan="1">Kelish vaqti</th>
            <th  colspan="1">Jonash vaqti</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(table,index) in form.result"  :key="index" >
            <th  colspan="1">{{table.time_to_1}} {{index}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_1, table.time_to_1, index, table)" v-model="table.time_from_1" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_2}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_2, table.time_to_2, )" v-model="table.time_from_2" type="text" class="table_input" ></th>
            <th  colspan="1">{{table.time_to_3}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_3, table.time_to_3, )" v-model="table.time_from_3" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_4}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_4, table.time_to_4, )" v-model="table.time_from_4" type="text" class="table_input"></th>
            <th  colspan="1">{{ index == form.length -1 ? table.whereTo.name : table.whereForm.name}}</th>
            <th  colspan="1">{{table.time_to_5}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_5, table.time_to_5, )" v-model="table.time_from_5" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_6}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_6, table.time_to_6, )" v-model="table.time_from_6" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_7}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_7, table.time_to_7, )" v-model="table.time_from_7" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_8}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_8, table.time_to_8, )" v-model="table.time_from_8" type="text" class="table_input"></th>
            <th  colspan="1" class="th_with_input"><button @click="removeItem(index)" type="button" class="btn btn-danger btn_trash"><i  class="fas fa-trash"></i></button></th>
          </tr>
          <!-- <tr v-for="(table,index) in form"  :key="index" >
            <th  colspan="1">{{table.time_to_1}} {{index}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_1, table.time_to_1, index, table)" v-model="table.time_from_1" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_2}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_2, table.time_to_2, )" v-model="table.time_from_2" type="text" class="table_input" ></th>
            <th  colspan="1">{{table.time_to_3}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_3, table.time_to_3, )" v-model="table.time_from_3" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_4}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_4, table.time_to_4, )" v-model="table.time_from_4" type="text" class="table_input"></th>
            <th  colspan="1">{{ index == form.length -1 ? table.whereTo.name : table.whereForm.name}}</th>
            <th  colspan="1">{{table.time_to_5}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_5, table.time_to_5, )" v-model="table.time_from_5" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_6}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_6, table.time_to_6, )" v-model="table.time_from_6" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_7}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_7, table.time_to_7, )" v-model="table.time_from_7" type="text" class="table_input"></th>
            <th  colspan="1">{{table.time_to_8}}</th>
            <th  colspan="1" class="th_with_input"><input @input="calcToTime(table.time_from_8, table.time_to_8, )" v-model="table.time_from_8" type="text" class="table_input"></th>
            <th  colspan="1" class="th_with_input"><button @click="removeItem(index)" type="button" class="btn btn-danger btn_trash"><i  class="fas fa-trash"></i></button></th>
          </tr> -->
        </tbody>
      </table>
    </div>
    <div class="form-group col-lg-12 form_btn d-flex justify-content-end">
      <button  type="submit" class="btn btn-primary btn_save_category"><i  class="fas fa-save"></i>
        Сохранить
      </button>
    </div>
  </form>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["titulData"],
  components: {
    DatePicker,
  },
  data() {
    return {
      form: {},
    };
  },
  async mounted() {
    await this.actionGetScheduleTable({id: this.$route.params.directionId, count: 1})
    this.form = this.getSchedule
    // this.form = this.titulData.timing_with
    // let lastObj = {
    //   time_from_1
    //   time_from_2
    //   time_from_3
    //   time_from_4
    //   time_from_5
    //   time_from_6
    //   time_from_8:
    // }
    this.form.push(this.form[this.form.length -1])
  },
  computed: {
    ...mapGetters("direction", ["getDirection", "getSchedule"]),
  },
  methods: {
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable", 'actionGetScheduleTable']),
    async saveData() {},
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    removeItem(index){
      this.form.splice(index, 1);
    },
    calcToTime(fromTime, toTime, index, thisItem){
      let nextItem = this.form[index]
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
</style>