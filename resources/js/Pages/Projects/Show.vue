<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { List, Project } from '@/types'
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { useDraggable } from 'vue-draggable-plus'
import TaskList from './Partials/TaskList.vue'
import CreateTaskList from './Partials/CreateTaskList.vue'

const props = defineProps<{
	project: Project
	lists: List[]
}>()

const draggable = ref<HTMLElement | null>(null)
const listsRef = ref(props.lists)

useDraggable(draggable, listsRef, {
	handle: '.list_drag_handle',
	ghostClass: 'border',
	onEnd: (e) => {
		const index = e.newIndex
		if (index) {
			const prevList = listsRef.value[index - 1]
			const nextList = listsRef.value[index + 1]
			const list = listsRef.value[index]

			let position = list.position

			if (prevList && nextList) {
				position = (prevList.position + nextList.position) / 2
			} else if (nextList) {
				position = nextList.position / 2
			} else if (prevList) {
				position = prevList.position + prevList.position / 2
			}

			const form = useForm({
				position,
			})

			console.log(list)

			form.put(route('lists.update', list.id), {
				preserveState: true,
				preserveScroll: true,
			})
		}
	},
})
</script>

<template>
	<Head :title="project.name" />

	<AuthenticatedLayout :projectId="project.id">
		<ConfirmDialog />
		<div class="flex h-full gap-2 overflow-x-scroll p-6">
			<div ref="draggable" class="flex h-full gap-2">
				<TaskList v-for="list in listsRef" :key="list.id" :list="list" />
			</div>
			<CreateTaskList :project="project.id" />
		</div>
	</AuthenticatedLayout>
</template>
