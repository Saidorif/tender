<template>
  <div class="add_area">
    <div class="card">
      <div class="card-header tabCard">
        <PassportTab/>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
<!--             <thead>
              <tr>
                <th>№ т/р</th>
                <th>Автотранспорт воситаси категорияси</th>
                <th>Автотранспорт воситаси моделининг класси (фақат енгил автомобиллар учун)</th>
                <th>Таклиф</th>
              </tr>
            </thead> -->
            <tbody>
              <tr>
                <td>1</td>
                <td width="50%"><b>Автотранспорт воситаси категорияси</b></td>
                <td>shaxarlararo</td>
              </tr>
              <tr>
                <td>2</td>
                <td width="50%"><b>Автотранспорт воситаси моделининг класси</b></td>
                <td>Matiz, Spark, Mers</td>
              </tr>
              <tr>
                <td rowspan="3">3</td>
                <td width="50%"><b>Автотранспорт воситалари сони (саройдан фойдаланиш коэффициенти 0,8 хисобга олинганда)</b></td>
                <td>4</td>
              </tr>
              <tr>
                <td>Ишкунлари</td>
                <td>
                  <input type="number" v-model="form.working_days" class="form-control">
                </td>
              </tr>
              <tr>
                <td>Дам олиш кунлари</td>
                <td>
                  <input type="number" v-model="form.holiday_days" class="form-control">
                </td>
              </tr>
               <!-- 3 end -->
              <tr>
                <td>4</td>
                <td width="50%"><b>Автотранспорт воситалари ҳолати</b></td>
                <td>14 йилдан</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">5</td>
                <td width="50%"><b>Йуналишнинг умумий узунлиги</b></td>
                <td><b>600 км</b></td>
              </tr>
              <tr>
                <td>Тошкент-Турткул</td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <tr>
                <td>Турткул-Тошкент</td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">6</td>
                <td width="50%"><b>Бекатлар сони</b></td>
                <td><b>7</b></td>
              </tr>
              <tr>
                <td>Тошкент-Турткул</td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <tr>
                <td>Турткул-Тошкент</td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>7</td>
                <td width="50%"><b>Мавсумийлиги</b></td>
                <td>Доимий</td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">8</td>
                <td width="50%"><b>Рейслар (қатновлар) сони</b></td>
                <td><b>4</b></td>
              </tr>
              <tr>
                <td>Тошкент-Турткул</td>
                <td>2</td>
              </tr>
              <tr>
                <td>Турткул-Тошкент</td>
                <td>2</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">9</td>
                <td width="50%"><b>Дастлабки рейс (ишни бошлаш) вақти</b></td>
                <td><b>7</b></td>
              </tr>
              <tr>
                <td>Тошкент томондан</td>
                <td>6-00</td>
              </tr>
              <tr>
                <td>Турткул томондан</td>
                <td>5-30</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">10</td>
                <td width="50%"><b>Сўнги рейс (ишни тугалланиш) вақти</b></td>
                <td><b>7</b></td>
              </tr>
              <tr>
                <td>Тошкент томондан</td>
                <td>6-00</td>
              </tr>
              <tr>
                <td>Турткул томондан</td>
                <td>5-30</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td>11</td>
                <td width="50%"><b>Бекатлар оралиқ интерваллари</b></td>
                <td><b>10 минут</b></td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="3">12</td>
                <td width="50%"><b>Рейс вақти</b></td>
                <td><b>5 соат 45 минут</b></td>
              </tr>
              <tr>
                <td>Тошкент-Турткул</td>
                <td>5 соат 45 минут</td>
              </tr>
              <tr>
                <td>Турткул-Тошкент</td>
                <td>5 соат 45 минут</td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>13</td>
                <td width="50%"><b>Харакатланиш жадваллари</b></td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <!-- 3 s -->
              <tr>
                <td rowspan="3">14</td>
                <td width="50%"><b>Тариф</b></td>
                <td><b>65</b></td>
              </tr>
              <tr>
                <td>1 км. учун йўл тариф (шаҳар атрофи, шаҳарлараро йўналишлар учун)</td>
                <td>1 км. учун (65 сум). Йўл кира ҳаққи (00 сум)</td>
              </tr>
              <tr>
                <td>Йўл кира ҳаққи (шаҳар йўналишлар учун)</td>
                <td>1400 сум</td>
              </tr>
              <!-- 3 end -->
              <!-- 3 s -->
              <tr>
                <td rowspan="2">15</td>
                <td width="50%"><b>Автотранспорт воситаларини умумий сиғими</b></td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <tr>
                <td>ўриндиқлар сони</td>
                <td><input type="number" v-model="form.holiday_days" class="form-control"></td>
              </tr>
              <!-- 3 end -->
              <tr>
                <td>16</td>
                <td width="50%"><b>Минимал балл</b></td>
                <td>27</td>
              </tr>
            </tbody>
          </table>
          <div class="text_place">
            <label for="text">Текст</label>
            <textarea id="text" class="form-control" v-model="form.holiday_days"></textarea>
          </div>
          <div class="btn_send d-flex justify-content-end">
            <button type="button" class="btn btn-primary" @click.prevent="saveData">
              <i class="fas fa-save"></i>
              Сохранить
            </button>
          </div>
        </div>
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
      form: {
        working_days:'',
        holiday_days:'',
      },
    };
  },
  async mounted() {
    await this.actionEditDirection(this.$route.params.directionId);
    },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ["getSchedule"]),
  },
  methods: {
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("passportTab", ["actionAddTiming", "clearTimingTable", 'actionGetScheduleTable']),
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    saveData(){

    }
  },
};
</script>
<style scoped>
  .btn_send{
    margin-top:30px;
  }
</style>