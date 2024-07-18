<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import ProjectForm from './Partials/ProjectForm.vue'
import { Project } from '@/types'

defineProps<{
	project: Project
}>()
</script>

<template>
	<Head title="Create Project" />

	<AuthenticatedLayout :projectId="project.id">
		<div class="flex h-full items-center justify-center py-6">
			<Card class="w-full max-w-xl">
				<template #content>
					<ProjectForm :project="project" />
				</template>
			</Card>
		</div>
	</AuthenticatedLayout>
</template>
