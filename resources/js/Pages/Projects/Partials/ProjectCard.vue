<script setup lang="ts">
import { Project } from '@/types'
import { Link, router } from '@inertiajs/vue3'
import { MenuMethods } from 'primevue/menu'

const props = defineProps<{
	project: Project
}>()

import { MenuItem } from 'primevue/menuitem'
import { useConfirm } from 'primevue/useconfirm'
import { ref } from 'vue'

const projectMenu = ref<MenuMethods | null>(null)
const projectMenuItems = ref<MenuItem[]>([
	{
		label: 'Settings',
		command: () => {
			router.get(route('projects.edit', props.project.id))
		},
	},
	{
		label: 'Delete',
		command: () => {
			confirm.require({
				message: 'Are you sure you want to delete the project?',
				header: 'Delete Project',
				rejectProps: {
					label: 'Cancel',
					severity: 'secondary',
					outlined: true,
				},
				acceptProps: {
					label: 'Delete',
					severity: 'danger',
				},
				accept: () => {
					router.delete(route('projects.destroy', props.project.id))
				},
			})
		},
	},
])
const toggleProjectMenu = (event: MouseEvent) => {
	projectMenu.value?.toggle(event)
}

const confirm = useConfirm()
</script>

<template>
	<Card
		class="group relative h-full select-none"
		pt:body:class="flex flex-col h-full"
		pt:content:class="grow">
		<template #title>
			<Link :href="route('projects.show', project.id)">
				<h1 class="text-wrap pe-8">{{ project.name }}</h1>
				<i
					class="pi pi-chevron-right absolute right-6 top-7 -translate-x-3 opacity-0 transition-all group-hover:translate-x-0 group-hover:opacity-100"></i>
			</Link>
		</template>
		<template #content>
			<p class="line-clamp-3">{{ project.description }}</p>
		</template>
		<template #footer>
			<div class="flex items-center justify-between">
				<Button
					icon="pi pi-ellipsis-v"
					aria-haspopup="true"
					aria-controls="project_menu"
					text
					type="button"
					severity="secondary"
					@click="toggleProjectMenu" />
				<Menu
					ref="projectMenu"
					id="project_menu"
					:popup="true"
					:model="projectMenuItems">
				</Menu>
			</div>
		</template>
	</Card>
</template>
