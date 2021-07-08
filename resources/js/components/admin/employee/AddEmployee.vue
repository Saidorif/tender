<template>
  <div class="add_employee">
      <Loader v-if="laoding"/>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i  class="peIcon fas fa-users"></i></i>{{$t('Qoʼshish')}}
        </h3>
        <router-link class="btn btn-primary back_btn" to="/crm/employee">
          <span class="peIcon pe-7s-back"></span> {{$t('Orqaga')}}
        </router-link>
      </div>
      <form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
        <div class="card-body d-flex flex-wrap">
          <div class="col-md-8">
            <div class="row">
              <div class="form-group col-lg-6">
                <label for="region_id">{{$t('Viloyat')}}</label>
                <select
                  id="region_id"
                  class="form-control input_style"
                  :class="isRequired(form.region_id) ? 'isRequired' : ''"
                  v-model="form.region_id"
                >
                  <option value="" selected disabled>{{$t('Tanlang')}}!</option>
                  <option :value="item.id" v-for="(item,index) in getRegionList">{{item.name}}</option>
                </select>
              </div>
              <div class="form-group col-lg-6">
                <label for="surname">{{$t('Familiya')}}</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="surname"
                  :class="isRequired(form.surname) ? 'isRequired' : ''"
                  v-model="form.surname"
                />
              </div>
              <div class="form-group col-lg-6">
                <label for="name">{{$t('Ism')}}</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="name"
                  :class="isRequired(form.name) ? 'isRequired' : ''"
                  v-model="form.name"
                />
              </div>
              <div class="form-group col-lg-6">
                <label for="middlename">{{$t('Sharifi')}}</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="middlename"
                  :class="isRequired(form.middlename) ? 'isRequired' : ''"
                  v-model="form.middlename"
                />
              </div>
              <div class="form-group col-lg-6">
                <label for="positon">{{$t('Lavozim')}}</label>
                <select
                  class="form-control"
                  :class="isRequired(form.position_id) ? 'isRequired' : '' "
                  id="positon"
                  v-model="form.position_id"
                >
                  <option value selected disabled>{{$t('Tanlang')}} </option>
                  <option
                    :value="position.id"
                    v-for="(position,index) in getPositionList"
                  >{{position.name}}</option>
                </select>
              </div>
              <div class="form-group col-lg-6">
                <label for="phone">{{$t('Telefon')}}</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="phone"
                  v-mask="'99 999 99 99'"
                  v-model="form.phone"
                  :class="isRequired(form.phone) ? 'isRequired' : ''"
                >
              </div>
              <div class="form-group col-md-6">
                <label for="role">{{$t('Roʼl')}}</label>
                <select
                  class="form-control"
                  :class="isRequired(form.role_id) ? 'isRequired' : '' "
                  id="countryName"
                  v-model="form.role_id"
                >
                  <option value selected disabled>{{$t('Tanlang')}} </option>
                  <option :value="role.id" v-for="(role,index) in getRoleList">{{role.label}}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">{{$t('Email')}}</label>
                <input
                  type="email"
                  class="form-control input_style"
                  :class="isRequired(form.email) ? 'isRequired' : ''"
                  id="exampleInputEmail1"
                  v-model="form.email"
                  @blur="checkEmailInput"
                />
                <small class="redText" v-if="emailError">{{$t('Email band')}} !</small>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">{{$t('Parol')}}</label>
                <input
                  type="password"
                  class="form-control input_style"
                  id="exampleInputPassword1"
                  :class="isRequired(form.password) ? 'isRequired' : ''"
                  v-model="form.password"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="ConfirmPassword1">{{$t('Parolni tasdiqlash')}}</label>
                <input
                  type="password"
                  class="form-control input_style"
                  id="ConfirmPassword1"
                  v-model="form.confirm_password"
                  :class="isRequired(form.confirm_password) ? 'isRequired' : ''"
                  @input="confirmPassword()"
                />
                <small class="redText" v-if="checkPassword">
                  <b>{{$t('Parol mos emas')}}</b>
                </small>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group photoFileUploader">
              <div class="avatar-upload">
                <div class="avatar-edit">
                  <input
                    type="file"
                    id="image"
                    accept=".png, .jpg, .jpeg"
                    @change="changePhoto($event)"
                  />
                  <label for="image">
                    <i class="pe-7s-pen"></i>
                  </label>
                </div>
                <div class="avatar-preview">
                  <div
                    id="imagePreview"
                    :style="{'backgroundImage': 'url('+ photoImg(form.image) +')'}"
                  ></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> {{$t('Saqlash')}}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapActions, mapGetters } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {
      form: {
        surname: "",
        middlename: "",
        name: "",
        email: "",
        password: "",
        confirm_password: "",
        role_id: "",
        region_id: "",
        position_id: "",
        phone: "",
        image: "",
      },
      fileFormat: "нет-файла",
      requiredInput: false,
      checkPassword: false,
      laoding: true,
      emailError: false
    };
  },
  async mounted() {
    await this.actionRoleList();
    await this.actionPositionList();
    await this.actionRegionList();
    this.laoding = false
  },
  computed: {
    ...mapGetters("employee", ["getMassage"]),
    ...mapGetters("role", ["getRoleList"]),
    ...mapGetters("position", ["getPositionList"]),
    ...mapGetters("region", ["getRegionList"]),
    ...mapGetters("area", ["getAreaList"]),
  },
  methods: {
    ...mapActions("region", ["actionRegionList"]),
    ...mapActions("area", ["actionAreaByRegion"]),
    ...mapActions("role", ["actionRoleList"]),
    ...mapActions("employee", ["actionAddEmployee", "actionCheckEmail"]),
    ...mapActions("position", ["actionPositionList"]),
    confirmPassword() {
      if (this.form.password && this.form.confirm_password) {
        if (this.form.password != this.form.confirm_password) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    photoImg(img) {
      if (img.length < 100) {
        return "/img/user.jpg";
      } else {
        return img;
      }
    },
    changePhoto(event) {
      let file = event.target.files[0];
      if (
        event.target.files[0]["type"] === "image/png" ||
        event.target.files[0]["type"] === "image/jpeg" ||
        event.target.files[0]["type"] === "image/jpg"
      ) {
        if (file.size > 1048576) {
          swal.fire({
            type: "error",
            title: this.$t('Hatolik'),
            text: "Размер изображения больше лимита"
          });
        } else {
          let reader = new FileReader();
          reader.onload = event => {
            this.form.image = event.target.result;
          };
          reader.readAsDataURL(file);
        }
      } else {
        swal.fire({
          type: "error",
          title: this.$t('Hatolik'),
          text: "Картинка должна быть только png,jpg,jpeg!"
        });
      }
    },
    isRequired(input) {
      if (input != null) {
        return this.requiredInput && input === "";
      }
    },
    async sendEmployee() {
      if (
        this.form.middlename !='' &&
        this.form.surname !='' &&
        this.form.name !='' &&
        this.form.email !='' &&
        this.form.password !='' &&
        this.form.confirm_password !='' &&
        this.form.region_id !='' &&
        this.form.position_id !='' &&
        this.form.role_id !='' &&
        this.checkPassword == false
      ) {
          this.laoding = true
        await this.actionAddEmployee(this.form);
        this.laoding = false
        if (this.getMassage.success) {
          this.$router.push("/crm/employee");
          this.requiredInput = false;
          toast.fire({
            type: "success",
            icon: "success",
            title:this.getMassage.message
          });
        }
      } else {
        this.requiredInput = true;
      }
    },
    async checkEmailInput() {
        this.laoding = true
      await this.actionCheckEmail({ email: this.form.email });
      this.laoding = false
      if (
        this.getMassage.error &&
        this.getMassage.message.email == "Почта уже занята."
      ) {
        this.emailError = true;
      } else {
        this.emailError = false;
      }
    },
  }
};
</script>
<style scoped>
</style>
