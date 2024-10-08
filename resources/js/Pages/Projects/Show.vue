<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import KanbanColumn from '@/Components/KanbanColumn.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { useDraggable } from 'vue-draggable-plus'
import CreateColumn from '@/Pages/Projects/Partials/CreateColumn.vue'

const props = defineProps({
	project: Object,
	data: Array,
	teamMembers: Array,
	canUpdateColumn: Boolean,
	canDeleteColumn: Boolean,
	canCreateColumn: Boolean,
	canCreateTask: Boolean,
	canDeleteTask: Boolean,
	isAdmin: Boolean
})

const draggable = ref(null)
const columns = ref(props.data)

useDraggable(draggable, columns.value, {
	handle: '.column_drag_handle',
	ghostClass: 'border-primary',
	onEnd: (e) => {
		const index = e.newIndex
		const prevCol = columns.value[index - 1]
		const nextCol = columns.value[index + 1]
		const column = columns.value[index]

		let position = column.position

		if (prevCol && nextCol) {
			position = (prevCol.position + nextCol.position) / 2
		} else if (nextCol) {
			position = nextCol.position / 2
		} else if (prevCol) {
			position = prevCol.position + prevCol.position / 2
		}

		router.put(
			route('columns.move', { column: column.id }),
			{
				position: position,
			},
			{
				preserveState: false,
				preserveScroll: true,
			}
		)
	},
})
</script>

<template>
	<AppLayout :title="project.name" :project="project.id">
		<div class="mx-10 flex h-full gap-2 overflow-x-scroll">
			<!-- Columns -->
			<div ref="draggable" class="flex h-full gap-2">
				<KanbanColumn v-for="column in columns" :key="column.id" :column="column" :columns="columns"
					:teamMembers="teamMembers" :canUpdateColumn="canUpdateColumn" :canDeleteColumn="canDeleteColumn"
					:canCreateTask="canCreateTask" :canDeleteTask="canDeleteTask" :isAdmin="isAdmin" />
			</div>

			<!-- Create new column -->
			<CreateColumn v-if="canCreateColumn" :project_id="project.id" />
		</div>
	</AppLayout>
</template>
