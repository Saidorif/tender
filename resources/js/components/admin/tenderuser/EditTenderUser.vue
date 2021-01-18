<template>
  <div class="add_region">
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-bullhorn"></i>
          Посмотреть тендер
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/tenderannounce">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="form-group col-md-2">
              <label for="name">Дата тердера</label>
              <div class="form-control input_style">
                {{ form.time }}
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="address">Адрес</label>
              <div class="form-control input_style">
                {{ form.address }}
              </div>
            </div>
          </div>
        </form>
        <!-- All edit choosen tables -->
        <div class="table-responsive" v-if="tenderlots.length > 0">
            <div class="d-flex justify-content-center">
                <h4>Лоты</h4>
            </div>
            <div class="card cardtender" v-for="(t_lots,t_index) in tenderlots">
                <div class="card-header" >
                    <h4 class="lot_n"><em>Лот №</em> {{t_index+1}}</h4>
                    <button
                        type="button"
                        class="btn btn-info btn_save_category"
                        @click.prevent="getEditId(t_lots.id)"
                    >
                        <i class="far fa-share-square text-light"></i>
                        <span class="text-light">Отправить заявку</span>
                    </button>
                </div>
                <div class="card-body">
                    <template v-for="(items,index) in t_lots.direction_id">
                        <div class="mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>{{index+1}}) {{items.name}} ({{getLengthReys(items, t_lots)}} рейс)</h4>

                            <router-link
                                :to='`/crm/stepuser/demand-tab/${items.id}`'
                                class="btn btn-outline-info"
                            >
                                <i class="fas fa-eye"></i>
                            </router-link>
                        </div>
                        <div v-if="items.reys_status">
                            <h3>
                            <span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span>
                            </h3>
                            <table class="table table-bordered">
                            <!-- <thead>
                                <tr>
                                <th>№</th>
                                <th v-for="(item,index) in items.reysesFrom[0].reys_times" colspan="2">
                                    {{item.where.name}}
                                </th>
                                </tr>
                            </thead> -->
                            <thead>
								<tr>
									<th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
									<th  scope="col"  :colspan="items.reysesFrom[0].reys_times.length * 2" style="text-align: center;">{{items.reysesFrom[0].where.name}} томондан  </th>
								</tr>
                                <tr>
                                    <th colspan="2" v-for="(item, index) in items.reysesFrom[0].stations" style="text-align: center;">
                                        {{ item.name }}
                                    </th>
                                </tr>
                                <tr >
                                    <template v-for="(item, index) in items.reysesFrom[0].reys_times">
                                        <th style="text-align: center;" >Прибытие</th>
                                        <th style="text-align: center;">Отправление</th>
                                    </template>
                                </tr>
				  			</thead>
                            <tbody>
                                <tr
                                v-for="(reys,key) in items.reysesFrom"
                                v-if="showTabeleReys(reys, t_lots, items)"
                                >
                                <td>{{key+1}}</td>
                                <template v-for="(val,key) in reys.reys_times">
                                    <td>{{val.start}}</td>
                                    <td>{{val.end}}</td>
                                </template>
                                </tr>
                            </tbody>
                            </table>
                            <h3>
                            <span>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</span>
                            </h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th  scope="col" rowspan="5" style="text-align: center;">Qatnovlar</th>
                                        <th  scope="col"  :colspan="items.reysesTo[0].reys_times.length * 2" style="text-align: center;">{{items.reysesTo[0].where.name}} томондан </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" v-for="(item, index) in items.reysesTo[0].stations" style="text-align: center;">
                                            {{ item.name }}
                                        </th>
                                    </tr>
                                    <tr >
                                        <template v-for="(item, index) in items.reysesTo[0].reys_times">
                                            <th style="text-align: center;" >Прибытие</th>
                                            <th style="text-align: center;">Отправление</th>
                                        </template>
                                    </tr>
                                </thead>
                            <!-- <thead>
                                <tr>
                                <th>№</th>
                                <th v-for="(item,index) in items.reysesTo[0].reys_times" colspan="2">
                                    {{item.where.name}}
                                </th>
                                </tr>
                            </thead> -->
                            <tbody>
                                <tr
                                v-for="(reys,key) in items.reysesTo"
                                v-if="showTabeleReys(reys, t_lots, items)"
                                >
                                <td>{{key+1}}</td>
                                <template v-for="(val,key) in reys.reys_times">
                                    <td>{{val.start}}</td>
                                    <td>{{val.end}}</td>
                                </template>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
   <!--      <div class="table-responsive" v-if="tenderlots.length > 0">
          <div class="d-flex justify-content-center">
            <h4>Лоты</h4>
          </div>
          <div class="choosenItemsTable" v-for="(t_lots,t_index) in tenderlots">
            <div class="d-flex">
              <h4 class="lot_n"><em>Лот №</em> {{t_index+1}}</h4>
              <button
                type="button"
                class="btn btn-info btn_save_category"
                @click.prevent="getEditId(t_lots.id)"
              >
                <i class="far fa-share-square text-light"></i>
                <span class="text-light">Отправить заявку</span>
              </button>
            </div>
            <ul v-for="(items,index) in t_lots.direction_id">
                <template>
                  <li class="mb-2">
                    <div class="d-flex align-items-center">
                      <button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+'from'" aria-expanded="false" :aria-controls="'collapseExample'+index+'from'">
                        <template>
                        <span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span>
                        </template>
                    </button>
                    <router-link
                      :to='`/crm/direction/demand-tab/${items.id}`'
                      class="btn btn-outline-info"
                    >
                      <i class="fas fa-eye"></i>
                    </router-link>
                    </div>
                  <div class="collapse" :id="'collapseExample'+index+'from'" v-if="items.reysesFrom.length > 0">
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>№</th>
                          <th v-for="(item,index) in items.reysesFrom[0].reys_times" colspan="2">
                            {{item.where.name}}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(reys,key) in items.reysesFrom"
                          :class="activeEditClass(lots[index],reys.id) ? 'active' : ''"
                        >
                          <td>{{key+1}}</td>
                          <template v-for="(val,key) in reys.reys_times">
                            <td>{{val.start}}</td>
                            <td>{{val.end}}</td>
                          </template>
                        </tr>
                      </tbody>
                    </table>
                </div>
                </li>
                  <li>
                    <div class="d-flex align-items-center">
                      <button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+'to'" aria-expanded="false" :aria-controls="'collapseExample'+index+'to'">
                        <template>
                        <span>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</span>
                        </template>
                    </button>
                    <router-link
                      :to='`/crm/direction/demand-tab/${items.id}`'
                      class="btn btn-outline-info"
                    >
                      <i class="fas fa-eye"></i>
                    </router-link>
                    </div>
                  <div class="collapse" :id="'collapseExample'+index+'to'" v-if="items.reysesTo.length > 0">
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>№</th>
                          <th v-for="(item,index) in items.reysesTo[0].reys_times" colspan="2">
                            {{item.where.name}}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(reys,key) in items.reysesTo"
                          :class="activeEditClass(lots[index],reys.id) ? 'active' : ''"
                        >
                          <td>{{key+1}}</td>
                          <template v-for="(val,key) in reys.reys_times">
                            <td>{{val.start}}</td>
                            <td>{{val.end}}</td>
                          </template>
                        </tr>
                      </tbody>
                    </table>
                </div>
                </li>
                </template>
                <template>
                  <li>
                    <div class="d-flex align-items-center">
                      <button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
                        <template>
                          <span>{{items.name}}</span>
                        </template>
                    </button>
                    <router-link
                      :to='`/crm/direction/demand-tab/${items.id}`'
                      class="btn btn-outline-info"
                    >
                      <i class="fas fa-eye"></i>
                    </router-link>
                    </div>
                  </li>
                </template>
            </ul>
          </div>
        </div> -->
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
      form: {
        direction_ids: [],
        time: "",
        address: "",
        type: "simple",
      },
      requiredInput: false,
      direction_ids: {},
      isLoading: false,
      edit_direction_ids: [],
      lots: [],
      tenderlots: [],
    };
  },
  computed: {
    ...mapGetters("application", [
      "getApplications",
      "getApplication",
      "getMassage",
      "getUserEditApplication",
      "getUserApplications",
      "getAddMessage",
    ]),
    ...mapGetters("tenderannounce", ["getMassage", "getTenderAnnounce"]),
    ...mapGetters("direction", ["getDirectionFindList"]),
    ...mapGetters("passportTab", ["getSchedule"]),
    ...mapGetters("busbrand", ["getBusBrandList"]),
  },
  watch: {
    getTenderAnnounce: {
      handler() {
        this.form.time = this.getTenderAnnounce.time;
        this.form.address = this.getTenderAnnounce.address;
        this.edit_direction_ids = this.getTenderAnnounce.direction_ids;
        this.lots = this.getTenderAnnounce.tenderlots;
        this.tenderlots = this.getTenderAnnounce.tenderlots;
      },
    },
  },
  async mounted() {
    await this.actionEditTenderAnnounce(this.$route.params.tenderuserId);
    this.form.time = this.getTenderAnnounce.time;
    this.form.address = this.getTenderAnnounce.address;
    this.edit_direction_ids = this.getTenderAnnounce.direction_ids;
    this.lots = this.getTenderAnnounce.tenderlots;
    this.tenderlots= this.getTenderAnnounce.tenderlots
  },
  methods: {
    ...mapActions("application", [
      "actionApplications",
      "actionDeleteApplication",
      "actionAddApplication",
      "actionUserEditApplication",
      "actionApplicationList",
    ]),
    ...mapActions("tenderannounce", [
      "actionAddTenderAnnounce",
      "actionEditTenderAnnounce",
      "actionUpdateTenderAnnounce",
      "actionDeleteTenderAnnounceItem",
    ]),
    ...mapActions("direction", ["actionDirectionFind"]),
    ...mapActions("passportTab", ["actionGetScheduleTable"]),
    async getEditId(id) {
      let data = {
        tender_id: this.$route.params.tenderuserId,
        lot_id: id,
      };
      await this.actionUserEditApplication(data);
      if (this.getUserEditApplication.success) {
        this.$router.push(
          "/crm/application/user/" + this.getUserEditApplication.result.id
        );
      }
    },
    activeEditClass(item){
      if (item.status == 'active') {
        return 'edit-active'
      }else{
        return 'edit-pending'
      }
      // let lot_list = lots.reys_id
      // if (lot_list.length > 0) {
      //  if (lot_list.includes(id)) {
      //    return true
      //  }
      // }
    },
    showTabeleReys(item, elem, parentItem){
        if(elem != undefined){
            if(elem.reys_id.includes(item.id)){
                parentItem['byreys'] = true
                return true
            }else{
                return false
            }
        }
		// if (item.status == 'active') {
		// 	return 'edit-active'
		// }else{
		// 	return 'edit-pending'
		// }
		// let lot_list = lots.reys_id
		// if (lot_list.length > 0) {
		// 	if (lot_list.includes(id)) {
		// 		return true
		// 	}
		// }
    },
		    getLengthReys(reys, elem){
                let count = 0;
                if(reys.reys_status){
                    reys.reysesFrom.forEach((item,index)=>{
                        if(elem.reys_id.includes(item.id)){
                            count++
                        }
		    		})
		    		reys.reysesTo.forEach((item,index)=>{
                        if(elem.reys_id.includes(item.id)){
                            count++
                        }
		    		})
                }else{
		    		reys.reysesFrom.forEach((item,index)=>{
		    				count++
		    		})
		    		reys.reysesTo.forEach((item,index)=>{
		    				count++
		    		})
                }
		    	return count;
		    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
  },
};
</script>
<style scoped>
  .lot_item{
    display: flex;
    width: 400px;
    justify-content: space-around;
    margin-bottom:20px;
  }
  .lot_remove{
    cursor: pointer;
    font-size: 20px;
  }
  tr.active,tr.inactive{
    cursor:pointer !important;
  }
  tr.active:hover,tr.inactive:hover{
    background:#d0d0d0 !important;
  }
  tr.active,tr.edit-pending{
    background:#d6d6d6;
  }
  tr.pending{
    background:#8e8e8e;
    cursor:not-allowed !important;
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
</style>
