<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import ProjectForm from './Partials/ProjectForm.vue'
</script>

<template>
	<Head title="Create Project" />

	<AuthenticatedLayout>
		<div class="flex h-full items-center justify-center py-6">
			<Card class="w-full max-w-xl">
				<template #content>
					<ProjectForm />
				</template>
			</Card>
		</div>
	</AuthenticatedLayout>
</template>
