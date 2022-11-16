<template>
  <bread-crumb title="GenerateQuiz"></bread-crumb>
  <base-card>
    <template v-slot:cardHeader>
      <div class="card-header">
        <div class="card-title py-3">Data User</div>
      </div>
    </template>
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
    ></base-table>
  </base-card>
</template>

<script setup>
import { onMounted, reactive, watch } from "vue";
import useUser from "../../../composables/User";
import BaseTable from "../../components/Base/BaseTable.vue";
import Search from "../../components/Form/Search.vue";
const { users, getUsers } = useUser();
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
const headers = [
  { key: "name", label: "Nama" },
  { key: "email", label: "Email" },
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
</script>

<style lang="scss" scoped></style>
