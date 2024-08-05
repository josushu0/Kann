<script setup lang="ts">
import DataTable from '@/Components/Table/DataTable.vue';
import AppLayout from '@/Layouts/AppLayout.vue'
import { columns } from './columns'
import { Button } from '@/Components/shadcn/ui/button';
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';

defineProps({
  users: Object,
  sort: Object
})
</script>

<template>
  <AppLayout title="Users">
    <div class="flex flex-col gap-2 h-full">
      <div class="flex px-2 justify-end">
        <Button variant="outline" as-child>
          <Link :href="route('users.create')" class="flex gap-1 items-center">
          New
          <Icon icon="lucide:plus" />
          </Link>
        </Button>
      </div>
      <DataTable :columns="columns" :data="users" :sort="sort" />
    </div>
  </AppLayout>
</template>
