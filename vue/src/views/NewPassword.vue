<template>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div
      class="
        flex flex-col
        items-center
        justify-center
        px-6
        py-8
        mx-auto
        md:h-screen
        lg:py-0
      "
    >
      <div
        class="
          w-full
          bg-white
          rounded-lg
          shadow
          dark:border
          md:mt-0
          sm:max-w-md
          xl:p-0
          dark:bg-gray-800 dark:border-gray-700
        "
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <div class="px-8 mb-4 text-center">
            <h3 class="pt-4 mb-2 text-2xl">Atur Ulang Password</h3>
            <p class="mb-4 text-sm text-gray-700">
              Masukan Password Baru untuk merubah password.
            </p>
          </div>
          <form class="space-y-4 md:space-y-6" @submit="onSubmit">
            <div>
              <form-title judul="Password Baru"></form-title>
              <form-text
                id="password"
                type="password"
                v-model="user.password"
                placeholder="masukan password baru"
              ></form-text>
            </div>

            <button
              type="submit"
              class="
                group
                relative
                w-full
                flex
                justify-center
                py-2
                px-4
                border border-transparent
                text-sm
                font-medium
                rounded-md
                text-white
                bg-indigo-600
                hover:bg-indigo-700
                focus:outline-none
                focus:ring-2
                focus:ring-offset-2
                focus:ring-indigo-500
              "
            >
              Simpan
            </button>
          </form>
          <!-- FORM -->
          <hr class="mb-6 border-t" />
          <div class="text-center">
            <router-link
              :to="{ name: 'Register' }"
              class="font-medium text-indigo-600 hover:text-indigo-500"
            >
              Daftar Baru
            </router-link>
          </div>
          <div class="text-center">
            <router-link
              :to="{ name: 'Login' }"
              class="font-medium text-indigo-600 hover:text-indigo-500"
            >
              Sudah Punya Akun ? Login!
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, reactive, ref, watch } from "vue";
import { useRoute } from "vue-router";

import useAuth from "../composables/Auth";
import FormTitle from "../views/components/Form/FormTitle.vue";
import FormText from "../views/components/Form/FormText.vue";
import Footer from "../views/layouts/Footer.vue";
const { resetPassword, newPassword } = useAuth();
const route = useRoute();
const user = reactive({
  password: "",
});
if (route.params.id) {
  resetPassword(route.params.id);
}
const onSubmit = async (ev) => {
  ev.preventDefault();

  await newPassword({ ...user }, route.params.id);
};
</script>

<style lang="scss" scoped>
</style>