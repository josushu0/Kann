<script setup>
import { cn } from '@/lib/utils'
import { Button } from '@/Components/shadcn/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu'
import { Icon } from '@iconify/vue';

defineProps({
  column: Object,
  title: String
})

</script>

<script>
export default {
  inheritAttrs: false,
}
</script>

<template>
  <div v-if="column.getCanSort()" :class="cn('flex items-center gap-2', $attrs.class ?? '')">
    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <Button variant="ghost" size="sm" class="-ml-3 h-8 data-[state=open]:bg-accent">
          <span>{{ title }}</span>
          <Icon icon="lucide:arrow-up" v-if="column.getIsSorted() === 'asc'" class="ml-2 size-4" />
          <Icon icon="lucide:arrow-down" v-else-if="column.getIsSorted() === 'desc'" class="ml-2 size-4" />
          <Icon icon="lucide:chevrons-up-down" v-else class="ml-2 size-4" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="start">
        <DropdownMenuItem @click="column.toggleSorting(false)">
          <Icon icon="lucide:arrow-up" class="mr-2 size-3.5 text-muted-foreground/70" />
          Asc
        </DropdownMenuItem>
        <DropdownMenuItem @click="column.toggleSorting(true)">
          <Icon icon="lucide:arrow-down" class="mr-2 size-3.5 text-muted-foreground/70" />
          Desc
        </DropdownMenuItem>
        <DropdownMenuItem @click="column.clearSorting()">
          <Icon icon="lucide:chevrons-up-down" class="mr-2 size-3.5 text-muted-foreground/70" />
          Reset
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  </div>

  <div v-else :class="$attrs.class">
    {{ title }}
  </div>
</template>
