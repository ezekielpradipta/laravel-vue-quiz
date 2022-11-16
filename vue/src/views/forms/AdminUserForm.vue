<template>
  <bread-crumb title="Tambah Data User"></bread-crumb>
  <base-card>
    <pre>{{ model }}</pre>
    <template v-slot:cardHeader>
      <div class="card-header">
        <div class="card-title py-3">Tambah Data User</div>
      </div>
    </template>
    <form-master @submit="onSubmit">
      <form-step>
        <div class="grid xl:grid-cols-2 xl:gap-6">
          <div class="relative mb-6 w-full group">
            <form-title judul="Email"> </form-title>
            <form-text
              id="email"
              type="email"
              v-model="model.email"
              placeholder="email@email.com"
            ></form-text>
            <span class="text-danger" v-if="model.validate.email">{{
              model.validate.email
            }}</span>
          </div>

          <div class="relative mb-6 w-full group">
            <form-title judul="Name"> </form-title>
            <form-text
              id="name"
              type="text"
              v-model="model.name"
              placeholder="Your Name"
            ></form-text>
          </div>
        </div>
        <div class="grid xl:grid-cols-2 xl:gap-6">
          <div class="relative mb-6 w-full group">
            <form-title judul="Password"> </form-title>
            <form-text
              id="password"
              type="password"
              v-model="model.password"
              placeholder="Your Password"
            ></form-text>
          </div>
          <div class="relative mb-6 w-full group">
            <form-title judul="Password Confirmation"> </form-title>
            <form-text
              id="password"
              type="password"
              v-model="model.password_confirmation"
              placeholder="Password Confirmation"
            ></form-text>
          </div>
        </div>
      </form-step>
    </form-master>
  </base-card>
</template>

<script setup>
import FormMaster from "../components/Form/FormMaster.vue";
import FormStep from "../components/Form/FormStep.vue";
import FormTitle from "../components/Form/FormTitle.vue";
import FormText from "../components/Form/FormText.vue";
import useUser from "../../composables/User";
import { onMounted, reactive, watch } from "vue";
import { useRoute } from "vue-router";
const route = useRoute();
const model = reactive({
  email: "",
  name: "",
  validate: [],
  password: "",
  password_confirmation: "",
  id: null,
});

const { cekEmail, createUser, getUser, user } = useUser();
watch(
  () => model.email,
  (newValue, oldValue) => {
    validateEmail(newValue);
  }
);
const validateEmail = async (value) => {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
    await cekEmail({ ...model }).then((response) => {
      if (response.data === "unique") {
        model.validate["email"] = "";
      } else {
        model.validate["email"] = "Email Sudah Terdaftar";
      }
    });
  } else {
    model.validate["email"] = "Bukan Format Email";
  }
};
const onSubmit = async () => {
  await createUser({ ...model });
};
if (route.params.id) {
  console.log(route.params.id);
  getUser(route.params.id);
  watch(user, (data) => {
    if (data) {
      Object.assign(model, data);
      console.log(data);
    }
  });
}
</script>

<style lang="scss" scoped>
</style>