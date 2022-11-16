<template>
  <bread-crumb title="List User"></bread-crumb>
  <base-card>
    <template v-slot:cardHeader>
      <div class="card-header">
        <div class="card-title py-3">Data User</div>
      </div>
    </template>
    <div>
      <router-link :to="{ name: 'AdminUserForm' }">
        <base-btn rounded purple_outline icon class="text-sm mr-2 w-48 mb-4">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-2 -ml-1"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 4v16m8-8H4"
            />
          </svg>
          Tambah User</base-btn
        >
      </router-link>
    </div>

    <div class="grid xl:grid-cols-4 gap-4 mb-4">
      <search
        placeholder="Search By Email"
        v-model="filter.filter_email"
        v-on:keyup="filter_nn"
      >
      </search>
    </div>

    <base-table
      :headers="headers"
      :items="data_table_2.data"
      :pages="data_table_2.page"
      :pageSize="data_table_2.pageSize"
      :total-pages="data_table_2.totalPages"
      @pagechanged="onPageChange"
      @delete="deleteID"
    ></base-table>
  </base-card>
</template>

<script setup>
import { inject, onMounted, reactive, watch } from "vue";
import useUser from "../../../composables/User";
import BaseTable from "../../components/Base/BaseTable.vue";
import Search from "../../components/Form/Search.vue";
const { users, getUsers, deleteData } = useUser();
onMounted(getUsers);
const data_table_2 = reactive({
  data: [],
  page: 1,
  pageSize: 5,
  totalPages: 0,
});
const filter = reactive({
  filter_email: "",
});
const swal = inject("$swal");
const headers = [
  { key: "name", label: "Nama" },
  { key: "email", label: "Email" },
  {
    key: "id",
    label: "Aksi",
    route: "AdminUserView",
  },
];
watch(users, (data) => {
  data_table_2.data = data.data;
  data_table_2.totalPages = data.last_page;
});
const onPageChange = async (page) => {
  data_table_2.page = page;
  await getUsers(data_table_2.page, { ...filter });
};
const filter_nn = async () => {
  data_table_2.page = 1;
  await getUsers(data_table_2.page, { ...filter });
};
const deleteID = async (id) => {
  await swal({
    title: "Apakah Anda Yakin?",
    text: "Data Tidak Bisa dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya!",
  }).then((result) => {
    if (result.isConfirmed) {
      swal("Deleted!", "Data Berhasil Terhapus", "success");
      deleteData(id);
      getUsers(data_table_2.page, { ...filter });
    }
  });
};
</script>

<style lang="scss" scoped></style>
