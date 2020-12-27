<template>
  <div class="add_region">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-file"></i>
          Лоты
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/completed-tenders">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
          <div class="table-responsive" v-for="(lots,lot_index) in getTender">
              <h5>Лот <em>№</em> {{lot_index + 1}}</h5>
              <table class="table table-bordered" >
                  <thead>
                      <tr>
                          <th>№</th>
                          <th>Направления</th>
                          <th>Перевозчики отправившие предложении</th>
                          <th>Набранные баллы</th>
                          <th>Результаты изучения тендерных предложений</th>
                          <th>Статус лицензии</th>
                          <th>Протоколы</th>
                          <th>Контракты</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(directions, d_index) in lots">
                          <td>{{d_index+1}}</td>
                          <td>{{directions[0].name}}</td>
                          <td class="without_padding">
                            <ul class="list-inline">
                              <li v-for="(item,index) in directions">
                                {{item.company_name != null ? item.company_name : 'noname'}}
                              </li>
                            </ul>
                          </td>
                          <td class="without_padding">
                            <ul class="list-inline">
                              <li v-for="(item,index) in directions">
                                {{item.total}}
                              </li>
                            </ul>
                          </td>
                          <td class="without_padding">
                            <ul class="list-inline">
                              <li v-for="(item,index) in directions">
                                status
                              </li>
                            </ul>
                          </td>
                          <td class="without_padding">
                            <ul class="list-inline">
                              <li v-for="(item,index) in directions">
                                status
                              </li>
                            </ul>
                          </td>
                          <td class="without_padding">
                            <router-link class="" tag="a" :to="`/crm/protocol/${$route.params.tenderId}`">
                              Протокол
                            </router-link>
                          </td>
                          <td class="without_padding">
                            <ul class="list-inline">
                              <li v-for="(item,index) in directions">
                                contract
                              </li>
                            </ul>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    DatePicker,
    Multiselect,
  },
  data() {
    return {
    };
  },
  computed: {
    ...mapGetters("completedtender", ["getTender"]),
  },
  async mounted() {
    await this.actionCompletedTendersShow(this.$route.params.tenderId);
    console.log(this.getTender)
  },
  methods: {
    ...mapActions("completedtender", [
      "actionCompletedTendersShow",
    ]),
  },
};
</script>
<style scoped>
tr {
  cursor: pointer !important;
}
tr.active {
  background: #d6d6d6;
}
.check_box_with_label {
}
.check_box_with_label input {
  --active: #275efe;
  --active-inner: #fff;
  --focus: 2px rgba(39, 94, 254, 0.3);
  --border: #bbc1e1;
  --border-hover: #275efe;
  --background: #fff;
  --disabled: #f6f8ff;
  --disabled-inner: #e1e6f9;
  -webkit-appearance: none;
  -moz-appearance: none;
  height: 21px;
  outline: none;
  display: inline-block;
  vertical-align: top;
  position: relative;
  margin: 0;
  cursor: pointer;
  border: 1px solid var(--bc, var(--border));
  background: var(--b, var(--background));
  -webkit-transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
  transition: background 0.3s, border-color 0.3s, box-shadow 0.2s;
  width: 38px;
  border-radius: 11px;
  min-height: unset;
}
.check_box_with_label input::after {
  content: "";
  display: block;
  position: absolute;
  -webkit-transition: opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  transition: opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  transition: transform var(--d-t, 0.3s) var(--d-t-e, ease),
    opacity var(--d-o, 0.2s);
  transition: transform var(--d-t, 0.3s) var(--d-t-e, ease),
    opacity var(--d-o, 0.2s),
    -webkit-transform var(--d-t, 0.3s) var(--d-t-e, ease);
  left: 2px;
  top: 2px;
  border-radius: 50%;
  width: 15px;
  height: 15px;
  background: var(--ab, var(--border));
  -webkit-transform: translateX(var(--x, 0));
  transform: translateX(var(--x, 0));
}
.check_box_with_label label {
  display: block;
  cursor: pointer;
  margin-bottom: 15px;
}
.check_box_with_label input[type="checkbox"]:checked {
  --ab: var(--active-inner);
  --x: 17px;
  --b: var(--active);
  --bc: var(--active);
  --d-o: 0.3s;
  --d-t: 0.6s;
  --d-t-e: cubic-bezier(0.2, 0.85, 0.32, 1.2);
}
input.disabled {
  cursor: not-allowed;
}
.cardtender{
    padding: 0;
    box-shadow: none;
    background-color: rgba(0,0,0,.03);
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}
.cardtender .card-header{
    background: #f3f3f4;
}
.without_padding{
  padding: 0px !important;
}
.without_padding ul{
  margin-bottom: 0px;
}
.without_padding li{
  text-align: center;
}
.list-inline li{
  border-bottom: 1px solid #000;
}
.list-inline li:last-child{
  border: none;
}
</style>
