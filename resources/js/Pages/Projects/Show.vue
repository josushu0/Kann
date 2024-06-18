<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ProjectCard from '@/Components/ProjectCard.vue'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Icon } from '@iconify/vue'
import { ref, watch } from 'vue'

const props = defineProps({
	projects: {
		type: Array,
	},
})

const filteredProjects = ref(props.projects)
const search = ref('')

watch(search, (value) => {
	if (search.value.length > 0) {
		filteredProjects.value = filteredProjects.value.filter((project) =>
			project.name.toLowerCase().includes(search.value.toLowerCase())
		)
	} else {
		filteredProjects.value = props.projects
	}
})
</script>

<template>
	<AppLayout title="Projects">
		<div class="container space-y-4">
			<div class="flex gap-2">
				<Label for="search_project" class="sr-only">Search Projects</Label>
				<Input
					type="text"
					id="search_project"
					name="search_project"
					placeholder="Search Projects..."
					v-model="search" />
				<Button class="flex items-center gap-1">
					<Icon icon="lucide:plus" class="size-5" />
					Create Project
				</Button>
			</div>
			<div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
				<ProjectCard
					v-for="project in filteredProjects"
					:key="project.id"
					:project="project" />
			</div>
		</div>
	</AppLayout>
</template>
