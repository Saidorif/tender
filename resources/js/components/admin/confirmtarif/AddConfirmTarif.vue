<template>
  <div class="add_region">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h4 class="title_user">
          <i class="peIcon fas fa-clipboard-check"></i>
          Подтвердить тариф
        </h4>
        <router-link class="btn btn-primary back_btn" to="/crm/confirm-tender">
          <span class="peIcon pe-7s-back"></span>
          {{$t('Orqaga')}}
        </router-link>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group in col-md-2">
            <label for="name">Направления</label>
            <p class="form-control input_style disabled">{{ form.time }}</p>
          </div>
          <div class="form-group col-md-3">
            <label for="price">Тариф</label>
            <p class="form-control input_style disabled">{{ form.price }}</p>
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
import Loader from '../../Loader'
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    DatePicker,
    Multiselect,
    Loader
  },
  data() {
    return {
        laoding: true,
        form: {
            direction: "",
            price: "",
        },
        requiredInput: false,
        isLoading: false,
      	fromName: "",
      	toName: "",
        rejectmsg: '',
    };
  },
  computed: {
    ...mapGetters("tarifannounce", ["getMassage", "getTarifAnnounce"]),
    ...mapGetters("confirmtarif", ["getRejMassage"]),
  },
  async mounted() {
    await this.actionEditTarifAnnounce(this.$route.params.tarifannounceId);
    this.laoding = false
  },
  methods: {
    ...mapActions("confirmtarif", [
      "actionRejectTarif",
      "actionCompletedTarif"
    ]),
    ...mapActions("tarifannounce", [
      "actionAddTarifAnnounce",
      "actionEditRarifAnnounce",
      "actionUpdateTarifAnnounce",
      "actionDeleteTarifAnnounceItem",
    ]),
  	activeEditClass(item){
  		if (item.status == 'active') {
  			return 'edit-active'
  		}else{
  			return 'edit-pending'
  		}
  	},
    isRequired(input) {
      return this.requiredInput && input === "";
    },
    async completedTender(){
      await this.actionCompletedTarif(this.$route.params.tarifannounceId);
      if(this.getRejMassage.success){
        toast.fire({
				  type: "success",
				  icon: "success",
				  title: this.getRejMassage.message
				});
        this.$router.push("/crm/confirm-tarif");
      }
    },
    async rejectTarif(){
      if (this.rejectmsg != '' && this.rejectmsg != null){
          this.laoding = true
        await this.actionRejectTarif({id:this.$route.params.tarifannounceId, message: this.rejectmsg })
        this.laoding = false
        $('#exampleModal').modal('hide')
        if(this.getRejMassage.success){
          toast.fire({
				    type: "success",
				    icon: "success",
				    title: this.getRejMassage.message
				  });
          this.$router.push("/crm/confirm-tarif");
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
