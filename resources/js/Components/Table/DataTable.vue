<script setup>
import { ref } from 'vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../shadcn/ui/table';
import { FlexRender, useVueTable, getCoreRowModel } from '@tanstack/vue-table'
import { router } from '@inertiajs/vue3'
import DataTablePagination from './DataTablePagination.vue'

const props = defineProps({
  columns: {
    type: Array,
    required: true
  },
  data: {
    type: Object,
    required: true
  },
  sort: {
    type: Object,
    required: true
  }
})

const query = () => {
  router.get(
    route('users.index', {
      _query: {
        sortColumn: sorting.value[0] ? sorting.value[0].id : null,
        sortOrder: sorting.value.length > 0 ? (sorting.value[0].desc ? 'desc' : 'asc') : null,
        page: pagination.value.pageIndex + 1,
        rowCount: pagination.value.pageSize
      }
    })
  )
}

const sorting = ref([{
  id: props.sort.id,
  desc: props.sort.order === 'desc' ? true : false
}])
const setSorting = (updateSorting) => {
  sorting.value = updateSorting(sorting.value)
  query()
}

const pagination = ref({
  pageIndex: props.data.current_page - 1,
  pageSize: props.data.per_page
})
const setPagination = (updatePagination) => {
  pagination.value = updatePagination(pagination.value)
  query()
}

const table = useVueTable({
  get data() { return props.data.data },
  get columns() { return props.columns },
  state: {
    get sorting() {
      return sorting.value
    },
    get pagination() {
      return pagination.value
    }
  },
  initialState: {
    pagination: {
      pageIndex: props.data.current_page - 1,
      pageSize: props.data.per_page
    }
  },
  getCoreRowModel: getCoreRowModel(),
  manualSorting: true,
  onSortingChange: setSorting,
  manualPagination: true,
  rowCount: props.data.per_page,
  pageCount: props.data.last_page,
  onPaginationChange: setPagination,
})

</script>

<template>
  <div class="flex flex-col gap-4 justify-between overflow-hidden h-full">
    <div class="overflow-scroll rounded-md border">
      <div>
        <Table>
          <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
              <TableHead v-for="header in headerGroup.headers" :key="header.id">
                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                  :props="header.getContext()" />
              </TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <template v-if="table.getRowModel().rows?.length">
              <TableRow v-for="row in table.getRowModel().rows" :key="row.id"
                :data-state="row.getIsSelected() && 'selected'">
                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                  <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                </TableCell>
              </TableRow>
            </template>

            <TableRow v-else>
              <TableCell :colspan="columns.length" class="h-24 text-center">
                No results.
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
    <DataTablePagination :table="table" />
  </div>
</template>
