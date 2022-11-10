<template>
  <bread-crumb title="List User"></bread-crumb>
  <base-card>
    <div class="lg:flex justify-between items-center mb-6">
      <p class="font-semibold mb-2 lg:mb-0">Daftar Pengguna</p>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead
        class="
          text-xs text-gray-700
          uppercase
          bg-gray-50
          dark:bg-gray-700 dark:text-gray-400
        "
      >
        <tr>
          <th scope="col" class="px-6 py-3">Nama</th>
          <th scope="col" class="px-6 py-3">Email</th>
        </tr>
      </thead>
      <tbody class="mb-4">
        <tr
          v-for="(p, index) in data_table.data.data"
          :key="index"
          class="
            bg-white
            border-b
            dark:bg-gray-800 dark:border-gray-700
            hover:bg-gray-50
            dark:hover:bg-gray-600
          "
        >
          <th
            scope="row"
            class="
              px-6
              py-4
              font-medium
              text-gray-900
              dark:text-white
              whitespace-nowrap
            "
          >
            {{ p.name }}
          </th>
          <td class="px-6 py-4">{{ p.email }}</td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-center mt-5">
      <nav
        class="
          relative
          z-0
          inline-flex
          justify-center
          rounded-md
          shadow-sm
          -space-x-px
        "
        aria-label="Pagination"
      >
        <a
          v-for="(link, i) of data_table.data.links"
          :key="i"
          :disabled="!link.url"
          href="#"
          @click="getForPage($event, link)"
          aria-current="page"
          class="
            relative
            inline-flex
            items-center
            px-4
            py-2
            border
            text-sm
            font-medium
            whitespace-nowrap
          "
          :class="[
            link.active
              ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
              : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
            i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
            i === data_table.data.links.length - 1 ? 'rounded-r-md' : '',
          ]"
          v-html="link.label"
        >
        </a>
      </nav>
    </div>
    <base-table
      :headers="headers"
      :items="data_table_2.data"
      :pages="data_table_2.page"
      :pageSize="data_table_2.pageSize"
      :total-pages="data_table_2.totalPages"
      @pagechanged="onPageChange"
    ></base-table>
  </base-card>
  <pre>{{ data_table_2.data.total }}</pre>
</template>

<script setup>
import { onMounted, reactive, watch } from "vue";
import useUser from "../../../composables/User";
import BaseTable from "../../components/Base/BaseTable.vue";
const { users, getUsers } = useUser();
onMounted(getUsers);
const data_table = reactive({
  data: [],
});
const data_table_2 = reactive({
  data: [],
  page: 1,
  pageSize: 5,
  totalPages: 0,
});
const filter = reactive({
  coba: "AAAAAAAA",
});
const headers = [
  { key: "name", label: "Nama" },
  { key: "email", label: "Email" },
];
watch(users, (data) => {
  data_table.data = data;
  data_table_2.data = data.data;
  data_table_2.totalPages = Math.floor(data.total / data_table_2.pageSize) + 1;
  console.log(data.data);
});
function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }
  getUsers(link.url, { ...filter });
}
const onPageChange = async (page) => {
  data_table_2.page = page;
  await getUsers();
};
</script>

<style lang="scss" scoped></style>
