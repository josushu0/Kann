<script setup>
import { Icon } from '@iconify/vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import CreateTask from '@/Components/CreateTask.vue'

const props = defineProps({
	task: Object,
	column: String,
	columns: Array,
	teamMembers: Array,
})
</script>

<template>
	<CreateTask :task="task" :column="column" :columns="columns" :teamMembers="teamMembers">
		<Button variant="ghost" class="flex w-full select-none justify-start p-2 h-fit">
			<div class="task_drag_handle flex-none cursor-grab p-3">
				<Icon icon="lucide:grip-vertical" />
			</div>
			<span class="text-wrap text-start break-words max-w-[182px]">{{ task.name }}</span>
		</Button>
	</CreateTask>
</template>
