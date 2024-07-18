<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Project } from '@/types'
import { Head } from '@inertiajs/vue3'

const props = defineProps<{
	project: Project
}>()

console.log(props.project)
</script>

<template>
	<Head :title="project.name" />

	<AuthenticatedLayout :projectId="project.id"></AuthenticatedLayout>
</template>
