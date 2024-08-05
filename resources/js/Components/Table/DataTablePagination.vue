<script setup>
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../shadcn/ui/select';
import { Button } from '../shadcn/ui/button';
import { Icon } from '@iconify/vue';

defineProps({
  table: Object
})
</script>

<template>
  <div class="flex items-center justify-end gap-6 lg:gap-8 px-2">
    <div class="flex items-center gap-2">
      <p class="text-sm font-medium">
        Rows per page
      </p>
      <Select :model-value="`${table.getState().pagination.pageSize}`" @update:model-value="table.setPageSize">
        <SelectTrigger class="w-fit space-x-2">
          <SelectValue :placeholder="`${table.getState().pagination.pageSize}`" />
        </SelectTrigger>
        <SelectContent side="top">
          <SelectItem v-for="pageSize in [10, 20, 30, 40, 50]" :key="pageSize" :value="`${pageSize}`">
            {{ pageSize }}
          </SelectItem>
        </SelectContent>
      </Select>
    </div>
    <div class="flex items-center justify-center text-sm font-medium">
      Page {{ table.getState().pagination.pageIndex + 1 }} of
      {{ table.getPageCount() }}
    </div>
    <div class="flex items-center gap-2">
      <Button variant="outline" class="size-8 p-0" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
        <span class="sr-only">Go to previous page</span>
        <Icon icon="lucide:chevron-left" class="size-4" />
      </Button>
      <Button variant="outline" class="size-8 p-0" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
        <span class="sr-only">Go to next page</span>
        <Icon icon="lucide:chevron-right" class="size-4" />
      </Button>
    </div>
  </div>
</template>
