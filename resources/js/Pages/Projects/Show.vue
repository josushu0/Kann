<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProjectCard from '@/Components/ProjectCard.vue'

const props = defineProps({
	projects: {
		type: [],
	},
})
</script>

<template>
	<AppLayout title="Projects">
		<div class="container grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-3">
			<ProjectCard
				v-for="project in projects"
				:key="project.id"
				:project="project" />
		</div>
	</AppLayout>
</template>
