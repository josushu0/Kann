<script setup>
import {
	Card,
	CardHeader,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import { Icon } from '@iconify/vue'

const props = defineProps({
	task: Object,
})
</script>

<template>
	<Card>
		<CardHeader class="flex h-full select-none flex-row items-center p-2">
			<div class="task_drag_handle flex-none cursor-grab p-3">
				<Icon icon="lucide:grip-vertical" />
			</div>
			<CardTitle class="text-base">{{ task.name }}</CardTitle>
		</CardHeader>
	</Card>
</template>
