<template>
  <div
    class="
      dataTable-container
      block
      w-full
      overflow-x-auto
      whitespace-nowrap
      borderless
      hover
    "
  >
    <table class="w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-indigo-50">
        <th
          scope="col"
          class="px-6 py-3"
          v-for="{ key, label, sortable } in headers"
          :key="key"
        >
          {{ label }}
        </th>
      </thead>
      <tbody v-if="props.items.length == 0">
        <tr>
          Data Tidak Ditemukan
        </tr>
      </tbody>
      <tbody v-else class="mb-4">
        <tr
          v-for="(p, index) in props.items"
          :key="index"
          class="
            bg-white
            border-b
            dark:bg-gray-800 dark:border-gray-700
            hover:bg-indigo-50
            dark:hover:bg-gray-600
          "
        >
          <td
            v-for="{ key, label, route } in headers"
            :key="key"
            class="px-6 py-4"
          >
            <div v-if="label == 'Aksi'">
              <slot :name="`(${key})`" :value="p[key]" :item="p">
                <router-link
                  :to="{
                    name: route,
                    params: { id: p[key] },
                  }"
                >
                  <BaseBtn
                    rounded
                    class="
                      border border-primary
                      text-primary
                      hover:bg-primary hover:text-white
                      mr-2
                    "
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-4 w-4"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                      />
                    </svg>
                  </BaseBtn>
                </router-link>
                <BaseBtn
                  @click="deleteThis(p[key])"
                  rounded
                  class="
                    border border-danger
                    text-danger
                    hover:bg-danger hover:text-white
                    mr-1
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                </BaseBtn>
              </slot>
            </div>
            <div v-else>
              <slot :name="`(${key})`" :value="p[key]" :item="p">
                {{ p[key] }}
              </slot>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  <div
    class="bg-white px-4 py-3 flex items-center justify-between sm:px-6 mt-4"
  >
    <div class="flex-1 flex justify-between sm:hidden">
      <a
        href="#"
        @click.prevent="onClickPreviousPage"
        :class="hitung.isInFirstPage ? 'disabled' : ''"
        :disabled="hitung.isInFirstPage"
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:bg-gray-50
        "
      >
        Previous
      </a>
      <a
        href="#"
        @click.prevent="onClickNextPage"
        :class="hitung.isInLastPage ? 'disabled' : ''"
        :disabled="hitung.isInLastPage"
        class="
          ml-3
          relative
          inline-flex
          items-center
          px-4
          py-2
          border border-gray-300
          text-sm
          font-medium
          rounded-md
          text-gray-700
          bg-white
          hover:bg-gray-50
        "
      >
        Next
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <a
            href="#"
            @click.prevent="onClickPreviousPage"
            :class="hitung.isInFirstPage ? 'disabled' : ''"
            :disabled="hitung.isInFirstPage"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-l-md
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <span class="sr-only">Previous</span>
            <!-- Heroicon name: solid/chevron-left -->
            <svg
              class="h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
          <li :key="page.id" v-for="page in hitung.pages">
            <a
              href="#"
              @click.prevent="onClickPage(page.name)"
              :disabled="page.isDisabled"
              :class="{
                'z-10 border-purple-500 text-purple-500 inline-flex px-4 py-2':
                  isPageActive(page.name),
              }"
              class="
                bg-white
                border-gray-300
                text-gray-500
                hover:bg-gray-50
                relative
                inline-flex
                items-center
                px-4
                py-2
                border
                text-sm
                font-medium
              "
            >
              {{ page.name }}
            </a>
          </li>

          <a
            href="#"
            @click.prevent="onClickNextPage"
            :class="hitung.isInLastPage ? 'disabled' : ''"
            :disabled="hitung.isInLastPage"
            class="
              relative
              inline-flex
              items-center
              px-2
              py-2
              rounded-r-md
              border border-gray-300
              bg-white
              text-sm
              font-medium
              text-gray-500
              hover:bg-gray-50
            "
          >
            <span class="sr-only">Next</span>
            <!-- Heroicon name: solid/chevron-right -->
            <svg
              class="h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
        </nav>
      </div>
    </div>
  </div>
  Halaman {{ props.pages }} dari {{ props.totalPages }}
</template>

<script setup>
import { computed, reactive, watch, ref } from "vue";
const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  items: {
    type: Array,
    required: true,
  },
  pages: {
    type: Number,
    required: true,
  },
  pageSize: {
    type: Number,
    required: true,
  },
  maxVisibleButtons: {
    type: Number,
    required: false,
    default: 3,
  },
  totalPages: {
    type: Number,
    required: true,
  },
});
//Per page = pageSize
//current page = pages
const emit = defineEmits(["pagechanged", "delete"]);
const hitung = reactive({
  isInFirstPage: computed(() => {
    return props.pages === 1;
  }),
  isInLastPage: computed(() => {
    if (props.totalPages === 0) {
      return true;
    }
    return props.pages === props.totalPages;
  }),
  endPage: computed(() => {
    if (props.totalPages === 0) {
      return 1;
    }
    if (props.totalPages < props.maxVisibleButtons) {
      return props.totalPages;
    }
    return Math.min(
      hitung.startPage + props.maxVisibleButtons - 1,
      props.totalPages
    );
  }),
  startPage: computed(() => {
    //page1
    if (props.pages === 1) {
      return 1;
    }
    //page akhir
    if (props.totalPages < props.maxVisibleButtons) {
      return 1;
    }
    if (props.pages === props.totalPages) {
      return props.totalPages - props.maxVisibleButtons + 1;
    }
    //page bukan 1
    return props.pages - 1;
  }),
  pages: computed(() => {
    const range = [];
    for (let i = hitung.startPage; i <= hitung.endPage; i++) {
      range.push({
        name: i,
        isDisabled: i === props.pages,
      });
    }
    return range;
  }),
});
function paginated() {
  return props.items.slice(
    (props.pages - 1) * props.pageSize,
    (props.pages - 1) * props.pageSize + props.pageSize
  );
}

function onClickFirstPage() {
  if (hitung.isInFirstPage) {
    return false;
  }
  emit("pagechanged", 1);
}
function onClickPreviousPage() {
  if (hitung.isInFirstPage) {
    return false;
  }
  emit("pagechanged", props.pages - 1);
}
function onClickPage(page) {
  emit("pagechanged", page);
}
function onClickNextPage() {
  if (hitung.isInLastPage) {
    return false;
  }
  emit("pagechanged", props.pages + 1);
}
function onClickLastPage() {
  if (hitung.isInLastPage) {
    return false;
  }
  emit("pagechanged", props.totalPages);
}
function isPageActive(page) {
  return props.pages === page;
}
function deleteThis(e) {
  emit("delete", e);
}
</script>

<style lang="scss" scoped>
</style>