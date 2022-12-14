<template>
  <div v-if="modul.formEmail">
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
              <h3 class="pt-4 mb-2 text-2xl">Lupa Password?</h3>
              <p class="mb-4 text-sm text-gray-700">
                Masukan Email dan Kami Akan Mengirimkan Token Untuk Mengatur
                Ulang Password.
              </p>
            </div>
            <form class="space-y-4 md:space-y-6" @submit="kirimToken">
              <div>
                <form-title judul="Email"></form-title>
                <form-text
                  id="email"
                  type="email"
                  v-model="user.email"
                  placeholder="masukan alamat email"
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
                :disabled="modul.counting"
                @click="startCountdown"
              >
                <vue-countdown
                  v-if="modul.counting"
                  :time="60000"
                  @end="onCountdownEnd"
                  v-slot="{ totalSeconds }"
                  >Coba lagi dalam {{ totalSeconds }} detik</vue-countdown
                >
                <span v-else>Kirim Token Ke Email</span>
              </button>

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
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref, watch } from "vue";
import useAuth from "../composables/Auth";
import FormTitle from "../views/components/Form/FormTitle.vue";
import FormText from "../views/components/Form/FormText.vue";
import Footer from "../views/layouts/Footer.vue";
const { sentToken } = useAuth();
const user = reactive({
  email: "",
});
const modul = reactive({
  button: false,
  counting: false,
  formEmail: true,
});
const kirimToken = async (ev) => {
  ev.preventDefault();
  await sentToken({ ...user });
};
const onSubmit = async (ev) => {
  ev.preventDefault();
  console.log("AAAAAAAAAAAAAAAAAA");
};
function isDisabled() {
  return modul.button;
}
function cobaLagi() {
  modul.button = true;
}
function startCountdown() {
  modul.counting = true;
}
function onCountdownEnd() {
  modul.counting = false;
}
</script>

<style lang="scss" scoped>
</style>