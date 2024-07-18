<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import ProjectCard from './Partials/ProjectCard.vue'
import { Project } from '@/types'
import { Head, Link } from '@inertiajs/vue3'

defineProps<{
	projects: Project[]
}>()
</script>

<template>
	<Head title="Projects" />

	<AuthenticatedLayout>
		<div class="container mx-auto space-y-4 px-4 py-6">
			<div class="flex gap-4">
				<IconField class="w-full">
					<InputIcon class="pi pi-search" />
					<InputText placeholder="Search..." class="w-full" />
				</IconField>
				<Link :href="route('projects.create')">
					<Button label="New" icon="pi pi-plus" class="shrink-0" />
				</Link>
			</div>
			<div
				class="grid w-full grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
				<ProjectCard
					v-for="project in projects"
					:key="project.id"
					:project="project" />
				<ConfirmDialog />
			</div>
		</div>
	</AuthenticatedLayout>
</template>
