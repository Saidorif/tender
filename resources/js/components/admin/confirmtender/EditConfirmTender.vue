<template>
  <div class="add_region">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-clipboard-check"></i>
          Подтвердить тендер
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/confirm-tender">
          <span class="peIcon pe-7s-back"></span>
          Назад
        </router-link>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group in col-md-2">
            <label for="name">Дата тердера</label>
            <p class="form-control input_style disabled">{{ form.time }}</p>
          </div>
          <div class="form-group col-md-3">
            <label for="address">Адрес</label>
            <p class="form-control input_style disabled">{{ form.address }}</p>
          </div>
          <div class="col-md-2 ml_auto">
            <button
              type="button"
              class="btn btn-danger"
              data-toggle="modal"
              data-target="#exampleModal"
            >
              <i class="fas fa-ban"></i> Отказ
            </button>
            <button type="button" class="btn btn-success" @click="completedTender()">
              <i class="far fa-check-circle"></i>Подтвердить
            </button>
          </div>
        </div>
        <!-- All edit choosen tables -->
				<!-- All edit choosen tables -->
			  	<div class="table-responsive" v-if="tenderlots.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>Лоты</h4>
			  		</div>
				  	<!-- <div class="choosenItemsTable" v-for="(t_lots,t_index) in tenderlots">
		  		    	<div class="d-flex">
					  		<h4 class="lot_n"><em>Лот №</em> {{t_index+1}}</h4>
				  		</div>
		  		    	<template v-for="(items,index) in t_lots.direction_id">
				  		    <div class="mb-2">
				  		    	<div class="d-flex align-items-center">
						  			<h4>{{index+1}})</h4>
					  		    	<button class="btn btn-outline-secondary mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index+t_index+'from'" aria-expanded="false" :aria-controls="'collapseExample'+index+t_index+'from'">
					  		    		<template>
										    <span>{{items.name}}</span>
									    	<span>
									    		({{getLengthReys(items)}} рейс)
									    		<i class="pe-7s-angle-down-circle"></i>
									    	</span>
					  		    		</template>
								  	</button>
								  	<router-link
								  		:to='`/crm/stepuser/demand-tab/${items.id}`'
								  		class="btn btn-outline-info"
							  		>
									  	<i class="fas fa-eye"></i>
								  	</router-link>
				  		    	</div>
							  	<div class="collapse" :id="'collapseExample'+index+t_index+'from'" v-if="items.reysesFrom.length > 0">
						  			<h3>
						  				<span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span>
						  			</h3>
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
								  				:class="activeEditClass(reys)"
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
								  				<th>№</th>
								  				<th v-for="(item,index) in items.reysesTo[0].reys_times" colspan="2">
									  				{{item.where.name}}
									  			</th>
								  			</tr>
								  		</thead>
								  		<tbody>
								  			<tr
								  				v-for="(reys,key) in items.reysesTo"
								  				:class="activeEditClass(reys)"
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
				  	</div> -->
            <div class="card cardtender" v-for="(t_lots,t_index) in tenderlots">
                <div class="card-header" >
                        <h4 class="lot_n"><em>Лот №</em> {{t_index+1}}</h4>
             <!--            <div>
                          <a href="#" class="btn btn-outline-danger">
                              <i class="fas fa-trash text-danger lot_remove" @click.prevent="removeEditLot(t_lots.id)"></i>
                          </a>
                          <button
                              type="button"
                              class="btn btn-info btn_save_category"
                              @click.prevent="getEditId(t_lots.id)"
                          >
                              <i class="far fa-share-square text-light"></i>
                              <span class="text-light">Отправить заявку</span>
                          </button>
                        </div> -->

                </div>
                <div class="card-body">
                    <template v-for="(items,index) in t_lots.direction_id">
                        <div class="mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4>{{index+1}}) {{items.name}} <span v-if="getLengthReys(items, t_lots) > 0">({{getLengthReys(items, t_lots)}} рейс)</span></h4>

                            <router-link
                                :to='`/crm/stepuser/demand-tab/${items.id}`'
                                class="btn btn-outline-info"
                            >
                                <i class="fas fa-eye"></i>
                            </router-link>
                        </div>
                        <div v-if="items.reys_status">
                          <template v-if="items.reys_status.from">
                            <h3>
                              <span>{{items.reysesFrom[0].where.name}} - {{items.reysesFrom[0].from.name}}</span>
                            </h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="5" style="text-align:center;">Qatnovlar</th>
                                        <th scope="col" :colspan="items.reysesFrom[0].reys_times.length * 2" style="text-align:center;">
                                            {{items.reysesFrom[0].where.name}} томондан
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" v-for="(item, index) in items.reysesFrom[0].reys_times" style="text-align:center;">
                                            {{item.where.name}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <template v-for="(item, index) in items.reysesFrom[0].reys_times">
                                            <th style="text-align:center;">Прибытие</th>
                                            <th style="text-align:center;">Отправление</th>
                                        </template>
                                    </tr>
                                </thead>
                                <!-- <thead>
                                    <tr>
                                        <th>№</th>
                                        <th v-for="(item,index) in items.reysesFrom[0].reys_times" colspan="2">
                                            {{item.where.name}}
                                        </th>
                                    </tr>
                                </thead> -->
                                <tbody>
                                    <tr
                                    v-for="(reys,key) in items.reysesFrom"
                                    v-if="showTabeleReys(reys, t_lots, items)"
                                    >
                                    <td style="text-align:center;">{{key+1}}</td>
                                    <template v-for="(val,key) in reys.reys_times">
                                        <td style="text-align:center;">{{val.end}}</td>
                                        <td style="text-align:center;">{{val.start}}</td>
                                    </template>
                                    </tr>
                                </tbody>
                            </table>
                          </template>
                          <template v-if="items.reys_status.to">
                            <h3>
                              <span>{{items.reysesTo[0].where.name}} - {{items.reysesTo[0].from.name}}</span>
                            </h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="5" style="text-align:center;">Qatnovlar</th>
                                        <th scope="col" :colspan="items.reysesTo[0].reys_times.length * 2" style="text-align:center;">
                                            {{items.reysesTo[0].where.name}} томондан
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" v-for="(item, index) in items.reysesTo[0].reys_times" style="text-align:center;">
                                            {{item.where.name}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <template v-for="(item, index) in items.reysesTo[0].reys_times">
                                            <th style="text-align:center;">Прибытие</th>
                                            <th style="text-align:center;">Отправление</th>
                                        </template>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr
                                  v-for="(reys,key) in items.reysesTo"
                                  v-if="showTabeleReys(reys, t_lots, items)"
                                  >
                                  <td style="text-align:center;">{{key+1}}</td>
                                  <template v-for="(val,key) in reys.reys_times">
                                    <td style="text-align:center;">{{val.end}}</td>
                                    <td style="text-align:center;">{{val.start}}</td>
                                  </template>
                                  </tr>
                              </tbody>
                            </table>
                          </template>
                        </div>
                        </div>
                    </template>
                </div>
            </div>
                </div>
			  	<!-- all choosen lots -->
		  		<div class="table-responsive" v-if="allLotes.length > 0">
			  		<div class="d-flex justify-content-center">
			  			<h4>Добавленные лоты</h4>
			  		</div>
				  	<div class="choosenItemsTable" v-for="(lots,lot_key) in allLotes">
				  		<div class="d-flex">
					  		<h4 class="lot_n"><em>№</em> {{lot_key+1}}</h4>
					  		<i class="fas fa-trash text-danger lot_remove" @click.prevent="removeLot(lot_key)"></i>
				  		</div>
				  		<ul v-for="(item,index) in lots">
				  		    <li>
				  		    	<div class="d-flex align-items-center">
					  		    	<h4>{{index+1}})</h4>
					  		    	<button class="btn btn-outline-success mr-3 ml-3" type="button" data-toggle="collapse" :data-target="'#collapseExample'+index" aria-expanded="false" :aria-controls="'collapseExample'+index">
					  		    		<template v-if="item.reyses.length > 0">
										    <span>{{item.reyses[0].where.name}} - {{item.reyses[0].from.name}}</span>
										    <span>({{item.reyses.length}} рейсы)</span>
					  		    		</template>
					  		    		<template v-else>
					  		    			<span>{{item.directions.name}}</span>
					  		    		</template>
								  	</button>
				  		    	</div>
							  	<div class="collapse" :id="'collapseExample'+index" v-if="item.reyses.length > 0">
								  <table class="table table-bordered table-hover">
							  			<thead>
								  			<tr>
								  				<th>№</th>
								  				<th v-for="(item,index) in item.reyses[0].reys_times" colspan="2">
									  				{{item.where.name}}
									  			</th>
								  			</tr>
								  		</thead>
								  		<tbody>
								  			<tr v-for="(reys,key) in item.reyses">
								  				<td>{{key+1}}</td>
								  				<template v-for="(val,key) in reys.reys_times">
									  				<td>{{val.end}}</td>
									  				<td>{{val.start}}</td>
								  				</template>
								  			</tr>
								  		</tbody>
								  	</table>
								</div>
				  			</li>
				  		</ul>
				  		<hr>
				  	</div>
			  	</div>



        <!-- cancel modal -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Причина отказа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <textarea class="form-control" v-model="rejectmsg" name="" id="" cols="30" rows="10" placeholder="Техт отказа" :class="isRequired(rejectmsg) ? 'isRequired' : ''"  ></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" @click="rejectTender()">Отправить</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";
import { mapGetters, mapActions } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Multiselect,
    Loader
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
        checked: false,
        checkedGrafik: false,
        isLoading: false,
        allLotes:[],
      	allItems: [],
      	fromName: "",
      	fromItems: [],
      	fromFirstItems: [],
      	choosenFromItems: [],
      	toName: "",
      	toFirstItems: [],
      	toItems: [],
      	choosenToItems: [],
      	findList: [],
      	tableItems: [],
      	edit_direction_ids: [],
        tenderlots:[],
        lots: [],
        rejectmsg: '',
        laoding: true,
    };
  },
  computed: {
    ...mapGetters("tenderannounce", ["getMassage", "getTenderAnnounce"]),
    ...mapGetters("direction", ["getDirectionFindList"]),
    ...mapGetters("passportTab", ["getSchedule"]),
    ...mapGetters("confirmtender", ["getRejMassage"]),
  },
  async mounted() {
    await this.actionEditTenderAnnounce(this.$route.params.tenderannounceId);
    this.laoding = false
    this.form.time = this.getTenderAnnounce.time;
    this.form.address = this.getTenderAnnounce.address;
    this.edit_direction_ids = this.getTenderAnnounce.direction_ids;
    this.lots = this.getTenderAnnounce.tenderlots;
    this.tenderlots = this.getTenderAnnounce.tenderlots
  },
  methods: {
    ...mapActions("confirmtender", [
      "actionRejectTender",
      "actionCompletedTender"
    ]),
    ...mapActions("tenderannounce", [
      "actionAddTenderAnnounce",
      "actionEditTenderAnnounce",
      "actionUpdateTenderAnnounce",
      "actionDeleteTenderAnnounceItem",
    ]),
    ...mapActions("direction", ["actionDirectionFind"]),
    ...mapActions("passportTab", ["actionGetScheduleTable"]),
    async removeFromEditItems(lots, reys, directions) {
      let reys_id = [];
      if (lots && reys) {
        let lot_list = lots.reys_id;
        reys.forEach((item, index) => {
          if (lot_list.includes(item.id)) {
            reys_id.push(item.id);
          }
        });
      }
      let data = {
        id: this.$route.params.tenderannounceId,
        direction_id: directions.id,
        reys_id,
      };
      this.laoding = true
      await this.actionDeleteTenderAnnounceItem(data);
      if (this.getMassage.success) {
        await this.actionEditTenderAnnounce(
          this.$route.params.tenderannounceId
        );
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getMassage.message,
        });
      }
      this.laoding = false

    },
	activeEditClass(item){
		if (item.status == 'active') {
			return 'edit-active'
		}else{
			return 'edit-pending'
		}
		// let lot_list = lots.reys_id
		// if (lot_list.length > 0) {
		// 	if (lot_list.includes(id)) {
		// 		return true
		// 	}
		// }
	},
    // getLengthReys(lots, reys) {
    //   let lot_list = lots.reys_id;
    //   let count = 0;
    //   reys.forEach((item, index) => {
    //     if (lot_list.includes(item.id)) {
    //       count++;
    //     }
    //   });
    //   return count;
    // },
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
    async completedTender(){
      this.laoding = true
      await this.actionCompletedTender(this.$route.params.tenderannounceId);
            this.laoding = false
      if(this.getRejMassage.success){
        toast.fire({
				  type: "success",
				  icon: "success",
				  title: this.getRejMassage.message
				});
        this.$router.push("/crm/confirm-tender");
      }
    },
    async rejectTender(){
      if (this.rejectmsg != '' && this.rejectmsg != null){
                this.laoding = true
        await this.actionRejectTender({id:this.$route.params.tenderannounceId, message: this.rejectmsg })
              this.laoding = false
        $('#exampleModal').modal('hide')
        if(this.getRejMassage.success){
          toast.fire({
				    type: "success",
				    icon: "success",
				    title: this.getRejMassage.message
				  });
          this.$router.push("/crm/confirm-tender");
        }
        this.requiredInput = false
      }else{
        this.requiredInput = true
      }
    }
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
</style>
