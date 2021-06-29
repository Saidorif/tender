<template>
  <div class="add_area">
    <Loader v-if="laoding"/>
    <div class="card card_with_tabs">
      <div class="card-header tabCard">
        <PassportTab/>
      </div>
      <div class="card-body">
                      <div class="col-12 d-flex justify-content-end align-items-start mb-2">
                <span class="alert alert-success mr-2" v-if="getDirection.sxema_status == 'completed'" style="padding:6px 20px;">{{$t('Tadiqlangan')}}</span>
                <span class="alert alert-warning mr-2" v-if="getDirection.sxema_status == 'pending'" style="padding:6px 20px;">{{$t('Kutish jarayonida')}}</span>
                <span class="alert alert-danger mr-2" v-if="getDirection.sxema_status == 'active'" style="padding:6px 20px;">{{$t('Tasdiqlanmagan')}}</span>
            </div>
        <div class="row tabRow">
          <h1 v-if="titulData.type">{{$t('Avtobus qatnov yoʼli tasviri')}}  {{titulData.type.type}} - {{titulData.pass_number}} - {{$t('sonli')}} "{{titulData.name}}" </h1>
          <div class="map_scheme" v-if="schemeData.length">
            <div class="mid_line"></div>
            <template v-for="(p_item,p_index) in schemeData">
              <div class="stationItem start_point cicle_item" v-if="p_index == 0" :key="p_index">
                <h6>{{p_item.whereForm ? p_item.whereForm.name : ""}}</h6>
              </div>

              <div class="sm_cicle_item stationItem" v-if="p_index > 0" :key="p_index">
                <h6>{{p_item.whereForm ? p_item.whereForm.name : ""}}</h6>
              </div>

              <template v-for="(ch_item, ch_index) in p_item.details">
                <template>
                  <div class="icon_item" v-if="String(ch_item.count).length < 3">
                    <img
                        v-if="ch_item.sign"
                      :src="'/signs/'+ch_item.sign.photo"
                      :key="'icon'+p_index+ch_index"
                      width="30"
                    />
                    <sup>{{ch_item.count}} </sup>
                  </div>
                </template>
              </template>

              <div
                class="end_point cicle_item stationItem"
                v-if="schemeData.length  == p_index + 1"
                :key="'last'+p_index"
              >
                <h6>{{p_item.whereTo ? p_item.whereTo.name : ""}}</h6>
              </div>
            </template>
          </div>
          <div class="road_signs col-md-6">
            <h6>{{$t('Shartli belgilar')}}</h6>
            <ul>
              <li>
                  <div class="icon_item bdn">
                      <div class="cicle_item"></div>
                  </div>
                  <span>{{$t('Avtostansiya')}}</span>
              </li>
              <li>
                  <div class="icon_item bdn">
                      <div class="sm_cicle_item"></div>
                  </div>
                  <span>{{$t('Toʼxtash joylari')}}</span>
              </li>
              <li v-for="(sign) in getConditionalSignList">
                <div class="icon_item">
                  <img :src="'/signs/'+sign.photo" width="30" />
                </div>
                <span>{{sign.name}}</span>
              </li>
            </ul>
          </div>
          <form @submit.prevent.enter="sendFile"  enctype="multipart/form-data" class="col-md-6 d-flex flex-wrap">
            <input type="file" accept="application/pdf" id="file" ref="file" @change="handleFileUpload()" required name="file" class="form-control" style="width:60%;border-radius:0px;height: 41px;" >
            <button type="submit" class="btn btn-primary btn_save_category" style="width: 210px;border-radius:0px;height: 41px;">{{$t('Faylni saqlash')}}</button>
            <a v-if="getDirection.sxema_file" :href="getDirection.sxema_file" download="" class="btn btn-info btn_save_category">{{$t('Faylni yuklash')}}</a>
          </form>
          <div class="row col-md-12"  v-if="agreedData.length">
            <div class="form-group col-xl-3 col-md-6 agree_item" v-for="(p_item,p_index) in agreedData">
              <h6>"{{$t('Kelishilgan')}}"</h6>
              <p>{{p_item.organ }} {{ p_item.job}}:</p>
              <p><span></span>{{p_item.fio }}. {{ p_item.date}}</p>
              <p></p>
            </div>
          </div>
          <form @submit.prevent.enter="saveData" enctype="multipart/form-data" class="col-md-12">
            <div class="row col-md-12">
                <div class="form-group col-xl-3 col-md-6">
                <label for="organ">{{$t('Tashkilot nomi')}}</label>
                <input
                    type="text"
                    v-model="form.organ"
                    id="organ"
                    class="form-control input_style"
                    :class="isRequired(form.organ) ? 'isRequired' : ''"
                />
                </div>
                <div class="form-group col-xl-3 col-md-6">
                <label for="organ">{{$t('Xodim lavozimi')}}</label>
                <input
                    type="text"
                    v-model="form.job"
                    id="organ"
                    class="form-control input_style"
                    :class="isRequired(form.job) ? 'isRequired' : ''"
                />
                </div>
                <div class="form-group col-xl-3 col-md-6">
                <label for="organ">{{$t('F.I.Sh')}}</label>
                <input
                    type="text"
                    v-model="form.fio"
                    id="organ"
                    class="form-control input_style"
                    :class="isRequired(form.fio) ? 'isRequired' : ''"
                />
                </div>
                <div class="form-gruop col-xl-3 col-md-6">
                <label for="organ">{{$t('Sana')}}</label>
                <div class="d-flex">
                    <date-picker lang="ru" class="input_style" v-model="form.date" type="date" format="DD-MM-YYYY" valueType="format"       :class="isRequired(form.date) ? 'isRequired' : ''"></date-picker>
                    <button  @click="addAgreeData" type="button" class="btn btn-info ml-2"><i  class="fas fa-plus"></i></button>
                </div>
                </div>
            </div>
            <div class="form-group col-lg-12">
                <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-success btn_save_category" @click.prevent="sendToActivate">
                    <i class="far fa-share-square"></i>
                     {{$t('Tasdiqlashga yuvorish')}}
                    </button>
                </div>
                <div class="col-md-6 form_btn d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn_save_category" @click.prevent="saveData">
                    <i class="fas fa-save"></i>
                    {{$t('Saqlash')}}
                    </button>
                </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapGetters, mapActions } from "vuex";
import PassportTab from "./PassportTab";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    PassportTab,
    Loader
  },
  data() {
    return {
      titulData: {},
      schemeData: [],
      form:{
          organ: '',
          job: "",
          fio: '',
          date: '',
          direction_id: this.$route.params.directionId,
      },
      agreedData: [],
      requiredInput: false,
      laoding: true,
      file: ''
    };
  },
  async mounted() {
    await this.actionEditDirection(this.$route.params.directionId);
    await this.actionConditionalSignList();
    this.laoding = false
    this.titulData = this.getDirection
    this.schemeData = this.titulData ? this.titulData.timing_with : [];
    this.agreedData = this.titulData.schema_details;
  },
  computed: {
    ...mapGetters("direction", ["getDirection"]),
    ...mapGetters("passportTab", ["getMsg"]),
    ...mapGetters("conditionalsign", ["getConditionalSignList"]),
    ...mapGetters('confirmscheme',['getSchemeMassage'])
  },
  methods: {
    ...mapActions("passportTab", ["actionAddTiming", "actionAddSchemadetail", 'actionSendSchemeFile']),
    ...mapActions("direction", ["actionEditDirection"]),
    ...mapActions("conditionalsign", ["actionConditionalSignList"]),
    ...mapActions('confirmscheme',['actionApproveScheme']),
    async sendToActivate(){
      await this.actionApproveScheme(this.$route.params.directionId)
      if (this.getSchemeMassage.success){
        await this.actionEditDirection(this.$route.params.directionId);
        toast.fire({
          type: "success",
          icon: "success",
          title: this.getSchemeMassage.message,
        });
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: this.getSchemeMassage.message,
        });
      }
    },

    async saveData() {
      if(this.agreedData.length){
        this.laoding = true
        await this.actionAddSchemadetail({id:this.$route.params.directionId, data:this.agreedData})
        this.laoding = false
        console.log(this.getMsg)
        if(this.getMsg.success){
          toast.fire({
            type: "success",
            icon: "success",
            title: this.getMsg.message
          });
        }else{
          toast.fire({
            type: "error",
            icon: "error",
            title: 'Tizimda xotolik bor. iltimos qaytadan urinib koring!'
          });
        }
      }else{
        toast.fire({
          type: "error",
          icon: "error",
          title: 'Malumotlar formasini toldinring!'
        });
      }

    },
    handleFileUpload(){
        this.file = this.$refs.file.files[0];
    },
    async sendFile(){
        if(this.file){
            let myFileData = new FormData();
            myFileData.append('file', this.file);
            myFileData.append('direction_id', this.$route.params.directionId);
            await this.actionSendSchemeFile(myFileData);
            if(this.getMsg.success){
                toast.fire({
                    type: "success",
                    icon: "success",
                    title: 'Fayl yuklandi',
                });
            }
        }else{
            toast.fire({
                type: "error",
                icon: "error",
                title: 'Faylni tanlang',
            });
        }

    },
    addAgreeData(){
        let data = this.form
        if(this.form.organ != "" && this.form.job != "" && this.form.fio != "" && this.form.date != ""){
            this.requiredInput = false;
            this.agreedData.push(data)
                this.form = {
                organ: '',
                job: '',
                fio: '',
                date: '',
                direction_id: this.$route.params.directionId,
            }
        } else {
            this.requiredInput = true;
        }

    },
    isRequired(input) {
      return this.requiredInput && input === "";
    },
  },
};
</script>
<style scoped>
.tabRow {
  padding-left: 30px;
  padding-right: 30px;
}
.map_scheme {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 100px;
  padding-bottom: 100px;
  position: relative;
}
.cicle_item {
  height: 20px;
  width: 20px;
  border-radius: 6px;
  border: 3px solid black;
  background: #fff;
  z-index: 9;
  position: relative;
}
.sm_cicle_item {
  height: 15px;
  width: 15px;
  border-radius: 50%;
  border: 3px solid black;
  background: #fff;
  z-index: 9;
  position: relative;
}

.stationItem h6 {
  position: absolute;
  top: -30px;
  left: 50%;
  -webkit-transform: translateX(-50%);
  transform: translateX(-50%);
  white-space: nowrap;
}
.mid_line {
  position: absolute;
  left: 0;
  right: 0;
  top: 49.4%;
  width: 100%;
  height: 3px;
  background: #000;
  z-index: 0;
}

.stationItem:nth-child(even) h6 {
  top: -30px;
}
.stationItem:nth-child(odd) h6 {
  top: 30px;
}
.end_point {
}
.end_point.stationItem h6,
.start_point.stationItem h6 {
  font-weight: bold;
  top: -30px;
}
.start_point.stationItem h6{
    left: 30px;
}
.icon_item {
  position: relative;
  border: 1px solid #000;
  border-radius: 6px;
  padding: 2px;
  height: 35px;
  width: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
}
.icon_item img {
  max-width: 80%;
  max-height: 80%;
}
.icon_item sup {
  position: absolute;
  top: -7px;
  right: -7px;
  font-size: 10px;
  font-weight: bold;
  border-radius: 50%;
  width: 15px;
  height: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
  border: 1px solid #000;
}
.road_signs h6 {
  text-align: center;
  font-weight: bold;
  font-size: 20px;
  margin-bottom: 10px;
}
.road_signs ul{
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}
.road_signs ul li{
    list-style: none;
    width: 50%;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    padding-right: 15px;

}
.road_signs ul li .bdn{
    border: none;
}
.road_signs ul li .icon_item{
    margin-right: 10px;
}
.agree_item h6{
    text-transform: uppercase;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
}
.agree_item p span{
    display: inline-flex;
    width: 150px;
    border-bottom: 1px solid #000;
    margin-right: 5px;
}
</style>
